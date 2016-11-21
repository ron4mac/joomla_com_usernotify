<?php
/*
* @package    User Notify Component
* @copyright  (C) 2016 RJCreations. All rights reserved.
* @license    GNU General Public License version 3 or later; see LICENSE.txt
*/

defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');

class UserNotifyControllerUserNotify extends JControllerAdmin
{
	public function getModel ($name = 'UserSubs', $prefix = 'UserNotifyModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}

}