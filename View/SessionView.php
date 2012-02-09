<?php
class SessionView {
	public function __construct() {
		$label_mail = _('Email');
		$label_password = _('Mot de passe');
		$text_submit = _('Se connecter');
		$text_registration = _('Inscription');

		$url_submit = CNavigation::generateUrlToApp('Session', 'submit');
		$url_registration = CNavigation::generateUrlToApp('Registration');

		echo <<<END
<form action="$url_submit" name="login" method="post" class="form-horizontal well">
<fieldset>
	<div class="control-group">
		<label for="input_mail">$label_mail</label>
		<div  class="controls">
			<input name="email_devis" id="input_mail" type="email"
				autofocus required />
		</div>
	</div>
	<div class="control-group">
		<label for="input_pass">$label_password</label>
		<div  class="controls">
			<input name="password_devis" id="input_pass" type="password"
			required />
		</div>
	</div>
	<div class="form-actions">
		<input type="submit" value="$text_submit" class="btn btn-primary btn-large span3"/>
	</div>
</fieldset>
</form>	

<a href="$url_registration"><div id="lien_inscription">
$text_registration
</div></a>
END;
	}
}
?>
