<?php session_start();
require_once("config.php");

function recurse_copy($src,$dst) {
    try {
        $dir = opendir($src);
        @mkdir($dst,0777,true);
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..') && (substr($file, 0, 1) != '.')) {
                if (is_dir($src . '/' . $file)) {
                    recurse_copy($src . '/' . $file, $dst . '/' . $file);
                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
    } catch (Exception $e) {
        exit();
    }
    closedir($dir);
}

if (isset($_SESSION["loggedIn"])) {
    $lang = $_SESSION["language"];
    $contentDir =  "../". CONTENT_DIR . DIRECTORY_SEPARATOR;
    $draft = $contentDir . $lang.'_draft';
    $htm = $contentDir . $lang.'_htm';
    $backup =  $contentDir   . $lang . '_backup_'. DIRECTORY_SEPARATOR . $lang . @date('siH-dmo');
    if (isset($_GET['reset'])) {
        recurse_copy($htm, $draft);
    } else {
        recurse_copy($htm, $backup);
        recurse_copy($draft, $htm);
    }

    $_SESSION[$_SESSION['language']."_edited"] = false;
}

header("Location:". $_SERVER['HTTP_REFERER']);
