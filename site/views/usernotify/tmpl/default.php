<?php
/*
* @package    User Notify Component
* @copyright  (C) 2016 RJCreations. All rights reserved.
* @license    GNU General Public License version 3 or later; see LICENSE.txt
*/

defined('_JEXEC') or die;

// so we can use bootstrap tabs
jimport('joomla.html.html.bootstrap');

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers');

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidator');

JHtml::stylesheet('components/com_usernotify/static/css/usernotify.css');
// more styling added here, and in this way, so it overrides the template
JFactory::getDocument()->addStyleDeclaration('
.catstbl .controls {
	margin-left: 0;
}
.catstbl .control-group {
	margin-bottom: 4px;
}
.nav.nav-tabs {
	margin-bottom: 0;
}
.tab-content{
	padding: 1em;
	background-color: #FFF;
	border: 1px solid #CCC;
	border-top: none;
}
');

// options for the tabs
$tabOptions = array('active' => 'tab1_id');
$shupd = ($this->params->get('upd', 0) == 1);
?>
<div class="usersubs-category<?php echo $this->params->get('pageclass_sfx');?>">
<?php if ($this->params->def('show_page_heading', 1)) : ?>
	<h1>
		<?php echo $this->escape($this->params->get('page_heading')); ?>
	</h1>
<?php endif; ?>
	<div class="alert alert-info"><p><?php echo JText::_('COM_USERNOTIFY_USER_BLURB'); ?></p></div>
	<form action="<?php echo JRoute::_('index.php?option=com_usernotify'); ?>" method="post" name="adminForm" id="notify-form" class="form-horizontal form-validate">
		<fieldset class="adminform">
		<?php echo JHtml::_('bootstrap.startTabSet', 'ID-Tabs-Group', $tabOptions);?>
		<?php echo JHtml::_('bootstrap.addTab', 'ID-Tabs-Group', 'tab1_id', JText::_('COM_USERNOTIFY_TAB_SUBSCRIPTIONS')); ?>
			<div>
				<table class="catstbl table-striped">
				<tr>
					<th class="head1 hasTooltip" title="<?=JText::_('COM_USERNOTIFY_SUB_CAT_DESC')?>"><?=JText::_('COM_USERNOTIFY_SUB_CAT')?></th>
					<th class="head23 hasTooltip" title="<?=JText::_('COM_USERNOTIFY_SUB_EMAIL_DESC')?>"><?=JText::_('COM_USERNOTIFY_SUB_EMAIL')?></th>
					<th class="head23 hasTooltip" title="<?=JText::_('COM_USERNOTIFY_SUB_SMS_DESC')?>"><?=JText::_('COM_USERNOTIFY_SUB_SMS')?></th>
					<?php if ($shupd): ?>
					<th class="head23 hasTooltip" title="<?=JText::_('COM_USERNOTIFY_SUB_UPDT_DESC')?>"><?=JText::_('COM_USERNOTIFY_SUB_UPDT')?></th>
					<?php endif; ?>
				</tr>
				<? foreach ($this->cats as $cat): ?>
				<tr>
					<td class="hasPopover" data-content="<?=strip_tags($cat['description'])?>"><?=$cat['title']?></td>
					<td class="center"><?=$this->form->renderField('eml', 'cats.'.$cat['cid'])?></td>
					<td class="center"><?=$this->form->renderField('sms', 'cats.'.$cat['cid'])?></td>
					<?php if ($shupd): ?>
					<td class="center"><?=$this->form->renderField('upd', 'cats.'.$cat['cid'])?></td>
					<?php endif; ?>
				</tr>
				<? endforeach; ?>
				</table>
			</div>
		<?php echo JHtml::_('bootstrap.endTab');?>
		<?php echo JHtml::_('bootstrap.addTab', 'ID-Tabs-Group', 'tab2_id', JText::_('COM_USERNOTIFY_TAB_CONFIGURATION')); ?>
			<div>
				<?=$this->form->renderFieldset('uopts')?>
				<?=$this->form->renderFieldset('cuopts')?>
			</div>
		<?php echo JHtml::_('bootstrap.endTab');?>
		<?php echo JHtml::_('bootstrap.endTabSet', 'ID-Tabs-Group');?>
		</fieldset>
		<button type="submit" class="btn btn-primary validate"><?=JText::_('COM_USERNOTIFY_UPDATE_SUBMIT')?></button>
		<input type="hidden" name="task" value="update" />
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>