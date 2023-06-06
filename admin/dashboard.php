<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
  { 
header('location:index.php');
}
else{?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="Hotel CasaThea - Proiect DAW" />
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
<a href="lista-rezervari.php">    
<div class="alert alert-success back-widget-set text-center">
<i class="fa-solid fa-calendar-days fa-5x"></i>
<?php 
$sql ="SELECT Id from tblrezervari ";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$listdbooks=$query->rowCount();
?>
<h3><?php echo htmlentities($listdbooks);?></h3>
REZERVARI
</div>
</a>
</div>


<div class="col-md-3 col-sm-3 col-xs-6">
<a href="lista-facturi.php">
<div class="alert alert-info back-widget-set text-center">
<i class="fa-solid fa-file-invoice fa-5x"></i>
<?php 
$sql1 ="SELECT Id from tblfacturi ";
$query1 = $dbh -> prepare($sql1);
$query1->execute();
$results1=$query1->fetchAll(PDO::FETCH_OBJ);
$documentepublicate=$query1->rowCount();
?>

<h3><?php echo htmlentities($documentepublicate);?> </h3>
FACTURI EMISE
</div>
</a>
</div>
             

<div class="col-md-3 col-sm-3 col-xs-6">
<a href="lista-utilizatori.php">
<div class="alert alert-danger back-widget-set text-center">
<i class="fa fa-users fa-5x"></i>
<?php 
$sql3 ="SELECT Id from tblutilizatori ";
$query3 = $dbh -> prepare($sql3);
$query3->execute();
$results3=$query3->fetchAll(PDO::FETCH_OBJ);
$utilizatoriactivi=$query3->rowCount();
?>
<h3><?php echo htmlentities($utilizatoriactivi);?></h3>
UTILIZATORI
</div>
</a>
</div>

<div class="col-md-3 col-sm-3 col-xs-6">
<a href="lista-camere.php">
<div class="alert alert-warning back-widget-set text-center">
<i class="fa-solid fa-door-closed fa-5x"></i>
<?php 
$sql3 ="SELECT id from tblcamere ";
$query3 = $dbh -> prepare($sql3);
$query3->execute();
$results3=$query3->fetchAll(PDO::FETCH_OBJ);
$utilizatoriactivi=$query3->rowCount();
?>
<h3><?php echo htmlentities($utilizatoriactivi);?></h3>
CAMERE
</div>
</a>
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
