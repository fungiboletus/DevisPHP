<?php
class PaypalView
{
	public static function showInfos($credit)
	{
		echo <<<END
	<div class="alert alert-info">Vous avez actuellement <strong>$credit</strong> € de crédit.</div>
END;
	}
	public static function showForm()
	{
		$url_submit = CNavigation::generateUrlToApp('Paypal', 'submit');
		echo <<<END
<form action="$url_submit" name="credit_form" method="post" class="form-horizontal">
<fieldset>
	<legend>Crédit</legend>
	<div class="control-group">
		<label for="input_credit" class="control-label">Montant à ajouter</label>
		<div class="controls">
			<div class="input-prepend">
                <span class="add-on">€</span>
				<input name="credit" id="input_credit" type="number" class="span2" min="1" value="0"/>
			</div>
		</div>
	</div>
</fieldset>
	<div class="form-actions">
		<input type="submit" class="btn btn-large btn-warning" value="Procéder au payement par Paypal"/>
	</div>
</form>
END;
	}
}
?>
