<?php
/*
* @package    User Notify Component
* @copyright  (C) 2015 RJCreations. All rights reserved.
* @license    GNU General Public License version 3 or later; see LICENSE.txt
*/

defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

class UserNotifyController extends JControllerForm	//Legacy
{

	public function display ($cachable=false, $urlparams=false)
	{
/*		// Initialise variables.
		$cachable	= true;	// Huh? Why not just put that in the constructor?
		$user		= JFactory::getUser();

		// Set the default view name and format from the Request.
		// Note we are using w_id to avoid collisions with the router and the return page.
		// Frontend is a bit messier than the backend.
		$id		= $this->input->getInt('w_id');
		$vName	= $this->input->getCmd('view', 'categories');
		$this->input->set('view', $vName);

		if ($user->get('id') ||($_SERVER['REQUEST_METHOD'] == 'POST' && $vName = 'categories')) {
			$cachable = false;
		}

		$safeurlparams = array(
			'id'				=> 'INT',
			'limit'				=> 'INT',
			'limitstart'		=> 'INT',
			'filter_order'		=> 'CMD',
			'filter_order_Dir'	=> 'CMD',
			'lang'				=> 'CMD'
		);

		// Check for edit form.
		if ($vName == 'form' && !$this->checkEditId('com_usernotify.edit.usersubs', $id)) {
			// Somehow the person just went to the form - we don't allow that.
			return JError::raiseError(403, JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
		}
*/
		return parent::display($cachable, $urlparams);
	}


	public function update ()
	{
		//echo'<xmp>';var_dump($this->input);echo'</xmp>';
		$this->getModel()->saveUserSettings($this->input->post->get('jform', array(), 'array'));
		JFactory::getApplication()->enqueueMessage(JText::_('COM_USERNOTIFY_SETTINGS_SAVED'), 'notice');
	}

}