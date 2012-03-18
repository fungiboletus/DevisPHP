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
		<input type="submit" class="btn btn-large btn-warning" value="Procéder au payement avec Paypal"/>
	</div>
</form>
END;
	}
	public static function showList($logs)
	{
		CHead::addJS('jquery.tablesorter.min');
		echo <<<END
<table class="table table-striped table-bordered paypal_list">
	<thead><tr>
		<th class="header">Id</th>
		<th class="header green">Date</th>
		<th class="header blue">OK</th>
		<th class="header orange">Crédit</th>
		<th class="header purple">Utilisateur</th>
	</tr></thead>
	<tbody>
END;
		foreach ($logs as $u)
		{
			$url = CNavigation::generateUrlToApp('Paypal', 'view', array('id' => $u->getID()));
			$id = $u->getId();
			$hdate = AbstractView::formateDate($u['date_log']);
			$hnom = htmlspecialchars($u['user']->name);
			$hcredit = htmlspecialchars($u['credit']);
			$hok = $u['ok'] ? '<span class="badge badge-success">OK</span>' : '<span class="badge badge-error">Non</span>';;
			echo <<<END
<tr>
	<td><a href="$url">
		<span class="badge badge-info">$id</span>
	</a></td>
	<td><a href="$url">$hdate</a></td>
	<td><a href="$url">$hok</a></td>
	<td><a href="$url">$hcredit €</a></td>
	<td><a href="$url">$hnom</a></td>
</tr>
END;
		}

		echo "</tbody></table>";
	}

	public static function showInfosLog($log)
	{

		$id = $log->getId();
		$hdate = AbstractView::formateDate($log->date_log);
		$h_url = CNavigation::generateUrlToApp('User', 'view', array(
			'id' => $log->user->getId()));
		$hnom = htmlspecialchars($log->user->name);
		$hcredit = htmlspecialchars($log->credit);
		$hok = $log->ok ? 'OK' : 'Non';
		echo <<<END
	<h2>Informations</h2>
	<dl>
		<dt>Id</td>
		<dd>$id</dd>

		<dt>Date</td>
		<dd>$hdate</dd>

		<dt>OK</td>
		<dd>$hok</dd>
		
		<dt>Crédit</td>
		<dd>$hcredit €</dd>

		<dt>Utilisateur</td>
		<dd><a href="$h_url">$hnom</a></dd>
	</dl>

	<h2>Informations brutes envoyées par Paypal</h2>
	<div class="pre">
	<dl>

END;

		foreach (json_decode($log->infos) as $k => $v)
		{
			echo "\t<dt>", htmlspecialchars($k), "</dt>\n";
			echo "\t<dd>", htmlspecialchars($v), "</dd>\n";
		}
		$url_liste = CNavigation::generateUrlToApp('Paypal', 'liste');
		echo "</dl></div>\n<a href=\"$url_liste\" class=\"btn btn-large\">Retour à la liste</a><br/>";
	}
}
?>
