<?php

define('NO_LOGIN_REQUIRED', true);

class Session
{
	
	public function index() {
		$this->login();
	}

	public function login() {
		CNavigation::setTitle(_('Connexion'));
		CNavigation::setDescription(_('Se connecter à l\'interface d\'administration'));
		new SessionView();
	}

	public function submit() {
		if (CNavigation::isValidSubmit(array('email_devis', 'password_devis'), $_POST)) {
			
			$user = R::findOne('user', 'mail = :mail AND password = :password', array('mail' => $_POST['email_devis'], 'password' => sha1($_POST['password_devis'].'grossel_devis')));

			if ($user) {
				$_SESSION['logged'] = true;
				$_SESSION['user'] = $user;
				CNavigation::redirectToApp('Dashboard');
			}
		}

		new CMessage(_('Impossible de se connecter !!!'), 'error');
		CNavigation::redirectToApp('Session');
	}

	public function logout() {
		session_destroy();
		session_start();
		new CMessage(_('Déconnexion réussie'));
		CNavigation::redirectToApp('Session','login');
	}

}

?>
