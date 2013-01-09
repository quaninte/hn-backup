<?php

define('ROOT', __DIR__);
define('CONFIG_DIR', ROOT . '/config/');
define('HANDLERS_DIR', ROOT . '/handlers/');
define('VIEWS_DIR', ROOT . '/views/');

require CONFIG_DIR . 'bootstrap.php';

if (!isLoggedIn()) {
    require HANDLERS_DIR . 'login.php';
    require VIEWS_DIR . 'login.php';

    die;
}

require HANDLERS_DIR . 'settings.php';
require VIEWS_DIR . 'settings.php';