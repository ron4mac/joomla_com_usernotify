<?php
/*
* @package    User Notify Component
* @copyright  (C) 2016 RJCreations. All rights reserved.
* @license    GNU General Public License version 3 or later; see LICENSE.txt
*/

defined('_JEXEC') or die;

class TableUsernotifyuc extends JTable
{
	public function __construct (&$db)
	{
		parent::__construct('#__usernotify_uc', array('uid','catid'), $db);
	}


	public function getUserCcfg ($uid)
	{
		$query = $this->_db->getQuery(true)
			->select('*')
			->from($this->_tbl)
			->where('uid = ' . $uid);
		$this->_db->setQuery($query);
		$ccfg = $this->_db->loadAssocList();
		return $ccfg;
	}


	public function getCatUcfg ($catid)
	{
		$query = $this->_db->getQuery(true)
			->select('*')
			->from($this->_tbl)
			->where('catid = ' . $catid);
		$this->_db->setQuery($query);
		$ccfg = $this->_db->loadAssocList();
		return $ccfg;
	}

}