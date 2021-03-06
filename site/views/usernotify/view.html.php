<?php
/*
* @package    User Notify Component
* @copyright  (C) 2016 RJCreations. All rights reserved.
* @license    GNU General Public License version 3 or later; see LICENSE.txt
*/

defined('_JEXEC') or die;

jimport('joomla.application.component.view');

class UserNotifyViewUsernotify extends JViewLegacy
{

	function display ($tpl = null)
	{
		$app = JFactory::getApplication();
		$this->params = $app->getParams();

		// Get some data from the models
		$this->form = $this->get('Form');
		$this->cats = $this->get('CatSettings');

		parent::display($tpl);
	}

}