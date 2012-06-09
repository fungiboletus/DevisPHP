<?php

class User
{

	private function upload_file($file, $old_value, $suffixe, $image_allowed = true, $pdf_allowed = true)
	{

		if ($file['error'] === UPLOAD_ERR_OK)
		{
			// C'est une vérification d'une information qui vient du client
			// mais de toutes façons, l'intêret de stocker autre chose pour un pdf est faible
			// l'idée est plus de signaler aux gens qui ont un mauvais navigateur l'éventuelle erreur
			// au lieu de réellement coder une fonction de sécurité
			if ($pdf_allowed && $file['type'] == 'application/pdf')
			{
				$suffixe .= '.pdf';
			}
			else if ($image_allowed && ($file['type'] == 'image/png' || $file['type'] == 'image/x-png'))
			{
				$suffixe .= '.png';
			}
			else if ($image_allowed && ($file['type'] == 'image/jpeg' || $file['type'] == 'image/pjpeg'))
			{
				$suffixe .= '.jpg';
			}
			else
			{
				new CMessage(_('Le fichier ne possède pas un bon format de fichier.'), 'error');
				return;
			}
		
			$path = sha1_file($file['tmp_name']).$suffixe;
			if (!move_uploaded_file($file['tmp_name'], 'Uploads/'.$path)) {
		
				new CMessage(_('Impossible d\'enregistrer le fichier.'),'error');
			}
			return $path;
		}
		else
		{
			switch ($file['error'])
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
					return $old_value;
				default:
					new CMessage(_('Une erreur inconnue a été détectée pour le fichier pdf.'), 'error');
			}
		}
	}

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
		UserView::showForm($props, $_SESSION['user']->isAdmin);
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

		if (!isset($_POST['cats'])) $_POST['cats'] = array();
		if (!isset($_POST['deps'])) $_POST['deps'] = array();
		
		foreach ($_POST['cats'] as &$c)
			$c = intval($c);	
		
		foreach ($_POST['deps'] as &$d)
			$d = intval($d);	
	
		$user->cats = json_encode($_POST['cats']);
		$user->deps = json_encode($_POST['deps']);

		if ($admin && CNavigation::isValidSubmit(array('credit'), $_POST))
		{
			$user->credit = intval($_POST['credit']);
		}


		if (isset($_FILES['presentation']))
			$user->presentation = $this->upload_file($_FILES['presentation'], $user->presentation, 'presentation', false, true);
		if (isset($_FILES['kbis']))
			$user->kbis = $this->upload_file($_FILES['kbis'], $user->kbis, 'kbis');
		if (isset($_FILES['assurdec']))
			$user->assurdec = $this->upload_file($_FILES['assurdec'], $user->assurdec, 'assurdec');
		if (isset($_FILES['pieceidentite']))
			$user->pieceidentite = $this->upload_file($_FILES['pieceidentite'], $user->pieceidentite, 'pieceidentite');

		R::store($user);

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
