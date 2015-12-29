<?php
// No direct access.
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