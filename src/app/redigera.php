<?php 

session_start();
if (!$_SESSION['inloggning']) {
    header("Location:".'index.php');
}

date_default_timezone_set('Europe/Bucharest');
$base_url = str_replace(basename(__FILE__), '..'.DS, $_SERVER['PHP_SELF']);
$base_url = realpath($base_url);
if (isset($_POST["content"])) {
    if (get_magic_quotes_gpc()) {
        $_POST["content"] = stripslashes($_POST["content"]); //Viss version lägger på \:ar vid " om så ta bort.
    }
}

if (isset($_GET["file"]) && !isset($_POST['content'])) { // läser och testar värden och häntar filen.
    $file = '..'.DIRECTORY_SEPARATOR . $_GET["file"];
    if (!file_exists($file)) {
        echo $file;
    };
    $aktivid = (isset($_GET['aktivid'])) ? $_GET['aktivid'] : '';
    $htmlcontent = @file_get_contents($file);
    $_SESSION["htmbackup"] = $htmlcontent;
    $backupfile = '';
    
} elseif (isset($_POST["content"])) {
    $contentDir = '..'.DIRECTORY_SEPARATOR.'content';
    $contentLangDir = $contentDir .DIRECTORY_SEPARATOR. $_SESSION['langguage'] . '_htm';
    $contentLangBackup = $contentLangDir . '_bakup';
    createDirs($contentDir,$contentLangDir,$contentLangBackup);

    $htmlcontent = $_POST["content"];
    $file = $_POST["file"];
    $aktivid = $_POST['aktivid'];
    @file_put_contents($file, $htmlcontent);
    $_SESSION["htmbackup"] = NULL;   
    $_SESSION[$_SESSION['langguage']."_edited"] = true;
    header("Location: ../".$aktivid."");

} else {
    $htmlcontent = '';
    $file = '';
    $aktivid = '';
    $backupfile = '';
}

function createDirs($contentDir,$languageSpecific, $backup){
    if (!file_exists($contentDir)) {
        mkdir($contentDir, 0777, true);
    }

    if (!file_exists($languageSpecific)){
        mkdir($languageSpecific, 0777, true);    
    }

    if (!file_exists($backup)){
        mkdir($backup, 0777, true);    
    }
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=uft-8">
        <title>Redigera med tiny</title>
        <base href="http://<?php echo $_SERVER['HTTP_HOST'].$base_url?>">
        <script type="text/javascript" src="app/lib/tinymce/tinymce.min.js"></script>
        <link rel="stylesheet" type="text/css" href="app/styles/main.css" />



        <script type="text/javascript">
            tinymce.init({
                selector: "#textarea2",
                theme: "modern",
                width: 620,
                height: 300,
                document_base_url: '/<?php echo $base_url; ?>',
                plugins: [
                     "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                     "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
                     "table contextmenu directionality emoticons paste textcolor responsivefilemanager save code template"
               ],
               toolbar1: "save | undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
               toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor | print preview",
               save_enablewhendirty: true,
               image_advtab: true ,
               external_filemanager_path:"<?php echo $base_url?>filemanager/",
               filemanager_title:"Responsive Filemanager" ,
               external_plugins: { "filemanager" : "/<?php echo $base_url?>filemanager/plugin.min.js"},
               content_css : "<?php echo $base_url; ?>/app/styles/main.css", 
               templates: [ 
                    {title: 'quote', description: 'Insert a guote on the site', url : 'app/mceTemplates/quote.html'}, 
                    {title: 'imgFigure', description: 'Insert a image placeholder for img and img caption', url: 'app/mceTemplates/figure.html'} 
                ]
            });
        </script>
    </head>
    <body>
        <p>File <?php echo $file; ?></p>
        <div class="left">
            <form action="app/redigera.php" method="post">
                <textarea id="textarea2" name="content">
                    <?php echo $htmlcontent; ?>
                </textarea>
                <input type="hidden" value="<?php echo $file?>" name="file"/><input type="hidden" value="<?php echo $aktivid?>" name="aktivid"/>
            </form>
        </div>
    </body>
</html>
