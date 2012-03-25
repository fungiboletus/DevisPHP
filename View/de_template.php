<?php
	CHead::addCss('DevisEquitable');
?>
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
	<div id="header">
   		<div class="container">
            <div id="logo" style="cursor:pointer" onclick="window.location.href='index.html'"></div>
        	<div id="menu">
				<ul id="menu">
					<li id="active"><a href="#">Accueil</a></li>
					<li><a href="#">Soumettre un devis</a></li>
					<li><a href="#">Nos services</a></li>
					<li><a href="#">Contact</a></li>
				</ul>
        	</div>
		</div>
	</div> <!-- fin #header -->
    <div class="container">
		<div id="site_content">
			<div class="page-header">
				<h1><?php echo htmlspecialchars(CNavigation::getBodyTitle());?></h1>
			</div>
<?php
// Call of the function
CMessage::showMessages();

echo $PAGE_CONTENT;
?>
		</div>
    </div> <!-- fin #container -->
    
    <div id="footer">
		<div id="copyright">
			<p>Copyright <a href="#" title="titre site">www.site.com</a> &copy;2010| <a href="#">Informations / mentions</a> | Creation site: <a title="creation site internet" href="http://www.stbonnet-web.com">Saint Bonnet Web</a></p>
		</div>
    </div>

</body>
</html>
