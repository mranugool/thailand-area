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

use \Joomla\CMS\HTML\HTMLHelper;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Uri\Uri;
use \Joomla\CMS\Router\Route;
use \Joomla\CMS\Language\Text;


HTMLHelper::addIncludePath(JPATH_COMPONENT . '/helpers/html');
HTMLHelper::_('behavior.tooltip');
HTMLHelper::_('behavior.formvalidation');
HTMLHelper::_('formbehavior.chosen', 'select');
HTMLHelper::_('behavior.keepalive');

// Import CSS
$document = Factory::getDocument();
$document->addStyleSheet(Uri::root() . 'media/com_thailandarea/css/form.css');
?>
<script type="text/javascript">
	js = jQuery.noConflict();
	js(document).ready(function () {
		
	js('input:hidden.province_id').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('province_idhidden')){
			js('#jform_province_id option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_province_id").trigger("liszt:updated");
	js('input:hidden.district_id').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('district_idhidden')){
			js('#jform_district_id option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_district_id").trigger("liszt:updated");
	});

	Joomla.submitbutton = function (task) {
		if (task == 'subdistrict.cancel') {
			Joomla.submitform(task, document.getElementById('subdistrict-form'));
		}
		else {
			
			if (task != 'subdistrict.cancel' && document.formvalidator.isValid(document.id('subdistrict-form'))) {
				
				Joomla.submitform(task, document.getElementById('subdistrict-form'));
			}
			else {
				alert('<?php echo $this->escape(Text::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
			}
		}
	}
</script>

<form
	action="<?php echo JRoute::_('index.php?option=com_thailandarea&layout=edit&id=' . (int) $this->item->id); ?>"
	method="post" enctype="multipart/form-data" name="adminForm" id="subdistrict-form" class="form-validate form-horizontal">

	
	<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
	<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />
	<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />
	<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />
	<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />
	<?php echo $this->form->renderField('created_by'); ?>
	<?php echo $this->form->renderField('modified_by'); ?>
	<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'province')); ?>
	<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'province', JText::_('COM_THAILANDAREA_TAB_PROVINCE', true)); ?>
	<div class="row-fluid">
		<div class="span10 form-horizontal">
			<fieldset class="adminform">
				<legend><?php echo JText::_('COM_THAILANDAREA_FIELDSET_PROVINCE'); ?></legend>
				<?php echo $this->form->renderField('subdistrict_code'); ?>
				<?php echo $this->form->renderField('subdistrict_name_th'); ?>
				<?php echo $this->form->renderField('subdistrict_name_en'); ?>
				<?php echo $this->form->renderField('subdistrict_geo_id'); ?>
				<?php echo $this->form->renderField('subdistrict_postcode'); ?>
				<?php echo $this->form->renderField('province_id'); ?>
				<?php
				foreach((array)$this->item->province_id as $value)
				{
					if(!is_array($value))
					{
						echo '<input type="hidden" class="province_id" name="jform[province_idhidden]['.$value.']" value="'.$value.'" />';
					}
				}
				?>
				<?php echo $this->form->renderField('district_id'); ?>
				<?php
				foreach((array)$this->item->district_id as $value)
				{
					if(!is_array($value))
					{
						echo '<input type="hidden" class="district_id" name="jform[district_idhidden]['.$value.']" value="'.$value.'" />';
					}
				}
				?>
				<?php echo $this->form->renderField('note'); ?>
				<?php if ($this->state->params->get('save_history', 1)) : ?>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('version_note'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('version_note'); ?></div>
					</div>
				<?php endif; ?>
			</fieldset>
		</div>
	</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php if (JFactory::getUser()->authorise('core.admin','thailandarea')) : ?>
	<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'permissions', JText::_('JGLOBAL_ACTION_PERMISSIONS_LABEL', true)); ?>
		<?php echo $this->form->getInput('rules'); ?>
	<?php echo JHtml::_('bootstrap.endTab'); ?>
<?php endif; ?>
	<?php echo JHtml::_('bootstrap.endTabSet'); ?>

	<input type="hidden" name="task" value=""/>
	<?php echo JHtml::_('form.token'); ?>

</form>
