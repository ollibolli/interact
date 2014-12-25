<?php
// startar sessionen
session_start();

// om anv�ndaren �r inloggad avslutas denna session h�r
if (isset($_SESSION["inloggning"])) {
unset($_SESSION["inloggning"]);
}

// n�r utloggningen �r klar visas loginsidan igen
header("Location: ../index");
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
 <h1>Du är utloggad</h1>
</body>
</html>
