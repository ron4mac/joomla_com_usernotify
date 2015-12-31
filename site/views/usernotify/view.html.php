<?php
/*
* @package    User Notify Component
* @copyright  (C) 2015 RJCreations. All rights reserved.
* @license    GNU General Public License version 3 or later; see LICENSE.txt
*/

defined('_JEXEC') or die;

jimport('joomla.application.component.view');

class UserNotifyViewUsernotify extends JViewLegacy
{
	protected $state;
	protected $item;

	function display($tpl = null)
	{
		$app = JFactory::getApplication();
		$params = $app->getParams();

		// Get some data from the models
		$state = $this->get('State');
		$item = $this->get('Item');		//echo'<xmp>';var_dump($item);echo'</xmp>';

		$this->params = $params;
		$this->form = $this->get('Form');
		$this->cats = $this->get('CatSettings');
//echo'<xmp>';var_dump($this);echo'</xmp>';
		parent::display($tpl);
	}

}