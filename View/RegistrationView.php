<?php
class RegistrationView {
	public static function showMailForm() {
		$label_mail = _('Adresse mail');
		$url_submit = CNavigation::generateUrlToApp('Registration', 'submit_mail');
		$text_submit = _('Recevoir le formulaire d\'inscription');
		echo <<<END
<form action="$url_submit" name="registration_form" method="post" class="form-horizontal">
<fieldset>
	<div class="control-group">
		<label for="input_mail" class="control-label">$label_mail</label>
		<div class="controls">
			<input name="mail" id="input_mail" type="email" required/>
		</div>
	</div>
	<div class="form-actions">
		<input type="submit" class="btn btn-large btn-primary" value="$text_submit" />
	</div>
</fieldset>
</form>	
END;
	}
	public static function showForm($mail, $token) {
		$label_name = _('Nom');
		$label_mail = _('Adresse mail');
		$label_password = _('Mot de passe');
		$text_submit = _('Créer le compte');
		$url_submit = CNavigation::generateUrlToApp('Registration', 'submit');
		$hmail = htmlspecialchars($mail);
		$htoken = htmlspecialchars($token);
		echo <<<END
<form action="$url_submit" name="registration_form" method="post" class="form-horizontal">
<fieldset>
	<div class="control-group">
		<label for="input_mail" class="control-label">$label_mail</label>
		<div class="controls">
			<input name="mail" id="input_mail" type="email" required disabled value="$hmail"/>
		</div>
	</div>
	<div class="control-group">
		<label for="input_nom" class="control-label">$label_name</label>
		<div class="controls">
			<input name="nom" id="input_nom" type="text" autofocus required />
		</div>
	</div>
	<div class="control-group">
		<label for="input_password" class="control-label">$label_password</label>
		<div class="controls">
			<input name="password" id="input_password" type="password" required />
		</div>
	</div>
	<div class="form-actions">
		<input type="hidden" name="token" value="$htoken" />
		<input type="submit" class="btn btn-large btn-primary" value="$text_submit" />
	</div>
</fieldset>
</form>	
END;
	}

	public static function showInformationsMail()
	{
		$lien_demande = CNavigation::generateUrlToApp('Registration');
		echo <<<END
	<p>Vous allez recevoir un mail contenant un lien vers le formulaire d'inscription.</p>

	<p>Si vous ne recevais pas de mail, n'hésitez pas à <a href="$lien_demande">renouveler la demande</a>, de vérifier votre adresse mail, et votre filtre anti-spam.</p> 
END;
	}
}
?>
