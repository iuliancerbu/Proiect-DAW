<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
} else {

    if(isset($_GET['cancel']))
    {
    $id=$_GET['cancel'];
    $status=0;
    $sql = "update tblrezervari set Status=:status  WHERE Id=:id";
    $query = $dbh->prepare($sql);
    $query -> bindParam(':id',$id, PDO::PARAM_STR);
    $query -> bindParam(':status',$status, PDO::PARAM_STR);
    $query -> execute();
    header('location:lista-rezervari.php');
    }
    
    
    if(isset($_GET['confirm']))
    {
    $id=$_GET['confirm'];
    $status=2;
    $sql = "update tblrezervari set Status=:status  WHERE Id=:id";
    $query = $dbh->prepare($sql);
    $query -> bindParam(':id',$id, PDO::PARAM_STR);
    $query -> bindParam(':status',$status, PDO::PARAM_STR);
    $query -> execute();
    header('location:lista-rezervari.php');
    }

?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="Hotel CasaThea - Proiect DAW" />
    <meta name="author" content="IC" />
    <title>Hotel CasaThea - Lista Facturi</title>
    
    <link href="assets/css/bootstrap.css" rel="stylesheet" />

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
    <?php if ($_SESSION['error'] != "") { ?>
<div class="col-md-6">
<div class="alert alert-danger" >
 <strong>Error :</strong> 
 <?php echo htmlentities($_SESSION['error']); ?>
<?php echo htmlentities($_SESSION['error'] = ""); ?>
</div>
</div>
<?php } ?>

<?php if ($_SESSION['msg'] != "") { ?>
<div class="col-md-6">
<div class="alert alert-success" >
 <strong>Success :</strong> 
 <?php echo htmlentities($_SESSION['msg']); ?>
<?php echo htmlentities($_SESSION['msg'] = ""); ?>
</div>
</div>
<?php } ?>



</div>

<div class="right-div">

</div>



<div class="panel panel-default">
            
            <div class="panel-heading clearfix"><i class="fa-solid fa-file-invoice"></i> <strong>FACTURI</strong> </div>

            

            <!-- ***TABEL REZULTATE*** -->
            <div class="row">
                <div class="col-md-12">
                


                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example" data-pagination="true">
                                    <thead>
                                        <tr>
                                            <th>Nr. Factura</th>
                                            <th>Data</th>
                                            <th>Nr. Rezervare</th>
                                            <th>Nume si prenume</th>
                                            <th>Detalii rezervare</th>
                                            <th>Valoare (lei)</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php

                                    $sql = "SELECT tblfacturi.id, tblfacturi.Data, tblfacturi.IdRezervare,tblfacturi.ValoareFactura, tblutilizatori.Nume, tblutilizatori.EmailId, tblutilizatori.MobileNumber, tblrezervari.CameraId, tblrezervari.CheckIn, tblrezervari.CheckOut, tblcamere.NumeCamera, tblcamere.TipCamera\n"
                                    . "FROM tblfacturi \n"
                                    . "JOIN tblutilizatori ON tblutilizatori.id = tblfacturi.IdClient\n"
                                    . "JOIN tblrezervari ON tblrezervari.id = tblfacturi.IdRezervare\n"
                                    . "JOIN tblcamere ON tblcamere.id = tblrezervari.CameraId";

                                    $query = $dbh->prepare($sql);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                   
                                    if ($query->rowCount() > 0) {
                                        foreach ($results as $result) { 
?>                                      
                                        <tr class="odd gradeX">
                                            <td class="center"><?php echo htmlentities($result->id); ?></td>
                                            <td class="center"><?php echo htmlentities($result->Data); ?></td>
                                            <td class="center"><a href="detalii-rezervare.php?rezid=<?php echo htmlentities($result->IdRezervare); ?>"><?php echo htmlentities($result->IdRezervare); ?></td>
                                            <td class="center"><?php echo htmlentities($result->Nume); ?></td>
                                            <td class="center"><?php echo htmlentities($result->NumeCamera); ?>, <?php echo htmlentities($result->TipCamera); ?>, Perioada: <?php echo htmlentities($result->CheckIn); ?>-<?php echo htmlentities($result->CheckOut); ?></td>
                                            <td class="center"><?php echo htmlentities($result->ValoareFactura); ?></td>
                                            <td>
                                            <a href="../facturi/factura_rezervare_no_<?php echo htmlentities($result->IdRezervare);?>.pdf" class="btn btn-primary btn-sm"><i class="fa-regular fa-file"></i> Vezi factura</a> 
                                            </td>
                                        </tr>
                                    <?php }
                                    }
}?>                                        
                                    </tbody>
                                </table>
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
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
    <script src="assets/js/custom.js"></script>
</body>
</html>

