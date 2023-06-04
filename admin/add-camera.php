<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else {

    
    $target_dir = "../poze/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $fileName = basename($_FILES["fileToUpload"]["name"]);
    $autor = $_SESSION['id'];

if(isset($_POST['add']))
{

    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
    echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');</script>";
      $uploadOk = 0;
    }
    else {



$numecamera=$_POST['numecamera'];
$tipcamera=$_POST['tipcamera'];
$suprafata=$_POST['suprafata'];
$capacitate=$_POST['capacitate'];
$nrpaturi=$_POST['nrpaturi'];
$tippat=$_POST['tippat'];
$descriere=$_POST['descriere'];
$pret=$_POST['pret'];
$facilitati = implode(", ", $_POST['facilitate']);



if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

$sql="INSERT INTO  tblcamere(NumeCamera,TipCamera,Suprafata,Capacitate, NrPat,TipPat,Facilitati,Descriere,Pret,PozaCamera) VALUES(:numecamera,:tipcamera,:suprafata,:capacitate,:nrpaturi,:tippat,:facilitati,:descriere,:pret,'$fileName')";
$query = $dbh->prepare($sql);
$query->bindParam(':numecamera',$numecamera,PDO::PARAM_STR);
$query->bindParam(':tipcamera',$tipcamera,PDO::PARAM_STR);
$query->bindParam(':suprafata',$suprafata,PDO::PARAM_STR);
$query->bindParam(':capacitate',$capacitate,PDO::PARAM_STR);
$query->bindParam(':nrpaturi',$nrpaturi,PDO::PARAM_STR);
$query->bindParam(':tippat',$tippat,PDO::PARAM_STR);
$query->bindParam(':descriere',$descriere,PDO::PARAM_STR);
$query->bindParam(':pret',$pret,PDO::PARAM_STR);
$query->bindParam(':facilitati', $facilitati, PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
}
            if ($lastInsertId) {
                $_SESSION['msg'] = "Camera a fost adaugata cu succes.";
                header('location:lista-camere.php');



            }
            else 
            {
            $_SESSION['error']="Ceva nu a mers bine. Mai incearca o data.";
            header('location:lista-camere.php');
            }

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
    <title>Hotel CasaThea - Adauga Camera</title>

    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <script src="https://kit.fontawesome.com/78d47f6922.js" crossorigin="anonymous"></script>

</head>
<body>

<?php include('includes/header.php');?>

    <div class="content-wra
    <div class="content-wrapper">
         <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Adaugare Camera</h4>

                            </div>

</div>
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<div class="panel panel-info">
<div class="panel-heading">
DETALII CAMERA
</div>
<div class="panel-body">
<form role="form" method="post" enctype="multipart/form-data">
<div class="form-group">
<label>Nume camera<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="numecamera" autocomplete="off"  required />
</div>

<div class="form-group">
<label> Tip camera<span style="color:red;">*</span></label>
<select class="form-control" name="tipcamera" required="required">
<option value=""> Alege tipul camerei</option>
<?php 
$sql = "SELECT * from  tbltipcamera";
$query = $dbh -> prepare($sql);

$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>  
<option value="<?php echo htmlentities($result->TipCamera);?>"><?php echo htmlentities($result->TipCamera);?></option>
 <?php }} ?> 
</select>
</div>

<div class="form-group">
<label>Suprafata camera:<span style="color:red;">*</span></label>
<input class="form-control" type="number" name="suprafata" autocomplete="off"  required />
</div>

<div class="form-group">
<label>Capacitate (persoane):<span style="color:red;">*</span></label>
<input class="form-control" type="number" name="capacitate" autocomplete="off" value='0' required />
</div> 


<div class="form-group">
<label>Nr. paturi:<span style="color:red;">*</span></label>
<input class="form-control" type="number" name="nrpaturi" autocomplete="off" value='0' required />
</div> 

<div class="form-group">
<label> Tip pat<span style="color:red;">*</span></label>
<select class="form-control" name="tippat" required="required">
<option value=""> Alege tipul patului </option>
<?php 
$sql = "SELECT * from  tbltippat";
$query = $dbh -> prepare($sql);

$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>  
<option value="<?php echo htmlentities($result->TipPat);?>"><?php echo htmlentities($result->TipPat);?></option>
 <?php }} ?> 
</select>
</div>

<div class="form-group">
<label>Facilitati:<span style="color:red;">*</span></label>
<fieldset>
        <input type="checkbox" name="facilitate[]" value="WiFi">WiFi<br>
        <input type="checkbox" name="facilitate[]" value="Minibar">Minibar<br>
        <input type="checkbox" name="facilitate[]" value="Baie proprie cu dus">Baie proprie cu dus<br>
        <input type="checkbox" name="facilitate[]" value="Baie proprie cada">Baie proprie cada<br>
        <input type="checkbox" name="facilitate[]" value="Baie proprie jacuzzi">Baie proprie jacuzzi<br>
        <input type="checkbox" name="facilitate[]" value="Balcon">Balcon<br>
        <input type="checkbox" name="facilitate[]" value="TV">TV<br>
        <input type="checkbox" name="facilitate[]" value="Netflix">Netflix<br>
        <input type="checkbox" name="facilitate[]" value="Seif">Seif<br>
        <input type="checkbox" name="facilitate[]" value="Room service 24h">Room service 24h<br>
    </fieldset>  
</div>

<div class="form-group">
<label>Descriere:<span style="color:red;">*</span></label>
<textarea class="form-control"  name="descriere" rows="5"  autocomplete="off"  required> </textarea>
</div> 

<div class="form-group">
<label>Pret (lei/noapte):<span style="color:red;">*</span></label>
<input class="form-control" type="number" name="pret" autocomplete="off" value='0' required />
</div> 

<div class="form-group">
<label>Poza camera(.jpg)<span style="color:red;">*</span></label>
<input class="form-control" type="file" name="fileToUpload" id="fileToUpload" autocomplete="off"  required />
</div>




<button type="submit" name="add" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Adauga </button>
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
