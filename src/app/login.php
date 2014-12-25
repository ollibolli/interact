<?php 
// startar sessionen
session_start();

// ange ditt användarnamn och lösenord i variablerna
$anvandarID = "melo";
$losenord = "melopower";

if (isset($_POST["anvandarID"]) && isset($_POST["losenord"])) { // kontrollerar om användarnamn och lösenord är rätt
    if ($_POST["anvandarID"] === $anvandarID && $_POST["losenord"] === $losenord) { // ange den session som lagrar rätt inloggningsuppgifter
        $_SESSION["inloggning"] = true; // efter rätt inloggning förflyttas användaren till den skyddade sidan
        header("Location:".'../index.php');
        exit;
    }
    else {
        $felmeddelande = "Du har angivit fel användarnamn eller lösenord!";
    } // om användarnamn och lösenord är fel lagras meddelandetexten i variabeln
}

?>
 <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd" />
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="<?php echo $stylecss?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo $menucss?>" />
        <meta http-equiv="Content-Type" content="text/html; charset=uft-8">
        <title>Logga in</title>
    </head>
    <body>
        <h2>Logga in </h2>
        <p>
            <?php 
            echo "<strong><font color='#ff0000'>".$felmeddelande."</font></strong>";
            echo "<strong><font color='#ff0000'>".$meddelande2."</font></strong>";
            ?>
        </p>
        <form action="login.php" method="post" name="loginform">
            <table border="0" cellpadding="5" cellspacing="0" bgcolor="#ccff66" class="kantlinje">
                <tr>
                    <td>
                        Anv&auml;ndarnamn
                    </td>
                    <td>
                        <input name="anvandarID" type="text" class="formularfalt" value="melo">
                    </td>
                </tr>
                <tr>
                    <td>
                        L&ouml;senord
                    </td>
                    <td>
                        <input name="losenord" type="password" class="formularfalt">
                    </td>
                </tr>
                <tr rowspan="2">
                    <td height="53">
                    </td>
                    <td>
                </tr>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                    <td>
                        <input type="submit" value="Logga in">
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>