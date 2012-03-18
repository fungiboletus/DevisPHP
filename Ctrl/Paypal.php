<?php

class Paypal
{
	public function index()
	{
		CNavigation::setTitle('Rajouter du crédit à votre compte');
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

		$ret = $r->doExpressCheckout(
			floatval($_POST['credit']), 'Crédit Devis Équitable',
			$url.CNavigation::generateUrlToApp('Paypal', 'retour'),
			$url.CNavigation::generateUrlToApp('Paypal', 'annulation'),
			'', 'EUR');
		
		CNavigation::setTitle('Erreur de paiement');
		groaw($ret);
	}

	public function retour()
	{
		if (!isset($_GET['token']) || !isset($_GET['PayerID'])) CTools::hackError();

		$resultat = $this->getPaypalObject()->doPayment();

		$log = R::dispense('paypal');
		$log->date_log = time();
		$log->infos = json_encode($resultat);
		R::store($log);

		if ($resultat['ACK'] == 'Success')
		{
			$credit = floatval($resultat['AMT']);
			
			$_SESSION['user']->credit += $credit;
			R::store($_SESSION['user']);

			new CMessage('Félicitations pour votre achat de crédit');
			new CMessage('Votre compte a été crédité de '.$credit.'€','warning');
		}
		else
		{
			new CMessage('Une erreur s\'est produite. N\'hésitez pas à contacter l\'administrateur en cas de problème. Les informations sur l\'erreur sont sauvegardées.', 'error');
		}

		CNavigation::redirectToApp('Dashboard');
	}

	public function annulation()
	{
		new CMessage('Vous avez annulé la commande de crédit.', 'error');
		CNavigation::redirectToApp('Paypal');
	}
}

?>
