<?php
/**
 * @version		$Id$
 * @package		Joomla.Site
 * @subpackage	com_usernotify
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
jimport('joomla.application.component.helper');
/**
 * UserSubs Component HTML Helper
 *
 * @static
 * @package		Joomla.Site
 * @subpackage	com_usernotify
 * @since 1.5
 */
class JHtmlIcon
{
	static function create($usersubs, $params)
	{
		$uri = JFactory::getURI();

		$url = JRoute::_(UserNotifyHelperRoute::getFormRoute(0, base64_encode($uri)));
		$text = JHtml::_('image','system/new.png', JText::_('JNEW'), NULL, true);
		$button = JHtml::_('link',$url, $text);
		$output = '<span class="hasTip" title="'.JText::_('COM_USERNOTIFY_FORM_CREATE_USERSUBS').'">'.$button.'</span>';
		return $output;
	}

	static function edit($usersubs, $params, $attribs = array())
	{
		$user = JFactory::getUser();
		$uri = JFactory::getURI();

		if ($params && $params->get('popup')) {
			return;
		}

		if ($usersubs->state < 0) {
			return;
		}

		JHtml::_('behavior.tooltip');
		$url	= UserNotifyHelperRoute::getFormRoute($usersubs->id, base64_encode($uri));
		$icon	= $usersubs->state ? 'edit.png' : 'edit_unpublished.png';
		$text	= JHtml::_('image','system/'.$icon, JText::_('JGLOBAL_EDIT'), NULL, true);

		if ($usersubs->state == 0) {
			$overlib = JText::_('JUNPUBLISHED');
		}
		else {
			$overlib = JText::_('JPUBLISHED');
		}

		$date = JHtml::_('date',$usersubs->created);
		$author = $usersubs->created_by_alias ? $usersubs->created_by_alias : $usersubs->author;

		$overlib .= '&lt;br /&gt;';
		$overlib .= $date;
		$overlib .= '&lt;br /&gt;';
		$overlib .= htmlspecialchars($author, ENT_COMPAT, 'UTF-8');

		$button = JHtml::_('link',JRoute::_($url), $text);

		$output = '<span class="hasTip" title="'.JText::_('COM_USERNOTIFY_EDIT').' :: '.$overlib.'">'.$button.'</span>';

		return $output;
	}
}
