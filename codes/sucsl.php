<?php
echo "payment success<br>";
session_start();
$s=$_SESSION['subs'];
$r=$_SESSION['roll'];
$db=$_SESSION['db'];
$table=$_SESSION['table'];
$con = mysqli_connect("localhost", "root", "", $db);
if (!$con) {
    header("Location: home.html");
    die("Can't connect to the database");
}
$x=0;
foreach ($s as $sb=>$value) {
    $x+=1;
}
$y=$x;
$sql = "SELECT * FROM $table where roll='$r'";
$result = mysqli_query($con, $sql);
$n=0;
if(mysqli_num_rows($result)==0){
    $sql = "insert into $table(roll) values('$r')";
    $result = mysqli_query($con, $sql);
}
$sql = "update $table set ";
foreach ($s as $sb=>$value) {
    $a=substr($value,0,1);
    if($a=='o'||$a=='p'){
        $conn = mysqli_connect("localhost", "root", "", "electives");
        if (!$conn) {
        die("Can't connect to the database");
    }
    $tab="pe";
    if($a=='o'){
        $tab="oe";
    }
    $sql1 = "SELECT * FROM $tab where roll='$r'";
    $result1 = mysqli_query($conn, $sql1);
    $row=$result1->fetch_assoc();
    $subid=$row[$value];
    $tab="pes";
    if($a=='o'){
        $tab="oes";
    }
    $sql1 = "SELECT * FROM $tab where id='$subid'";
    $result1 = mysqli_query($conn, $sql1);
    $row=$result1->fetch_assoc();
    $nsub=$row['subject'];
    $sql=$sql.$value."='$nsub'";
    }
    else{
    $sql=$sql.$value."='yes' ";
    }
    if($x!=1){
        $sql.=",";
    }
    $x-=1;
    echo $sql."<br>";
}
$sql.="where roll='$r'";
echo $sql;
$result = mysqli_query($con, $sql);

header("Location:cbthtd.php");
$con->close();

?>
