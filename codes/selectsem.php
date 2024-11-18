<?php
$a=$_POST['1'];
$b=$_POST['2'];
$c=$_POST['3'];
$d=$_POST['4'];
$con = mysqli_connect("localhost", "root", "", "x");
if (!$con) {
    die("Can't connect to the database");
}
if($a!=""){
$q = "update slct set sem='$a' where year=1";
mysqli_query($con, $q);
}
if($b!=""){
$q = "update slct set sem='$b' where year=2";
mysqli_query($con, $q);
}
if($c!=""){
$q = "update slct set sem='$c' where year=3";
mysqli_query($con, $q);
}
if($d!=""){
$q = "update slct set sem='$d' where year=4";
mysqli_query($con, $q);
}
header("Location:viewsem.php");
?>
