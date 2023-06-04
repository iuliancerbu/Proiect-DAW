<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{ 

$guest = $_SESSION['id'];

if(isset($_POST['confirm']))
{
$rezid=intval($_GET['rezid']);
$status=2;

$sql = "UPDATE tblrezervari SET tblrezervari.Status=:status  WHERE tblrezervari.Id=:rezid;";
$query = $dbh->prepare($sql);
$query -> bindParam(':rezid',$rezid, PDO::PARAM_STR);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query -> execute();


$sql=" INSERT INTO tblfacturi (IdClient, IdRezervare, ValoareFactura) VALUES ((SELECT GuestId FROM tblrezervari WHERE Id = :rezid) ,:rezid,(SELECT Valoare FROM tblrezervari WHERE Id = :rezid))";
$query = $dbh->prepare($sql);
$query -> bindParam(':guestid',$guestid, PDO::PARAM_INT);
$query -> bindParam(':rezid',$rezid, PDO::PARAM_INT);
$query -> execute();
header('location:factura.php?rezid='.$rezid);

}

if(isset($_POST['cancel']))
{
$rezid=intval($_GET['rezid']);
$status=0;
$sql = "UPDATE tblrezervari SET tblrezervari.Status=:status  WHERE tblrezervari.Id=:rezid;";
$query = $dbh->prepare($sql);
$query -> bindParam(':rezid',$rezid, PDO::PARAM_STR);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query -> execute();
$_SESSION['msg']="Rezervarea a fost anulata.";
header('location:detalii-rezervare.php?rezid='.$rezid);
exit();
}



?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="Hotel CasaThea - Proiect DAW" />
    <meta name="author" content="IC" />
    <title>Hotel CasaThea - Detalii Rezervare</title>

    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <script src="https://kit.fontawesome.com/78d47f6922.js" crossorigin="anonymous"></script>


</head>
<body>

<?php include('includes/header.php');?>

<?php 
$rezid=intval($_GET['rezid']);
$sql= "SELECT tblrezervari.Id as rezid, tblrezervari.GuestId , tblrezervari.CameraId, tblrezervari.CheckIn, tblrezervari.CheckOut, tblrezervari.Valoare, tblrezervari.Status, tblutilizatori.Nume, tblutilizatori.EmailId, tblutilizatori.MobileNumber, tblcamere.NumeCamera FROM tblrezervari JOIN tblutilizatori ON tblutilizatori.id=tblrezervari.GuestId JOIN tblcamere ON tblcamere.id=tblrezervari.CameraId where tblrezervari.Id=:rezid";
$query = $dbh -> prepare($sql);
$query->bindParam(':rezid',$rezid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach ($results as $result){
        $status=$result->Status;
        $guestid = $result->GuestId;
  }  ?> 


    <div class="content-wrapper">
         <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">

<div class="row">
    

<?php if($_SESSION['error']!="")
    {?>
<div class="col-md-8">
<div class="alert alert-danger" >
 <strong>Error :</strong> 
 <?php echo htmlentities($_SESSION['error']);?>
<?php echo htmlentities($_SESSION['error']="");?>
</div>
</div>
<?php } ?>

<?php if($_SESSION['msg']!="")
{?>
<div class="col-md-8">
<div class="alert alert-info" >
 <strong>Success :</strong> 
 <?php echo htmlentities($_SESSION['msg']);?>
<?php echo htmlentities($_SESSION['msg']="");?>
</div>
</div>
<?php } ?>
</div>

<div class="col-md-10 col-sm-6 col-xs-12 col-md-offset-1">
<div class="panel panel-info">
<div class="panel-heading">
Detalii rezervare
</div>
<div class="panel-body">
<form role="form" method="post">
                                                   
<div class="form-group">

<label>Numar rezervare: :</label>
<?php echo htmlentities($result->rezid);?></br>

<label>Nume si prenume :</label>
<?php echo htmlentities($result->Nume);?></br>

<label>Email :</label>
<?php echo htmlentities($result->EmailId);?></br>

<label>Telefon :</label>
<?php echo htmlentities($result->MobileNumber);?></br>

<label>Camera rezervata :</label>
<?php echo htmlentities($result->NumeCamera);?></br>

<label>CheckIn :</label>
<?php echo htmlentities($result->CheckIn);?></br>

<label>CheckOut :</label>
<?php echo htmlentities($result->CheckOut);?></br>

<label>Valoare :</label>
<?php echo htmlentities($result->Valoare);?></br>

<label>Status :</label>
<span style="color:
    <?php if ($status == 0) {
        echo 'red';
    } elseif ($status == 1) {
        echo 'black';
    } elseif ($status == 2) {
        echo 'green';
    } ?>">
    <?php if ($status == 0) {
        echo 'Anulata';
    } elseif ($status == 1) {
        echo 'In asteptare';
    } elseif ($status == 2) {
        echo 'Confirmata';
    } ?></br>




<?php if($status==1) {?>
    <button type="submit" name="confirm" onclick="return confirm('Sunteti sigur ca vreti sa confirmati rezervarea?');" id="submit" class="btn btn-primary btn-sm""><i class="fa-solid fa-check"></i> Confirma</button>
    <button type="submit" name="cancel" onclick="return confirm('Sunteti sigur ca vreti sa anulati rezervarea?');" id="submit" class="btn btn-danger btn-sm""><i class="fa fa-times"></i> Anuleaza</button>
<?php } ?>
<a href="lista-rezervari.php" class="btn btn-primary btn-sm"><i class="fa fa-chevron-left"></i> Inapoi</a>


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

<?php } ?><?php } ?>