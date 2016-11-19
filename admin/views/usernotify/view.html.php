<?php
/*
* @package    User Notify Component
* @copyright  (C) 2015 RJCreations. All rights reserved.
* @license    GNU General Public License version 3 or later; see LICENSE.txt
*/

defined('_JEXEC') or die;

jimport('joomla.application.component.view');

class UserNotifyViewUserNotify extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;

	public function display ($tpl = null)
	{
		$this->state = $this->get('State');
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		$this->addToolbar();

		// Include the component HTML helpers.
		JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

//		$this->sidebar = JHtmlSidebar::render();

		parent::display($tpl);
	}

	protected function addToolbar ()
	{
		require_once JPATH_COMPONENT.'/helpers/usernotify.php';

		$state = $this->get('State');
		$canDo = UserNotifyHelper::getActions($state->get('filter.category_id'));
		$user = JFactory::getUser();
		
		JToolBarHelper::title(JText::_('COM_USERNOTIFY_MANAGER_CATEGORIES'), 'notification-2 usernotify');
		if ($canDo->get('core.edit')) {
			JToolBarHelper::editList('category.config','JTOOLBAR_EDIT');
		}
//		if ($canDo->get('core.edit.state')) {
//			JToolBarHelper::divider();
//			JToolBarHelper::custom('usernotify.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
//		}
		JToolBarHelper::trash('category.trash','JTOOLBAR_REMOVE');
		JToolBarHelper::divider();
		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_usernotify');
			JToolBarHelper::divider();
		}

		JToolBarHelper::help('usernotify', true);
	}

}