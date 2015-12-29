<?php
/**
 * @version		$Id: usernotify.php 20196 2011-01-09 02:40:25Z ian $
 * @package		Joomla.Site
 * @subpackage	com_usernotify
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');
require_once JPATH_COMPONENT.'/helpers/route.php';

$controller	= JControllerLegacy::getInstance('UserNotify');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();