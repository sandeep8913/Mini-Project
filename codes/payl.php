<?php
$s=$_POST['subjects'];
session_start();
$_SESSION['subs']=$s;
$n=0;
foreach ($s as $sb=>$value) {
    $n+=1;
}
$n+=1;
$n*=100;
$a="rzp_test_pHPapXCATNkPPp";
?>
<form action="sucsl.php" method="POST">
<script
    src="https://checkout.razorpay.com/v1/checkout.js"
    data-key=<?php echo $a;?> 
    data-amount=<?php echo $n*100;?>
    data-currency="INR"
    data-id=<?php echo 'OID'.rand(10,100).'END'; ?>
    data-buttontext="Pay with Razorpay"
    data-name="GCET"
    data-description="CBT"
    data-image="https://www.facultyplus.com/wp-content/uploads/2021/12/GCET-logo.png"
    data-prefill.name=<?php echo $c;?> 
    data-prefill.email=<?php echo $a.'@gcet.edu.in';?> 
    data-theme.color="#227cd6"
></script>
<input type="hidden" custom="Hidden Element" name="hidden"/>
</form>