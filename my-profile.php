<?php 
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['login'])==0)
    {   
header('location:index.php');
}
else{ 
if(isset($_POST['update']))
{    
$sid=$_SESSION['id'];  
$fname=$_POST['fullanme'];
$mobileno=$_POST['mobileno'];
$adresa=$_POST['adresa'];


$sql="UPDATE tblutilizatori SET Nume=:fname,MobileNumber=:mobileno, Adresa=:adresa WHERE id=:sid";
$query = $dbh->prepare($sql);
$query->bindParam(':sid',$sid,PDO::PARAM_STR);
$query->bindParam(':fname',$fname,PDO::PARAM_STR);
$query->bindParam(':mobileno',$mobileno,PDO::PARAM_STR);
$query->bindParam(':adresa',$adresa,PDO::PARAM_STR);
$query->execute();
$_SESSION['msg'] = "Contul a fost actualizat.";
header('location:my-profile.php');
exit();
}

?>

<!DOCTYPE html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="Hotel CasaThea - Proiect DAW" />
    <meta name="author" content="IC" />
    <title>Casa Thea - Profilul Meu</title>

    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' /> 
    <script src="https://kit.fontawesome.com/78d47f6922.js" crossorigin="anonymous"></script>

</head>
<body>

<?php include('includes/header.php');?>
>
    <div class="content-wrapper">
         <div class="container">
        <div class="row pad-botm">

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

            <div class="col-md-12">
                <h4 class="header-line"><i class="fa-solid fa-user"></i> Profilul meu</h4>
                
                            </div>

        </div>
             <div class="row">
           
<div class="col-md-9 col-md-offset-1">
               <div class="panel panel-info">
                        <div class="panel-heading">
                           Detalii profil
                        </div>
                        <div class="panel-body">
                            <form name="signup" method="post">
<?php 
$sid=$_SESSION['id'];
$sql="SELECT tblutilizatori.Nume, tblutilizatori.EmailId, tblutilizatori.MobileNumber, tblutilizatori.Adresa FROM  tblutilizatori  WHERE tblutilizatori.id=:sid ";
$query = $dbh -> prepare($sql);
$query-> bindParam(':sid', $sid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>  




<div class="form-group">
<label>Nume si prenume :</label>
<input class="form-control" type="text" name="fullanme" value="<?php echo htmlentities($result->Nume);?>" autocomplete="off" required />

<label>Telefon :</label>
<input class="form-control" type="text" name="mobileno" maxlength="15" value="<?php echo htmlentities($result->MobileNumber);?>" autocomplete="off" required />

<label>Adresa :</label>
<input class="form-control" type="text" name="adresa" maxlength="100" value="<?php echo htmlentities($result->Adresa);?>" autocomplete="off" required />

<label>Email :</label>
<input class="form-control" type="text" name="email" maxlength="30" value="<?php echo htmlentities($result->EmailId);?>" autocomplete="off" disabled />
</div>
<?php }} ?>

                              
<button type="submit" name="update" class="btn btn-primary btn-sm" id="submit">Actualizeaza </button>

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
<?php } ?>
