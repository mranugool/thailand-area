<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Thailandarea
 * @author     Anugool Sridum <a.sridum@gmail.com>
 * @copyright  2020 Anugool Sridum
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Thailandarea records.
 *
 * @since  1.6
 */
class ThailandareaModelSubdistricts extends \Joomla\CMS\MVC\Model\ListModel
{
    
        
/**
	* Constructor.
	*
	* @param   array  $config  An optional associative array of configuration settings.
	*
	* @see        JController
	* @since      1.6
	*/
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id', 'a.`id`',
				'ordering', 'a.`ordering`',
				'state', 'a.`state`',
				'created_by', 'a.`created_by`',
				'modified_by', 'a.`modified_by`',
				'subdistrict_code', 'a.`subdistrict_code`',
				'subdistrict_name_th', 'a.`subdistrict_name_th`',
				'subdistrict_name_en', 'a.`subdistrict_name_en`',
				'subdistrict_geo_id', 'a.`subdistrict_geo_id`',
				'subdistrict_postcode', 'a.`subdistrict_postcode`',
				'province_id', 'a.`province_id`',
				'district_id', 'a.`district_id`',
				'note', 'a.`note`',
			);
		}

		parent::__construct($config);
	}

    
        
    
        

        
	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @param   string  $ordering   Elements order
	 * @param   string  $direction  Order direction
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	protected function populateState($ordering = null, $direction = null)
	{
        // List state information.
        parent::populateState('id', 'ASC');

        $context = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
        $this->setState('filter.search', $context);

        // Split context into component and optional section
        $parts = FieldsHelper::extract($context);

        if ($parts)
        {
            $this->setState('filter.component', $parts[0]);
            $this->setState('filter.section', $parts[1]);
        }
	}

	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * This is necessary because the model is used by the component and
	 * different modules that might need different sets of data or different
	 * ordering requirements.
	 *
	 * @param   string  $id  A prefix for the store id.
	 *
	 * @return   string A store id.
	 *
	 * @since    1.6
	 */
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id .= ':' . $this->getState('filter.search');
		$id .= ':' . $this->getState('filter.state');

                
                    return parent::getStoreId($id);
                
	}

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return   JDatabaseQuery
	 *
	 * @since    1.6
	 */
	protected function getListQuery()
	{
		// Create a new query object.
		$db    = $this->getDbo();
		$query = $db->getQuery(true);

		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select', 'DISTINCT a.*'
			)
		);
		$query->from('`#__thailand_subdistricts` AS a');
                
		// Join over the users for the checked out user
		$query->select("uc.name AS uEditor");
		$query->join("LEFT", "#__users AS uc ON uc.id=a.checked_out");

		// Join over the user field 'created_by'
		$query->select('`created_by`.name AS `created_by`');
		$query->join('LEFT', '#__users AS `created_by` ON `created_by`.id = a.`created_by`');

		// Join over the user field 'modified_by'
		$query->select('`modified_by`.name AS `modified_by`');
		$query->join('LEFT', '#__users AS `modified_by` ON `modified_by`.id = a.`modified_by`');
		// Join over the foreign key 'province_id'
		$query->select('`#__thailand_provinces_3434578`.`provinces_name_th` AS #__thailand_provinces_fk_value_3434578');
		$query->join('LEFT', '#__thailand_provinces AS #__thailand_provinces_3434578 ON #__thailand_provinces_3434578.`id` = a.`province_id`');
		// Join over the foreign key 'district_id'
		$query->select('`#__thailand_districts_3434581`.`districts_name_th` AS #__thailand_districts_fk_value_3434581');
		$query->join('LEFT', '#__thailand_districts AS #__thailand_districts_3434581 ON #__thailand_districts_3434581.`id` = a.`district_id`');
                

		// Filter by published state
		$published = $this->getState('filter.state');

		if (is_numeric($published))
		{
			$query->where('a.state = ' . (int) $published);
		}
		elseif (empty($published))
		{
			$query->where('(a.state IN (0, 1))');
		}

		// Filter by search in title
		$search = $this->getState('filter.search');

		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0)
			{
				$query->where('a.id = ' . (int) substr($search, 3));
			}
			else
			{
				$search = $db->Quote('%' . $db->escape($search, true) . '%');
				$query->where('( a.subdistrict_code LIKE ' . $search . '  OR  a.subdistrict_name_th LIKE ' . $search . '  OR  a.subdistrict_name_en LIKE ' . $search . '  OR  a.subdistrict_postcode LIKE ' . $search . ' )');
			}
		}
                

		// Filtering province_id
		$filter_province_id = $this->state->get("filter.province_id");

		if ($filter_province_id !== null && !empty($filter_province_id))
		{
			$query->where("a.`province_id` = '".$db->escape($filter_province_id)."'");
		}

		// Filtering district_id
		$filter_district_id = $this->state->get("filter.district_id");

		if ($filter_district_id !== null && !empty($filter_district_id))
		{
			$query->where("a.`district_id` = '".$db->escape($filter_district_id)."'");
		}
		// Add the list ordering clause.
		$orderCol  = $this->state->get('list.ordering', 'id');
		$orderDirn = $this->state->get('list.direction', 'ASC');

		if ($orderCol && $orderDirn)
		{
			$query->order($db->escape($orderCol . ' ' . $orderDirn));
		}

		return $query;
	}

	/**
	 * Get an array of data items
	 *
	 * @return mixed Array of data items on success, false on failure.
	 */
	public function getItems()
	{
		$items = parent::getItems();
                
		foreach ($items as $oneItem)
		{

			if (isset($oneItem->province_id))
			{
				$values    = explode(',', $oneItem->province_id);
				$textValue = array();

				foreach ($values as $value)
				{
					$db    = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
						->select('`#__thailand_provinces_3434578`.`provinces_name_th`')
						->from($db->quoteName('#__thailand_provinces', '#__thailand_provinces_3434578'))
						->where($db->quoteName('#__thailand_provinces_3434578.id') . ' = '. $db->quote($db->escape($value)));

					$db->setQuery($query);
					$results = $db->loadObject();

					if ($results)
					{
						$textValue[] = $results->provinces_name_th;
					}
				}

				$oneItem->province_id = !empty($textValue) ? implode(', ', $textValue) : $oneItem->province_id;
			}

			if (isset($oneItem->district_id))
			{
				$values    = explode(',', $oneItem->district_id);
				$textValue = array();

				foreach ($values as $value)
				{
					$db    = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query
						->select('`#__thailand_districts_3434581`.`districts_name_th`')
						->from($db->quoteName('#__thailand_districts', '#__thailand_districts_3434581'))
						->where($db->quoteName('#__thailand_districts_3434581.id') . ' = '. $db->quote($db->escape($value)));

					$db->setQuery($query);
					$results = $db->loadObject();

					if ($results)
					{
						$textValue[] = $results->districts_name_th;
					}
				}

				$oneItem->district_id = !empty($textValue) ? implode(', ', $textValue) : $oneItem->district_id;
			}
		}

		return $items;
	}
}
