<?php
class DevisView {

	public static function showSousCatSelect($categorie = array(), $selected_id = null) {
		echo '<option value="-1">Pas de sous-catégorie</option>';

			foreach ($categorie as $id => $sc) {
				$hsc = htmlspecialchars($sc);
				$selected = $id == $selected_id ? ' selected' : '';
				echo "\n<option value=\"$id\"$selected>$hsc</option>";
			}
	}

	public static function showForm($values, $devis_id = null, $adisabled = false) {

		$values = array_map('htmlspecialchars', $values); // <3

		$disabled = $adisabled ? ' disabled' : '';

		$url_submit = CNavigation::generateUrlToApp('Devis', 'submit');
		echo "<form action=\"$url_submit\" name=\"registration_form\" method=\"post\" class=\"form-horizontal\">\n";

		if ($devis_id) {
			echo "\t<input type=\"hidden\" name=\"devis_id\" value=\"",intval($devis_id),"\"/>\n";
		}

		echo <<<END
<fieldset>
	<legend>Demande</legend>
	<div class="control-group">
		<label for="input_sujet">Sujet</label>
		<div class="controls">
			<input name="sujet" id="input_sujet" type="text" autofocus class="span6" value="{$values['sujet']}" maxlength="80"$disabled/>
		</div>
	</div>
	<div class="control-group">
		<label for="input_description">Description</label>
		<div class="controls">
			<textarea name="description" id="input_description" class="span6" rows="5"$disabled>{$values['description']}</textarea>
		</div>
	</div>
	<div class="control-group">
		<label for="input_type">Catégorie</label>
		<div class="controls">
END;
			$selected_id = $values['type'];
			$sub_selected_id = $values['subtype'];
			Categories::validerIDs($selected_id, $sub_selected_id);
			
			if ($adisabled)
			{
				$c = Categories::$liste[$selected_id];
				echo "\t\t\t<input type=\"text\" name=\"type\" id=\"input_type\" class=\"span4\" required$disabled value=\"",htmlspecialchars($c[0]),"\"/>\n";
				echo "\t\t\t<input type=\"text\" name=\"subtype\" id=\"input_subtype\" class=\"span4\"$disabled value=\"",htmlspecialchars($c[1][$sub_selected_id]),"\"/>\n";
			}
			else
			{
				echo "\t\t\t<select name=\"type\" id=\"input_type\" class=\"span4\" required$disabled>\n";
				$first = null;

				foreach (Categories::$liste as $id => $c) {
					$selected = '';
					if ($id === $selected_id) {
						$selected = ' selected';
						$first = $c[1];
					}
					$hc = htmlspecialchars($c[0]);
					echo "\t\t\t\t<option value=\"$id\"$selected>$hc</option>\n";
				}
				echo "\t\t\t</select>\n";
				
				echo "\t\t\t<select name=\"subtype\" id=\"input_subtype\" class=\"span4\"$disabled>\n";
				self::showSousCatSelect(is_null($first) ? array() : $first, $sub_selected_id);
				echo "\t\t\t</select>\n";
				echo "\t\t\t<p class=\"help-block\">Sélectionnez une catégorie et une sous-catégorie pour améliorer la visibilité de votre demande de devis pour les professionnels.</p>\n";
			}
		echo <<<END
		</div>
	</div>
</fieldset>
<fieldset>
	<legend>Informations ?</legend>
	<div class="control-group">
		<label for="input_delai">Délai prévu</label>
		<div class="controls">
END;
		$id_delai = Delais::validerID($values['delai']);
		if ($adisabled)
		{
			echo "\t\t\t<input type=\"text\" name=\"delai\" id=\"input_delai\" class=\"span4\" value=\"",
			htmlspecialchars(Delais::$liste[$id_delai]),"\"$disabled>\n";
		}
		else
		{
			echo "\t\t\t<select name=\"delai\" id=\"input_delai\" class=\"span4\"$disabled>\n";
				foreach (Delais::$liste as $id => $c) {
					$selected = $id_delai === $id ? ' selected' : '';
					$hc = htmlspecialchars($c);
					echo "\t\t\t\t<option value=\"$id\"$selected>$hc</option>\n";
				}
			echo "\t\t\t</select>\n";
		}
		echo <<<END
		</div>
	</div>
	
	<div class="control-group">
		<label for="input_budget">Budget</label>
		<div class="controls">
			<div class="input-prepend">
                <span class="add-on">€</span>
END;
			$type = $adisabled ? 'text' : 'number';
			echo "\t\t\t<input name=\"budget\" class=\"span2\" id=\"input_budget\" size=\"16\" type=\"$type\" min=\"100\" value=\"{$values['budget']}\",$disabled>\n";

			if (!$adisabled) {
				echo "\t\t\t<p class=\"help-block\">Saisissez le budget que vous souhaitez investir. Laissez le champ vide pour ne pas indiquer de budget.</p>\n";
			}
		echo <<<END
              </div>
		</div>
	</div>
	
	<div class="control-group">
		<label for="input_financement">Financement</label>
		<div class="controls">
END;
		$id_financement = Financements::validerID($values['financement']);

		if ($adisabled)
		{
			echo "\t\t\t<input type=\"text\" name=\"financement\" id=\"input_financement\" class=\"span4\" value=\"", htmlspecialchars(Financements::$liste[$id_financement]),"\"$disabled>\n";
		}
		else
		{
			echo "\t\t\t<select name=\"financement\" id=\"input_financement\" class=\"span4\"$disabled>\n";
			foreach (Financements::$liste as $id => $c) {
				$selected = $id_financement === $id ? ' selected' : '';
				$hc = htmlspecialchars($c);
				echo "\t\t\t\t<option value=\"$id\"$selected>$hc</option>\n";
			}
			echo "\t\t\t</select>\n";
		}
		echo <<<END
		</div>
	</div>
	
	<div class="control-group">
		<label for="input_objectif">Objectif de la demande</label>
		<div class="controls">
END;
		$id_objectif = Objectifs::validerID($values['objectif']);

		if ($adisabled)
		{
			echo "\t\t\t<input type=\"text\" name=\"objectif\" id=\"input_objectif\" class=\"span4\" value=\"",
			htmlspecialchars(Objectifs::$liste[$id_objectif]),"\"$disabled>\n";
		}
		else
		{
			echo "\t\t\t<select name=\"objectif\" id=\"input_objectif\" class=\"span4\"$disabled>\n";
			foreach (Objectifs::$liste as $id => $c) {
				$selected = $id_objectif === $id ? ' selected' : '';
				$hc = htmlspecialchars($c);
				echo "\t\t\t\t<option value=\"$id\"$selected>$hc</option>\n";
			}
			echo "\t\t\t</select>\n";
		}
		echo <<<END
		</div>
	</div>

</fieldset>
<fieldset>
	<legend>Coordonées</legend>
	<div class="control-group">
		<label for="input_nom">Nom et Prénom</label>
		<div class="controls">
			<input name="nom" id="input_nom" type="text" required class="span4" value="{$values['nom']}" maxlength="80"$disabled/>
		</div>
	</div>
	<div class="control-group">
		<label for="input_cp">Code postal</label>
		<div class="controls">
			<input name="cp" id="input_cp" type="text" class="span1" value="{$values['cp']}"$disabled/>
		</div>
	</div>
	<div class="control-group">
		<label for="input_dep">Département</label>
		<div class="controls">
END;
			$id_dep = Regions::validerID($values['dep']);

			if (!$adisabled) echo "\t\t\t<select name=\"dep\" id=\"input_dep\" class=\"span4\"$disabled>\n";
			foreach (Regions::$liste as $region => $departements) {
				if (!$adisabled) {
					$hr = htmlspecialchars($region);
					echo "\t\t\t\t<optgroup label=\"$hr\">\n";
				}

				foreach ($departements as $id => $dep) {
					$hd = htmlspecialchars($dep);
					$id_display = $id === 201 ? '2A' : ($id === 202 ? '2B' : ($id < 10 ? '0'.$id : $id)); 
					if ($adisabled && $id_dep === $id)
					{
						echo "\t\t\t<input type=\"text\" name=\"dep\" id=\"input_dep\" class=\"span4\" value=\"$id_display - $hd\"$disabled/>\n";
					}
					else
					{
						$selected = $id === $id_dep ? ' selected' : '';
						echo "\t\t\t\t\t<option value=\"$id\"$selected>$id_display - $hd</option>\n";
					}
				}
				if (!$adisabled) echo "\t\t\t\t</optgroup>\n\t\t\t</select>\n";
			}
			$class_error = isset($_SESSION['mail_error']) ? ' error' : '';
			$msg_error = isset($_SESSION['mail_error']) ? 'Veuillez entrer une adresse email valide. Elle sera utilisée pour vous proposer les offres de devis.' : '';
			$autofocus_error = isset($_SESSION['mail_error']) ? ' autofocus' : 'L\'adresse email sera utilisée pour vous proposer les offres de devis.';
		echo <<<END
		</div>
	</div>
	<div class="control-group$class_error">
		<label for="input_mail">Adresse email</label>
		<div class="controls">
			<input name="mail" id="input_mail" type="email" required class="span4" value="{$values['mail']}"$autofocus_error maxlength="80"$disabled/>
			<p class="help-block">$msg_error</p>
		</div>
	</div>
	<div class="control-group">
		<label for="input_tel">Téléphone</label>
		<div class="controls">
			<input name="tel" id="input_tel" type="tel" class="span4" value="{$values['tel']}" maxlength="80"$disabled/>
		</div>
	</div>

</fieldset>
	<div class="form-actions">
		<a href="#" class="btn btn-large">Retour à la liste</a>
		<input type="submit" class="btn btn-large btn-primary" name="submit" value="Enregistrer" />
		<input type="submit" class="btn btn-large btn-danger" name="submit" value="Supprimer" />
		<input type="submit" class="btn btn-large btn-success" name="submit" value="Valider" />
		<input type="submit" class="btn btn-large btn-warning" name="submit" value="Acheter" />
	</div>
</form>	
END;
	}

	public static function showBoutonNouveauDevis() {
	echo <<<END
	<a href="" class="btn btn-primary btn-large">Nouvelle demande de devis</a>
END;
	}
	
	public static function showList($devis)
	{
		if ($devis)
		{
			CHead::addJS('jquery.tablesorter.min');
			echo <<<END
			<table class="table table-striped table-bordered">
				<thead><tr>
					<th class="header yellow">Sujet</th>
					<th class="header green">Mail</th>
					<th class="header blue">Nom</th>
				</tr></thead>
				<tbody>
END;
			foreach ($devis as $d) {
				$url = CNavigation::generateUrlToApp('Dashboard', 'view', array('id' => $d->getID()));
				echo "\t<tr><td><a href=\"$url\">", wordwrap(htmlspecialchars($d['sujet']),60,"<br/>",true),
					 "</a></td><td><a href=\"$url\">", htmlspecialchars($d['mail']),
					 "</a></td><td><a href=\"$url\">", htmlspecialchars($d['nom']), "</a></td></tr>\n";
			}

			echo "</tbody></table>";
		}
		else
		{
			echo <<<END
<div class="alert-message block-message warning">
<p>Il n'y a aucun devis pour l'instant.</p>
</div>
END;
		}
	}
}
?>
