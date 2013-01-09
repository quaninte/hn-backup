<?php

if (isset($_POST['settings']) && $_POST['settings']) {
    $submittedSettings = $_POST['settings'];

    $content = "<?php\n";
    $content .= '$settings = ' . var_export($submittedSettings, true) . ';';

    file_put_contents(CONFIG_DIR . 'settings.php', $content);
    redirect(getBase());
}