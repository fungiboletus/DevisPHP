<?php

class User
{
	public function index()
	{
		$this->view($_SESSION['user']);
		CNavigation::setTitle(_('Informations de votre profil'));
	}

	public function view($user = null)
	{
		if ($user === null)
		{
			if (!$_SESSION['user']->isAdmin) CTools::hackError();

			$user = R::load('user', isset($_REQUEST['id']) ? $_REQUEST['id'] : $_SESSION['user']->getId());
			if (!$user->getID()) CTools::hackError();
		}
		$props = $user->getProperties();
		unset($props['sharedDevis']);

		CNavigation::setTitle(_('Visualisation de l\'utilisateur numéro ').$user->getID());
		UserView::showForm($props, $_SESSION['user']->isAdmin, file_exists('PDF/'.sha1($user->mail).'.pdf'));
	}

	public function liste()
	{
		if (!$_SESSION['user']->isAdmin) CTools::hackError();

		CNavigation::setTitle(_('Liste des artisans'));

		UserView::showList(R::find('user'));
	}

	public function submit()
	{
		//groaw($_POST);
		if (!CNavigation::isValidSubmit(array('id', 'name', 'mail', 'password', 'company', 'website', 'tel'), $_POST)) CTools::hackError();

		if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
			new CMessage(_('Veuillez renseigner une adresse mail.'), 'error');
			CNavigation::redirectToApp('User', 'view', array('id' => $_POST['id']));
		}

		$admin = $_SESSION['user']->isAdmin;

		if (!$admin && intval($_POST['id']) != $_SESSION['user']->getID()) CTools::hackError();

		$user = R::load('user', $_POST['id']);

		if (!$user->getID()) CTools::hackError();

		$user->name = $_POST['name'];
		if ($_POST['password'] !== '******')
			$user->password = sha1($_POST['password'].'grossel_devis');
		$user->mail = $_POST['mail'];
		$user->company = $_POST['company'];
		$user->website = $_POST['website'];
		$user->tel = $_POST['tel'];

		if ($admin && CNavigation::isValidSubmit(array('credit','deps', 'cats'), $_POST))
		{
			$user->cats = $_POST['cats'];
			$user->deps = $_POST['deps'];
			$user->credit = intval($_POST['credit']);
		}

		R::store($user);

		if (isset($_FILES['pdf']))
		{
			if ($_FILES['pdf']['error'] === UPLOAD_ERR_OK)
			{
				// C'est une vérification d'une information qui vient du client
				// mais de toutes façons, l'intêret de stocker autre chose pour un pdf est faible
				// l'idée est plus de signaler aux gens qui ont un mauvais navigateur l'éventuelle erreur
				// au lieu de réellement coder une fonction de sécurité
				if ($_FILES['pdf']['type'] == 'application/pdf')
				{
					if (!move_uploaded_file($_FILES['pdf']['tmp_name'], 'PDF/'.sha1($user->mail).'.pdf')) {
				
						new CMessage(_('Impossible d\'enregistrer le fichier pdf.'),'error');
					}
				}
				else
				{
					new CMessage(_('Le fichier n\'est pas de type pdf (selon votre navigateur)'), 'error');
				}

			}
			else
			{
				switch ($_FILES['pdf']['error'])
				{
					case UPLOAD_ERR_INI_SIZE:
					case UPLOAD_ERR_FORM_SIZE:
						new CMessage(_('Le fichier est trop voluminux.'), 'error');
						break;
					case UPLOAD_ERR_PARTIAL:
						new CMessage(_('Le fichier n\'a pas totalement été envoyé.'),'error');
						break;
					case UPLOAD_ERR_NO_FILE:
						// Le comportement de base
						break;
					default:
						new CMessage(_('Une erreur inconnue a été détectée pour le fichier pdf.'), 'error');
				}
			}
		}

		new CMessage(_('Enregistrement effectué'));
		
		// Mise à jour de l'utilisateur dans la session aussi
		if (!$admin)
		{
			$_SESSION['user'] = $user;
			CNavigation::redirectToApp('User');
		}
		else
		{
			CNavigation::redirectToApp('User', 'view', array('id'=>$user->getId()));
		}
	}
}
?>
