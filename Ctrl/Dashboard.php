<?php

class Dashboard
{
	public function index() {
		CNavigation::setTitle('Tableau de bord');
		
	}
	
	public function view() {
		CNavigation::setTitle(_('Visualisation d\'une demande de devis'));
		if (isset($_REQUEST['id'])) {
			$devis = R::load('devis', $_REQUEST['id']);
			//groaw($devis->getProperties());
			DevisView::showForm($devis->getProperties(), $devis->getID(), true);
		}
		else
		{
			CTools::hackError();
		}
	}

	public function liste() {
		CNavigation::setTitle(_('Liste des demandes'));
		DevisView::showList(R::find('devis', 'etape = 0'));
	}
}

?>
