<?php
session_start();
include('includes/config.php');
$_SESSION = array();
$email = $_GET['email'];
$activation_code = $_GET['activation_code'];

// Verificare cod de activare în baza de date
$sql = "SELECT * FROM tblutilizatori WHERE EmailId = :email AND CodValidare = :activation_code";
$query = $dbh->prepare($sql);
$query->bindParam(':email', $email, PDO::PARAM_STR);
$query->bindParam(':activation_code', $activation_code, PDO::PARAM_STR);
$query->execute();
$user = $query->fetch(PDO::FETCH_ASSOC);

if ($user) {
  // Actualizare starea contului în baza de date
  $sql = "UPDATE tblutilizatori SET Status = 1 WHERE EmailId = :email";
  $query = $dbh->prepare($sql);
  $query->bindParam(':email', $email, PDO::PARAM_INT);
  $query->execute();

//   echo 'Contul ' . $user['EmailId'] . ' a fost activat cu succes!';
  $_SESSION['msg'] = "Contul " . $user['EmailId'] . " a fost activat! ";
  header("location:index.php"); 
} else {
    $_SESSION['error']="Codul de activare este invalid.";
    header("location:index.php"); 
}
?>