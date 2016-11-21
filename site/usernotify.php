<?php
/*
* @package    User Notify Component
* @copyright  (C) 2016 RJCreations. All rights reserved.
* @license    GNU General Public License version 3 or later; see LICENSE.txt
*/

defined('_JEXEC') or die;

jimport('joomla.application.component.controller');
//require_once JPATH_COMPONENT.'/helpers/route.php';

$controller	= JControllerLegacy::getInstance('UserNotify');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();