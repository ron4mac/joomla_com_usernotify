<?php
/**
 * @version		$Id: usernotify.php 20196 2011-01-09 02:40:25Z ian $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

/**
 * UserNotify helper.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_usernotify
 * @since		1.6
 */
class UserNotifyHelper
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param	string	The name of the active view.
	 * @since	1.6
	 */
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
		if ($vName=='categories') {
			JToolBarHelper::title(
				JText::sprintf('COM_CATEGORIES_CATEGORIES_TITLE',JText::_('com_usernotify')),
				'usernotify-categories');
		}
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @param	int		The category ID.
	 * @return	JObject
	 * @since	1.6
	 */
	public static function getActions($categoryId = 0)
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

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
