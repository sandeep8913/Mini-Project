<form action="samp.php" method="post">
<input type="text" name="r"></input>
<input type="submit">
<?php 
$r=$_POST['r'];
$s=substr($r,0,2);
$cy=date('Y');
$cys=substr((string)$cy,2,2);
$yr=(int)$cys-(int)$s;
echo $yr;
?>