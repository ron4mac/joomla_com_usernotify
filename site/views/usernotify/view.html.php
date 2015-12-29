<?php
/**
 * @version		$Id: view.html.php 20196 2011-01-09 02:40:25Z ian $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * HTML View class for the User Notify component
 *
 * @package		Joomla.Site
 * @subpackage	com_usernotify
 * @since		1.5
 */
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