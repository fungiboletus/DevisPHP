<?php
class DevisView {
	public static function showForm() {
	
		$url_submit = CNavigation::generateUrlToApp('Devis', 'submit');
		echo <<<END
<form action="$url_submit" name="registration_form" method="post" class="form-horizontal">
<fieldset>
	<legend>Votre devis</legend>
	<div class="control-group">
		<label for="input_type">Catégorie</label>
		<div class="controls">
			<select name="type" id="input_type" class="span4" autofocus required>
				<option>something</option>
				<option>2</option>
				<option>3</option>
				<option>4</option>
				<option>5</option>
			</select>
			<select name="subtype" id="input_subtype" class="span4" disabled>
				<option>something</option>
				<option>2</option>
				<option>3</option>
				<option>4</option>
				<option>5</option>
			</select>
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
				<option>something</option>
				<option>2</option>
				<option>3</option>
				<option>4</option>
				<option>5</option>
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
