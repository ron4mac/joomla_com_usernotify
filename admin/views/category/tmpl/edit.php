<?php
/*
* @package    User Notify Component
* @copyright  (C) 2016 RJCreations. All rights reserved.
* @license    GNU General Public License version 3 or later; see LICENSE.txt
*/

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
$tabs = $this->form->getFieldsets();
?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'category.cancel' || document.formvalidator.isValid(document.id('category-form'))) {
			<?=$this->form->getField('email_tmpl')->save();?>
			<?=$this->form->getField('sms_tmpl')->save();?>
			Joomla.submitform(task, document.getElementById('category-form'));
		}
		else {
			alert('<?=$this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>

<form action="<?=JRoute::_('index.php?option=com_usernotify&layout=edit&nid='.(int) $this->nid); ?>" method="post" name="adminForm" id="category-form" class="form-horizontal form-validate">
	<fieldset class="adminform">
		<legend><?=$this->catExt; ?></legend>
		<div class="form-horizontal">
<?php
	echo JHtml::_('bootstrap.startTabSet', 'ID-Tabs-Group', array('active'=>'settings_id'));
	foreach ($tabs as $tab) {
		echo JHtml::_('bootstrap.addTab', 'ID-Tabs-Group', $tab->name.'_id', JText::_($tab->label));
		echo '<div class="tab-description alert alert-info">'.JText::_($tab->description).'</div>';
		echo $this->form->renderFieldset($tab->name);
		echo JHtml::_('bootstrap.endTab');
	}
	echo JHtml::_('bootstrap.endTabSet');
?>
		</div>
	</fieldset>
	<input type="hidden" name="task" value="" />
	<?=JHtml::_('form.token'); ?>
</form>