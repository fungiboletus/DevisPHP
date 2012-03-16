<?php

define('TIME_ZONE', 'Europe/Paris');
setlocale (LC_ALL, 'fr_FR.utf8','fr_FR', 'fr'); 

// Use of url rewriting
define('URL_REWRITING', 'app');
//define('URL_REWRITING', false);

define('DEBUG',true);

define('DB_DSN_PDO', 'mysql:host=localhost;dbname=devisphp');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
define('DB_FREEZE', false);
define('DB_DEBUG', false);

const $smtp_settings = array('smtp.gmail.com', 465, 'ssl');
define('STMP_USER', 'a.pultier at gmail.com');
define('STMP_PASSWORD', 'root');

define('CREDIT_DEPART', 10);
define('COUT_ACHAT', 2);
?>
