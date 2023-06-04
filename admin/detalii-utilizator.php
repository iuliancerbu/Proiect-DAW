<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{ 
    $id=intval($_GET['utilid']);

    if(isset($_POST['block']))
    {
    $status=0;
    $sql = "update tblutilizatori set Status=:status  WHERE tblutilizatori.id=:id";
    $query = $dbh->prepare($sql);
    $query -> bindParam(':id',$id, PDO::PARAM_INT);
    $query -> bindParam(':status',$status, PDO::PARAM_STR);
    $query -> execute();
    $_SESSION['msg'] = "Contul a fost blocat.";
    header('location:detalii-utilizator.php?utilid=' .$id);
    exit();
    }
    
    if(isset($_POST['activate']))
    {
    $status=1;
    $sql = "update tblutilizatori set Status=:status  WHERE tblutilizatori.id=:id";
    $query = $dbh->prepare($sql);
    $query -> bindParam(':id',$id, PDO::PARAM_INT);
    $query -> bindParam(':status',$status, PDO::PARAM_STR);
    $query -> execute();
    $_SESSION['msg'] = "Contul a fost activat.";
    header('location:detalii-utilizator.php?utilid=' .$id);
    exit();
    }

    if(isset($_POST['del']))
    {
    $sql = "SELECT * FROM tblrezervari WHERE tblrezervari.GuestId=:id";
    $query = $dbh -> prepare($sql);
    $query -> bindParam(':id',$id, PDO::PARAM_INT);
    $query->execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
    if($query->rowCount() > 0)
    {
        $_SESSION['error'] = "Contul nu poate fi sters. Exista rezervari inregistrate de acest cont. Pentru a restrictiona accesul utilizatorului la platforma blocati contul. ";
        header('location:detalii-utilizator.php?utilid=' .$id);
        exit();
    }
    else { 
    $sql = "DELETE FROM tblutilizatori WHERE tblutilizatori.id=:id";
    $query = $dbh->prepare($sql);
    $query -> bindParam(':id',$id, PDO::PARAM_STR);
    $query -> execute();
    $_SESSION['msg'] = "Contul a fost sters.";
    header('location:lista-utilizatori.php');
    exit();
    }
    }
    

?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="Hotel CasaThea - Proiect DAW" />
    <meta name="author" content="IC" />
    <title>Hotel CasaThea - Detalii Utilizator</title>

    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <script src="https://kit.fontawesome.com/78d47f6922.js" crossorigin="anonymous"></script>


</head>
<body>

<?php include('includes/header.php');?>

<?php 
$utilid=intval($_GET['utilid']);
$sql = "SELECT tblutilizatori.Nume, tblutilizatori.EmailId, tblutilizatori.Status, tblutilizatori.RegDate, tblutilizatori.MobileNumber, tblutilizatori.Adresa FROM tblutilizatori  where tblutilizatori.id=:utilid";
$query = $dbh -> prepare($sql);
$query->bindParam(':utilid',$utilid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach ($results as $result)

           ?> 


    <div class="content-wrapper">
         <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">

                            </div>

</div>
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
<div class="col-md-10 col-sm-6 col-xs-12 col-md-offset-1"">
<div class="panel panel-info">
<div class="panel-heading">
Detalii cont
</div>
<div class="panel-body">
<form role="form" method="post">
                                                   
<div class="form-group">
<label>Nume utilizator :</label>
<?php echo htmlentities($result->Nume);?></br>

<label>Email :</label>
<?php echo htmlentities($result->EmailId);?></br>

<div class="form-group">
<label>Telefon :</label>
<?php echo htmlentities($result->MobileNumber);?></br>

<div class="form-group">
<label>Adresa :</label>
<?php echo htmlentities($result->Adresa);?></br>

<p><label>Status :</label>


<?php if($result->Status==1)
{?>
<span style="color:green">Activ</span>
<button type="submit" name="block" onclick="return confirm('Sunteti sigur ca vreti sa blocati contul?');" id="submit" class="btn btn-danger btn-sm""><i class="fa fa-times"></i> Blocheaza</button>
<?php } 
else {?>
<span style="color:red">Blocat</span>
<button type="submit" name="activate" onclick="return confirm('Sunteti sigur ca vreti sa activati contul?');" id="submit" class="btn btn-success btn-sm""><i class="fa-solid fa-check"></i> Activeaza</button>
    <?php } ?>

</p>
<label>Data cont :</label>
<?php echo htmlentities($result->RegDate);?></br>

<button type="submit" name="del" onclick="return confirm('Sunteti sigur ca vreti sa stergeti contul?');" id="submit" class="btn btn-danger btn-sm""><i class="fa fa-times"></i> Sterge cont</button> <?php }?>

<a href="lista-utilizatori.php" class="btn btn-primary btn-sm"><i class="fa fa-chevron-left"></i> Inapoi</a>
</div>   
</div> 
</div> 
</div> 
</div>   
</div> 
</div>   
</div>  
</form>


  <?php include('includes/footer.php');?>

    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/custom.js"></script>

</body>
</html>
<?php } ?>
