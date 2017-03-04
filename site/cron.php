<?php
/*
* @package    User Notify Component
* @copyright  (C) 2016 RJCreations. All rights reserved.
* @license    GNU General Public License version 3 or later; see LICENSE.txt
*/
define('_JEXEC',1);
if (file_exists(dirname(dirname(__DIR__)).'/includes')) {
	define('JPATH_BASE', dirname(dirname(__DIR__)));
} else {
	define('JPATH_BASE', dirname(dirname(dirname(__DIR__))));
}

require_once JPATH_BASE . '/includes/defines.php';
require_once JPATH_LIBRARIES . '/import.legacy.php';
require_once JPATH_LIBRARIES . '/cms.php';
require_once JPATH_CONFIGURATION . '/configuration.php';

class UNotifyApp extends JApplicationCli
{
	// to be used to send notifications when email/sms will be queued for metered sending
	public function doExecute ()
	{
		$cparms = JComponentHelper::getParams('com_usernotify');
		$limit = $cparms->get('msgper', 40);

		$qfil = JPATH_SITE.'/tmp/unotifyqueue.sqlite';
		if (!file_exists($qfil)) return;

		$qdb = JDatabaseDriver::getInstance(array('driver'=>'sqlite','database'=>$qfil));
		$qdb->setDebug(7);
		$qdb->connect();
		$qdb->setQuery('SELECT * FROM `queue` LIMIT '.$limit);
		$lst = $qdb->loadAssocList();
		foreach ($lst as $m) {
			$this->sendNotice($m['addr'],$m['subj'],$m['body']);
			$qdb->setQuery('DELETE FROM `queue` WHERE `q_id`='.$m['q_id'])->execute();
		}
	}

	private function sendNotice ($addr, $subj, $body)
	{
		$mailer = JFactory::getMailer();
		$mailer->XMailer = 'Joomla UserNotify';
	//	$mailer->useSendmail();
		$mailer->addRecipient($addr);
		$mailer->setSubject($subj);
		$mailer->isHTML(true);
	//	$mailer->Encoding = 'base64';
		$mailer->setBody('<!DOCTYPE html><html><head></head><body>'.$body.'</body></html>');
	//	$mailer->AltBody = JMailHelper::cleanText(strip_tags($body));
		$mailer->AltBody = htmlspecialchars_decode(strip_tags($body), ENT_QUOTES);
	//	$mailer->AddEmbeddedImage( JPATH_ROOT.'/images/rjcreationslogo.png', 'logo_id', 'rjcreationslogo.png', 'base64', 'image/png' );
		if (!$mailer->Send()) $this->ldump(array('Mailing failed: ',$mailer->ErrorInfo));
	}

}

try
{
    $cron_app = new UNotifyApp();
    $cron_app->execute();
}
catch (Exception $e)
{
    // An exception has been caught, just echo the message.
    echo $e->getMessage();
    exit($e->getCode());
}
