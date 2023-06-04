<?php
session_start();
error_reporting(0);
include('includes/config.php');
if((strlen($_SESSION['alogin'])==0) OR $_SESSION['RolId']!='1')
    {   
header('location:index.php');
}
else{ 
?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="Hotel CasaThea - Proiect DAW" />
    <meta name="author" content="IC" />
    <title>Hotel CasaThea - Lista Utilizatori</title>

    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
        <script src="https://kit.fontawesome.com/78d47f6922.js" crossorigin="anonymous"></script>

</head>
<body>

<?php include('includes/header.php');?>

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


        </div>
            <div class="row">
                <div class="col-md-12">
                
                    <div class="panel panel-default">
                    <div class="panel-heading clearfix"><i class="fa-solid fa-users"></i> <strong>UTILIZATORI</strong> </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>ID</th>
                                            <th>Nume si Prenume</th>
                                            <th>Email</th>
                                            <th>Data inregistrarii</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php $sql = "SELECT id , Nume, EmailId, RegDate, Status from tblutilizatori";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>                                      
                                        <tr class="odd gradeX">
                                            <td class="center"><?php echo htmlentities($cnt);?></td>
                                            <td class="center"><?php echo htmlentities($result->id);?></td>
                                            <td class="center"><?php echo htmlentities($result->Nume);?></td>
                                            <td class="center"><?php echo htmlentities($result->EmailId);?></td>
                                             <td class="center"><?php echo htmlentities($result->RegDate);?></td>
                                            <td class="center"><?php if($result->Status==1)
                                            {
                                                echo htmlentities("Active");
                                            } else {


                                            echo htmlentities("Blocked");
}
                                            ?></td>
                                            <td class="center">

    <a href="detalii-utilizator.php?utilid=<?php echo htmlentities($result->id); ?>"><button class="btn btn-primary btn-sm"><i class="fa fa-check "></i> Detalii</button>
                                        
                                            </td>
                                        </tr>
 <?php }} ?>                                      
                                    </tbody>
                                </table>
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
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>
