<?php
/*
* @package    User Notify Component
* @copyright  (C) 2015 RJCreations. All rights reserved.
* @license    GNU General Public License version 3 or later; see LICENSE.txt
*/

defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

class UserNotifyModelUserNotify extends JModelList
{

	public function __construct($config = array())
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array('catID', 'pub', 'upd');
		}
		parent::__construct($config);
	}


	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = JFactory::getApplication('administrator');

		// Load the filter state.
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

		// Load the parameters.
		$params = JComponentHelper::getParams('com_usernotify');
		$this->setState('params', $params);

		// List state information.
		parent::populateState('a.title', 'asc');
	}

	protected function getListQuery()
	{
		$cOpts = JComponentHelper::getParams('com_usernotify');	//echo'<xmp>';var_dump($cOpts->get('target'));echo'</xmp>';//jexit();
		$targs = '"' . implode('","', $cOpts->get('target')) . '"';
		
		// Create a new query object.
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);

		// Select the required fields from the table.
		$query->select('c.id AS catid, c.title, c.extension, n.*')
			->from('`#__categories` AS c')
			->where('c.extension IN ('.$targs.')')
			->join('LEFT', '`#__usernotify_c` AS n ON n.cid = c.id');

		return $query;
	}

}