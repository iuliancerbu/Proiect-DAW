<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {


    $guest = $_SESSION['id'];
    $checkin = $_GET['checkin'];
    $checkout = $_GET['checkout'];
    $checkin_date = new DateTime($checkin);
    $checkout_date = new DateTime($checkout);
    
    $difference = $checkin_date->diff($checkout_date);
    $days = $difference->days;
    $valoare = 0;
    
//ACTIUNE FINALIZARE REZERVARE
    if (isset($_POST['finalizeaza_rezervarea'])) {

        $camid = $_GET['camid'];
        $valoare=$_POST['valoare'];


        $sql = "INSERT INTO tblrezervari (GuestId, CameraId, CheckIn, CheckOut, Valoare) VALUES (:guest, :camid, :checkin, :checkout, :valoare)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':guest', $guest, PDO::PARAM_INT);
        $query->bindParam(':camid', $camid, PDO::PARAM_INT);
        $query->bindParam(':checkin', $checkin, PDO::PARAM_STR);
        $query->bindParam(':checkout', $checkout, PDO::PARAM_STR);
        $query->bindParam(':valoare', $valoare, PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
        if ($lastInsertId) {
            
            $_SESSION['msg'] = "Rezervarea a fost finalizata cu succes! Rezervarea dumneavoastra urmeaza sa fie confirmata. Dupa confirmare veti putea vedea factura in 'Detalii rezervare'.";
            header('location: lista-rezervari.php');
            exit();
        } else {
            $_SESSION['error'] = "Eroare la finalizarea rezervarii. Va rugam incercati din nou.";
            header('location: lista-rezervari.php');
            exit();
        }
    }


    ?>


    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="description" content="Hotel CasaThea - proiect DAW" />
        <meta name="author" content="IC" />
        <title>Hotel CasaThea - Booking</title>

        <link href="assets/css/bootstrap.css" rel="stylesheet" />
        <link href="assets/css/font-awesome.css" rel="stylesheet" />
        <link href="assets/css/style.css" rel="stylesheet" />
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
        <script src="https://kit.fontawesome.com/78d47f6922.js" crossorigin="anonymous"></script>

    </head>

    <body>

        <?php include('includes/header.php'); ?>



        <?php
        $camid = intval($_GET['camid']);
        echo ("Camid:" . $camid);
        $procid = intval($_GET['procid']);
        $sql = "SELECT * from tblcamere where tblcamere.id=:camid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':camid', $camid, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            foreach ($results as $result)
            $valoare = $days * $result->Pret;
            ?>


            <div class="content-wrapper">
                <div class="container">
                    <div class="row pad-botm">

                    <?php if ($_SESSION['error'] != "") { ?>
            <div class="col-md-6">
                <div class="alert alert-danger">
                    <strong>Error :</strong>
                    <?php echo htmlentities($_SESSION['error']); ?>
                    <?php echo htmlentities($_SESSION['error'] = ""); ?>
                </div>
            </div>
        <?php } ?>

        <?php if ($_SESSION['msg'] != "") { ?>
            <div class="col-md-6">
                <div class="alert alert-success">
                    <strong>Success :</strong>
                    <?php echo htmlentities($_SESSION['msg']); ?>
                    <?php echo htmlentities($_SESSION['msg'] = ""); ?>
                </div>
            </div>
        <?php } ?>


                        <div class="col-md-12">
                            <h4 class="header-line text-center">
                                <?php echo htmlentities($result->NumeCamera); ?>
                            </h4>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-10 col-sm-6 col-xs-12 col-md-offset-1"">
                            <div class=" panel panel-info">
                                <div class="panel-heading">
                                Detalii rezervare
                                </div>

                                <div class="panel-body">
                                    <form role="form" method="post" enctype="multipart/form-data>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Nume Camera :</label>
                                                <?php echo htmlentities($result->NumeCamera); ?></br>

                                                <label>Tip Camera :</label>
                                                <?php echo htmlentities($result->TipCamera); ?></br>

                                                <label>Facilitati :</label>
                                                <?php echo htmlentities($result->Facilitati); ?></br>

                                                <label>Pat :</label>
                                                <?php echo htmlentities($result->NrPat); ?> x
                                                <?php echo htmlentities($result->TipPat); ?></br>

                                                <label>Descriere :</label>
                                                <?php echo htmlentities($result->Descriere); ?></br>
                                            </div>

                                            <div class="col-md-6">
                                                <?php $imagePath = '../hotel/poze/' . htmlentities($result->PozaCamera); ?>
                                                <img src="<?php echo $imagePath; ?>" alt="Image description"
                                                style="max-width: 100%;" /></br>
                                            </div>

        <?php } ?>

                                            <?php
                                            $guest = $_SESSION['id'];
                                            $sql = "SELECT * from tblutilizatori where tblutilizatori.id=:guest";
                                            $query = $dbh->prepare($sql);
                                            $query->bindParam(':guest', $guest, PDO::PARAM_STR);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            if ($query->rowCount() > 0) {
                                                foreach ($results as $result)
                                                ?>
        
                                            <div class="col-md-6">
                                                
                                                <label>Nume si prenume :</label>
                                                <?php echo htmlentities($result->Nume); ?></br>
                                                <label>Telefon :</label>
                                                <?php echo htmlentities($result->MobileNumber); ?></br>
                                                <label>E-mail :</label>
                                                <?php echo htmlentities($result->EmailId); ?></br>
                                            </div>

                                            <?php } ?>

                                            <div class="col-md-6">
                                                
                                                <label>Data checkin :</label>
                                                <?php echo htmlentities($checkin); ?></br>
                                                <label>Data checkout :</label>
                                                <?php echo htmlentities($checkout); ?></br>
                                                <label>Valoare rezervare:</label>
                                                <?php echo htmlentities($valoare); ?>
                                                <span> lei</span></br>
                                                <input type="hidden" name="valoare" value="<?php echo htmlentities($valoare); ?>">

                                            
                                                <button type="submit" name="finalizeaza_rezervarea"
                                                class="btn btn-primary btn-sm"><i class="fa-solid fa-circle-check"></i> Finalizeaza rezervarea</button>
                                                <a href="javascript:history.back(1)" class="btn btn-primary btn-sm"><i class="fa fa-chevron-left"></i> Inapoi</a>
                                            </div>

                                            


                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        



        <?php include('includes/footer.php'); ?>

        <script src="assets/js/jquery-1.10.2.js"></script>
        <script src="assets/js/bootstrap.js"></script>
        <script src="assets/js/custom.js"></script>

    </body>

</html>
<?php } ?>