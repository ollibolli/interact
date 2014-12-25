<?php session_start();

function recurse_copy($src,$dst) { 
    $dir = opendir($src); 
    @mkdir($dst); 
    while(false !== ( $file = readdir($dir)) ) { 
        if (( $file != '.' ) && ( $file != '..') && (substr($file, 0, 1) != '.')) { 
            if ( is_dir($src . '/' . $file) ) { 
                recurse_copy($src . '/' . $file,$dst . '/' . $file); 
            } 
            else { 
                copy($src . '/' . $file,$dst . '/' . $file); 
            } 
        } 
    } 
    closedir($dir); 
} 


if (isset($_SESSION["inloggning"])) {
	$lang = $_SESSION["langguage"];
	$draft = '../content/'.$lang.'_draft';
	$htm = '../content/'.$lang.'_htm';
	$backup = '../content/'.$lang.'_backup_'.@date('siH-dmo');
	recurse_copy($htm, $backup);
	recurse_copy($draft, $htm);
	$_SESSION[$_SESSION['langguage']."_edited"] = false;

}
header("Location:".'../index.php');

