<?php
/*
* @package    User Notify Component
* @copyright  (C) 2016 RJCreations. All rights reserved.
* @license    GNU General Public License version 3 or later; see LICENSE.txt
*/

defined('_JEXEC') or die;

jimport('joomla.application.component.view');

class UserNotifyViewCategory extends JViewLegacy
{
	protected $state;
	protected $item;
	protected $form;

	public function display ($tpl = null)
	{
		$m = $this->getModel();
		$context = $m->get('option').'.cfg.'.$m->get('name');
		$this->nid = (int) JFactory::getApplication()->getUserState($context . '.nid');
		$this->cid = (int) JFactory::getApplication()->getUserState($context . '.cid');
		$this->catExt = $m->getCatTitleExt($this->cid);

		$this->state	= $this->get('State');
		$this->item		= $this->get('Item');
		$this->form		= $this->get('Form');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		$this->addToolbar();
		parent::display($tpl);
	}


	protected function addToolbar ()
	{
		JFactory::getApplication()->input->set('hidemainmenu', true);

		$user = JFactory::getUser();
		$isNew = ($this->item->cid == 0);
		$checkedOut = !($this->item->checked_out == 0 || $this->item->checked_out == $user->get('id'));
		$canDo = UserNotifyHelper::getActions($this->state->get('filter.category_id'), $this->item->cid);

		JToolBarHelper::title(JText::_('COM_USERNOTIFY_EDIT_CATEGORY').$this->catExt, 'notification usernotify');

		// If not checked out, can save the item.
		if (!$checkedOut && ($canDo->get('core.edit')||(count($user->getAuthorisedCategories('com_usernotify', 'core.create'))))) {
			JToolBarHelper::apply('category.apply', 'JTOOLBAR_APPLY');
			JToolBarHelper::save('category.save', 'JTOOLBAR_SAVE');
		}
		if (!$checkedOut && (count($user->getAuthorisedCategories('com_usernotify', 'core.create')))) {			
			JToolBarHelper::custom('category.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
		}
		// If an existing item, can save to a copy.
		if (!$isNew && (count($user->getAuthorisedCategories('com_usernotify', 'core.create')) > 0)) {
			JToolBarHelper::custom('category.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
		}
		if (empty($this->item->id)) {
			JToolBarHelper::cancel('category.cancel', 'JTOOLBAR_CANCEL');
		} else {
			JToolBarHelper::cancel('category.cancel', 'JTOOLBAR_CLOSE');
		}

		JToolBarHelper::divider();
		JToolBarHelper::help('category', true);
	}

}
