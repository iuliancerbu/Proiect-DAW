<?php
session_start();
error_reporting(0);
include('includes/config.php');

$email=$_POST['email'];
if(isset($_POST['send']))
{
  
    $sql="SELECT * FROM tblutilizatori WHERE EmailId= :email";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_OBJ);
    $activation_code = $result[0]->CodValidare;

    if($query->rowCount() > 0){

            
                // TRIMITERE  EMAIL 
                $subject = "Resetare parolă cont Casa Thea";
                $message = 'Dragă utilizator,';
                $message .= '<br><br>Ai solicitat resetarea parolei pentru contul tău de pe site-ul nostru. Pentru a-ți reseta parola, te rugăm să urmezi link-ul de mai jos:';
                $message .= '<br><br><a href="http://localhost/hotel/reset_password.php?email=' . $email .'&amp;activation_code='.$activation_code.'">Link resetare parola</a>';
                $message .= '<br><br>Link-ul va fi valabil timp de 24 de ore. Dacă nu dorești să îți resetezi parola, te rugăm să ignori acest email.';
                $message .= '<br><br>Cu stima,';
                $message .= '<br>Echipa Casa Thea';
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $headers .= 'From: noreplay@casathea.ro' . "\r\n";

                if (mail($email, $subject, $message, $headers)) {
                    $_SESSION['msg']="Pentru resetarea parolei verificati adresa de email. ";
                    header("location:index.php"); 
                } else {
                    $_SESSION['error']="Adresa de email nu este valida.";
                    header("location:index.php"); 
                
            }   
        }    
}

?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="Hotel CasaThea - Proiect DAW" />
    <meta name="author" content="IC" />
    <title>Hotel CasaThea - Recuperare parola</title>
  
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />


</head>
<body>

<?php include('includes/header.php');?>

<div class="content-wrapper">
<div class="container">
<div class="row pad-botm">
<div class="col-md-12">
<h4 class="header-line">Resetare parola cont</h4>
</div>
</div>
             
          
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3" >
<div class="panel panel-info">
<div class="panel-heading">
Resetare parola cont
</div>
<div class="panel-body">
<form role="form" name="chngpwd" method="post">

<div class="form-group">
<label>Adresa de e-mail:</label>
<input class="form-control" type="email" name="email" required autocomplete="off" />
</div>


 <button type="submit" name="send" class="btn btn-info">Reseteaza parola</button> | <a href="index.php">Login</a>
</form>
 </div>
</div>
</div>
</div>  
        
             
 
    </div>
    </div>
->
 <?php include('includes/footer.php');?>

    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/custom.js"></script>

</body>
</html>
