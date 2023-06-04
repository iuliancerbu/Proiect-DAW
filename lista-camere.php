<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {

        // Înregistrarea unei vizualizări noi
        $ip = $_SERVER['REMOTE_ADDR']; // Adresa IP a utilizatorului
        $page = $_SERVER['REQUEST_URI']; // URL-ul paginii vizitate
        $date = date('Y-m-d H:i:s'); // Data și ora vizualizării
    
        // Inserarea datelor în baza de date
        $sql = "INSERT INTO tblstatistici (ip, pagina, data) VALUES ('$ip', '$page', '$date')";
        $dbh->query($sql);



    $checkin = $_REQUEST['checkin'];
    $checkout = $_REQUEST['checkout'];
    $nrpers = $_REQUEST['nrpers'];


    if(isset($_GET['inid']))
    {
    $id=$_GET['inid'];
    $status=0;
    $sql = "update tblcamere set Status=:status  WHERE id=:id";
    $query = $dbh->prepare($sql);
    $query -> bindParam(':id',$id, PDO::PARAM_STR);
    $query -> bindParam(':status',$status, PDO::PARAM_STR);
    $query -> execute();
    header('location:lista-camere.php');
    }
    
    
    
    
    if(isset($_GET['id']))
    {
    $id=$_GET['id'];
    $status=1;
    $sql = "update tblcamere set Status=:status  WHERE id=:id";
    $query = $dbh->prepare($sql);
    $query -> bindParam(':id',$id, PDO::PARAM_STR);
    $query -> bindParam(':status',$status, PDO::PARAM_STR);
    $query -> execute();
    header('location:lista-camere.php');
    }



?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="Hotel CasaThea - Proiect DAW" />
    <meta name="author" content="IC" />
    <title>Hotel CasaThea - Lista camere</title>
    
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
            
            <div class="panel-heading clearfix"><i class="fa fa-fw fa-search"></i> Verifica disponibilitatea</strong> </div>
            
            <!-- ***FILTRE CAUTARE*** -->
            <div class="panel-body">
				<div class="col-sm-12">
					<form method="get">
						<div class="row">

                            <div class="col-sm-2">
							    <div class="form-group">
                                <label>Check in:</label>
                                <input type="date" name="checkin" id="checkin" class="form-control" placeholder="Data check in" value="<?php echo isset($_GET['checkin']) ? htmlentities($_GET['checkin']) : ''; ?>"required>
                                </div>
							</div>

                            <div class="col-sm-2">
							    <div class="form-group">
                                <label>Check out:</label>
                                <input type="date" name="checkout" id="checkout" class="form-control" placeholder="Data check out" value="<?php echo isset($_GET['checkout']) ? htmlentities($_GET['checkout']) : ''; ?>"required>
                                </div>
							</div>

                            <script>
                            var checkinInput = document.getElementById("checkin");
                            var checkoutInput = document.getElementById("checkout");

                            checkinInput.addEventListener("change", validateDates);
                            checkoutInput.addEventListener("change", validateDates);

                            function validateDates() {
                                var checkinDate = new Date(checkinInput.value);
                                var checkoutDate = new Date(checkoutInput.value);
                                var currentDate = Date.now();

                                if (checkinDate < currentDate) {
                                checkinInput.setCustomValidity("Data de checkin trebuie să fie ulterioară datei curente.");
                                } else if (checkoutDate <= checkinDate) {
                                checkinInput.setCustomValidity("Data de check out trebuie să fie ulterioară datei de check in.");
                                } else {
                                checkinInput.setCustomValidity("");
                                }
                            }
                            </script>


                            <div class="col-sm-2">
                            <label>Nr persoane:</label>
                            <select class="form-control" name="nrpers" required>
                            <option value="1" <?php echo isset($_GET['nrpers']) && $_GET['nrpers'] == '1' ? 'selected' : ''; ?>>1</option>
                            <option value="2" <?php echo isset($_GET['nrpers']) && $_GET['nrpers'] == '2' ? 'selected' : ''; ?>>2</option>
                            <option value="3" <?php echo isset($_GET['nrpers']) && $_GET['nrpers'] == '3' ? 'selected' : ''; ?>>3</option>
                            <option value="4" <?php echo isset($_GET['nrpers']) && $_GET['nrpers'] == '4' ? 'selected' : ''; ?>>4</option>
                            <option value="5" <?php echo isset($_GET['nrpers']) && $_GET['nrpers'] == '5' ? 'selected' : ''; ?>>5</option>
                            </select>
                            </div>



							<div class="col-sm-3">
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
		 </div>



            <!-- ***TABEL REZULTATE*** -->
            <?php if(isset($_GET['submit'])) { ?>
            <div class="row">
                <div class="col-md-12">
                
                     <div class="panel panel-default">


                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover table-sm" id="dataTables-example" data-pagination="true">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nume Camera</th>
                                            <th>Tip</th>
                                            <th>Poza</th>
                                            <th>Suprafata</th>
                                            <th>Paturi</th>
                                            <th>Facilitati</th>
                                            <th>Tarif (lei/noapte)</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php

                                    $sql = "SELECT  tblcamere.NumeCamera, tblcamere.TipCamera, tblcamere.Suprafata, tblcamere.NrPat, tblcamere.TipPat, tblcamere.Facilitati, tblcamere.Capacitate, tblcamere.Pret, tblcamere.PozaCamera, tblcamere.id as camid  
                                            FROM  tblcamere 
                                            WHERE (id NOT IN (SELECT CameraId FROM tblrezervari WHERE (CheckIn < :checkout AND CheckOut > :checkin ))
                                            AND tblcamere.Capacitate>=:nrpers)";

                                    $query = $dbh->prepare($sql);
                                    $query->bindParam(':nrpers', $nrpers, PDO::PARAM_STR);
                                    if (!empty($_REQUEST['checkin']) && !empty($_REQUEST['checkout'])) {
                                    $query->bindParam(':checkin', $checkin, PDO::PARAM_STR);
                                    $query->bindParam(':checkout', $checkout, PDO::PARAM_STR);
                                    }

                                    $query->execute();
   
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);

                                    $cnt = 1;
                                    if ($query->rowCount() > 0) {
                                        foreach ($results as $result) { ?>                                      
                                        <tr class="odd gradeX">
                                            <td class="center"><?php echo htmlentities($cnt); ?></td>
                                            <td class="center"><?php echo htmlentities($result->NumeCamera); ?></td>
                                            <td class="center"><?php echo htmlentities($result->TipCamera); ?></td>
                                            <td class="center" ><img src="poze/<?php echo htmlentities($result->PozaCamera); ?>" width="200" </td>
                                            <td class="center"><?php echo htmlentities($result->Suprafata); ?></td>
                                            <td class="center"><?php echo htmlentities($result->NrPat); ?> x <?php echo htmlentities($result->TipPat); ?></td>
                                            <td class="center"><?php echo htmlentities($result->Facilitati); ?></td>
                                            <td class="center"><?php echo htmlentities($result->Pret); ?></td>
                                            <td class="text-right" >
                                    
                                            <?php
                                            if (strlen($_SESSION['login']) == 0) {
                                                $redirectUrl = '../hotel/login.php'; // Pagina către care utilizatorul neautentificat va fi redirecționat
                                                if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
                                                    $redirectUrl = "https://$_SERVER[HTTP_HOST]/$redirectUrl";
                                                else
                                                    $redirectUrl = "http://$_SERVER[HTTP_HOST]/$redirectUrl";
                                                $bookingUrl = 'booking.php?camid=' . htmlentities($result->camid) . '&checkin=' . htmlentities($checkin) . '&checkout=' . htmlentities($checkout);
                                                $_SESSION['redirect_url'] = $bookingUrl; // Salvăm URL-ul de redirecționare în sesiune
                                                echo '<a href="' . $redirectUrl . '"><button class="btn btn-primary btn-sm"><i class="fa-solid fa-circle-check"></i> Rezervati camera</button></a>';
                                            } else {
                                                echo '<a href="booking.php?camid=' . htmlentities($result->camid) . '&checkin=' . htmlentities($checkin) . '&checkout=' . htmlentities($checkout) . '"><button class="btn btn-primary btn-sm"><i class="fa-solid fa-circle-check"></i> Rezervati camera</button></a>';
                                            }
                                            ?>   
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


  <?php include('includes/footer.php');?>

    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>
