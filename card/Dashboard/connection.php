<?php

session_start();

if(!isset($_SESSION['loggedin'])){
    echo"<script>window.location.href='../login.php'</script>";

}


$connection=mysqli_connect('localhost','root','','ur-student-card');
if($connection){
// echo'connected';
}

?>