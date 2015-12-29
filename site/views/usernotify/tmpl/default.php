<?php
// no direct access
defined('_JEXEC') or die;

// so we can use bootstrap tabs
jimport('joomla.html.html.bootstrap');

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers');

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidator');

JHtml::stylesheet('components/com_usernotify/static/css/usernotify.css');
// more styling added here, and in this way, so it overrides the template
JFactory::getDocument()->addStyleDeclaration('.catstbl .controls {margin-left: 0;} .catstbl .control-group {margin-bottom: 4px;}');

// options for the tabs
$tabOptions = array('active' => 'tab1_id');
?>
<div class="usersubs-category<?php echo $this->params->get('pageclass_sfx');?>">
<?php if ($this->params->def('show_page_heading', 1)) : ?>
	<h1>
		<?php echo $this->escape($this->params->get('page_heading')); ?>
	</h1>
<?php endif; ?>
	<form action="<?php echo JRoute::_('index.php?option=com_usernotify'); ?>" method="post" name="adminForm" id="notify-form" class="form-horizontal form-validate">
		<fieldset class="adminform">
		<?php echo JHtml::_('bootstrap.startTabSet', 'ID-Tabs-Group', $tabOptions);?>
		<?php echo JHtml::_('bootstrap.addTab', 'ID-Tabs-Group', 'tab1_id', JText::_('COM_USERNOTIFY_TAB_CONFIGURATION')); ?>
			<div>
				<?=$this->form->renderFieldset('uopts')?>
				<?=$this->form->renderFieldset('cuopts')?>
			</div>
		<?php echo JHtml::_('bootstrap.endTab');?>
		<?php echo JHtml::_('bootstrap.addTab', 'ID-Tabs-Group', 'tab2_id', JText::_('COM_USERNOTIFY_TAB_SUBSCRIPTIONS')); ?>
			<div>
				<table class="catstbl table-striped">
				<tr>
					<th class="head1 hasTooltip" title="<?=JText::_('COM_USERNOTIFY_SUB_CAT_DESC')?>"><?=JText::_('COM_USERNOTIFY_SUB_CAT')?></th>
					<th class="head23 hasTooltip" title="<?=JText::_('COM_USERNOTIFY_SUB_EMAIL_DESC')?>"><?=JText::_('COM_USERNOTIFY_SUB_EMAIL')?></th>
					<th class="head23 hasTooltip" title="<?=JText::_('COM_USERNOTIFY_SUB_SMS_DESC')?>"><?=JText::_('COM_USERNOTIFY_SUB_SMS')?></th>
					<th class="head23 hasTooltip" title="<?=JText::_('COM_USERNOTIFY_SUB_UPDT_DESC')?>"><?=JText::_('COM_USERNOTIFY_SUB_UPDT')?></th>
				</tr>
				<? foreach ($this->cats as $cat): ?>
				<tr>
					<td><?=$cat['title']?></td>
					<td class="center"><?=$this->form->renderField('email'.$cat['cid'], 'cats')?></td>
					<td class="center"><?=$this->form->renderField('sms'.$cat['cid'], 'cats')?></td>
					<td class="center"><?=$this->form->renderField('update'.$cat['cid'], 'cats')?></td>
				</tr>
				<? endforeach; ?>
				</table>
			</div>
		<?php echo JHtml::_('bootstrap.endTab');?>
		<?php echo JHtml::_('bootstrap.endTabSet', 'ID-Tabs-Group');?>
		</fieldset>
		<button type="submit" class="btn btn-primary validate"><?=JText::_('COM_USERNOTIFY_UPDATE_SUBMIT')?></button>
		<input type="hidden" name="task" value="update" />
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>