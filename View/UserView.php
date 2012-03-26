<?php
class UserView
{

	public static function showForm($values = array(), $show_admin = false, $pdf = false)
	{
		$values = array_map('htmlspecialchars', $values); // <3

		$url_submit = CNavigation::generateUrlToApp('User', 'submit');
		echo "<form action=\"$url_submit\" name=\"user_form\" method=\"post\" class=\"form-horizontal\" enctype=\"multipart/form-data\">\n";

		echo <<<END
		<input type="hidden" name="id" value="{$values['id']}"/>
<fieldset>
	<legend>Votre compte</legend>
	<div class="control-group">
		<label for="input_name" class="control-label">Nom</label>
		<div class="controls">
			<input name="name" id="input_name" type="text" class="span6" value="{$values['name']}" maxlength="80"/>
		</div>
	</div>
	<div class="control-group">
		<label for="input_mail" class="control-label">Adresse mail</label>
		<div class="controls">
			<input name="mail" id="input_mail" type="email" class="span6" value="{$values['mail']}" maxlength="80"/>
		</div>
	</div>
	<div class="control-group">
		<label for="input_password" class="control-label">Mot de passe</label>
		<div class="controls">
			<input name="password" id="input_password" type="password" class="span6" value="******" maxlength="80"/>
			<p class="help-block">Laissez identique pour garder l'ancien mot de passe.</p>
		</div>
	</div>
</fieldset>
<fieldset>
	<legend>Informations sur l'entreprise</legend>
	<div class="control-group">
		<label for="input_company" class="control-label">Nom de l'entreprise</label>
		<div class="controls">
			<input name="company" id="input_company" type="text" class="span6" value="{$values['company']}" maxlength="80"/>
		</div>
	</div>
	<div class="control-group">
		<label for="input_website" class="control-label">Site web</label>
		<div class="controls">
			<input name="website" id="input_website" type="url" class="span6" value="{$values['website']}" maxlength="80"/>
		</div>
	</div>
	<div class="control-group">
		<label for="input_tel" class="control-label">Téléphone</label>
		<div class="controls">
			<input name="tel" id="input_tel" type="text" class="span6" value="{$values['tel']}" maxlength="80"/>
		</div>
	</div>
	<div class="control-group">
		<label for="input_pdf" class="control-label">Support de présentation</label>
		<div class="controls">
			<input name="pdf" id="input_pdf" type="file" class="span4" accept="application/pdf" maxlength="2097152"/>
END;
	if ($pdf)
	{
		$url = $GLOBALS['ROOT_PATH'].'/PDF/'.sha1($values['mail']).'.pdf';
		echo "<a href=\"$url\" class=\"btn btn-inverse\">Télécharger le support enregistré</a>";
	}
echo <<<END
			<p class="help-block">Ce dossier sera envoyé de manière automatique aux clients pour vous présenter. Le document doit être au format PDF, et ne dois pas dépasser 2Mio. Laissez vide pour garder le même support de présentation.</p>
		</div>
	</div>
</fieldset>
END;
if ($show_admin)
{
echo <<<END
<fieldset>
	<legend>Administration</legend>
	<div class="control-group">
		<label for="input_credit" class="control-label">Crédit</label>
		<div class="controls">
			<div class="input-prepend">
                <span class="add-on">€</span>
				<input name="credit" id="input_credit" type="number" class="span2" value="{$values['credit']}"/>
			</div>
		</div>
	</div>
	<div class="control-group">
		<label for="input_deps" class="control-label">Départements autorisés</label>
		<div class="controls">
			<input name="deps" id="input_deps" type="text" class="span6" value="{$values['deps']}" />
			<p class="help-block">Entrez les numéros de départements séparés par des virgules. Laissez vide pour tout accepter.</p>
		</div>
	</div>
	<div class="control-group">
		<label for="input_cats" class="control-label">Catégories autorisés</label>
		<div class="controls">
			<input name="cats" id="input_cats" type="text" class="span6" value="{$values['cats']}"/>
			<p class="help-block">Entrez les numéros des catégories séparées par des virgules. Laissez vide pour tout accepter.</p>
		</div>
	</div>
</fieldset>
END;
}
echo <<<END
	<div class="form-actions">
		<input type="submit" class="btn btn-large btn-primary" value="Mettre à jour les informations"/>
	</div>
</form>
END;
	}

	public static function showList($users)
	{
		CHead::addJS('jquery.tablesorter.min');
		echo <<<END
<table class="table table-striped table-bordered user_list">
	<thead><tr>
		<th class="header">Id</th>
		<th class="header yellow">Nom</th>
		<th class="header orange">Société</th>
		<th class="header blue">Crédit</th>
	</tr></thead>
	<tbody>
END;
		foreach ($users as $u)
		{
			$url = CNavigation::generateUrlToApp('User', 'view', array('id' => $u->getID()));
			$id = $u->getId();
			$hnom = htmlspecialchars($u['name']);
			$hsociete = htmlspecialchars($u['company']);
			$hcredit = htmlspecialchars($u['credit']);
			echo <<<END
<tr>
	<td><a href="$url">
		<span class="badge badge-info">$id</span>
	</a></td>
	<td><a href="$url">$hnom</a></td>
	<td><a href="$url">$hsociete</a></td>
	<td><a href="$url">$hcredit</a></td>
</tr>
END;
		}

		echo "</tbody></table>";
	}
}
?>
