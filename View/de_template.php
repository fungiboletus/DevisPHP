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

            <div id="logo" style="cursor:pointer" onclick="window.location.href='<?php echo $ROOT_PATH;?>../../index.html'"></div>

        <div id="menu">
        	<ul id="menu">
            	<li><a href="<?php echo $ROOT_PATH;?>../../index.html">Accueil</a></li>
            	<li><a href="<?php echo $ROOT_PATH;?>../../informations.html">Informations</a></li>
            	<li><a href="<?php echo $ROOT_PATH;?>../../services.html">Nos services</a></li>
            	<li><a href="http://www.devis-equitable.com/dyn/app/Session/login">Connexion</a></li>
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
    <div id="copy">
			<div class="copyg"><img src="<?php echo $ROOT_PATH;?>../../images/cnil.png" /><img src="<?php echo $ROOT_PATH;?>../../images/paypal.png" /></div> 
      <div id="copyspacer"></div>
            <div class="copyc">
             <p>
             <a href="#">Soumission de devis en ligne</a><br/>
             <a href="<?php echo $ROOT_PATH;?>../../ethique.html">Notre ethique</a><br/>
             <a href="<?php echo $ROOT_PATH;?>../../confiance.html">Pourquoi nous faire confiance?</a><br/>
             <a class="OpenClose" href="#">Afficher / cacher les catégories</a>
             </p>
  			</div>
 <div class="copyc">
             <p>
             <a href="<?php echo $ROOT_PATH;?>../../faq.html">Foire à question</a><br/>
             <a href="http://devis-equitable.com/dyn/">Faire une demande de devis gratuit</a><br/>
             <a href="<?php echo $ROOT_PATH;?>../../a-propos.html">A propos</a><br/>
             </p>
  			</div>
            <div class="copyd">
             <p><a href="<?php echo $ROOT_PATH;?>../../contact.html">Nous contacter</a><br/>
             	<a href="<?php echo $ROOT_PATH;?>../../mentions.html">Mentions légales</a> | <a href="#">Crédits</a><br/>
               &copy; <a href="http://www.devis-equitable.com" title="devis artisans gratuits">www.devis-equitable.com</a></p>
  			</div>
          </div>
    </div><!-- fin #footer -->



</body>

</html>

