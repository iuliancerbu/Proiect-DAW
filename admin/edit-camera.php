<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{

    $camid=intval($_GET['camid']);
    $target_dir = "../poze/";
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
                $camid=intval($_GET['camid']);
                $sql="UPDATE  tblcamere SET PozaCamera='$fileName' WHERE id=:camid";
                $query = $dbh->prepare($sql);
                $query->bindParam(':camid',$camid,PDO::PARAM_STR);
                $query->execute();
            }
        }
    }   


$new_numecamera=$_POST['new_numecamera'];
$new_tipcamera=$_POST['new_tipcamera'];
$new_suprafata=$_POST['new_suprafata'];
$new_nrpat=$_POST['new_nrpat'];
$new_tippat=$_POST['new_tippat'];
$new_facilitati=$_POST['new_facilitati'];
$new_descriere=$_POST['new_descriere'];


    $sqlu="UPDATE  tblcamere SET NumeCamera=:new_numecamera, TipCamera=:new_tipcamera, Suprafata=:new_suprafata, NrPat=:new_nrpat, TipPat=:new_tippat, Facilitati=:new_facilitati, Descriere=:new_descriere, id=LAST_INSERT_ID(id) WHERE id=:camid";
    $queryu = $dbh->prepare($sqlu);
    $queryu->bindParam(':new_numecamera',$new_numecamera,PDO::PARAM_STR);
    $queryu->bindParam(':new_tipcamera',$new_tipcamera,PDO::PARAM_STR);
    $queryu->bindParam(':new_suprafata',$new_suprafata,PDO::PARAM_STR);
    $queryu->bindParam(':new_nrpat',$new_nrpat,PDO::PARAM_STR);
    $queryu->bindParam(':new_tippat',$new_tippat,PDO::PARAM_STR);
    $queryu->bindParam(':new_facilitati',$new_facilitati,PDO::PARAM_STR);
    $queryu->bindParam(':new_descriere',$new_descriere,PDO::PARAM_STR);
    $queryu->bindParam(':camid',$camid,PDO::PARAM_STR);
    $queryu->execute();


$lastInsertId = $dbh->lastInsertId();

            if ($lastInsertId) {

                $_SESSION['msg'] = "Modificarile au fost efectuate cu succes.";
                header("location:lista-camere.php");


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
    <title>Hotel CasaThea - Edit Camera</title>

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
$camid=intval($_GET['camid']);
$sql2 = "SELECT  tblcamere.NumeCamera, tblcamere.TipCamera, tblcamere.Suprafata, tblcamere.Capacitate, tblcamere.NrPat, tblcamere.TipPat, tblcamere.Facilitati, tblcamere.Descriere, tblcamere.PozaCamera, tblcamere.id as camid from tblcamere where tblcamere.id=:camid";
$query2 = $dbh -> prepare($sql2);
$query2->bindParam(':camid',$camid,PDO::PARAM_STR);
$query2->execute();
$results=$query2->fetchAll(PDO::FETCH_OBJ);
if($query2->rowCount() > 0)
{
foreach ($results as $result)
?>

    <div class="content-wrapper">
         <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line text-center"><?php echo htmlentities($result->NumeCamera);?></h4>

                            </div>

</div>
<div class="row">
<div class="col-md-12 col-sm-6 col-xs-12 ">
<div class="panel panel-info">
<div class="panel-heading">
DETALII CAMERA
</div>

<div class="panel-body" name="detalii camera" >
<form role="form" method="post" enctype="multipart/form-data">

<div class="row">
<div class="col-md-6">
<label>Nume camera:<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="new_numecamera" value="<?php echo htmlentities($result->NumeCamera);?>"  required  disabled />

<label> Tip camera:<span style="color:red;">*</span></label>
<select class="form-control" name="new_tipcamera" required="required" disabled>
<option value="<?php echo htmlentities($result->TipCamera);?>"> <?php echo htmlentities($TipCamera=$result->TipCamera);?></option>
<?php 
$sql1 = "SELECT * from  tbltipcamera";
$query1 = $dbh -> prepare($sql1);
$query1->execute();
$results=$query1->fetchAll(PDO::FETCH_OBJ);
if($query1->rowCount() > 0)
{
foreach($results as $row)
{           
if($TipCamera==$row->TipCamera)
{
continue;
}
else
{
    ?>  
<option value="<?php echo htmlentities($row->TipCamera);?>"><?php echo htmlentities($row->TipCamera);?></option>
<?php }}} ?> 
</select>

<label>Suprafata:<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="new_suprafata" value="<?php echo htmlentities($result->Suprafata)?>"  required  disabled/>

<label>Capacitate (persoane):<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="new_capacitate" value="<?php echo (htmlentities($result->Capacitate));?>" autocomplete="off"  required disabled/>

<label>Nr paturi:<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="new_nrpat" value="<?php echo (htmlentities($result->NrPat));?>" autocomplete="off"  required disabled/>

<label> Tip pat:<span style="color:red;">*</span></label>
<select class="form-control" name="new_tippat" required="required" disabled>
<option value="<?php echo htmlentities($result->TipPat);?>"> <?php echo htmlentities($NumeDepart=$result->TipPat);?></option>
<?php 
$sql1 = "SELECT * from  tbltippat";
$query1 = $dbh -> prepare($sql1);
$query1->execute();
$results=$query1->fetchAll(PDO::FETCH_OBJ);
if($query1->rowCount() > 0)
{
foreach($results as $row)
{           
if($TipPat==$row->TipPat)
{
continue;
}
else
{
    ?>  
<option value="<?php echo htmlentities($row->TipPat);?>"><?php echo htmlentities($row->TipPat);?></option>
<?php }}} ?> 
</select>


<label>Facilitati:<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="new_facilitati" value="<?php echo (htmlentities($result->Facilitati));?>" autocomplete="off"  required disabled />


<label>Descriere:<span style="color:red;">*</span></label>
<textarea class="form-control"  name="new_descriere" rows="5" required disabled> <?php echo (htmlentities($result->Descriere));?> </textarea>
</div> 


<div class="col-md-6">
<?php
$imagePath = '../poze/' . htmlentities($result->PozaCamera);
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
<a href="javascript:history.back()" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Renunta</a>



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
