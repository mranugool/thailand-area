<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Thailandarea
 * @author     Anugool Sridum <a.sridum@gmail.com>
 * @copyright  2020 Anugool Sridum
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

use \Joomla\CMS\Factory;

/**
 * Thailandarea helper.
 *
 * @since  1.6
 */
class ThailandareaHelper
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param   string  $vName  string
	 *
	 * @return void
	 */
	public static function addSubmenu($vName = '')
	{
		JHtmlSidebar::addEntry( JText::_('COM_THAILANDAREA_TITLE_PROVINCES'), 'index.php?option=com_thailandarea&view=provinces', $vName == 'provinces' );
		JHtmlSidebar::addEntry( JText::_('COM_THAILANDAREA_TITLE_DISTRICTS'), 'index.php?option=com_thailandarea&view=districts', $vName == 'districts' );
		JHtmlSidebar::addEntry( JText::_('COM_THAILANDAREA_TITLE_SUBDISTRICTS'), 'index.php?option=com_thailandarea&view=subdistricts', $vName == 'subdistricts' );
		JHtmlSidebar::addEntry( JText::_('COM_THAILANDAREA_TITLE_CHANGELOGS'), 'index.php?option=com_thailandarea&view=changelogs', $vName == 'changelogs' );
	}

	/**
	 * Gets the files attached to an item
	 *
	 * @param   int     $pk     The item's id
	 *
	 * @param   string  $table  The table's name
	 *
	 * @param   string  $field  The field's name
	 *
	 * @return  array  The files
	 */
	public static function getFiles($pk, $table, $field)
	{
		$db = Factory::getDbo();
		$query = $db->getQuery(true);

		$query
			->select($field)
			->from($table)
			->where('id = ' . (int) $pk);

		$db->setQuery($query);

		return explode(',', $db->loadResult());
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @return    JObject
	 *
	 * @since    1.6
	 */
	public static function getActions()
	{
		$user   = Factory::getUser();
		$result = new JObject;

		$assetName = 'com_thailandarea';

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action)
		{
			$result->set($action, $user->authorise($action, $assetName));
		}

		return $result;
	}
}

