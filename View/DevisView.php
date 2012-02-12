<?php
class DevisView {

	public static function showSousCatSelect($categorie = array()) {
		echo '<option value="-1">Pas de sous-catégorie</option>';

			foreach ($categorie as $id => $sc) {
				$hsc = htmlspecialchars($sc);
				echo "\n<option value=\"$id\">$hsc</option>";
			}
	}

	public static function showForm($categories = array(), $regions = array()) {
	
		$url_submit = CNavigation::generateUrlToApp('Devis', 'submit');
		echo <<<END
<form action="$url_submit" name="registration_form" method="post" class="form-horizontal">
<fieldset>
	<legend>Votre devis</legend>
	<div class="control-group">
		<label for="input_type">Catégorie</label>
		<div class="controls">
			<select name="type" id="input_type" class="span4" autofocus required>
END;
			$first = null;
			foreach ($categories as $id => $c) {
				if ($first === null) {
					$first = $c[1];
				}
				$hc = htmlspecialchars($c[0]);
				echo "\t\t\t\t<option value=\"$id\">$hc</option>\n";
			}
		echo <<<END
			</select>
			<select name="subtype" id="input_subtype" class="span4">
END;
		self::showSousCatSelect(is_null($first) ? array() : $first);
		echo <<<END
			</select>
				<p class="help-block">Sélectionnez une catégorie et une sous-catégorie pour améliorer la visibilité de votre demande de devis pour les professionnels.</p>
		</div>
	</div>
	<div class="control-group">
		<label for="input_sujet">Sujet</label>
		<div class="controls">
			<input name="sujet" id="input_sujet" type="text" required class="span6"/>
		</div>
	</div>
	<div class="control-group">
		<label for="input_description">Description</label>
		<div class="controls">
			<textarea name="description" id="input_description" class="span6" rows="5"></textarea>
		</div>
	</div>
	<div class="control-group">
		<label for="input_budget">Budget</label>
		<div class="controls">
			<div class="input-prepend">
                <span class="add-on">€</span>
                <input class="span2" id="input_budget" size="16" type="number" min="100" step="100">
				<p class="help-block">Saisissez le budget que vous souhaitez investir. Laissez le champ vide pour ne pas indiquer de budget.</p> 
              </div>
		</div>
	</div>
</fieldset>
<fieldset>
	<legend>Coordonées</legend>
	<div class="control-group">
		<label for="input_nom">Nom et Prénom</label>
		<div class="controls">
			<input name="nom" id="input_nom" type="text" required class="span4"/>
		</div>
	</div>
	<div class="control-group">
		<label for="input_dep">Département</label>
		<div class="controls">
			<select name="dep" id="input_dep" class="span4">
END;
			foreach ($regions as $region => $departements) {
				$hr = htmlspecialchars($region);
				echo "\t\t\t\t<optgroup label=\"$hr\">\n";

				foreach ($departements as $id => $dep) {
					$hd = htmlspecialchars($dep);
					$id_dep = $id === 201 ? '2A' : ($id === 202 ? '2B' : $id); 
					$selected = $id === 75 ? ' selected' : '';
					echo "\t\t\t\t\t<option value=\"$id\"$selected>$id_dep - $hd</option>\n";
				}
				echo "\t\t\t\t</optgroup>\n";

			}
		echo <<<END
			</select>
		</div>
	</div>
	<div class="control-group">
		<label for="input_mail">Adresse email</label>
		<div class="controls">
			<input name="mail" id="input_mail" type="email" required class="span4"/>
			<p class="help-block">L'adresse email sera utilisée pour vous proposer les offres de devis.</p>
		</div>
	</div>
	<div class="control-group">
		<label for="input_tel">Téléphone</label>
		<div class="controls">
			<input name="tel" id="input_tel" type="tel" class="span4"/>
		</div>
	</div>

</fieldset>
	<div class="form-actions">
		<input type="submit" class="btn btn-large btn-primary" value="Envoyer le devis" />
	</div>
</form>	
END;
	}
}
?>
