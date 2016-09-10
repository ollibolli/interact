<?php

session_start();
require_once("config.php");

if (isset($_POST["anvandarID"]) && isset($_POST["losenord"])) {
    if ($_POST["anvandarID"] === USER && $_POST["losenord"] === PASSWORD) {
        $_SESSION[LOGGED_IN] = true;
        header("Location:".'../');
        exit;
    }
    else {
        $errorMessage = "Du har angivit fel användarnamn eller lösenord!";
    }
} else if (isset($_GET['logout'])) {
    if (isset($_SESSION[LOGGED_IN])) {
        unset($_SESSION[LOGGED_IN]);
    }
    header("Location: ../index");
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
            echo "<strong>".$errorMessage."</strong>";
            echo "<strong>".$meddelande2."</strong>";
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
