<?php
/*
* @package    User Notify Component
* @copyright  (C) 2016 RJCreations. All rights reserved.
* @license    GNU General Public License version 3 or later; see LICENSE.txt
*/

defined('_JEXEC') or die;

class UserNotifyModelUsernotify extends JModelForm
{
	protected $tbl = null;
	protected $tbluc = null;
	protected $cats = null;

	public function getForm ($data=array(), $loadData=true)
	{
		// Get the form.
		$form = $this->loadForm('com_usernotify.notify', 'notify', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}

		$cats = $this->getCatSettings();

		$flds = '';
		$ynradio = '" type="radio" default="0" hiddenLabel="hidden" class="btn-group btn-group-yesno catset"><option value="1" class="btn-mini">JYES</option><option value="0" class="btn-mini">JNO</option></field>';
		foreach ($cats as $cat) {
			$cid = $cat['cid'];
			$flds .= '<fields name="'.$cid.'">';
			$flds .= '<fieldset name="cat'.$cid.'">';
			$flds .= '<field name="eml'.$ynradio;
			$flds .= '<field name="sms'.$ynradio;
			$flds .= '<field name="upd'.$ynradio;
			$flds .= '</fieldset>';
			$flds .= '</fields>';
		}
		$form->load('<form><fields name="cats"><fieldset name="ucopts">'.$flds.'</fieldset></fields></form>');

		// by default, set email on for each category
		$cdat = array();
		foreach ($cats as $cat) {
			$cdat[$cat['cid']]['eml'] = 1;
		}

		// merge in the user's actual settings
		$uid = JFactory::getUser()->get('id');
		if ($ccfgs = $this->tbluc->getUserCcfg($uid)) {
			$ucats = array();
			foreach ($ccfgs as $ccfg) {
				$ucats[$ccfg['catid']]['eml'] = $ccfg['eml'];
				$ucats[$ccfg['catid']]['sms'] = $ccfg['sms'];
				$ucats[$ccfg['catid']]['upd'] = $ccfg['upd'];
			}
			$cdat = $ucats + $cdat;
		}

		// bind in the category stuff
		$tmp = new stdClass;
		$tmp->cats = $cdat;
		$form->bind($tmp);

		return $form;
	}


	public function getItem ($pk = null)
	{
		$uid = JFactory::getUser()->get('id');
		$this->tbl = $this->getTable();
		$this->tbluc = $this->getTable('usernotifyuc');
		if ($this->tbl->load(array('uid'=>$uid))) {
			return $this->tbl;
		} else {
			return (object) array('oo_all'=>1, 'oo_email'=>1);
		}
	}


	public function saveUserSettings ($data)
	{
		$vals = $data;
		$vals['uid'] = JFactory::getUser()->get('id');
		$this->tbl = $this->getTable();
		$this->tbl->save($vals);

		if (isset($data['cats'])) {
			$uid = JFactory::getUser()->get('id');
			$tbluc = $this->getTable('usernotifyuc');
			foreach ($data['cats'] as $cid=>$opts) {
				$tbluc->save(array_merge(array('catid'=>$cid, 'uid'=>$uid), $opts));
			}
		}
	}


	public function getCatSettings ()
	{
		if (!$this->cats) {
			$db = $this->getDbo();
			$db->setQuery('SELECT uc.cid, c.title, c.description FROM `#__usernotify_c` AS uc LEFT JOIN `#__categories` AS c ON uc.cid = c.id');
			$this->cats = $db->loadAssocList();
		}
		return $this->cats;
	}


	protected function loadFormData ()
	{
		$app = JFactory::getApplication();
		// Check the session for previously entered form data.
		$data = $app->getUserState('com_usernotify.notification.data', array());

		if (empty($data)) {
			$data = $this->getItem();

			// Prime some default values.
			if ($this->getState('category.id') == 0) {
				$data->cid = $app->input->getInt('cid', $app->getUserState('com_usernotify.usernotify.filter.category_id'));
			}
			if (!$data->cid)
				$data->cid = $app->getUserState('com_usernotify.cfg.category.cid');
		}

		return $data;
	}


	private function getUserSettings ()
	{
		$uid = JFactory::getUser()->get('id');
		$db = $this->getDbo();
		$db->setQuery('SELECT * FROM #__usernotify_u WHERE uid='.$uid);
		return $db->loadAssoc();
	}

}