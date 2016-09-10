<?php
session_start();

require_once('app/config.php');

if (isset($_GET['lang'])){
    $_SESSION[LANGUAGE]=$_GET['lang'];
}

$base_url = '/';
$base_url = str_replace(basename(__FILE__), '', $_SERVER['PHP_SELF']);
$parsedUrl = parse_url($_SERVER['REQUEST_URI']);
$resource = explode('/', $_GET['resource']);
$page = $resource[0];
if ( empty($page)){
    $page = 'index';
}

if ($_SESSION[LANGUAGE]=='sv') {
    $htmdir = CONTENT_DIR . "/sv_htm/";
    $draftdir = CONTENT_DIR . '/sv_draft/';
    $lang = '<a href="?lang=en">English</a>';
} else if ($_SESSION[LANGUAGE]=='en') {
    $htmdir = CONTENT_DIR . "/en_htm/";
    $draftdir = CONTENT_DIR . "en_draft/";
    $lang = '<a href="?lang=sv">Svenska</a>';
} else {
    $htmdir = CONTENT_DIR . "sv_htm/";
    $draftdir = CONTENT_DIR . "sv_draft/";
    $lang = '<a href="?lang=en">English</a>';
    $_SESSION['language']='sv';
}

if (isLoggedIn()){
    $htmdir = $draftdir;
}

if ( file_exists($htmdir.$page) == 0 && !isset($_SESSION["loggedIn"]) && $page != 'index'){
    header("HTTP/1.0 404 Not Found");
    echo "404";
    exit;
}

function isLoggedIn() {
    return isset($_SESSION[LOGGED_IN]);
}

function writeContent($contentsrc, $sectionId = 'Empty Section'){
    if (file_exists($contentsrc)){
        if (filesize($contentsrc) < 5 ){
            if (isset($_SESSION["loggedIn"])){
                echo $sectionId;
            } else {
                echo '';
            }
        } else {
            echo file_get_contents($contentsrc);
        }
    } else {
        if (isset($_SESSION["loggedIn"])){
            echo "Empty section";
        } else {
            echo '';
        }
    }
};

function section($page, $sectionId, $variant = ''){
    global $htmdir;
    $src = $htmdir . $page . $sectionId . '.html';
    $edit = '<div class="edit" data-active="' . $page . '" data-file="' . $page . $sectionId . '.html"><a href="/">&target;</a></div>';
    echo isset($_SESSION[LOGGED_IN]) ? $edit : '';
    echo '<div class="wrapper ' . $variant . '">';
    writeContent($src, $sectionId);
    echo '</div>';
}

function globalSection($sectionId, $variant = '') {
    section('', $sectionId, $variant, '');
}

function pageSection($sectionId, $variant = '') {
    global $page;
    section($page.'/', $sectionId, $variant, '');
}

function adminbar(){
    if (isLoggedIn()) {
        $needPublish = $_SESSION[$_SESSION['language']."_edited"] == true ? 'alert-danger' : '';
        $logout = '<span class=""> <a href="app/login.php?logout=logout">| Log out </a> </span>';
        $publicera = ' | <span class="' . $needPublish . '"> <a href="app/publish.php">Publish</a> </span>';
        $resetdraft = ' | <span class="pull-right"><a href="app/publish.php?reset=reset">| Reset | </a> </span>';
        echo '<div class="adminbar" style="color:#fff;">' . $logout . $publicera . $resetdraft . '</div>';
    }
}
function parseProperties(){
    global $htmdir, $page;
    $src = $htmdir . $page . '/metadata.properties';
    $properties = array();
    if (file_exists($src)) {
        $propList = explode("\n", file_get_contents($src));
        foreach ($propList as $prop) {
            $properties[explode("=",$prop)[0]] = explode("=",$prop)[1];
        }
    }
    return $properties;
}
$properties = parseProperties();

function metadata(){
    global $page, $properties;
    if (isLoggedIn()) {
        echo <<<EOT
<div>
<style>
    .MetaData {
        background:#eee;
        color:#000;
        padding:20px 50px;
        margin-top:30px;
        border-top:3px solid #000;
        position: absolute;
        bottom: -200px;
    }
    .MetaData label {
        width:120px;
        display:inline-block;
        font-size:14px;
    }
    .MetaData input {
        width:400px;
    }

 </style>
<div class="MetaData">
    <h4> Meta proprties for page </h4>
    <form id="MetaPropertiesForm" action="app/redigera.php" data-active="{$page}" data-file="{$page}/metadata.properties" >
        <label for="pageTitle">Page title</label><input type="text" name="pageTitle" value="{$properties['pageTitle']}" /><br />
        <label for="metaDescription">Meta description</label><input type="text"  name="metaDescription" value="{$properties['metaDescription']}" /> About 155 characters <br />
        <label for="keywords">Keywords</label><input type="text"  name="keywords" value="{$properties['keywords']}" /><br />
        <button type="submit" id="MetaPropertiesSubmit" class="btn ">Save</button>
    </form>
</div>
</div>
EOT;
    }
}
