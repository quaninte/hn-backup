<?php

define('ROOT', __DIR__);
define('CONFIG_DIR', __DIR__ . '/config/');
define('HANDLERS_DIR', __DIR__ . '/handlers/');
define('VIEWS_DIR', __DIR__ . '/views/');

require CONFIG_DIR . 'bootstrap.php';

if (!isLoggedIn()) {
    require HANDLERS_DIR . 'login.php';
    require VIEWS_DIR . 'login.php';

    die;
}

require HANDLERS_DIR . 'settings.php';
require VIEWS_DIR . 'settings.php';