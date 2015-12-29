<?php
/**
 * @version		$Id: view.feed.php 21097 2011-04-07 15:38:03Z dextercowley $
 * @package		Joomla.Site
 * @subpackage	com_usernotify
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * HTML View class for the User Notify component
 *
 * @static
 * @package		Joomla.Site
 * @subpackage	com_usernotify
 * @since 1.0
 */
class UserNotifyViewCategory extends JViewLegacy
{
	function display($tpl = null)
	{
		$app	= JFactory::getApplication();
		$document = JFactory::getDocument();

		$document->link = JRoute::_(UserNotifyHelperRoute::getCategoryRoute($this->input->getInt('id',null)));

		$this->input->set('limit', $app->getCfg('feed_limit'));
		$siteEmail = $app->getCfg('mailfrom');
		$fromName = $app->getCfg('fromname');
		$document->editor = $fromName;
		$document->editorEmail = $siteEmail;

		// Get some data from the model
		$items		= $this->get('Items');
		$category	= $this->get('Category');

		foreach ($items as $item)
		{
			// strip html from feed item title
			$title = $this->escape($item->title);
			$title = html_entity_decode($title, ENT_COMPAT, 'UTF-8');

			// url link to article
			$link = JRoute::_(UserNotifyHelperRoute::getUserSubsRoute($item->slug, $item->catid));

			// strip html from feed item description text
			$description = $item->description;
			$date = ($item->date ? date('r', strtotime($item->date)) : '');

			// load individual item creator class
			$feeditem = new JFeedItem();
			$feeditem->title		= $title;
			$feeditem->link			= $link;
			$feeditem->description	= $description;
			$feeditem->date			= $date;
			$feeditem->category		= 'UserNotify';

			// loads item info into rss array
			$document->addItem($feeditem);
		}
	}
}
?>