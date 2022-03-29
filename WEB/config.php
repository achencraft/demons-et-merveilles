<?php
//On demarre les sessions
session_start();

/******************************************************
----------------Configuration Obligatoire--------------
Veuillez modifier les variables ci-dessous pour que l'
espace membre puisse fonctionner correctement.
******************************************************/

//astuce pour utiliser les anciennes versions de connexion SQL
include_once('fix_mysql.inc.php');


//On se connecte a la base de donnee
mysql_connect('HOST', 'USER', 'PASSWORD');
mysql_select_db('DATABASE');



//Email du webmaster
$mail_webmaster = 'ADMIN MAIL';

//Adresse du dossier de la top site
$url_root = 'URL RACINE DU SITE';

/******************************************************
----------------Configuration Optionelle---------------
******************************************************/

//Nom du fichier de laccueil
$url_home = "https://" . $_SERVER['SERVER_NAME'] . '/index.php';

$url = "https://" . $_SERVER['SERVER_NAME'] ;

//dossier stylesheet
$stylefolder = "https://" . $_SERVER['SERVER_NAME'] .'/style';

//menu
$menufile = "https://" . $_SERVER['SERVER_NAME'] .'/overall/menu.php';


//dossier images
$imagefolder = "https://" . $_SERVER['SERVER_NAME'] .'/images';
?>
