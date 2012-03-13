<?php

define('TIME_ZONE', 'Europe/Paris');
setlocale (LC_ALL, 'fr_FR.utf8','fr_FR', 'fr'); 

// Use of url rewriting
define('URL_REWRITING', 'app');
//define('URL_REWRITING', false);

define('DEBUG',true);

define('DB_DSN_PDO', 'mysql:host=localhost;dbname=devisphp');
define('DB_USER', 'root');
define('DB_PASSWORD', '***');
define('DB_FREEZE', false);
define('DB_DEBUG', false);

define('CREDIT_DEPART', 10);
define('COUT_ACHAT', 2);
?>
