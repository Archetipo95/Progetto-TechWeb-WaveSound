<?

require('connection.php');

$password = $_POST['password'];
$email = $_POST['email'];
 
$pass_hash=password_hash($password,PASSWORD_BCRYPT);
$query = "SELECT email,pass FROM utente WHERE email = '$email' AND pass = '$pass_hash'";
$ris = mysqli_query($connection,$query);

if(mysqli_num_rows($ris)==0){
    echo '<script language=javascript>document.location.href="login.html"</script>';
}
else {
    echo '<script language=javascript>document.location.href="profilo.html"</script>';
}   

?>