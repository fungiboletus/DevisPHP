<?php

class ErrorView
{
	public static function showError($number = 0, $message = "Unknown error", $image = null, $code = null)
	{
		global $ROOT_PATH;

		$hmessage = htmlspecialchars($message);

		$hcode = $code ? '<pre>'.htmlspecialchars($code).'</pre>' : '';
		$number = intval($number);

		echo <<<END
<div class="alert alert-error">
<h4 class="alert-heading">Erreur $number</h4>
<p>$hmessage</p>
$hcode
<p class="alert-img">
	<img src="$ROOT_PATH/Img/photos/$image" alt="" />
</p>
</div>
END;
	}
}
?>
