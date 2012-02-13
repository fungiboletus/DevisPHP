<?php

define('NO_LOGIN_REQUIRED', true);

class Devis
{

	private function getCatSelect() {
		$cats = Categories::$liste;
		$_REQUEST['AJAX_MODE'] = true;

		DevisView::showSousCatSelect(
			isset($_REQUEST['cat'], $cats) ?
				$cats[$_REQUEST['cat']][1] : array());
	}

	public function index() {
		if (isset($_REQUEST['cat']))
		{
			$this->getCatSelect();
		}
		else
		{
			CNavigation::setTitle(_('Nouvelle demande de devis'));

			DevisView::showForm(array());
		}
	}

	public function submit() {
		
		if (isset($_REQUEST['cat']))
		{
			$this->getCatSelect();
		}
		elseif (CNavigation::isValidSubmit(array('type', 'sujet', 'nom','mail'), $_POST))
		{
			new CMessage('Owi');
			groaw($_POST);
			DevisView::showForm($_POST, Categories::$liste, Regions::$liste);
			//CNavigation::redirectToApp('Devis', 'ok');
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
