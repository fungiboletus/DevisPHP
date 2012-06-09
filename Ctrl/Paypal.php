<?php

class Paypal
{
	public function index()
	{
		CNavigation::setTitle(_('Rajouter du crédit à votre compte'));
		PaypalView::showInfos($_SESSION['user']->credit);
		PaypalView::showForm();
	}

	protected function getPaypalObject()
	{
		require_once('Tools/Paypal/paypal.php');
		require_once('Tools/Paypal/httprequest.php');
		return new PayPalTool(!PAYPAl_SANDBOX);
	}

	public function submit()
	{

		if (!isset($_POST['credit']) || floatval($_POST['credit']) < 1.0) CTools::hackError();

		$r = $this->getPaypalObject();

		$url = $r->getScheme().'://'.$_SERVER['SERVER_NAME'];

		$credit = floatval($_POST['credit']);
		$_SESSION['credit'] = $credit;

		$ret = $r->doExpressCheckout(
			$credit, _('Crédit Devis Équitable'),
			$url.CNavigation::generateUrlToApp('Paypal', 'retour'),
			$url.CNavigation::generateUrlToApp('Paypal', 'annulation'),
			'', 'EUR');
		
		CNavigation::setTitle(_("Nous avons constaté une erreur de paiement.\nVeuillez recommencer l'opération\nSi vous pensez que le paiement a tout de même été effectué,\nprenez contact avec notre équipe");
		groaw($ret);
	}

	public function retour()
	{
		if (!isset($_GET['token']) || !isset($_GET['PayerID'])) CTools::hackError();

		$resultat = $this->getPaypalObject()->doPayment();

		$log = R::dispense('paypal');
		$log->date_log = time();
		$log->infos = json_encode($resultat);
		$log->user = $_SESSION['user'];

		if ($resultat['ACK'] == 'Success')
		{
			$credit = floatval($resultat['AMT']);
			
			$_SESSION['user']->credit += $credit;
			R::store($_SESSION['user']);

			new CMessage(_('Votre règlement a bien été effectué.'));
			new CMessage(_('Votre compte a été crédité de '.$credit.'€'),'warning');
			$log->ok = true;
			$log->credit = $credit;
		}
		else
		{
			new CMessage(_('Une erreur s\'est produite. N\'hésitez pas à contacter l\'administrateur en cas de problème. Les informations sur l\'erreur sont sauvegardées.'), 'error');
			$log->ok = false;
			$log->credit = $_SESSION['credit'];
		}
		R::store($log);
		unset($_SESSION['credit']);

		CNavigation::redirectToApp('Dashboard');
	}

	public function annulation()
	{
		new CMessage(_('Vous avez annulé la commande de crédit.'), 'error');
		CNavigation::redirectToApp('Paypal');
	}

	public function liste()
	{
		if (!$_SESSION['user']->isAdmin) CTools::hackError();
		
		CNavigation::setTitle(_('Journal des opérations Paypal'));

		PaypalView::showList(R::find('paypal'));
	}

	public function view()
	{
		if (!$_SESSION['user']->isAdmin || !isset($_REQUEST['id'])) CTools::hackError();
		$log = R::load('paypal', $_REQUEST['id']);
		if (!$log->getID()) CTools::hackError();

		CNavigation::setTitle(_('Visualisation d\'un log paypal'));
	
		PaypalView::showInfosLog($log);
	}
}

?>
