<?php
$a=$_POST['username'];
$b=$_POST['password'];
if($a=="lib"&&$b=="gcet"){
    header("Location:libedit.php");
}
else{
    header("Location: lib.php?error=1");
}
?>