<?php
/*
* @package    User Notify Component
* @copyright  (C) 2015 RJCreations. All rights reserved.
* @license    GNU General Public License version 3 or later; see LICENSE.txt
*/

defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

class UserNotifyControllerCategory extends JControllerForm
{
	protected $view_list = 'usernotify';

	public function config ($key=null, $urlVar=null)
	{	//echo'<xmp>';var_dump($this);jexit();
		$app   = JFactory::getApplication();
		$model = $this->getModel();
		$table = $model->getTable();
		$cid   = $this->input->post->get('cid', array(), 'array');
		$context = "$this->option.cfg.$this->context";

		// Determine the name of the primary key for the data.
		if (empty($key))
		{
			$key = $table->getKeyName();
		}

		// To avoid data collisions the urlVar may be different from the primary key.
		if (empty($urlVar))
		{
			$urlVar = $key;
		}

		// Get the previous record id (if any) and the current record id.
		$recordId = (int) (count($cid) ? $cid[0] : $this->input->getInt($urlVar));
		$checkin = property_exists($table, 'checked_out');	//echo'<xmp>';var_dump($recordId);jexit();

		$catid = $recordId;
		$recordId = $model->getNid4Cid($recordId);	//var_dump($recordId);jexit();
//		if (!$recordId) {
//			return $this->add();
//		}
		$app->setUserState($context . '.nid', $recordId);
		$app->setUserState($context . '.cid', $catid);
	//	$model->setState('category.cfg.nid', $recordId);
	//	$model->setState('category.cfg.cid', $catid);

		// Access check.
		if (!$this->allowEdit(array($key => $recordId), $key))
		{
			$this->setError(JText::_('JLIB_APPLICATION_ERROR_EDIT_NOT_PERMITTED'));
			$this->setMessage($this->getError(), 'error');

			$this->setRedirect(
				JRoute::_(
					'index.php?option=' . $this->option . '&view=' . $this->view_list
					. $this->getRedirectToListAppend(), false
				)
			);

			return false;
		}

		// Attempt to check-out the new record for editing and redirect.
		if ($checkin && !$model->checkout($recordId))
		{
			// Check-out failed, display a notice but allow the user to see the record.
			$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_CHECKOUT_FAILED', $model->getError()));
			$this->setMessage($this->getError(), 'error');

			$this->setRedirect(
				JRoute::_(
					'index.php?option=' . $this->option . '&view=' . $this->view_item
					. $this->getRedirectToItemAppend($recordId, $urlVar), false
				)
			);

			return false;
		}
		else
		{
			// Check-out succeeded, push the new record id into the session.
			$this->holdEditId($context, $recordId);
			$app->setUserState($context . '.data', null);

			$this->setRedirect(
				JRoute::_(
					'index.php?option=' . $this->option . '&view=' . $this->view_item
					. $this->getRedirectToItemAppend($recordId, $urlVar), false
				)
			);

			return true;
		}
	}

	public function trash ()
	{
		$app   = JFactory::getApplication();
		$model = $this->getModel();
		$table = $model->getTable();
		$cids  = $this->input->post->get('cid', array(), 'array');

		$model->resetCategories($cids);

		$this->display();
	}

}