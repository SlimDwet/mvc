<?php

// Directory separator
define('DS', DIRECTORY_SEPARATOR);

// Chargement des configs
require_once dirname(__DIR__).'/app/Config/config.php';

// Path et inclusions de fichiers
set_include_path(CORE_DIR.':'.APP_DIR);

require_once 'functions.php';

// Gestion des erreurs
$errors = Errors::init();

// Vérification des configs
checkConfig();

// Database
$database = new Database();
$bdd = $database->getInstance();
Router::parse();