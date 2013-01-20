<?php
/**
 * Check if user is logged in or not
 * @return bool
 */
function isLoggedIn()
{
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
        return true;
    }
    return false;
}

function login()
{
    $_SESSION['logged_in'] = true;
}

function logout()
{
    $_SESSION['logged_in'] = false;
}

function redirect($url)
{
    header('Location: ' . $url);
    die;
}

function getSetting($key)
{
    global $settings, $params;
    if (!isset($settings[$key])) {

        if (isset($params[$key])) {
            return $params[$key]['value'];
        }

        return null;
    }

    return $settings[$key];
}

function getBase()
{
    return $_SERVER['REQUEST_URI'];
}

if (!function_exists('vd')) {
    function vd($var = false, $trace = 1, $showHtml = false, $showFrom = true) {
        if ($showFrom) {
            $calledFrom = debug_backtrace();
            for ($i = 0; $i < $trace; $i++) {
                if (!isset($calledFrom[$i]['file'])) {
                    break;
                }
                echo substr($calledFrom[$i]['file'], 1);
                echo ' (line <strong>' . $calledFrom[$i]['line'] . '</strong>)';
                echo "<br />";
            }
        }
        echo "<pre class=\"cake-debug\">\n";

        $var = var_dump($var);
        if ($showHtml) {
            $var = str_replace('<', '&lt;', str_replace('>', '&gt;', $var));
        }
        echo $var . "\n</pre>\n";
    }
    function vdd($var = false, $trace = 1, $showHtml = false, $showFrom = true) {
        if ($showFrom) {
            $calledFrom = debug_backtrace();
            for ($i = 0; $i < $trace; $i++) {
                if (!isset($calledFrom[$i]['file'])) {
                    break;
                }
                echo substr($calledFrom[$i]['file'], 1);
                echo ' (line <strong>' . $calledFrom[$i]['line'] . '</strong>)';
                echo "<br />";
            }
        }
        echo "<pre class=\"cake-debug\">\n";

        $var = var_dump($var);
        if ($showHtml) {
            $var = str_replace('<', '&lt;', str_replace('>', '&gt;', $var));
        }
        echo $var . "\n</pre>\n";
        die;
    }
}