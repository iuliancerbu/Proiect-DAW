<?php
session_start();
error_reporting(E_ALL);
include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {

    require('includes/fpdf/fpdf.php');

    // Crearea unei clase extinse din clasa FPDF
    class Invoice extends FPDF {
        private $invoiceId;
        private $invoiceDate;

        // Funcția pentru setarea ID-ului facturii și a datei
        public function setInvoiceDetails($id, $date) {
            $this->invoiceId = $id;
            $this->invoiceDate = $date;
        }

        // Funcția pentru generarea antetului facturii
        function Header() {
            // Setarea fontului și a dimensiunii pentru antet
            $this->SetFont('Arial','B',12);

            // Afisarea ID-ului facturii și a datei în antet
            $this->Cell(80);
            $this->Cell(30,10,'Factura '.$this->invoiceId,0,1,'C');


        }

        // Funcția pentru generarea conținutului facturii
        function Content($data)
        {
            // Setarea fontului și a dimensiunii pentru conținut
            $this->SetFont('Arial', '', 10);

            // Afisarea datelor din interogare
            foreach ($data as $row) {
                $this->Cell(80);
                $this->Cell(30,10,'Nr. ' . $row['id']. '/' . $row['Data'],0,0,'C');
                $this->Ln(20);
                $this->Cell(40, 10, 'Cumparator: ');
                $this->Cell(150, 10, 'Furnizor: ',0,0,'R');
                $this->Ln(5);
                $this->Cell(40, 10, 'Nume si prenume: ' . $row['Nume']);
                $this->Cell(150, 10,$row['NumeFirma'],0,0,'R');
                $this->Ln(5);
                $this->Cell(40, 10, 'Email: ' . $row['EmailId']);
                $this->Cell(150, 10, 'CUI: ' . $row['CUI'],0,0,'R');
                $this->Ln(5);
                $this->Cell(40, 10, 'Telefon: ' . $row['MobileNumber']);
                $this->Cell(150, 10, 'Reg.Com: ' . $row['RegCom'],0,0,'R');
                $this->Ln(5);
                $this->Cell(190, 10, 'Adresa: ' . $row['Adresa'],0,0,'R');
                $this->Ln(5);
                $this->Cell(190, 10, 'Telefon: ' . $row['Telefon'],0,0,'R');
                $this->Ln(20);


                $this->SetFont('Arial', '', 8);
                $this->Cell(10, 10, 'Nr', 1, 0, 'C');
                $this->Cell(160, 10, 'Produs', 1, 0, 'C');
                $this->Cell(20, 10, 'Valoare (lei)', 1, 1, 'C');
                
                $this->Cell(10, 10, '1.', 1, 0, 'C');
                $this->Cell(160, 10, 'Rezervare: ' . $row['NumeCamera']. ', ' .$row['TipCamera']. ', Peroioada: ' .$row['CheckIn']. ' - ' .$row['CheckOut'],1,0,'C');
                $this->Cell(20, 10, $row['ValoareFactura'],1,0,'C');
                $this->Ln(20);
                $this->Cell(40, 10, 'Termen de plata: 10 zile.');
                
            }
        }

        // Funcția pentru generarea piciorului de pagină al facturii
        function Footer()
        {
            // Setarea fontului și a dimensiunii pentru piciorul de pagină
            $this->SetFont('Arial', 'I', 12);
            // Textul piciorului de pagină
            $this->SetY(-15);
            $this->Cell(0, 10, 'Multumim!', 0, 0, 'C');
        }
    }

    // Crearea unei instanțe a clasei Invoice
    $pdf = new Invoice();
    $pdf->AddPage();

    try {
        // Executarea interogării
        $rezid = intval($_GET['rezid']);
        $sql = "SELECT tblfacturi.id, tblfacturi.Data, tblfacturi.IdRezervare,tblfacturi.ValoareFactura, tblutilizatori.Nume, tblutilizatori.EmailId, tblutilizatori.MobileNumber, tblrezervari.CameraId, tblrezervari.CheckIn, tblrezervari.CheckOut, tblcamere.NumeCamera, tblcamere.TipCamera, tblfirma.NumeFirma, tblfirma.CUI, tblfirma.RegCom, tblfirma.Adresa, tblfirma.Telefon\n"
            . "FROM tblfacturi \n"
            . "JOIN tblutilizatori ON tblutilizatori.id = tblfacturi.IdClient\n"
            . "JOIN tblrezervari ON tblrezervari.id = tblfacturi.IdRezervare\n"
            . "JOIN tblfirma ON tblfirma.id = 1\n"
            . "JOIN tblcamere ON tblcamere.id = tblrezervari.CameraId WHERE tblfacturi.IdRezervare=$rezid";

        $query = $dbh->query($sql);
        $data = $query->fetchAll(PDO::FETCH_ASSOC);

        if (count($data) > 0) {

            // Obținerea ID-ului facturii și a datei
            $invoiceId = $data[0]['id'];
            $invoiceDate = $data[0]['Data'];

            // Setarea detaliilor facturii în instanța clasei Invoice
            $pdf->setInvoiceDetails($invoiceId, $invoiceDate);

            // Generarea conținutului facturii utilizând datele din interogare
            $pdf->Content($data);

            // Obținerea id-ului rezervării
            $reservationId = $data[0]['IdRezervare'];

            // Calea către folderul facturi
            $folderPath = '../facturi/';

            // Modificarea numelui fișierului PDF cu id-ul rezervării și calea către folder
            $fileName = $folderPath . 'Factura_rezervare_no_' . $reservationId . '.pdf';

            // Salvarea facturii ca fișier PDF în folderul specificat
            $pdf->Output($fileName, 'F');

            // Setarea mesajului de confirmare în sesiune
            $_SESSION['msg'] = "Rezervarea a fost confirmata cu succes. Factura a fost generată. ";
            header("Location: detalii-rezervare.php?rezid=" . $reservationId);
            exit();

        } else {
            echo "Nu s-au găsit rezultate pentru interogare.";
        }
    } catch (PDOException $e) {
        echo "Eroare: " . $e->getMessage();
    }
}
?>
