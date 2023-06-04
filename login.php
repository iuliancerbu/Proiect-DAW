<?php
session_start();
error_reporting(0);
include('includes/config.php');
if($_SESSION['login']!=''){
    echo "<script type='text/javascript'> document.location ='lista-camere.php'; </script>";
}
else {

    // Înregistrarea unei vizualizări noi
    $ip = $_SERVER['REMOTE_ADDR']; // Adresa IP a utilizatorului
    $page = $_SERVER['REQUEST_URI']; // URL-ul paginii vizitate
    $date = date('Y-m-d H:i:s'); // Data și ora vizualizării

    // Inserarea datelor în baza de date
    $sql = "INSERT INTO tblstatistici (ip, pagina, data) VALUES ('$ip', '$page', '$date')";
    $dbh->query($sql);



if(isset($_POST['login']))
{

$email=$_POST['emailid'];
$password=md5($_POST['password']);
$sql ="SELECT id,EmailId,Password,Nume,Status,RolId FROM tblutilizatori WHERE EmailId=:email and Password=:password";
$query= $dbh -> prepare($sql);
$query-> bindParam(':email', $email, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
$query-> execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

if($query->rowCount() > 0)
{
        foreach ($results as $result) {
            $_SESSION['id'] = $result->id;
            $_SESSION['RolId'] = $result->RolId;
            $_SESSION['nume'] = $result->Nume;
            $redirectUrl = isset($_SESSION['redirect_url']) ? $_SESSION['redirect_url'] : 'lista-camere.php'; // Verificăm dacă există un URL de redirecționare salvat în sesiune
            header('location: ' . $redirectUrl);
            if ($result->RolId == 1) {
                $_SESSION['alogin'] = $_POST['emailid'];
                header('location: admin/dashboard.php');
                exit();

            } else {
                if ($result->Status == 1) {
                    $_SESSION['login'] = $_POST['emailid'];
                    
                    echo "<script type='text/javascript'> document.location ='index.php'; </script>";
                } else {
                    $_SESSION['error']="Contul dumneavoastra nu este activat sau este blocat. Verificati e-mailul pentru activare sau contactati administratorul.";
                    header('location: login.php');
                    exit();
                }
            }
        }
} 

else{
    $_SESSION['error']="Contul este invalid.";
}
}

?>
<!DOCTYPE html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="Hotel CasaThea - Proiect DAW" />
    <meta name="author" content="IC" />
    <title>Hotel CasaThea - Log in</title>

    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <script src="https://kit.fontawesome.com/78d47f6922.js" crossorigin="anonymous"></script>
</head>
<body>

<?php include('includes/header.php');?>


<div class="content-wrapper">
<div class="container">
<div class="row pad-botm">
<div class="row">
<?php if ($_SESSION['error'] != "") { ?>
            <div class="col-md-8">
                <div class="alert alert-danger">
                    <strong>Error :</strong>
                    <?php echo htmlentities($_SESSION['error']); ?>
                    <?php echo htmlentities($_SESSION['error'] = ""); ?>
                </div>
            </div>
        <?php } ?>

        <?php if ($_SESSION['msg'] != "") { ?>
            <div class="col-md-8">
                <div class="alert alert-success">
                    <strong>Success :</strong>
                    <?php echo htmlentities($_SESSION['msg']); ?>
                    <?php echo htmlentities($_SESSION['msg'] = ""); ?>
                </div>
            </div>
        <?php } ?>

             
<!--LOGIN-->           
<div class="row">
<div class="col-md-4 col-md-offset-8" >
<div class="panel panel-default">
<div class="panel-heading">
AUTENTIFICARE
</div>
<div class="panel-body">
<form role="form" method="post">
<br />
<div class="form-group">
<input class="form-control" type="text" name="emailid" placeholder="Adresa de email" required autocomplete="off" />
</div>
<div class="form-group">
<input class="form-control" type="password" name="password" placeholder="Parola" required autocomplete="off"  />


<p class="pull-right"><a href="user-forgot-password.php">Am uitat parola</a></p>
</div>
</br>
 <button type="submit" name="login" class="btn btn-info">Autentificare</button> | <a href="signup.php">Inregistreaza-te</a>
</form>
 </div>
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
<?php } ?>