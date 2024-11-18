<?php
session_start();
$_SESSION['a']=$_POST['a'];
$_SESSION['b']=$_POST['b'];
header("Location:index.php");
?>