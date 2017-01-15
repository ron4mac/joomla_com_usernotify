<?php
/*
* @package    User Notify Component
* @copyright  (C) 2016 RJCreations. All rights reserved.
* @license    GNU General Public License version 3 or later; see LICENSE.txt
*/

defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');

class UserNotifyModelCategory extends JModelAdmin
{
	protected $text_prefix = 'COM_USERNOTIFY';

	protected function canDelete ($record)
	{
		if (!empty($record->id)) {
			if ($record->state != -2) {
				return ;
			}
			$user = JFactory::getUser();

			if ($record->catid) {
				return $user->authorise('core.delete', 'com_usernotify.category.'.(int) $record->catid);
			}
			else {
				return parent::canDelete($record);
			}
		}	
	}


	protected function canEditState ($record)
	{
		$user = JFactory::getUser();

		if (!empty($record->catid)) {
			return $user->authorise('core.edit.state', 'com_usernotify.category.'.(int) $record->catid);
		}
		else {
			return parent::canEditState($record);
		}
	}


	public function getTable ($type = 'Category', $prefix = 'UserNotifyTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}


	public function getNid4Cid ($recordId)
	{
		$db = $this->getDbo();
		$db->setQuery('SELECT nid FROM #__usernotify_c WHERE cid='.$recordId);
		return $db->loadResult();
	}


	public function getCatTitleExt ($recordId)
	{
		$db = $this->getDbo();
		$db->setQuery('SELECT title,extension FROM #__categories WHERE id='.$recordId);
		$result = $db->loadAssoc();
		return $result['title'].' ('.$result['extension'].')';
	}


	public function resetCategories ($idArray)
	{
		$db = $this->getDbo();
		$db->setQuery('DELETE FROM #__usernotify_c WHERE cid IN ('.implode(',', $idArray).')');
		$db->execute();
	}


	public function getForm ($data = array(), $loadData = true)
	{
		// Initialise variables.
		$app = JFactory::getApplication();

		// Get the form.
		$form = $this->loadForm('com_usernotify.category', 'category', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}

		// Determine correct permissions to check.
		if ($this->getState('category.id')) {
			// Existing record. Can only edit in selected categories.
			$form->setFieldAttribute('catid', 'action', 'core.edit');
		} else {
			// New record. Can only create in selected categories.
			$form->setFieldAttribute('catid', 'action', 'core.create');
		}

		// Modify the form based on access controls.
		if (!$this->canEditState((object) $data)) {
			// Disable fields for display.
			$form->setFieldAttribute('ordering', 'disabled', 'true');
			$form->setFieldAttribute('state', 'disabled', 'true');
			$form->setFieldAttribute('publish_up', 'disabled', 'true');
			$form->setFieldAttribute('publish_down', 'disabled', 'true');

			// Disable fields while saving.
			// The controller has already verified this is a record you can edit.
			$form->setFieldAttribute('ordering', 'filter', 'unset');
			$form->setFieldAttribute('state', 'filter', 'unset');
			$form->setFieldAttribute('publish_up', 'filter', 'true');
			$form->setFieldAttribute('publish_down', 'filter', 'true');
		}

		return $form;
	}

	protected function loadFormData ()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_usernotify.edit.category.data', array());

		if (empty($data)) {
			$data = $this->getItem();

			// Prime some default values.
			if ($this->getState('category.id') == 0) {
				$app = JFactory::getApplication();
				$data->set('cid', JFactory::getApplication()->input->getInt('cid', $app->getUserState('com_usernotify.usernotify.filter.category_id')));
			}
			if (!$data->cid)
				$data->set('cid', $app->getUserState('com_usernotify.cfg.category.cid'));
		}

		return $data;
	}

	public function getItem ($pk = null)
	{
		if ($item = parent::getItem($pk)) {
			// Convert the grps field to an array.
			if ($item->grps)
				$item->grps = explode(',', $item->grps);
		}

		return $item;
	}

	protected function getReorderConditions ($table)
	{
		$condition = array();
		$condition[] = 'catid = '.(int) $table->catid;
		return $condition;
	}

}