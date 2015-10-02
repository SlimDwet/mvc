<?php

// Database
define('DB_HOST', 'localhost');
define('DB_NAME', 'my_framework');
define('DB_USER', 'root');
define('DB_PASS', 'root');

//Paths
define('WWW_ROOT', dirname(__DIR__).DS);
define('WEB_ROOT', 'http://localhost/my_framework/'); // URL du site
define('CORE_DIR', WWW_ROOT.'core'.DS);
define('APP_DIR', WWW_ROOT.'app'.DS);

// Comportements par défaut
define('DEF_CONTROLLER', 'home');