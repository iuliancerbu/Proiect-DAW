<?php 
session_start();
include('includes/config.php');
error_reporting(0);
if(isset($_POST['signup']))
{

    


$nume=$_POST['nume'];
$mobileno=$_POST['mobileno'];
$email=$_POST['email'];
$password=md5($_POST['password']); 
$activation_code=password_hash($activation_code, PASSWORD_DEFAULT);
$status=0;
$sql="INSERT INTO  tblutilizatori(Nume,MobileNumber,EmailId, Password, CodValidare) VALUES(:nume,:mobileno,:email,:password, :activation_code)";
$query = $dbh->prepare($sql);
$query->bindParam(':nume',$nume,PDO::PARAM_STR);
$query->bindParam(':mobileno',$mobileno,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':password',$password,PDO::PARAM_STR);
$query->bindValue(':activation_code',$activation_code,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{

$_SESSION['msg'] = "Contul dumneavoastra a fost inregistrat. Pentru activarea contului verificati-va e-mailul.";
header('location:index.php');

                // TRIMITERE  EMAIL 
                    $subject = "Activarea cont Casa Thea";
                    $message = "Contul dumneavoastra a fos creat.";
                    $message = 'Dragă '.$nume.',';
                    $message .= '<br><br>Îți mulțumim pentru crearea unui cont pe site-ul nostru! Pentru a-ți activa contul, te rugăm să apeși pe link-ul de mai jos:';
                    $message .= '<br><br><a href="http://localhost/hotel/activare.php?email=' . $email .'&amp;activation_code='.$activation_code.'">Link activare cont</a>';
                    $message .= '<br><br>După activare, vei putea să îți configurezi profilul și să începi să utilizezi site-ul nostru.';
                    $message .= '<br><br>Dacă nu ai creat acest cont, te rugăm să ignori acest email.';
                    $message .= '<br><br>Cu stima,';
                    $message .= '<br>Echipa Casa Thea';
                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    $headers .= 'From: noreplay@casathea.ro' . "\r\n";

                    if (mail($email, $subject, $message, $headers)) {
                        echo "<script>alert('Email-ul a fost trimis cu succes.');</script>";
                    } else {
                        echo "<script>alert('Eroare la trimiterea email-ului.');</script>";
                    }
                
                // SFARSIT - TRIMITERE NOTIFICARE PE EMAIL 



}
else 
{
echo "<script>alert('Ceva nu a mers bine. Mai incearca o data.');</script>";
}
}

?>

<!DOCTYPE html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="Hotel CasaThea - Proiect DAW" />
    <meta name="author" content="IC" />
    <title>Casa Thea - Sign Up</title>

    <link href="assets/css/bootstrap.css" rel="stylesheet" />

    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <script src="https://kit.fontawesome.com/78d47f6922.js" crossorigin="anonymous"></script>

<script type="text/javascript">
function valid()
{
if(document.signup.password.value!= document.signup.confirmpassword.value)
{
alert("Parolele introduse nu coincid!");
document.signup.confirmpassword.focus();
return false;
}
return true;
}
</script>
<script>
function checkAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'emailid='+$("#emailid").val(),
type: "POST",
success:function(data){
$("#user-availability-status").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script>    

</head>
<body>

<?php include('includes/header.php');?>

    <div class="content-wrapper">
         <div class="container">
        <div class="row pad-botm">
             <div class="row">
           
<div class="col-md-4 col-md-offset-8">
               <div class="panel panel-default">
                        <div class="panel-heading">
                           FORMULAR INREGISTRARE
                        </div>
                        <div class="panel-body">
                            <form name="signup" method="post" onSubmit="return valid();">
<div class="form-group">
<input class="form-control" type="text" name="nume" placeholder="Nume si prenume" autocomplete="off" required />
</div>


<div class="form-group">
<input class="form-control" type="text" name="mobileno" maxlength="10" placeholder="Telefon" autocomplete="off" required />
</div>
                                        
<div class="form-group">
<input class="form-control" type="email" name="email" id="emailid" onBlur="checkAvailability()" placeholder="Adresa de email" autocomplete="off" required  />
   <span id="user-availability-status" style="font-size:12px;"></span> 
</div>



<div class="form-group">
<input class="form-control" type="password" name="password" placeholder="Parola" autocomplete="off" required  />
</div>

<div class="form-group">
<input class="form-control"  type="password" name="confirmpassword" placeholder="Confirma parola" autocomplete="off" required  />
</div>
                               
<button type="submit" name="signup" class="btn btn-danger" id="submit">Inregistrare </button>

                                    </form>
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
    <script src="assets/js/custom.js"></script>
</body>
</html>
