<?php

class Dashboard
{
	public function index() {
		CNavigation::setTitle('Tableau de bord');
		groaw($_SESSION);	
	}
	
	public function view() {
		CNavigation::setTitle(_('Visualisation d\'une demande de devis'));
		if (isset($_REQUEST['id'])) {
			$devis = R::load('devis', $_REQUEST['id']);
			if (!$devis->getId()) CTools::hackError();

			$admin = $_SESSION['user']->isAdmin;

			if ($admin || false) {
				DevisView::showForm($devis->getProperties(),
					$admin ? 'admin' : 'artisan',
					$devis->getID(),
					!$admin,
					$devis->etape);
			}
			else
			{
				groaw($devis);
			}
		}
		else
		{
			CTools::hackError();
		}
	}

	public function liste() {
		echo "<div class=\"well\">\n\t";

		if ($_SESSION['user']->isAdmin) {
			switch (isset($_REQUEST['etape']) ? $_REQUEST['etape'] : null) {
				case 'validees':
					CNavigation::setTitle(_('Liste des demandes validées'));
					$etape = '= 1';
					break;
				case 'poubelle':
					CNavigation::setTitle(_('Poubelle'));
					CNavigation::setDescription('Pas encore vraiment implémenté');
					$etape = '= -1';
					break;
				case 'historique':
					CNavigation::setTitle(_('Historique'));
					CNavigation::setDescription('Pas encore vraiment implémenté');
					$etape = '< -1';
					break;
				case 'validation':
				default:
					CNavigation::setTitle(_('Liste des demandes à valider'));
					$etape = '= 0';
					break;
			}

			DevisView::showChoixListe($etape);
		}
		else
		{
			CNavigation::setTitle(_('Liste des demandes'));
			$etape = '= 1';
		}


		$query = 'etape '.$etape;
		
		if (isset($_REQUEST['type']) && isset($_REQUEST['subtype']))
		{
			$type = $_REQUEST['type'];
			$subtype = $_REQUEST['subtype'];

			Categories::validerIDs($type, $subtype);

			if ($_REQUEST['type'] !== '*') $query .= " and type = $type";
			if ($_REQUEST['subtype'] !== '*') $query .= " and subtype = $subtype";
			DevisView::showFormSelectionList();
		}

		echo "</div>\n";
		DevisView::showList(R::find('devis', $query));
	}
}

?>
