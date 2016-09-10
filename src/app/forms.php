<?php
if(isset($_POST['submit'])){
    $to = "info@interactcompetence.com"; // this is your Email address
    $from = $_POST['email']; // this is the sender's Email address
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $subject = "Form submission";
    $subject2 = "Copy of your form submission";
    $message = $first_name . " " . $last_name . " wrote the following:" . "\n\n";
    foreach ($_POST as $key => $value) {
        $message . $key . ":" . $value . "\n";
    }
    $headers = "From:" . $from;
    $headers2 = "From:" . $to;
    mail($to,$subject,$message,$headers);
    header('Location: ' . "../thank");
}
?>
