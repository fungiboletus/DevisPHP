<?php

define('NO_LOGIN_REQUIRED', true);
define('NO_HEADER_BAR', true);

class Session
{
	
	public function index() {
		$this->login();
	}

	public function login() {
		CNavigation::setTitle(_('Login'));
		new SessionView();
	}

	public function submit() {
		if (CNavigation::isValidSubmit(array('email_devis', 'password_devis'), $_POST)) {
R::debug(true);
			$user = R::findOne('user', 'mail = :mail AND password = :password', array('mail' => $_POST['email_devis'], 'password' => sha1($_POST['password_devis'].'grossel_devis')));

			if ($user) {
				$_SESSION['logged'] = true;
				$_SESSION['name'] = $user->name;
				$_SESSION['mail'] = $user->mail;
				$_SESSION['bd_id'] = $user->getID();
				$_SESSION['user'] = $user;
				CNavigation::redirectToApp('Dashboard');
			}
		}

		new CMessage(_('Impossible de se connecter !!!'));
		CNavigation::redirectToApp('Session');
	}

	public function logout() {
		session_destroy();
		CNavigation::redirectToApp('Session','login');
	}

}

?>
