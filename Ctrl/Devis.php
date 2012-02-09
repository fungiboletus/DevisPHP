<?php

define('NO_LOGIN_REQUIRED', true);

class Devis
{
	public function index() {
		CNavigation::setTitle(_('Nouvelle demande de devis'));

		DevisView::showForm();
	}

	public function submit() {
		
		if (CNavigation::isValidSubmit(array('type', 'sujet', 'nom','mail'), $_POST))
		{
			new CMessage('Owi');
			CNavigation::redirectToApp('Devis', 'ok');
		}
		else {
			CTools::hackError();
		}
	}

	public function ok() {
	
	}
}
?>
