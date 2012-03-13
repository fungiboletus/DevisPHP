<?php
class DashboardView {
	public static function showInfosCredit($credit) {
	$credit = htmlspecialchars($credit);
	$nom = htmlspecialchars($_SESSION['user']->name);
	echo <<<END
	<div class="well">
	<h3>
	Bonjour $nom.
	</h3>
	<hr/>
	<a href="#" class="btn btn-success float_right">Rajouter du crédit</a>
	<p> Vous avez <strong>$credit</strong> € de crédit.</p>

	</div>
END;
	}
	
	public static function showListTitle() {
		echo "<h2>Les demandes de devis que j'ai acheté</h2>\n<br/>\n";
	}
}
?>
