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

	public static function showForm($values) {

		$values = array_merge(array(
			'sujet' => '',
			'description' => '',
			'type' => '',
			'subtype' => '',
			'delai' => '',
			'financement' => '',
			'budget' => '',
			'objectif' => '',
			'nom' => '',
			'cp' => '',
			'dep' => '',
			'mail' => '',
			'tel' => ''), $values);

		$values = array_map('htmlspecialchars', $values); // <3

		$url_submit = CNavigation::generateUrlToApp('Devis', 'submit');
		echo <<<END
<form action="$url_submit" name="registration_form" method="post" class="form-horizontal">
<fieldset>
	<legend>Votre devis</legend>
	<div class="control-group">
		<label for="input_sujet">Sujet</label>
		<div class="controls">
			<input name="sujet" id="input_sujet" type="text" autofocus class="span6" value="{$values['sujet']}"/>
		</div>
	</div>
	<div class="control-group">
		<label for="input_description">Description</label>
		<div class="controls">
			<textarea name="description" id="input_description" class="span6" rows="5">{$values['description']}</textarea>
		</div>
	</div>
	<div class="control-group">
		<label for="input_type">Catégorie</label>
		<div class="controls">
			<select name="type" id="input_type" class="span4" required>
END;
			$first = null;
			$selected_id = $values['type'];
			$sub_selected_id = $values['subtype'];
			Categories::validerIDs($selected_id, $sub_selected_id);

			foreach (Categories::$liste as $id => $c) {
				$selected = '';
				if ($id === $selected_id) {
					$selected = ' selected';
					$first = $c[1];
				}
				$hc = htmlspecialchars($c[0]);
				echo "\t\t\t\t<option value=\"$id\"$selected>$hc</option>\n";
			}
		echo <<<END
			</select>
			<select name="subtype" id="input_subtype" class="span4">
END;
		self::showSousCatSelect(is_null($first) ? array() : $first, $sub_selected_id);
		echo <<<END
			</select>
				<p class="help-block">Sélectionnez une catégorie et une sous-catégorie pour améliorer la visibilité de votre demande de devis pour les professionnels.</p>
		</div>
	</div>
</fieldset>
<fieldset>
	<legend>Titre à trouver</legend>
	<div class="control-group">
		<label for="input_delai">Délai prévu</label>
		<div class="controls">
			<select name="delai" id="input_delai" class="span4">
END;
				$id_delai = Delais::validerID($values['delai']);
				foreach (Delais::$liste as $id => $c) {
					$selected = $id_delai === $id ? ' selected' : '';
					$hc = htmlspecialchars($c);
					echo "\t\t\t\t<option value=\"$id\"$selected>$hc</option>\n";
				}
		echo <<<END
			</select>
		</div>
	</div>
	
	<div class="control-group">
		<label for="input_budget">Budget</label>
		<div class="controls">
			<div class="input-prepend">
                <span class="add-on">€</span>
                <input name="budget" class="span2" id="input_budget" size="16" type="number" min="100" step="100" value="{$values['budget']}">
				<p class="help-block">Saisissez le budget que vous souhaitez investir. Laissez le champ vide pour ne pas indiquer de budget.</p> 
              </div>
		</div>
	</div>
	
	<div class="control-group">
		<label for="input_financement">Financement</label>
		<div class="controls">
			<select name="financement" id="input_financement" class="span4">
END;
				$id_financement = Financements::validerID($values['financement']);
				foreach (Financements::$liste as $id => $c) {
					$selected = $id_financement === $id ? ' selected' : '';
					$hc = htmlspecialchars($c);
					echo "\t\t\t\t<option value=\"$id\"$selected>$hc</option>\n";
				}
		echo <<<END
			</select>
		</div>
	</div>
	
	<div class="control-group">
		<label for="input_objectif">Objectif de la demande</label>
		<div class="controls">
			<select name="objectif" id="input_objectif" class="span4">
END;
				$id_objectif = Objectifs::validerID($values['objectif']);
				foreach (Objectifs::$liste as $id => $c) {
					$selected = $id_objectif === $id ? ' selected' : '';
					$hc = htmlspecialchars($c);
					echo "\t\t\t\t<option value=\"$id\"$selected>$hc</option>\n";
				}
		echo <<<END
			</select>
		</div>
	</div>

</fieldset>
<fieldset>
	<legend>Coordonées</legend>
	<div class="control-group">
		<label for="input_nom">Nom et Prénom</label>
		<div class="controls">
			<input name="nom" id="input_nom" type="text" required class="span4" value="{$values['nom']}"/>
		</div>
	</div>
	<div class="control-group">
		<label for="input_cp">Code postal</label>
		<div class="controls">
			<input name="cp" id="input_cp" type="text" class="span1" value="{$values['cp']}"/>
		</div>
	</div>
	<div class="control-group">
		<label for="input_dep">Département</label>
		<div class="controls">
			<select name="dep" id="input_dep" class="span4">
END;
			$id_dep = Regions::validerID($values['dep']);
			foreach (Regions::$liste as $region => $departements) {
				$hr = htmlspecialchars($region);
				echo "\t\t\t\t<optgroup label=\"$hr\">\n";

				foreach ($departements as $id => $dep) {
					$hd = htmlspecialchars($dep);
					$id_display = $id === 201 ? '2A' : ($id === 202 ? '2B' : ($id < 10 ? '0'.$id : $id)); 
					$selected = $id === $id_dep ? ' selected' : '';
					echo "\t\t\t\t\t<option value=\"$id\"$selected>$id_display - $hd</option>\n";
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
			<input name="mail" id="input_mail" type="email" required class="span4" value="{$values['mail']}"/>
			<p class="help-block">L'adresse email sera utilisée pour vous proposer les offres de devis.</p>
		</div>
	</div>
	<div class="control-group">
		<label for="input_tel">Téléphone</label>
		<div class="controls">
			<input name="tel" id="input_tel" type="tel" class="span4" value="{$values['tel']}"/>
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
