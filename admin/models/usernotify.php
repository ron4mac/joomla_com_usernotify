<?php
/*
* @package    User Notify Component
* @copyright  (C) 2016 RJCreations. All rights reserved.
* @license    GNU General Public License version 3 or later; see LICENSE.txt
*/

defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

class UserNotifyModelUserNotify extends JModelList
{

	public function __construct ($config = array())
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array('catID', 'pub', 'upd');
		}
		parent::__construct($config);
	}


	public function getItems ()
	{
		if ($items = parent::getItems()) {
			foreach ($items as &$item) {
				if (empty($item->grps)) continue;
				$grps = explode(',', $item->grps);
				$nams = array();
				foreach ($grps as $grp) {
					$nams[] = $this->getGrpName($grp);
				}
				$item->grps = implode('<br />', $nams);
			}
		}
		return $items;
	}


	protected function populateState ($ordering = null, $direction = null)
	{
		// Load the filter state
		$search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$accessId = $this->getUserStateFromRequest($this->context.'.filter.access', 'filter_access', null, 'int');
		$this->setState('filter.access', $accessId);

		$published = $this->getUserStateFromRequest($this->context.'.filter.state', 'filter_published', '', 'string');
		$this->setState('filter.state', $published);

		$categoryId = $this->getUserStateFromRequest($this->context.'.filter.category_id', 'filter_category_id', '');
		$this->setState('filter.category_id', $categoryId);

		$language = $this->getUserStateFromRequest($this->context.'.filter.language', 'filter_language', '');
		$this->setState('filter.language', $language);

		// Load the parameters
		$params = JComponentHelper::getParams('com_usernotify');
		$this->setState('params', $params);

		// List state information
		parent::populateState('a.title', 'asc');
	}


	protected function getListQuery ()
	{
		$cOpts = JComponentHelper::getParams('com_usernotify');
		$targs = -1;
		if ($cOpts->get('target')) {
			$targs = '"' . implode('","', $cOpts->get('target')) . '"';
		} else {
			JFactory::getApplication()->enqueueMessage(JText::_('COM_USERNOTIFY_SETUP_OPTIONS'), 'Notice');
		}

		// Create a new query object
		$db = $this->getDbo();
		$query = $db->getQuery(true);

		// Select the required fields from the table
		$query->select('c.id AS catid, c.title, c.description, c.extension, n.*')
			->from('`#__categories` AS c')
			->where('c.extension IN ('.$targs.')')
			->join('LEFT', '`#__usernotify_c` AS n ON n.cid = c.id');

		return $query;
	}


	private function getGrpName ($gid)
	{
		static $names = array();

		if (empty($names[$gid])) {
			$db = $this->getDbo();
			$db->setQuery('SELECT title FROM #__usergroups WHERE id='.$gid);
			$nam = $db->loadResult();
			$names[$gid] = $nam ?: '<deleted>';
		}

		return $names[$gid];
	}

}