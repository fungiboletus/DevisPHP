<!DOCTYPE html>
<html>
<head>
	<title><?php echo htmlspecialchars(CNavigation::getTitle()); ?> - Devis Équitable</title>
<?php foreach (CHead::$css as $css)
{
	echo "\t<link href=\"$ROOT_PATH/Css/$css.css\" media=\"screen\" rel=\"Stylesheet\" type=\"text/css\" />\n";
}
foreach (CHead::$js as $js)
{
	if (strpos($js, 'http://')===false) $js = "$ROOT_PATH/Js/$js.js";
	echo "\t<script type=\"text/javascript\" src=\"$js\"></script>\n";
}
?>
</head>
<body>
<?php

if (!defined('NO_HEADER_BAR'))
{

	$title = htmlspecialchars(CNavigation::getBodyTitle());

	$description = CNavigation::getDescription();

	if ($description) {
		$title = "$title&nbsp;&nbsp;<small>".htmlspecialchars($description)."</small>";
	}

	$url_root = CNavigation::generateUrlToApp(null);
	$c_user = $CTRL_NAME === 'User' ? ' class="active"' : '';

	echo <<<END
<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<nav class="container">

			<a href="$url_root" class="brand">Devis Équitable</a>
END;

	if (isset($_SESSION['logged'])) {
		$user_name = htmlspecialchars($_SESSION['user']->name);
		$url_dashboard = CNavigation::generateUrlToApp('Dashboard');
		$url_user = CNavigation::generateUrlToApp('User');
		$url_logout = CNavigation::generateUrlToApp('Session', 'logout');
		$url_help = CNavigation::generateUrlToApp('Help');
		$url_not_found = CNavigation::generateUrlToApp('PageIntrouvable');
		$url_demandes = CNavigation::generateUrlToApp('Dashboard','liste');
		$c_data = $CTRL_NAME === 'Data' && $ACTION_NAME === 'index' ? ' class="active"' : '';
		$c_dashboard = $CTRL_NAME === 'Dashboard' && $ACTION_NAME === 'index' ? ' class="active"' : '';

		echo <<<END
		<ul class="nav left boutons_inspecteur">
			<li$c_dashboard><a href="$url_dashboard" class="icon_button line_text">Tableau de bord</a></li>
			<li$c_data><a href="$url_demandes" class="icon_button shoebox_text">Demandes de devis</a></li>
		</ul>
		<ul class="nav right">	
			<li class="dropdown">
				<a href="#" class="dropdown-toggle icon_button user_text" data-toggle="dropdown">$user_name <b class="caret"></b></a>

				<ul class="dropdown-menu">
					<li><a href="$url_help">Aide</a></li>
					<li><a href="$url_not_found">Une erreur 404</a></li>
					<li class="divider"></li>
					<li><a href="$url_logout">Déconnexion</a></li>
				</ul>
			</li>
		</ul>
END;
	}
	elseif ($CTRL_NAME != 'Session')
	{
		$url_session = CNavigation::generateUrlToApp('Session');
		echo <<<END
		<ul class="nav right">
			<li><a href="$url_session" class="icon_button user_text">Administration</a></li>
		</ul>
END;
	}
	echo <<<END
		</nav>
	</div>
</div>
<div class="container" id="mainContent">
<div class="content">
<div class="page-header">
	<h1>$title</h1>
</div>
END;
} else
{
echo '<div class="container" id="mainContent">';
}

if (DEBUG) {
	showGroaw();
}
?>

<?php
// Call of the function
CMessage::showMessages();

echo $PAGE_CONTENT;
?>

</div>
</div>
</body>
</html>
