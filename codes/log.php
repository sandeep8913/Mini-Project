<?php
$un = $_POST["roll"];
$p = $_POST["pass"];
$con = mysqli_connect("localhost", "root", "", "x");
session_start();
$_SESSION['roll']=$un;
if (!$con) {
    header("Location: home.html");
    die("Can't connect to the database");
}

$q = "SELECT * FROM std WHERE roll='$un' AND pass='$p'";
$r = mysqli_query($con, $q);

if (mysqli_num_rows($r) >= 1) {
    $q1 = mysqli_fetch_assoc($r);
    $fee=$q1['fee'];
    $lib=$q1['lib'];
    $fine=$q1['fine'];
    if(($fee+$lib+$fine)<1){
        header("Location:hd.php");
    }
    else{
        $_SESSION['fee']=$fee;
    $_SESSION['lib']=$lib;
    $_SESSION['fine']=$fine;
    header("Location:due.php");
    }
} else {
    header("Location: std.php?error=1");
}

mysqli_close($con);
?>
