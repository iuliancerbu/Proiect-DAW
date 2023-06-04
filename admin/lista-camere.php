<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
} else {

    $condition = 'tblcamere.id IS NOT NULL';
    if (isset($_REQUEST['NumeCamera']) and $_REQUEST['NumeCamera'] != "") {
        $condition .= ' AND NumeCamera LIKE "%' . $_REQUEST['NumeCamera'] . '%"';
    }

    if (isset($_REQUEST['filtrutip']) and $_REQUEST['filtrutip'] != "") {
        $condition .= ' AND TipCamera = ' .$_REQUEST['filtrutip'] ;
    }




?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="Hotel CasaThea - Proiect DAW" />
    <meta name="author" content="IC" />
    <title>Hotel CasaThea - Lista Camere</title>
    
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


<div class="panel panel-default">
            
            <div class="panel-heading clearfix"><i class="fa fa-fw fa-globe"></i> <strong>CAMERE</strong> 
            <a href="add-camera.php" class="pull-right btn btn-success btn-sm"><i class="fa-solid fa-plus"></i> Adauga camera</a></div>
            
            <!-- ***FILTRE CAUTARE*** -->
            <div class="panel-body">
				<div class="col-sm-12">
					<h5><i class="fa fa-fw fa-search"></i> Cauta</h5>
					<form method="get">
						<div class="row">
							<div class="col-sm-2">
							    <div class="form-group">
                                <label>Nume camera</label>
                                <input type="text" name="NumeCamera" id="NumeCamera" class="form-control" value="<?php echo isset($_REQUEST['NumeCamera']) ? $_REQUEST['NumeCamera'] : '' ?>" placeholder="Nume camera">
                                </div>
							</div>

                            <div class="col-sm-2">
                            <label>Tip camera:</label>
                            <select class="form-control" name="filtrutip" >
                            <option value=""> Toate</option>
                            <?php
                            $sql = "SELECT * from  tbltipcamera";
                            $query = $dbh->prepare($sql);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                            if ($query->rowCount() > 0) {
                                foreach ($results as $result) { ?>  
                            <option value="'<?php echo htmlentities($result->TipCamera); ?>'" <?php if(isset($_REQUEST['filtrutip']) && $_REQUEST['filtrutip']==$result->TipCamera) { echo "selected"; } ?>><?php echo htmlentities($result->TipCamera); ?></option>

                            <?php }
                            } ?> 
                            </select>
                            </div>


							<div class="col-sm-4">
								<div class="form-group">
									<label>&nbsp;</label>
									<div>
										<button type="submit" name="submit" value="search" id="submit" class="btn btn-primary btn-sm"><i class="fa fa-fw fa-search"></i> Cauta</button>
										<a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-sync"></i></i> Sterge filte</a>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>




            <!-- ***TABEL REZULTATE*** -->
            <div class="row">
                <div class="col-md-12">
                



                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover table-sm" id="dataTables-example" data-pagination="true">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nume Camera</th>
                                            <th>Tip</th>
                                            <th>Suprafata</th>
                                            <th>Paturi</th>
                                            <th>Facilitati</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php

                                    $sql = "SELECT  tblcamere.NumeCamera, tblcamere.TipCamera, tblcamere.Suprafata, tblcamere.NrPat, tblcamere.TipPat, tblcamere.Facilitati, tblcamere.id as camid  from  tblcamere   WHERE $condition  ";

                                    $query = $dbh->prepare($sql);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    $cnt = 1;
                                    if ($query->rowCount() > 0) {
                                        foreach ($results as $result) { ?>                                      
                                        <tr class="odd gradeX">
                                            <td class="center"><?php echo htmlentities($cnt); ?></td>
                                            <td class="center"><?php echo htmlentities($result->NumeCamera); ?></td>
                                            <td class="center"><?php echo htmlentities($result->TipCamera); ?></td>
                                            <td class="center"><?php echo htmlentities($result->Suprafata); ?></td>
                                            <td class="center"><?php echo htmlentities($result->NrPat); ?> x <?php echo htmlentities($result->TipPat); ?></td>
                                            <td class="center"><?php echo htmlentities($result->Facilitati); ?></td>
                                            
                                            <td class="text-right" >
                                    
                                                <a href="edit-camera.php?camid=<?php echo htmlentities($result->camid); ?>"><button class="btn btn-primary btn-sm"><i class="fa-solid fa-eye"></i> Detalii</button>
                                            </td>
                                        </tr>
                                    <?php $cnt = $cnt + 1;
                                        }
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

