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
//echo'<xmp>';var_dump($this->state->get('category.id'));jexit();
?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'category.cancel' || document.formvalidator.isValid(document.id('category-form'))) {
			<?php echo $this->form->getField('email_tmpl')->save(); ?>
			<?php echo $this->form->getField('sms_tmpl')->save(); ?>
			Joomla.submitform(task, document.getElementById('category-form'));
		}
		else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_usernotify&layout=edit&nid='.(int) $this->nid); ?>" method="post" name="adminForm" id="category-form" class="form-horizontal form-validate">
	<fieldset class="adminform">
		<legend><?php echo $this->catExt; ?></legend>
		<div class="form-horizontal">

		<? foreach ($this->form->getFieldset() as $field): ?>
		<div class="control-group">
			<? if (!$field->hidden): ?>
			<div class="control-label"><?=$field->label?></div>
			<? endif; ?>
			<div class="controls"><?=$field->input?></div>
		</div>
		<? endforeach; ?>

		</div>
	</fieldset>
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>