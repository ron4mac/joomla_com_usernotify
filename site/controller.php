<?php
/*
* @package    User Notify Component
* @copyright  (C) 2016 RJCreations. All rights reserved.
* @license    GNU General Public License version 3 or later; see LICENSE.txt
*/

defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

class UserNotifyController extends JControllerForm
{

	public function display ($cachable=false, $urlparams=false)
	{
		$user = JFactory::getUser();
		if (!$user->id) {
			return JError::raiseError(403, JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $user->id));
		}
		return parent::display($cachable, $urlparams);
	}


	public function update ()
	{
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		$this->getModel()->saveUserSettings($this->input->post->get('jform', array(), 'array'));
		JFactory::getApplication()->enqueueMessage(JText::_('COM_USERNOTIFY_SETTINGS_SAVED'), 'notice');
	}

}