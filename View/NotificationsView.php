<?php

class NotificationsView {

	// méthode très utile, je dois l'avouer
	public static function afficherBoutonConfirmation()
	{
		$url = CNavigation::generateMergedUrl('Notifications',null, array('confirm' => true));
		echo '<a href="'.$url.'" class="btn btn-large">Envoyer les notifications</a>';
	}
}

?>
