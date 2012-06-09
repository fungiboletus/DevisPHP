<?php

class Notifications
{
	public function index() {
		if (!$_SESSION['user']->isAdmin) CTools::hackError();
		
		if (!isset($_REQUEST['devis'])) CTools::hackError();
		$devis = R::load('devis', $_REQUEST['devis']);
		$id = $devis->getId();
		if (!$id) CTools::hackError();


		$users_notifies = array();
		foreach (R::find('user') as $user)
		{
			$deps = json_decode($user->deps);
			$cats = json_decode($user->cats);

			if (in_array($devis->type, $cats) && in_array($devis->dep, $deps))
				$users_notifies[] = $user;
		}


		if (isset($_REQUEST['confirm']))
		{
			
			foreach ($users_notifies as $user)
			{
				$url_devis = CNavigation::generateUrlToApp('Dashboard', 'view', array('id' => $id)); 
				$mail = MMail::newMail()
					->setSubject(_('Une nouvelle de demande de devis correspondant à vos critères est disponible sur devis-equitable.fr'))
					->setTo(array($user->mail => $devis->name))
					->setBody(_("Une nouvelle demande de devis correspondant à vos critères de notifications est disponble sur devis-equitable.fr.\nVous trouverez plus d'informations à cette adresse : http://www.devis-equitable.fr").$url_devis._("\nSachez que vous pouvez modifier vos réglages de notifications à tout moment dans les paramètres de votre profil.\n\nMerci de votre confiance."));
				MMail::send($mail);
			}
			
			new CMessage(_('Les artisans ont étés notifiés'));
			CNavigation::redirectToApp('Dashboard', 'liste');
		}
		else
		{
			CNavigation::setTitle(_('Notifier les artisans'));
			CNavigation::setDescription(_('Artisans qui seront notifiés par mail.'));
			if (count($users_notifies) == 0)
			{
				new CMessage(_('Il n\'y a aucun artisan souhaitant être notifié pour cette demande de devis.'), 'info');
			}
			else
			{
				UserView::showList($users_notifies);
				NotificationsView::afficherBoutonConfirmation();
			}
		}
	}
}
?>
