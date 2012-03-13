<?php

define('NO_LOGIN_REQUIRED', true);

class Devis
{

	public static $variables = array(
			'sujet' => '',
			'description' => '',
			'type' => '',
			'subtype' => '',
			'delai' => '',
			'financement' => '',
			'budget' => '',
			'objectif' => '',
			'nom' => '',
			'cp' => '',
			'dep' => '',
			'mail' => '',
			'tel' => '');

	public function categories() {
		if (isset($_REQUEST['cat']))
		{
			$cats = Categories::$liste;
			$_REQUEST['AJAX_MODE'] = true;

			DevisView::showSousCatSelect(
				isset($_REQUEST['cat'], $cats) ?
					$cats[$_REQUEST['cat']][1] : array());
		}
		else
		{
			CTools::hackError();
		}
	}

	public function index() {
		if (isset($_REQUEST['cat']))
		{
			$this->categories();
		}
		else
		{
			CNavigation::setTitle(_('Nouvelle demande de devis'));

			DevisView::showForm(isset($_SESSION['devis_submit']) ? $_SESSION['devis_submit'] : self::$variables);
			unset($_SESSION['mail_error']);
		}
	}

	public function submit() {
	
		$devis = null;
		$modification = false;
		$etape_nouveau_devis = 0;
		
		if (isset($_SESSION['logged']) && isset($_POST['devis_id']))
		{
			$devis = R::load('devis', intval($_POST['devis_id']));
			if ($devis && isset($_POST['submit'])) {
				if ($_SESSION['user']->isAdmin) {
					switch ($_POST['submit']) {
					case 'Supprimer':
						$devis->etape = -1;
						R::store($devis);
						new CMessage('La demande de devis a été supprimée');
						break;
					case 'Valider':
						$devis->etape = 1;
						R::store($devis);
						new CMessage('La demande de devis a été validée');
						break;
					case 'Invalider':
						$devis->etape = 0;
						R::store($devis);
						new CMessage('La demande de devis a été invalidée');
						break;
					case 'Enregistrer':
						// On sauvegarde l'ancien devis
						$etape_nouveau_devis = $devis->etape;
						$devis->etape = -2;
						R::store($devis);
						$modification = true;
						break;
					default:
						CTools::hackError();
					}

					if ($_POST['submit'] !== 'Enregistrer')
						CNavigation::redirectToApp('Dashboard', 'liste');
				}
				else if ($_POST['submit'] === 'Acheter')
				{
					CNavigation::redirectToApp('Dashboard', 'acheter',array(
						'id' => $devis->getID()));
				}
			}
		}

		if (CNavigation::isValidSubmit(array('type', 'sujet', 'nom','mail'), $_POST))
		{
			$values = array_merge(self::$variables, $_POST);
			
			if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL))
			{
				new CMessage(_('Une adresse mail correcte est demandée'), 'error');
				$_SESSION['devis_submit'] = $values;
				$_SESSION['mail_error'] = true;
				CNavigation::redirectToApp('Devis');
			}

			$devis = R::dispense('devis');
			$devis->etape = $etape_nouveau_devis;

			$devis->sujet = $values['sujet'];
			$devis->description = $values['description'];
			$type = $values['type'];
			$subtype = $values['subtype'];
			Categories::validerIDs($type, $subtype);
			$devis->type = $type;
			$devis->subtype = $subtype;
			$devis->delai = Delais::validerID($values['delai']);
			$devis->budget = intval($values['budget']);
			$devis->financement = Financements::validerID($values['financement']);
			$devis->objectif = Objectifs::validerID($values['objectif']);
			$devis->nom = $values['nom'];
			$devis->cp = $values['cp'];
			$devis->dep = Regions::validerID($values['dep']);
			$devis->mail = $values['mail'];
			$devis->tel = $values['tel'];
			$devis->date_creation = time();

			R::store($devis);

			if ($modification) {
				new CMessage('Le devis a correctement été mis à jour');
				CNavigation::redirectToApp('Dashboard', 'view', array('id' => $devis->getId()));
			}
			else
			{
				//TODO trouver un meilleur message
				new CMessage('Votre demande de devis a été enregistrée. Vous serez informé de l\'évolution des hostilités.');
			
				$_SESSION['enregistrement_ok'] = true;
				
				// On enregistre les variables de contacts pour les devis suivants (héhé)
				$_SESSION['devis_submit'] = array_merge(self::$variables, array(
					'nom' => $values['nom'],
					'cp' => $values['cp'],
					'dep' => $values['dep'],
					'mail' => $values['mail'],
					'tel' => $values['tel']));

				CNavigation::redirectToApp('Devis', 'ok');
			}

		}
		else 
		{
			CTools::hackError();
		}
	}

	public function ok() {
		if (!isset($_SESSION['enregistrement_ok'])) {
			CNavigation::redirectToApp('Devis');
		}
		unset($_SESSION['enregistrement_ok']);
		CNavigation::setTitle(_('Enregistrement réussi'));
		DevisView::showBoutonNouveauDevis();
	}

}
?>
