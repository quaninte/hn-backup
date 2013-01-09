<?php

if (isset($_POST) && $_POST) {
    if ($_POST['username'] == $config['username'] && $_POST['password'] == $config['password']) {
        login();
        redirect(getBase());
    }
}