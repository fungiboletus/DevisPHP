<?php
class AchatView {

	public static function showConfirmationAchat($id, $credit, $cout)
	{
		$url_demande = CNavigation::generateUrlToApp('Dashboard', 'view', array('id' => $id));
		$url_confirmation = CNavigation::generateUrlToApp('Dashboard', 'acheter', array('id' => $id, 'confirmer' => true));
		$diff = $credit - $cout;

		echo <<<END
<div class="alert alert-block alert-info">
<p>Êtes vous certain de vouloir acheter cette demande de devis pour <strong>$cout</strong> € ?</p>

<p>Vous avez actuellement <strong>$credit</strong> € de crédit. Après achat, il vous restera <strong>$diff</strong> €.</p>
<br/>
<p>Le client sera informé par mail de votre achat.</p>
<hr/>

<a href="$url_demande" class="btn btn-large">Revenir à la demande</a>
<a href="$url_confirmation" class="btn btn-large btn-warning float_right">Confirmer l'achat</a>
</div>
END;
//'
	}

	public static function showInfoManqueCredit($id, $credit, $cout)
	{
		$url_demande = CNavigation::generateUrlToApp('Dashboard', 'view', array('id' => $id));
		$url_credit = CNavigation::generateUrlToApp('Paypal');

		echo <<<END
<div class="alert alert-block alert-error">
<p>Vous voulez acheter une demande de devis à <strong>$cout</strong> €, mais il vous reste <strong>$credit</strong> € de crédit.

<hr/>

<a href="$url_demande" class="btn btn-large">Revenir à la demande</a>
<a href="$url_credit" class="btn btn-large btn-success float_right">Rajouter du crédit</a>
</div>
END;
	}

}
?>
