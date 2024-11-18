<?php
$a="rzp_test_pHPapXCATNkPPp";
session_start();
$d=$_SESSION['fee'];
$c=$_SESSION['roll'];
$e=$_SESSION['fine'];
$b=$d+$e;
?>
<form action="success.php" method="POST">
<script
    src="https://checkout.razorpay.com/v1/checkout.js"
    data-key=<?php echo $a;?> 
    data-amount=<?php echo $b*100;?>
    data-currency="INR"
    data-id=<?php echo 'OID'.rand(10,100).'END'; ?>
    data-buttontext="Pay with Razorpay"
    data-name="GCET"
    data-description="HALL TICKET SYSTEM"
    data-image="https://www.facultyplus.com/wp-content/uploads/2021/12/GCET-logo.png"
    data-prefill.name=<?php echo $c;?> 
    data-prefill.email=<?php echo $a.'@gcet.edu.in';?> 
    data-theme.color="#227cd6"
></script>
<input type="hidden" custom="Hidden Element" name="hidden"/>
</form>