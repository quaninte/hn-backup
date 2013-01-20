<?php
if (PHP_SAPI !== 'cli') {
    die('cli mode only!');
}

define('ROOT', dirname(__DIR__) . '/');
define('CONFIG_DIR', ROOT . '/config/');
define('TMP_DIR', ROOT . '/tmp/');

require CONFIG_DIR . 'bootstrap.php';

$hnBackup = new HNBackup($settings);

$hnBackup->initialize();
$hnBackup->start();
