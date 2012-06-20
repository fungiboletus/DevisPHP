<?php

define('NO_LOGIN_REQUIRED', true);

class SiteMap
{

	public function index()
	{
		$_REQUEST['AJAX_MODE'] = true;
		header ('Content-Type: application/xml; charset=utf-8');
		
		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
		global $ROOT_PATH;

		foreach (Regions::$liste as $region => $departements) {
			//$hr = htmlspecialchars($region);

			foreach ($departements as $id => $dep) {
				//$hd = htmlspecialchars($dep);
			
				$url = CNavigation::generateUrlToApp('Devis', 'index', array(
					'dep' => $id,
					'departement' => $dep));

				echo "\t<url>\n\t\t<loc>http://www.devis-equitable.com$url</loc>\n\t</url>\n";
			}

		}
		
		foreach (Categories::$liste as $id => $c) {
			foreach ($c[1] as $idd => $sc) {
				$url = CNavigation::generateUrlToApp('Devis', 'index', array(
					'categorie' => $id,
					'c' => $sc));

				echo "\t<url>\n\t\t<loc>http://www.devis-equitable.com$url</loc>\n\t</url>\n";
			}
		}

		echo "</urlset>\n";
	}

}
?>
