<?php
session_start();
error_reporting(0);
include('includes/config.php');





$email = $_GET['email'];
$activation_code = $_GET['activation_code'];

// Verificare cod de activare în baza de date
$sql = "SELECT * FROM tblutilizatori WHERE EmailId = :email AND CodValidare = :activation_code";
$query = $dbh->prepare($sql);
$query->bindParam(':email', $email, PDO::PARAM_STR);
$query->bindParam(':activation_code', $activation_code, PDO::PARAM_STR);
$query->execute();
$user = $query->fetch(PDO::FETCH_ASSOC);

if(isset($_POST['change']))
{
$newpassword=md5($_POST['newpassword']);
if ($user) {
$con="update tblutilizatori set Password=:newpassword where EmailId=:email and CodValidare=:activation_code";
$chngpwd1 = $dbh->prepare($con);
$chngpwd1-> bindParam(':email', $email, PDO::PARAM_STR);
$chngpwd1-> bindParam(':activation_code', $activation_code, PDO::PARAM_STR);
$chngpwd1-> bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
$chngpwd1->execute();
$_SESSION['msg'] = "Parola dumneavoastra a fost schimbata. Acum puteti sa va logati cu noua parola.";
header('location:index.php');
}
else {
  $_SESSION['error'] = "Parola dumneavoastra nu a putut fi schimbata. Va rugam sa incertati inca o data.";
  header('location:index.php');
}
}


?>

<!DOCTYPE html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="Hotel CasaThea - Proiect DAW" />
    <meta name="author" content="IC" />
    <title>Hotel CasaThea - Reset Parola</title>
  
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

<script type="text/javascript">
function valid()
{
if(document.chngpwd.newpassword.value!= document.chngpwd.confirmpassword.value)
{
alert("Cele doua parole u coincid !!");
document.chngpwd.confirmpassword.focus();
return false;
}
return true;
}
</script>

</head>
<body>

<?php include('includes/header.php');?>
<?php if ($user) { ?>

  <div class="content-wrapper">
<div class="container">
<div class="row pad-botm">
<div class="col-md-12">
<h4 class="header-line">Restare Parola</h4>
</div>
</div>
             
          
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3" >
<div class="panel panel-info">
<div class="panel-heading">
Restare Parola
</div>
<div class="panel-body">
<form role="form" name="chngpwd" method="post" onSubmit="return valid();">


<div class="form-group">
<label>Parola</label>
<input class="form-control" type="password" name="newpassword" required autocomplete="off"  />
</div>

<div class="form-group">
<label>Confirmati Parola</label>
<input class="form-control" type="password" name="confirmpassword" required autocomplete="off"  />
</div>


 <button type="submit" name="change" class="btn btn-info">Schimba Parola</button> | <a href="index.php">Login</a>
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

}
<?php } ?>