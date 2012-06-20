<?php
define('NO_LOGIN_REQUIRED', true);

class Registration
{
	public function index() {
		CNavigation::setTitle(_('Enregistrement'));
		CNavigation::setDescription(_('Indiquez votre adresse mail pour vous inscrire.'));
		RegistrationView::showMailForm();
	}

	public function inscription()
	{
		if (isset($_GET['token']))
		{
			$inscription = R::findOne('inscription', 'token = ?', array($_GET['token']));

			if ($inscription)
			{
				CNavigation::setTitle(_('Enregistrement'));
				CNavigation::setDescription(_('Créez votre compte sans attendre !'));

				RegistrationView::showForm($inscription->mail, $inscription->token);
				return;
			}
		}

		new CMessage(_('La référence de l\'inscription est invalide. Vous êtes peut-être déjà inscrit. Si ce n\'est pas le cas, veuillez renouveler l\'opération.'), 'error');
		CNavigation::redirectToApp('Registration');

	}

	public function submit_mail()
	{
		if (!CNavigation::isValidSubmit(array('mail'), $_POST)) CTools::hackError();

		if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
			new CMessage(_('Veuillez renseigner une adresse mail valide'), 'error');
			CNavigation::redirectToApp('Registration');
		}

		$old_user = R::findOne('user', 'mail = :mail', array('mail' => $_POST['mail']));

		if ($old_user) {
			new CMessage(_('Un compte existe déjà avec cette adresse mail'), 'error');
			CNavigation::redirectToApp('Registration');
		}

		$token = sha1($_POST['mail'].uniqid().'avec_du_sel_svp');

		$inscription = R::dispense('inscription');
		$inscription->mail = $_POST['mail'];
		$inscription->token = $token;
		R::store($inscription);
	
		$url_inscription = CNavigation::generateUrlToApp('Registration', 'inscription', array('token' => $token));
		
		$mail = MMail::newMail()
			->setSubject(_('Inscription sur devis-equitable.fr'))
			->setTo($_POST['mail'])
			->setBody(_("Le formulaire d'inscription sur devis-equitable.fr est disponible à cette adresse : http://www.devis-equitable.fr").$url_inscription);
		MMail::send($mail);

		CNavigation::setTitle(_('Demande enregistrée'));
		RegistrationView::showInformationsMail();
	}

	public function submit() {
	
		if (!CNavigation::isValidSubmit(array('nom', 'password', 'token'), $_POST)) CTools::hackError();
			
		$inscription = R::findOne('inscription', 'token = ?', array($_POST['token']));

		if (!$inscription)
		{
			new CMessage(_('Il y a une erreur de référence dans l\'inscription.'));
			CNavigation::redirectToApp('Registration');
		}


		$user = R::dispense('user');
		$user->name = $_POST['nom'];
		$user->mail = $inscription->mail;
		$user->company = '';
		$user->website = '';
		$user->tel = '';
		$user->password = sha1($_POST['password'].'grossel_devis');
		$user->isAdmin = false;
		$user->credit = CREDIT_DEPART;
		$user->cats = '';
		$user->deps = '';

		R::store($user);
		R::trash($inscription);
		
		new CMessage(_('Inscription réussie'));
		$_SESSION['logged'] = true;
		$_SESSION['user'] = $user;
		CNavigation::redirectToApp('User');
	}
}
?>
