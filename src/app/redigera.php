<?php

session_start();
const DS = DIRECTORY_SEPARATOR;
require_once('config.php');

if (!$_SESSION[LOGGED_IN]) {
    header("Location: /");
}
date_default_timezone_set('Europe/Bucharest');
$base_url = str_replace(basename(__FILE__), '..'.DS, $_SERVER['PHP_SELF']);
$base_url = realpath($base_url);

if (isset($_POST["content"])) {
    if (get_magic_quotes_gpc()) {
        $_POST["content"] = stripslashes($_POST["content"]); //Viss version lägger på \:ar vid " om så ta bort.
    }
    $contentDir = "../" .CONTENT_DIR;
    $contentLangDir = $contentDir .DS. $_SESSION['language'] . '_htm';
    $contentLangBackup = $contentLangDir . '_bakup';
    $contentLangDraft = $contentDir .DS. $_SESSION['language'] . '_draft';
    $htmlcontent = $_POST["content"];
    $file = $_POST["file"];
    $aktivid = $_POST['aktivid'];
    $contentLangDraftPage = $contentLangDraft . DS . $aktivid;

    createDirs([$contentDir,$contentLangDir,$contentLangBackup, $contentLangDraft, $contentLangDraftPage]);

    file_put_contents($contentLangDraft . DS . $file, $htmlcontent);
    $_SESSION["htmbackup"] = NULL;
    $_SESSION[$_SESSION['language']."_edited"] = true;
    header("Location: ../".$aktivid."");

} else {
    $htmlcontent = '';
    $file = '';
    $aktivid = '';
    $backupfile = '';
}

function createDirs($dirs){
    foreach ($dirs as $key => $dir) {
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
    }
}

function createDirsTree($dirs){
    $tree = '';
    foreach ($dirs as $key => $dir) {
        $tree .= DS.$dir;
        if (!file_exists($tree)) {
            mkdir($tree, 0777, true);
        }
    }
}
