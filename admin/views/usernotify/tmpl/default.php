<?php
/*
* @package    User Notify Component
* @copyright  (C) 2015 RJCreations. All rights reserved.
* @license    GNU General Public License version 3 or later; see LICENSE.txt
*/

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('script','system/multiselect.js', false, true);

JHtml::stylesheet('administrator/components/com_usernotify/static/css/usernotify.css');

$user = JFactory::getUser();
$userId = $user->get('id');
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn = $this->escape($this->state->get('list.direction'));
$canOrder = $user->authorise('core.edit.state', 'com_usernotify.category');
$archived = $this->state->get('filter.state') == 2 ? true : false;
$trashed = $this->state->get('filter.state') == -2 ? true : false;
$saveOrder = $listOrder == 'a.ordering';
//echo'<xmp>';var_dump($this->items);echo'</xmp>';
//error_log('We have entered the usernotify view');
//trigger_error('We have entered the usernotify view');
?>

<form action="<?php echo JRoute::_('index.php?option=com_usernotify&view=usernotify'); ?>" method="post" name="adminForm" id="adminForm">
	<div id="j-main-container" class="span10">
	<div class="clr"> </div>

	<table class="table table-striped adminlist">
		<thead>
			<tr>
				<th width="1%">
					<input type="checkbox" name="checkall-toggle" value="" onclick="Joomla.checkAll(this)" />
				</th>
				<th class="title">
					<?php echo JHtml::_('grid.sort',  'JGLOBAL_TITLE', 'c.title', $listDirn, $listOrder); ?>
				</th>
				<th class="center" width="15%">
					<?php echo JHtml::_('grid.sort',  'COM_USERNOTIFY_NOTIFY_PUB_HEAD', 'n.pub', $listDirn, $listOrder); ?>
				</th>
				<th class="center" width="15%">
					<?php echo JHtml::_('grid.sort',  'COM_USERNOTIFY_NOTIFY_UPD_HEAD', 'n.upd', $listDirn, $listOrder); ?>
				</th>
				<th class="center" width="15%">
					<?php echo JHtml::_('grid.sort',  'COM_USERNOTIFY_EMAIL_TMPL_HEAD', 'n.email_tmpl', $listDirn, $listOrder); ?>
				</th>
				<th class="center" width="15%">
					<?php echo JHtml::_('grid.sort',  'COM_USERNOTIFY_SMS_TMPL_HEAD', 'n.sms_tmpl', $listDirn, $listOrder); ?>
				</th>
				<th width="1%" class="nowrap">
					<?php echo JHtml::_('grid.sort',  'JGRID_HEADING_ID', 'c.id', $listDirn, $listOrder); ?>
				</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="10">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php foreach ($this->items as $i => $item) :
			$ordering = ($listOrder == 'a.ordering');
			$cat_edt_link = JRoute::_('index.php?option=com_usernotify&task=category.config&ncid='. $item->catid);
			//$item->cat_link	= JRoute::_('index.php?option=com_categories&extension=com_usernotify&task=edit&type=other&cid[]='. $item->catid);
			$canCreate = $user->authorise('core.create', 'com_usernotify.category.'.$item->catid);
			$canEdit = $user->authorise('core.edit', 'com_usernotify.category.'.$item->catid);
			?>
			<tr class="row<?php echo $i % 2; ?>">
				<td class="center">
					<?php echo JHtml::_('grid.id', $i, $item->catid); ?>
				</td>
				<td class="hasPopover" data-content="<?=strip_tags($item->description)?>">
					<a href="<?php echo $cat_edt_link; ?>"><?php echo $this->escape($item->title).' ('.$this->escape($item->extension).')'; ?></a>
				</td>
			<?php if ($item->nid): ?>
				<td class="center<?= $item->pub?' ticked':'' ?>">
				</td>
				<td class="center<?= $item->upd?' ticked':'' ?>">
				</td>
				<td class="center<?= $item->email_tmpl?' ticked':'' ?>">
				</td>
				<td class="center<?= $item->sms_tmpl?' ticked':'' ?>">
				</td>
			<?php else: ?>
				<td class="center" colspan="4">
					<?= JText::_('COM_USERNOTIFY_NOT_CONFIGURED') ?>
				</td>
			<?php endif; ?>
				<td class="center">
					<?php echo (int) $item->catid; ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>

	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
	</div>
</form>
