<?php
$a=$_POST['username'];
$b=$_POST['password'];
if($a=="fee"&&$b=="gcet"){
    header("Location:feedit.php");
}
else{
    header("Location: fee.php?error=1");
}
?>