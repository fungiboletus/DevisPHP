<?php
require_once 'Tools/Swift/swift_required.php';

class MMail
{
	protected static $_mmail_transport = null;
	protected static $_mmail_mailer = null;

	protected static function _mmail_initialize_tm()
	{

		self::$_mmail_transport = call_user_func_array(array(MAIL_METHOD, 'newInstance'),
			$GLOBALS['mail_server_settings']);

		if (defined('MAIL_USER'))
		{
			self::$_mmail_transport->setUsername(MAIL_USER);
			self::$_mmail_transport->setPassword(MAIL_PASSWORD);
		}

		self::$_mmail_mailer = Swift_Mailer::newInstance(self::$_mmail_transport);
	}

	public static function newMail()
	{
		return Swift_Message::newInstance();
	}

	public static function send($mail)
	{
		if (self::$_mmail_mailer === null)
			self::_mmail_initialize_tm();

		$mail->setFrom($GLOBALS['mail_from']);
		self::$_mmail_mailer->send($mail);
	}
}

?>
