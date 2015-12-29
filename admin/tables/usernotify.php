<?php
defined('_JEXEC') or die;

class TableUsernotify extends JTable
{
	public function __construct (&$db)
	{
		parent::__construct('#__usernotify_u', array('id','uid'), $db);
	}

	public function bind ($array, $ignore = array())
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
		return parent::bind($array, $ignore);
	}

//	public function store ($updateNulls = false)
//	{
//		return parent::store($updateNulls);
//	}

}