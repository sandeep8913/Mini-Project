<?php
session_start();
$_SESSION['cbta']=$_POST['ac'];
$_SESSION['cbtb']=$_POST['bc'];
header("Location:cbtmng.php");
?>