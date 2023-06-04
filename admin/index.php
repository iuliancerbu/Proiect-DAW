<?php
session_start();
error_reporting(0);
include('includes/config.php');
if($_SESSION['alogin']!=''){
    echo "<script type='text/javascript'> document.location ='dashboard.php'; </script>";
}
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

            if ($result->RolId == 1) {
                $_SESSION['alogin'] = $_POST['emailid'];
                echo "<script type='text/javascript'> document.location ='dashboard.php'; </script>";
            } else {
                if ($result->Status == 1) {
                    $_SESSION['login'] = $_POST['emailid'];
                    
                    echo "<script type='text/javascript'> document.location ='index.php'; </script>";
                } else {
                    $_SESSION['error']="Contul dumneavoastra nu este activat sau este blocat. Verificati e-mailul pentru activare sau contactati administratorul.";

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
    <title>Hotel CasaThea - Index</title>

    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <script src="https://kit.fontawesome.com/78d47f6922.js" crossorigin="anonymous"></script>

</head>
<body>

<?php include('includes/header.php');?>


<?php if ($_SESSION['error'] != "") { ?>
            <div class="col-md-6">
                <div class="alert alert-danger">
                    <strong>Error :</strong>
                    <?php echo htmlentities($_SESSION['error']); ?>
                    <?php echo htmlentities($_SESSION['error'] = ""); ?>
                </div>
            </div>
        <?php } ?>

        <?php if ($_SESSION['msg'] != "") { ?>
            <div class="col-md-6">
                <div class="alert alert-success">
                    <strong>Success :</strong>
                    <?php echo htmlentities($_SESSION['msg']); ?>
                    <?php echo htmlentities($_SESSION['msg'] = ""); ?>
                </div>
            </div>
        <?php } ?>


<div class="content-wrapper">
<div class="container">
<div class="row pad-botm">
<div class="row">
    <?php if ($_SESSION['error'] != "") { ?>
<div class="col-md-12">
<div class="alert alert-danger" >
 <strong>Error :</strong> 
 <?php echo htmlentities($_SESSION['error']); ?>
<?php echo htmlentities($_SESSION['error'] = ""); ?>
</div>
</div>
<?php } ?>

<?php if ($_SESSION['msg'] != "") { ?>
<div class="col-md-12">
<div class="alert alert-success" >
 <strong>Success :</strong> 
 <?php echo htmlentities($_SESSION['msg']); ?>
<?php echo htmlentities($_SESSION['msg'] = ""); ?>
</div>
</div>
<?php } ?>
</div>

</div>
             
<!--LOGIN-->           
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3" >
<div class="panel panel-info">
<div class="panel-heading">
 LOGIN FORM
</div>
<div class="panel-body">
<form role="form" method="post">

<div class="form-group">
<label>Enter Email id</label>
<input class="form-control" type="text" name="emailid" required autocomplete="off" />
</div>
<div class="form-group">
<label>Password</label>
<input class="form-control" type="password" name="password" required autocomplete="off"  />
<p class="help-block"><a href="user-forgot-password.php">Am uitat parola</a></p>
</div>

 <button type="submit" name="login" class="btn btn-info">LOGIN </button> | <a href="signup.php">Inregistreaza-te</a>
</form>
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
