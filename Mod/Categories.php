<?php

class Categories {

	// Ne changez en aucun cas l'ordre des éléments des tableaux
	// Cela casserait les relations dans la base de données

	// Si vous voulez ajouter des nouveaux éléments, ajoutez les toujours
	// en fin de liste
	public static $liste = array(
		array('Pas de catégorie', array()),
		array('Construction Bati – bois', array(
			'Construction bois',
			'Construction garage',
			'Construction maison',
			'Construction speciale ( bureaux, immeuble, hotel etc …)'
		)),
		array('Maçonnerie', array(
			'Fondation',
			'Démolition',
			'Restauration de pierre',
			'Ouverture',
			'Petits Travaux'
		)),
		array('Charpente - Couverture - Zinguerie', array(
			'Charpente bois',
			'Charpente Mettalique',
			'Gouttière',
			'Traitament des bois et charpente',
			'Etanchéïté toit terrasse',
			'Couverture',
			'Fenêtre de toit',
			'Toiture végétalisée',
			'Paratonnerre - Parafoudre'
		)),
		array('Menuiserie', array(
			'Porte d\'entrée',
			'Fenêtre',
			'Porte de garage',
			'Porte fenêtre',
			'Porte intérieure',
			'Store',
			'Volet',
			'Serrurier'
		)),
		array('Isolation', array(
			'Isolation Thermique',
			'Isolation Phonique et accoustique',
			'Isolation par l\'extérieur'
		)),
		array('Mur - Plafond - Cloison - Plâtre', array(
			'Faux plafond',
			'Mur',
			'Cloison',
			'Platrerie Traditionnelle',
			'STAFF - STUC'
		)),
		array('Electricité', array(
			'Installation électrique',
			'Panneau solaire et photovoltaïque',
			'Interphone',
			'Cablage informatique et téléphonique',
			'Antenne et satellite'
		)),
		array('Plomberie', array(
			'Plomberie traditionnelle',
			'Chauffe-eau',
			'Chauffe-eau solaire',
			'Chaudière',
			'Chauffage',
			'Adoucisseur d\'eau'
		)),
		array('Sol et Mur intérieur', array(
			'Béton ',
			'Résine',
			'Béton ciré',
			'Carrelage',
			'Parquet',
			'Parquet flottant',
			'Marbre',
			'Sol plastique',
			'Moquette',
			'Pierre ',
			'Ardoise',
			'Faïence'
		)),
		array('Cuisine - Salle de bain', array(
			'Installation de cuisine',
			'Haute aspirante',
			'Plan de travail',
			'Electroménager'
		)),
		array('Salle de bain', array(
			'Salle de bain complète',
			'Sanitaire',
			'Installation WC',
			'Meuble salle de bains',
			'Saunas',
			'Hamman',
			'Spa - Balneo'
		)),
		array('Peinture - Tapisserie', array(
			'Peinture',
			'Lambris',
			'Papier peint - Taîsserie',
			'Décoration',
			'autres'
		)),
		array('Façade', array(
			'Ravalement de façade',
			'Enduit de façade',
			'Traitement de façade',
			'Etancheite de façade',
			'Peinture de façade',
			'Crepis',
			'Parement',
			'Nettoyage de façade',
			'Bardage'
		)),
		array('Piscine - Abri de piscine', array(
			'Piscine en kit',
			'Piscine bati',
			'Piscine bois',
			' Pose de liner',
			'Chauffage de piscine',
			'Alarme de piscine',
			'Barriere de piscine',
			'Securite piscine',
			'Couverture piscine',
			'Abris de piscine',
			'Materiel d\'entretient - filtration - local technique',
			'Contour de piscine',
			'Dallage'
		)),
		array('Assainissement - Terrassement', array(
			'Fosse sceptique',
			'Bac a graisse',
			'Terrassement',
			'Viabilisation ( tout a l\'egout, electricite, eau )',
			'Station d\'épuration',
			'Vidange et Entretient ( fosse septique, bac à graisse )',
			'Canalisation ( pose, remplacement, réparation )',
			'Canalisation ( nettoyage, débouchage )',
			'Drainage',
			'Enrochement',
			'Mini pelle avec chauffeur'
		)),
		array('Espaces verts', array(
			'Goudronnage',
			'Entretient Espace vert',
			'Création de jardin ',
			'Plantation arbres fruitiers',
			'Chemin d\'acces',
			'Arrosage ',
			'Elagage - Débroussaillage',
			'Puits',
			'Chemin d\'acces'
		)),
		array('Clôture - Portail', array(
			'Cloture Bati',
			'Cloture Panneau rigide',
			'Cloture Bois',
			'Cloture Grillage',
			'Portail d\'entrée',
			'Barriere'
		)),
		array('Alarme - securité - incendie', array(
			'Pose d\'alarme',
			'Gardiennage - Surveillance',
			'Videosurveillance',
			'Alarme incendie',
			'Désenfumage',
			'Blindage'
		)),
		array('Climatisation - Ventilation', array(
			'Climatision Reversible',
			'Climatisation',
			'Chambre froide',
			'VMC '
		)),
		array('Aménagement intérieur', array(
			'Amenagement de combles',
			'Amenagement Interieur',
			'Amenagement de Placards',
			'Agencement d\'un commerce',
			'Cave',
			'Dressing',
			'Bureaux',
			'Biblotheque',
			'Ebenisterie',
			'Amenagement pour personne a mobilité réduite'
		)),
		array('Ascenseur - Monte charge', array(
			'Ascenseur',
			'Monte Escalier',
			'Elevateur',
			'Monte charges'
		)),
		array('Escalier - Garde corps', array(
			'Escalier bois ',
			'Escalier alu - Metal',
			'Escalier béton',
			'Garde corps',
			'Autres'
		)),
		array('Cheminée - Accessoires', array(
			'Cheminée',
			'Conduit de cheminée',
			'Récuperateur de chaleur',
			'Insert et cheminée',
			'Ramonage'
		)),
		array('Diagnostics - Traitement', array(
			'DPE ( Diagnostic de performance energetique )',
			'Désamiantage',
			'Traitement de l\'humidité',
			'Diagnistic plomb',
			'Traitement bois et charpente',
			'Diagnostic Parasitaire ( Termites, mérules  etc … )',
			'Diagnostic amiante',
			'Radon ( Diagnostic et traitement )',
			'Diagnostic risque naturel',
			'Diagnostic GAZ',
			'Diagnostic electrique',
			'Diagnostic Assainissement',
			'DTI ( Diagnostic Technique Immobilier )',
			'Diagnostic légionnellose',
			'Traitement termites',
			'Traitement Façade',
			'Traitement champignons',
			'Traitement de l\'eau',
			'Traitement de l\'air',
			'Assechement des murs',
			'Remontée capillaire',
			'Dératisation',
			'Désinsectisation',
			'Dépigeonnage',
			'Démoussage',
			'Etat descriptif ( loi robien )',
			'Etat des lieux'
		)),
		array('Architecture - Expertise', array(
			'Plan de construction',
			'Projet d\'amenagement interieur',
			'Projet de rénovation',
			'Architecte paysagiste',
			'Maitre d\'œuvre',
			'Decorateur',
			'Bureau d\'expertise - Expert en batiment',
			'Bureau d\'etudes - ingenierie',
			'Loi carrez - Métrage',
			'Economiste'
		))
	);

	public static function validerIDs(&$id_a, &$id_b) {
		$c_liste = count(self::$liste);
		$id_a = $id_a < 0 ? 0 : ($id_a >= $c_liste ? 0 : intval($id_a));	
		$c_liste = count(self::$liste[$id_a][1]);
		$id_b = $id_b < 0 ? -1 : ($id_b >= $c_liste ? 0 : intval($id_b));	
	}
}



?>
