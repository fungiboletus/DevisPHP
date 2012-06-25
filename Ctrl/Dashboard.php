<?php

class Dashboard
{
	public function index() {
		CNavigation::setTitle(_('Tableau de bord'));
		DashboardView::showInfosCredit($_SESSION['user']->credit);
		$devis = $_SESSION['user']->sharedDevis;

		if (count($devis))
		{
			DashboardView::showListTitle();
			DevisView::showList($devis, false);
		}
	}

	public function view() {
		if (isset($_REQUEST['cat'])) {
			$d = new Devis();
			$d->categories();
			return;
		}

		if (isset($_REQUEST['id'])) {
			$devis = R::load('devis', $_REQUEST['id']);
			$id = $devis->getId();
			if (!$id) CTools::hackError();

			CNavigation::setTitle(_("Devis numéro $id"));
			if ($devis->date_creation)
				CNavigation::setDescription(AbstractView::formateDate($devis->date_creation));

			$admin = $_SESSION['user']->isAdmin;

			if ($admin) CHead::addJS('Devis');

			$achete = in_array($devis, $_SESSION['user']->sharedDevis);

			if ($devis->nb_achats >= NB_ACHATS_MAX && !$admin && !$achete)
			{
				new CMessage(_('Demande de devis non disponible.'), 'error');
				CNavigation::redirectToApp('Dashboard', 'liste');
			}
			
			if ($admin && $devis->nb_achats > 0)
			{
				echo '<h3>', _('Artisans ayant acheté cette demande de devis'),"</h3>\n<br/>\n";
				UserView::showList(R::related($devis, 'user'));
			}

			DevisView::showForm($devis->getProperties(),
				$admin ? 'admin' : ($achete ? 'artisan_achete' : ($devis->nb_achats >= NB_ACHATS_MAX ? 'artisan_max_achats' : 'artisan')),
				$id,
				!$admin,
				$devis->etape,
				!($admin || $achete));
			

		}
		else
		{
			CTools::hackError();
		}
	}

	public function acheter()
	{
		if (!isset($_REQUEST['id'])) CTools::hackError();
	
		$devis = R::load('devis', intval($_REQUEST['id']));

		if (!$devis->getId()) CTools::hackError();

		if (isset($_REQUEST['confirmer']))
		{
			if (in_array($devis, $_SESSION['user']->sharedDevis)) {
				new CMessage(_('Vous avez déjà acheté cette demande de devis'), 'error');
			}
			elseif ($_SESSION['user']->credit < COUT_ACHAT)
			{
				new CMessage(_('Désolé, mais votre solde de crédits est insuffisant pour acheter cette demande de devis.'), 'error');
			}
			elseif ($devis->nb_achats >= NB_ACHATS_MAX)
			{
				new CMessage(_('Désolé, mais il n\'est plus possible d\'acheter cette demande de devis'), 'error');
			}
			else
			{
				$_SESSION['user']->credit -= COUT_ACHAT;
				$_SESSION['user']->sharedDevis[] = $devis;
				R::store($_SESSION['user']);
				$devis->nb_achats += 1;
				R::store($devis);
				new CMessage(_("Votre achat a bien été effectué.\nLe client a reçu un mail présentant votre entreprise.\nNous vous encourageons à prendre contact et à envoyer votre devis dès que possible.\n\nMerci de votre confiance."));

				$company = $_SESSION['user']->company ? $_SESSION['user']->company : $_SESSION['user']->name; 
				$website = $_SESSION['user']->website ? ' ('.$_SESSION['user']->website.')' : '';
				$telephone = $_SESSION['user']->tel ? "\n\nTéléphone: ".$_SESSION['user']->tel : '';

				$body = _("Votre demande de devis sur Devis Équitable a été sélectionnée par l\'entreprise $company$website.");
			
				$mail = MMail::newMail()
					->setSubject(_('Un Votre demande de devis a été sélectionnée par l\'artisan «'.$company.'»'))
					->setTo(array($devis->mail => $devis->nom));

				$chemin_pdf = 'PDF/'.sha1($_SESSION['user']->mail).'.pdf';
				if (file_exists($chemin_pdf))
				{
					$mail->attach(
						Swift_Attachment::fromPath($chemin_pdf)->setFilename('Presentation.pdf')
					);
					$body .= _(' Vous trouverez une présentation en pièce jointe.');
				}

				$mail->setBody($body.$telephone);

				MMail::send($mail);
			}
			CNavigation::redirectToApp('Dashboard', 'view', array('id' => $devis->getId()));
		}
		else
		{
			CNavigation::setTitle(_('Achat d\'une demande de devis'));
			call_user_func(array('AchatView',
				$_SESSION['user']->credit < COUT_ACHAT ?
					'showInfoManqueCredit' : 'showConfirmationAchat'),
				$devis->getId(), $_SESSION['user']->credit, COUT_ACHAT);
		}
	}

	public function liste() {
		echo "<div class=\"well well-small\">\n\t";

		if ($_SESSION['user']->isAdmin) {
			switch (isset($_REQUEST['etape']) ? $_REQUEST['etape'] : null) {
				case 'validees':
					CNavigation::setTitle(_('Demandes validées'));
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
					CNavigation::setTitle(_('Demandes à valider'));
					$etape = '= 0';
					break;
			}

			DevisView::showChoixListe($etape);
		}
		else
		{
			CNavigation::setTitle(_('Toutes les demandes'));
			$etape = '= 1';
		}


		$query = 'etape '.$etape;
	
		if (isset($_REQUEST['notifications']) && $_REQUEST['notifications'])
		{

			$deps = json_decode($_SESSION['user']->deps);
			$cats = json_decode($_SESSION['user']->cats);

			foreach ($deps as &$dep)
				$dep = Regions::validerID($dep);
			
			$useless = 0;
			foreach ($cats as &$cat)
				Categories::validerIDs($cat, $useless); 
			
			if (!empty($deps))
				$query .= ' and dep in ('.implode(',',$deps).')';
			
			if (!empty($cats))
				$query .= ' and type in ('.implode(',',$cats).')';

			DevisView::showNotificationsListInfos();
		}
		else
		{
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
		
			DevisView::showFormSelectionList($type, $subtype, $dep, false);
		}
	
		$date_creation_max = time() - TEMPS_AFFICHAGE_DEVIS_ACHETES;

		// TODO installation
		if (!$_SESSION['user']->isAdmin) $query .= " AND (nb_achats < ".intval(NB_ACHATS_MAX)." OR date_creation >= $date_creation_max OR EXISTS (SELECT * FROM devis_user WHERE devis.id = devis_user.devis_id AND devis_user.user_id = ".intval($_SESSION['user']->getID())."))";


		echo "</div>\n";
		DevisView::showList(R::find('devis', $query));
	}

}

?>
