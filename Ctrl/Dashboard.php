<?php

class Dashboard
{
	public function index() {
		CNavigation::setTitle('Tableau de bord');
		groaw($_SESSION);	
	}
	
	public function view() {
		if (isset($_REQUEST['cat'])) {
			$d = new Devis();
			$d->categories();
			return;
		}

		CNavigation::setTitle(_('Visualisation d\'une demande de devis'));
		if (isset($_REQUEST['id'])) {
			$devis = R::load('devis', $_REQUEST['id']);
			if (!$devis->getId()) CTools::hackError();

			$admin = $_SESSION['user']->isAdmin;

			if ($admin)
			{
				CHead::addJS('Devis');
			}

			DevisView::showForm($devis->getProperties(),
				$admin ? 'admin' : 'artisan',
				$devis->getID(),
				!$admin,
				$devis->etape,
				!($admin || false));
		}
		else
		{
			CTools::hackError();
		}
	}

	public function liste() {
		echo "<div class=\"well well-small\">\n\t";

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
		
		$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : -1;
		$subtype = isset($_REQUEST['subtype']) ? $_REQUEST['subtype'] : -1;
		$dep = Regions::validerID(isset($_REQUEST['dep']) ? $_REQUEST['dep'] : -1);
		Categories::validerIDs($type, $subtype);

		$type = (!isset($_REQUEST['type']) || $_REQUEST['type'] === '*') ? '*' : $type;
		$subtype = (!isset($_REQUEST['subtype']) || $_REQUEST['subtype'] === '*') ? '*' : $subtype;
		$dep = (!isset($_REQUEST['dep']) || $_REQUEST['dep'] === '*') ? '*' : $dep;

		if ($type !== '*') $query .= " and type = $type";
		if ($subtype !== '*') $query .= " and subtype = $subtype";
		if ($dep !== '*') $query .= " and dep = $dep";

		DevisView::showFormSelectionList($type, $subtype, $dep);

		echo "</div>\n";
		DevisView::showList(R::find('devis', $query));
	}
}

?>
