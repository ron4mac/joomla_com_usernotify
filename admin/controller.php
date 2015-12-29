<?php
// No direct access
defined('_JEXEC') or die;

class UserNotifyController extends JControllerLegacy
{
	public function display ($cachable = false, $urlparams = false)
	{
		require_once JPATH_COMPONENT.'/helpers/usernotify.php';

		// Load the submenu.
//		UserNotifyHelper::addSubmenu($this->input->getCmd('view', 'usernotify'));

		$view = $this->input->getCmd('view', 'usernotify');
		$layout = $this->input->getCmd('layout', 'default');
		$id = $this->input->getInt('id');

		// Check for edit form.
		if ($view == 'usersubs' && $layout == 'edit' && !$this->checkEditId('com_usernotify.edit.usersubs', $id)) {
			// Somehow the person just went to the form - we don't allow that.
			$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
			$this->setMessage($this->getError(), 'error');
			$this->setRedirect(JRoute::_('index.php?option=com_usernotify&view=usernotify', false));

			return false;
		}

		parent::display();

		return $this;
	}
}