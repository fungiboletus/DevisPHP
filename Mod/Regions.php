<?php

class Regions {
	public static $liste = array(
	'Alsace' => array(
		67 => 'Bas-Rhin',
		68 => 'Haut-Rhin'),
	'Aquitaine' => array(
		24 => 'Dordogne',
		33 => 'Gironde',
		40 => 'Landes',
		47 => 'Lot-et-Garonne',
		64 => 'Pyrénées-Atlantiques'),
	'Auvergne' => array(
		3 => 'Allier',
		15 => 'Cantal',
		43 => 'Haute-Loire',
		63 => 'Puy-de-Dôme'),
	'Basse-normandie' => array(
		14 => 'Calvados',
		50 => 'Manche',
		61 => 'Orne'),
	'Bourgogne' => array(
		21 => 'Côte-d\'Or',
		58 => 'Nièvre',
		71 => 'Saône-et-Loire',
		89 => 'Yonne'),
	'Bretagne' => array(
		22 => 'Côtes-d\'Armor',
		29 => 'Finistère',
		35 => 'Ille-et-Vilaine',
		56 => 'Morbihan'),
	'Centre' => array(
		18 => 'Cher',
		28 => 'Eure-et-Loir',
		36 => 'Indre',
		37 => 'Indre-et-Loire',
		41 => 'Loir-et-Cher',
		45 => 'Loiret'),
	'Champagne-Ardenne' => array(
		8 => 'Ardennes',
		10 => 'Aube',
		51 => 'Marne',
		52 => 'Haute-Marne'),
	'Corse' => array(
		201 => 'Corse-du-Sud',
		202 => 'Haute-Corse'),
	'Franche-Comté' => array(
		25 => 'Doubs',
		39 => 'Jura',
		70 => 'Haute-Saône',
		90 => 'Territoire de Belfort'),
	'Départements d\'outre-mer' => array( 
		971 => 'Guadeloupe',
		972 => 'Martinique',
		973 => 'Guyane',
		974 => 'La Réunion',
		976 => 'Mayotte'),
	'Haute-Normandie' => array(
		27 => 'Eure',
		76 => 'Seine-Maritime'),
	'Languedoc-Roussillon' => array(
		11 => 'Aude',
		30 => 'Gard',
		34 => 'Hérault',
		48 => 'Lozère',
		66 => 'Pyrénées-Orientales'),
	'Limousin' => array(
		19 => 'Corrèze',
		23 => 'Creuse',
		87 => 'Haute-Vienne'),
	'Lorraine' => array(
		54 => 'Meurthe-et-Moselle',
		55 => 'Meuse',
		57 => 'Moselle',
		88 => 'Vosges'),
	'Midi-Pyrénées' => array(
		9 => 'Ariège',
		12 => 'Aveyron',
		31 => 'Haute-Garonne',
		32 => 'Gers',
		46 => 'Lot',
		65 => 'Hautes-Pyrénées',
		81 => 'Tarn',
		82 => 'Tarn-et-Garonne'),
	'Nord-Pas-de-Calais' => array(
		59 => 'Nord',
		62 => 'Pas-de-Calais'),
	'Pays de la Loire' => array(
		44 => 'Loire-Atlantique',
		49 => 'Maine-et-Loire',
		53 => 'Mayenne',
		72 => 'Sarthe',
		85 => 'Vendée'),
	'Picardie' => array(
		2 => 'Aisne',
		60 => 'Oise',
		80 => 'Somme'),
	'Poitou-Charentes' => array(
		16 => 'Charente',
		17 => 'Charente-Maritime',
		79 => 'Deux-Sèvres',
		86 => 'Vienne'),
	'Provence-Alpes-Côte d\'Azur' => array(
		4 => 'Alpes-de-Haute-Provence',
		5 => 'Hautes-Alpes',
		6 => 'Alpes-Maritimes',
		13 => 'Bouches-du-Rhône',
		83 => 'Var',
		84 => 'Vaucluse'),
	'Rhône-Alpes' => array(
		1 => 'Ain',
		7 => 'Ardèche',
		26 => 'Drôme',
		38 => 'Isère',
		42 => 'Loire',
		69 => 'Rhône',
		73 => 'Savoie',
		74 => 'Haute-Savoie'),
	'Île-de-France' => array(
		75 => 'Paris',
		77 => 'Seine-et-Marne',
		78 => 'Yvelines',
		91 => 'Essonne',
		92 => 'Hauts-de-Seine',
		93 => 'Seine-Saint-Denis',
		95 => 'Val-d\'Oise',
		94 => 'Val-de-Marne')
	);
	
	public static function validerID(&$id) {
		$id = $id < 0 ? -1 : ($id >= count(self::$liste) ? -1 : intval($id));
	}
}
?>
