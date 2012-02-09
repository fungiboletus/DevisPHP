<?php

define('NO_LOGIN_REQUIRED', true);

class Devis
{
	public function index() {
		if (isset($_REQUEST['cat']))
		{
			$cats = Categories::$liste;
			$_REQUEST['AJAX_MODE'] = true;

			DevisView::showSousCatSelect(
				array_key_exists($_REQUEST['cat'], $cats) ?
					$cats[$_REQUEST['cat']] : array());
		}
		else
		{
			CNavigation::setTitle(_('Nouvelle demande de devis'));

			DevisView::showForm(Categories::$liste);
		}
	}

	public function submit() {
		
		if (CNavigation::isValidSubmit(array('type', 'sujet', 'nom','mail'), $_POST))
		{
			new CMessage('Owi');
			CNavigation::redirectToApp('Devis', 'ok');
		}
		else 
		{
			CTools::hackError();
		}
	}

	public function ok() {
	
	}
}
?>
