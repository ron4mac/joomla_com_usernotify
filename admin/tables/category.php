<?php
/*
* @package    User Notify Component
* @copyright  (C) 2016 RJCreations. All rights reserved.
* @license    GNU General Public License version 3 or later; see LICENSE.txt
*/

defined('_JEXEC') or die;

class UserNotifyTableCategory extends JTable
{

	public function __construct (&$db)
	{
		parent::__construct('#__usernotify_c', 'nid', $db);
	}


	public function bind ($array, $ignore = '')
	{
		if (isset($array['params']) && is_array($array['params'])) {
			$registry = new JRegistry();
			$registry->loadArray($array['params']);
			$array['params'] = (string)$registry;
		}

		if (isset($array['metadata']) && is_array($array['metadata'])) {
			$registry = new JRegistry();
			$registry->loadArray($array['metadata']);
			$array['metadata'] = (string)$registry;
		}

		if (isset($array['grps']) && is_array($array['grps'])) {
			$array['grps'] = implode(',', $array['grps']);
		}

		return parent::bind($array, $ignore);
	}

}
