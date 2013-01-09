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