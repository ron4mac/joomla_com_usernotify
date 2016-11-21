<?php
/*
* @package    User Notify Component
* @copyright  (C) 2016 RJCreations. All rights reserved.
* @license    GNU General Public License version 3 or later; see LICENSE.txt
*/

defined('_JEXEC') or die;

class UserNotifyHelper
{
	public static function addSubmenu($vName = 'usernotify')
	{
		JSubMenuHelper::addEntry(
			JText::_('COM_USERNOTIFY_SUBMENU_USERNOTIFY'),
			'index.php?option=com_usernotify&view=usernotify',
			$vName == 'usernotify'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_USERNOTIFY_SUBMENU_CATEGORIES'),
			'index.php?option=com_categories&extension=com_usernotify',
			$vName == 'categories'
		);
		if ($vName == 'categories') {
			JToolBarHelper::title(
				JText::sprintf('COM_CATEGORIES_CATEGORIES_TITLE',JText::_('com_usernotify')),
				'usernotify-categories');
		}
	}


	public static function getActions($categoryId = 0)
	{
		$user = JFactory::getUser();
		$result = new JObject;

		if (empty($categoryId)) {
			$assetName = 'com_usernotify';
		} else {
			$assetName = 'com_usernotify.category.'.(int) $categoryId;
		}

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action) {
			$result->set($action,	$user->authorise($action, $assetName));
		}

		return $result;
	}

}