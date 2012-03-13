<?php
define('NO_LOGIN_REQUIRED', true);

class Registration
{
	public function index() {
		CNavigation::setTitle('Enregistrement');
		CNavigation::setDescription('Créez votre compte sans attendre !');

		RegistrationView::showForm();
	}

	public function submit() {
	
		if (CNavigation::isValidSubmit(array('nom', 'mail', 'password'), $_POST)) {
			if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
				new CMessage(_('Une adresse mail est demandée'), 'error');
				CNavigation::redirectToApp('Registration');
			}

			$old_user = R::findOne('user', 'mail = :mail', array('mail' => $_POST['mail']));

			if ($old_user) {
				new CMessage(_('Un compte existe déjà avec cette adresse mail'), 'error');
				CNavigation::redirectToApp('Registration');
			}

			$user = R::dispense('user');
			$user->name = $_POST['nom'];
			$user->mail = $_POST['mail'];
			$user->password = sha1($_POST['password'].'grossel_devis');
			$user->isAdmin = false;
			$user->credit = CREDIT_DEPART;

			R::store($user);
			
			new CMessage('Inscription réussie');
			$_SESSION['logged'] = true;
			$_SESSION['user'] = $user;
			CNavigation::redirectToApp('Dashboard');
		}
		else {
			CTools::hackError();
		}
	}
}
?>
