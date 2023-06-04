<?php 
session_start();
include('includes/config.php');
error_reporting(0);

// Verificăm dacă formularul a fost trimis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Definirea variabilelor și inițializarea cu valori goale
    $name = $email = $phone = $message = "";
    $nameErr = $emailErr = $phoneErr = $messageErr = "";

    $name = test_input($_POST["name"]);
    $email = test_input($_POST["email"]);
    $phone = test_input($_POST["phone"]);
    $message = test_input($_POST["message"]);

    if (empty($name)) {
        $nameErr = "Numele este obligatoriu";
    }

    if (empty($email)) {
        $emailErr = "Adresa de email este obligatorie";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Adresa de email nu este validă";
    }

    if (empty($phone)) {
        $phoneErr = "Numărul de telefon este obligatoriu";
    }


    if (empty($message)) {
        $messageErr = "Mesajul este obligatoriu";
    }


    if (empty($nameErr) && empty($emailErr) && empty($phoneErr) && empty($messageErr)) {
        $to = "iulian.cerbu@gmail.com"; // Adresa de e-mail a destinatarului
        $subject = "Mesaj de contact"; // Subiectul e-mailului

        // Construirea conținutului mesajului
        $emailBody = "Nume: $name\n";
        $emailBody .= "E-mail: $email\n";
        $emailBody .= "Telefon: $phone\n";
        $emailBody .= "Mesaj: $message\n";

        // Setarea antetului e-mailului
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";

        // Trimiterea e-mailului
        if (mail($to, $subject, $emailBody, $headers)) {
            $_SESSION['msg'] = "Mesajul a fost trimis cu succes!";
            header("Location: contact.php");
            exit();
        } else {
            $_SESSION['error'] = "Eroare la trimiterea mesajului. Vă rugăm să încercați din nou mai târziu.";
            header("Location: contact.php");
            exit();
        }
    }
}


function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


?>

<!DOCTYPE html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="Hotel CasaThea - Proiect DAW" />
    <meta name="author" content="IC" />
    <title>Casa Thea - Contact</title>

    <link href="assets/css/bootstrap.css" rel="stylesheet" />

    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <script src="https://kit.fontawesome.com/78d47f6922.js" crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>


</head>
<body>

<?php include('includes/header.php');?>

    <div class="content-wrapper">
         <div class="container">
        <div class="row pad-botm">
             <div class="row">
             <?php if ($_SESSION['error'] != "") { ?>
<div class="col-md-6">
<div class="alert alert-danger" >
 <strong>Error :</strong> 
 <?php echo htmlentities($_SESSION['error']); ?>
<?php echo htmlentities($_SESSION['error'] = ""); ?>
</div>
</div>
<?php } ?>

<?php if ($_SESSION['msg'] != "") { ?>
<div class="col-md-6">
<div class="alert alert-success" >
 <strong>Success :</strong> 
 <?php echo htmlentities($_SESSION['msg']); ?>
<?php echo htmlentities($_SESSION['msg'] = ""); ?>
</div>
</div>
<?php } ?>



</div>


             <div class="col-md-6 col-md-offset-3">
               <div class="panel panel-default">
    

                        <div class="panel-heading">
                           CONTACT
                        </div>
                                                <div class="panel-body">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
<div class="form-group">
        <input class="form-control" type="text" name="name" id="name" placeholder="Nume si prenume" value="<?php echo $name; ?>">
        <span class="error"><?php echo $nameErr; ?></span>
</div>

<div class="form-group">
        <input class="form-control" type="email" name="email" id="email" placeholder="Adresa de email" value="<?php echo $email; ?>">
        <span class="error"><?php echo $emailErr; ?></span>
</div>
                                        
<div class="form-group">
    <input class="form-control" type="tel" name="phone" id="phone" placeholder="Telefon"  value="<?php echo $phone; ?>">
        <span class="error"><?php echo $phoneErr; ?></span>
</div>

<div class="form-group">
    <textarea class="form-control" name="message" placeholder="Mesajul dumneavoastra"  id="message" rows="5"><?php echo $message; ?></textarea>
        <span class="error"><?php echo $messageErr; ?></span>
</div>

<div class="form-group">
    <div class="g-recaptcha" data-sitekey="6Le6g2gmAAAAAOiiCzM0NwyS_owbLd-qzLK9qsR_"></div>
</div>
                               
<button type="submit" name="submit" class="btn btn-danger" id="submit">Trimite</button>

                                    </form>
                            </div>
                        </div>
                            </div>

    </div>
    </div>
    </div>
    </div>

    <?php include('includes/footer.php');?>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/custom.js"></script>
</body>
</html>
