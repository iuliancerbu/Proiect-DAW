<?php
session_start();

if(isset($_POST['captcha_submit'])) {
    // Verificați captcha
    $captchaResponse = $_POST['g-recaptcha-response'];
    $secretKey = 'CHEIA_PRIVATA';

    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captchaResponse);
    $responseData = json_decode($response);

    if($responseData->success != true) {
        // Captcha invalidă, afișează un mesaj de eroare sau alte acțiuni
        $_SESSION['error'] = "Captcha invalidă. Vă rugăm să completați corect captcha.";
        header('location: '.$_SESSION['redirect_url']);
        exit();
    } else {
        // Captcha validă, continuați cu acțiunile dorite (de exemplu, înregistrarea, autentificarea, trimiterea formularului etc.)
        // ...
    }
}
?>
