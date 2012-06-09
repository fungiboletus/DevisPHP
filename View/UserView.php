<?php
class UserView
{

	public static function showForm($values = array(), $is_admin = false)
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
			<p class="help-block">Laissez identique pour garder l&apos;ancien mot de passe.</p>
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
		<label for="input_presentation" class="control-label">Support de présentation</label>
		<div class="controls">
			<input name="presentation" id="input_presentation" type="file" class="span4" accept="application/pdf" maxlength="2097152"/>
END;
	if (isset($values['presentation']) && $values['presentation'])
	{
		$url = $GLOBALS['ROOT_PATH'].'/Uploads/'.$values['presentation'];
		echo "<a href=\"$url\" class=\"btn btn-inverse\">Télécharger le support enregistré</a>";
	}
echo <<<END
			<p class="help-block">Ce dossier sera envoyé de manière automatique aux clients pour vous présenter. Le document doit être au format PDF, et ne dois pas dépasser 2Mio. Laissez vide pour garder le même support de présentation.</p>
		</div>
	</div>
</fieldset>
<fieldset>
	<legend>Administration</legend>
	<div class="control-group">
		<label for="input_kbis" class="control-label">KBIS</label>
		<div class="controls">
			<input name="kbis" id="input_kbis" type="file" class="span4" accept="application/pdf|image/*" maxlength="2097152"/>
END;
	if (isset($values['kbis']) && $values['kbis'])
	{
		$url = $GLOBALS['ROOT_PATH'].'/Uploads/'.$values['kbis'];
		echo "<a href=\"$url\" class=\"btn btn-inverse\">Télécharger le support enregistré</a>";
	}
echo <<<END
			<p class="help-block">Le fichier doit être de type PDF, ou une image.</p>
		</div>
	</div>
	<div class="control-group">
		<label for="input_assurdec" class="control-label">Assurance décennale</label>
		<div class="controls">
			<input name="assurdec" id="input_assurdec" type="file" class="span4" accept="application/pdf|image/*" maxlength="2097152"/>
END;
	if (isset($values['assurdec']) && $values['assurdec'])
	{
		$url = $GLOBALS['ROOT_PATH'].'/Uploads/'.$values['assurdec'];
		echo "<a href=\"$url\" class=\"btn btn-inverse\">Télécharger le support enregistré</a>";
	}
echo <<<END
			<p class="help-block">Le fichier doit être de type PDF, ou une image.</p>
		</div>
	</div>
	<div class="control-group">
		<label for="input_pieceidentite" class="control-label">Pièce d&apos;identité</label>
		<div class="controls">
			<input name="pieceidentite" id="input_pieceidentite" type="file" class="span4" accept="application/pdf|image/*" maxlength="2097152"/>
END;
	if (isset($values['pieceidentite']) && $values['pieceidentite'])
	{
		$url = $GLOBALS['ROOT_PATH'].'/Uploads/'.$values['pieceidentite'];
		echo "<a href=\"$url\" class=\"btn btn-inverse\">Télécharger le support enregistré</a>";
	}

echo <<<END
			<p class="help-block">Le fichier doit être de type PDF, ou une image.</p>
		</div>
	</div>
END;
if ($is_admin) {
echo <<<END
	<div class="control-group">
		<label for="input_credit" class="control-label">Crédit</label>
		<div class="controls">
			<div class="input-prepend">
                <span class="add-on">€</span>
				<input name="credit" id="input_credit" type="number" class="span2" value="{$values['credit']}"/>
			</div>
		</div>
	</div>
END;
}
echo <<<END
</fieldset>
<fieldset>
	<legend>Notifications</legend>
	<p class="well">Sélectionnez les départements et les catégories pour lesquelles vous souhaitez recevoir des notifications lorsqu&apos;une nouvelle demande de devis est disponible.</p>
	<div class="control-group multicolumns">
		<label class="control-label">Départements</label>
		<div class="controls">
END;
		$deps = json_decode($values['deps']);
		if ($deps == null) $deps = array();
		foreach (Regions::$liste as $region => $departements) {
			$hr = htmlspecialchars($region);
			echo "\t\t\t<h4>$hr</h4>\n";
			foreach ($departements as $id => $dep) {
				$hd = htmlspecialchars($dep);
				$checked = in_array($id, $deps) ? ' checked' : '';
				echo "\t\t\t<label class=\"checkbox\"><input type=\"checkbox\" name=\"deps[]\" value=\"$id\"$checked/>$hd</label>\n";
			}
			echo "\t\t\t<hr/>\n";
		}
echo <<<END
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">Catégories</label>
		<div class="controls">
END;
		$cats = json_decode($values['cats']);
		if ($cats == null) $cats = array();
		foreach (Categories::$liste as $id => $c) {
			$hc = htmlspecialchars($c[0]);
			$checked = in_array($id, $cats) ? ' checked' : '';
			echo "\t\t\t<label class=\"checkbox\"><input type=\"checkbox\" name=\"cats[]\" value=\"$id\"$checked/>$hc</label>\n";
		}
echo <<<END
	</div>
</fieldset>
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
