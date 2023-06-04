<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
  { 
header('location:index.php');
}
else{?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="Hotel CasaThea - proiect DAW" />
    <meta name="author" content="IC" />

    <title>Hotel CasaThea - Dashboard</title>

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
<div class="col-md-12">
    <h4 class="header-line">ADMIN DASHBOARD</h4>
    
                </div>

</div>
    
    <div class="row">

<div class="col-md-3 col-sm-3 col-xs-6">
<div class="alert alert-success back-widget-set text-center">
<i class="fa fa-book fa-5x"></i>
<?php 
$sql ="SELECT id from tblproceduri ";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$listdbooks=$query->rowCount();
?>


<h3><?php echo htmlentities($listdbooks);?></h3>
Proceduri
</div>
</div>


<div class="col-md-3 col-sm-3 col-xs-6">
<div class="alert alert-info back-widget-set text-center">
<i class="fa fa-file-lines fa-5x"></i>
<?php 
$sql1 ="SELECT id from tbldocumente ";
$query1 = $dbh -> prepare($sql1);
$query1->execute();
$results1=$query1->fetchAll(PDO::FETCH_OBJ);
$documentepublicate=$query1->rowCount();
?>

<h3><?php echo htmlentities($documentepublicate);?> </h3>
Documente
</div>
</div>
             

<div class="col-md-3 col-sm-3 col-xs-6">
<div class="alert alert-danger back-widget-set text-center">
<i class="fa fa-users fa-5x"></i>
<?php 
$sql3 ="SELECT id from tblutilizatori ";
$query3 = $dbh -> prepare($sql3);
$query3->execute();
$results3=$query3->fetchAll(PDO::FETCH_OBJ);
$utilizatoriactivi=$query3->rowCount();
?>
<h3><?php echo htmlentities($utilizatoriactivi);?></h3>
Utilizatori
</div>
</div>

<div class="col-md-3 col-sm-3 col-xs-6">
<div class="alert alert-danger back-widget-set text-center">
<i class="fa-solid fa-user-pen fa-5x"></i>
<?php 
$sql3 ="SELECT id from tblutilizatori ";
$query3 = $dbh -> prepare($sql3);
$query3->execute();
$results3=$query3->fetchAll(PDO::FETCH_OBJ);
$utilizatoriactivi=$query3->rowCount();
?>
<h3><?php echo htmlentities($utilizatoriactivi);?></h3>
Utilizatori
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
