<?php
$a=$_POST['username'];
$b=$_POST['password'];
if($a=="admin"&&$b=="gcet"){
    header("Location:admin.html");
}
else{
    header("Location: adm.php?error=1");
}
?>