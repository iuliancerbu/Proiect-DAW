<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{

    $camid=1;
    $target_dir = "../poze/logo/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $fileName = basename($_FILES["fileToUpload"]["name"]);
    

if(isset($_POST['update']))
{
    if(strlen($fileName)!=0) {
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
            echo "<script>alert('Fisierul nu este valid.');</script>";

        }
        else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $camid=1;
                $sql="UPDATE  tblfirma SET Logo='$fileName' WHERE id=:camid";
                $query = $dbh->prepare($sql);
                $query->bindParam(':camid',$camid,PDO::PARAM_STR);
                $query->execute();
            }
        }
    }   


$new_numefirma=$_POST['new_numefirma'];
$new_cui=$_POST['new_cui'];
$new_regcom=$_POST['new_regcom'];
$new_adresa=$_POST['new_adresa'];
$new_telefon=$_POST['new_telefon'];


    $sql="UPDATE  tblfirma SET NumeFirma=:new_numefirma, CUI=:new_cui, RegCom=:new_regcom, Adresa=:new_adresa, Telefon=:new_telefon, id=LAST_INSERT_ID(id) WHERE tblfirma.id=1";
    $query = $dbh->prepare($sql);
    $query->bindParam(':new_numefirma',$new_numefirma,PDO::PARAM_STR);
    $query->bindParam(':new_cui',$new_cui,PDO::PARAM_STR);
    $query->bindParam(':new_regcom',$new_regcom,PDO::PARAM_STR);
    $query->bindParam(':new_adresa',$new_adresa,PDO::PARAM_STR);
    $query->bindParam(':new_telefon',$new_telefon,PDO::PARAM_STR);
    $query->execute();


$lastInsertId = $dbh->lastInsertId();

            if ($lastInsertId) {

                $_SESSION['msg'] = "Datele au fost actualizate cu succes.";
                header("location:firma.php");


            }
            else 
            {
            $_SESSION['error']="Ceva nu a mers bine. Mai incearca o data.";
            header("location:lista-camere.php");
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
    <title>Casa Thea - Data societate</title>

    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <script src="https://kit.fontawesome.com/78d47f6922.js" crossorigin="anonymous"></script>

    <script>
    function activateFields() {
        var elements = document.querySelectorAll('input, select, textarea');
        var activateButton = document.querySelector('button[name="activate"]');
        var updateButton = document.querySelector('button[name="update"]');

        for (var i = 0; i < elements.length; i++) {
                elements[i].removeAttribute('disabled');
        }
        activateButton.style.display = "none";
        updateButton.style.display = "inline-block";
    }
    </script>


</head>
<body>

<?php include('includes/header.php');?>


<?php 
$sql2 = "SELECT  tblfirma.NumeFirma, tblfirma.CUI, tblfirma.RegCom, tblfirma.Adresa, tblfirma.Telefon, tblfirma.Logo from tblfirma where tblfirma.id=1";
$query2 = $dbh -> prepare($sql2);
$query2->execute();
$results=$query2->fetchAll(PDO::FETCH_OBJ);
if($query2->rowCount() > 0)
{
foreach ($results as $result)
?>

    <div class="content-wrapper">
         <div class="container">
        <div class="row pad-botm">


</div>
<div class="row">
<div class="col-md-12 col-sm-6 col-xs-12 ">
<div class="panel panel-info">
<div class="panel-heading">
DETALII FIRMA
</div>

<div class="panel-body" name="detalii camera" >
<form role="form" method="post" enctype="multipart/form-data">

<div class="row">
<div class="col-md-6">
<label>Nume firma:<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="new_numefirma" value="<?php echo htmlentities($result->NumeFirma);?>"  required  disabled />

<label> CUI:<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="new_cui" value="<?php echo htmlentities($result->CUI);?>"  required  disabled />

<label>Numar registrul comertului:<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="new_regcom" value="<?php echo htmlentities($result->RegCom)?>"  required  disabled/>

<label>Adresa:<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="new_adresa" value="<?php echo (htmlentities($result->Adresa));?>" autocomplete="off"  required disabled/>

<label>Telefon:<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="new_telefon" value="<?php echo (htmlentities($result->Telefon));?>" autocomplete="off"  required disabled />
</div> 

<div class="col-md-6">
<label>Logo documente:<span style="color:red;">*</span></label>
<?php
$imagePath = '../poze/logo/' . htmlentities($result->Logo);
?>
<img src="<?php echo $imagePath; ?>" alt="Image description" style="max-width: 100%;"/>
<div class="form-group">
<label>Schimba poza (.jpg):</label>
<input class="form-control" type="file" name="fileToUpload" id="fileToUpload" autocomplete="off" disabled />
</div>
</div>
</div></br>

<button type="button" name="activate" class="btn btn-primary btn-sm" onclick="activateFields()"><i class="fa-solid fa-pen-to-square"></i> Modifica</button>
<button type="submit" name="update" class="btn btn-success btn-sm" style="display: none;"><i class="fa-solid fa-check"></i> Salveaza</button>
<a href="index.php" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Renunta</a>



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
<?php } ?>
