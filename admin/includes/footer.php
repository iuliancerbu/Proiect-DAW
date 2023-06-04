
<?php 
error_reporting(E_ALL);
// Obținerea numărului total de vizualizări
$sql = "SELECT COUNT(*) AS total_vizualizari FROM tblstatistici";
$result = $dbh->query($sql);
$row = $result->fetch(PDO::FETCH_ASSOC);
$totalVizualizari = $row['total_vizualizari'];

// Obținerea numărului unic de utilizatori
$sql = "SELECT COUNT(DISTINCT ip) AS numar_utilizatori FROM tblstatistici";
$result = $dbh->query($sql);
$row = $result->fetch(PDO::FETCH_ASSOC);
$numarUtilizatori = $row['numar_utilizatori'];
?>

<section class="footer-section">
    <div class="container">
        <div class="row">
            <div class="col-md-4 text-left">
                <p>Număr total de vizualizări: <?php echo $totalVizualizari; ?></br>
                Număr de vizitatori unici: <?php echo $numarUtilizatori; ?></p>
            </div>
            <div class="col-md-4 text-center">
                <p>Copyright@Casa Thea 2023</br>
                Acesta este un proiect școlar</p>
            </div>
            <div class="col-md-4 text-right">
            </div>
        </div>
    </div>
</section>