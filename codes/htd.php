<?php
require_once __DIR__ .'/vendor/autoload.php';
$servername = "localhost";
$username = "root";
$password = "";
session_start();
$r=$_SESSION['roll'];
$s=substr($r,0,2);
$cy=date('Y');
$cys=substr((string)$cy,2,2);
$yr=(int)$cys-(int)$s;
$s=substr($r,4,1);
if($s=='5'){
    $yr+=1;
}
$conn = new mysqli($servername, $username, $password, 'x');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT sem FROM slct where year=$yr";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$dbname = $row['sem'];
$s=substr($r,7,1);
$y = "cse";
if($s=='4'){
    $y="ece";
}
$z=strtoupper($y);
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM $y";
$result = $conn->query($sql);

$ticket_html = '
<!DOCTYPE html>
<html>
<head>
    <title>Hall Ticket</title>
    <style>
        .ticket {
            border: 2px solid black;
            padding: 20px;
            margin: 20px;
        }
        .ticket-header {
            text-align: center;
            margin-bottom: 10px;
        }
        .ticket-body {
            margin-bottom: 20px;
        }
        .ticket-table {
            width: 100%;
            border-collapse: collapse;
        }
        .ticket-table th, .ticket-table td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        .ticket-table th {
            background-color: #f2f2f2;
        }
        .ticket-footer {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="ticket">
<div class="ticket-header">
<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTKnoKCV8q7R3WizZyhN7EapSVlbCeC5Kk3vw&s" alt="College Logo" style="width: 100px; height: auto;">
        <h2>Geethanjali College of Engineering and Technology</h2>
    </div>
    <div class="ticket-header">
        <h2>Hall Ticket</h2>
    </div>
    <div class="ticket-header">
        <h2>'.$z.'</h2>
    </div>
    <div class="ticket-body">
        <p><strong>Roll Number:</strong> ' . $r . '</p>
        <table class="ticket-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Subject</th>
                    <th>Date</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $start_time = date("H:i", strtotime($row['time']));
        $end_time = date("H:i", strtotime($row['time'] . "+3 hours"));
        $subj=$row['subject'];
        $pid=$row['id'];
        $xs=substr($subj,0,1);
        if($xs=='p' || $xs=='o'){
            $tab="pe";
            if($xs=='o'){
                $tab="oe";
            }
            $con = new mysqli($servername, $username, $password,"electives");
            if ($con->connect_error) {
             die("Connection failed: " . $con->connect_error);
            }
            $sqlq="SELECT * from $tab where roll='$r' ";
            $result1 = $con->query($sqlq);
            $row1 = $result1->fetch_assoc();
            $subid=$row1[$subj];
            $tab="pes";
            if($xs=='o'){
                $tab="oes";
            }
            $sqlq="SELECT * from $tab where id='$subid' ";
            $result1 = $con->query($sqlq);
            $row1 = $result1->fetch_assoc();
            $subj=$row1['subject'];
            $con->close();
        }
        $ticket_html .= '
        <tr>
            <td>' . $pid . '</td>
            <td>' . $subj . '</td>
            <td>' . $row['date']. '</td>
            <td>' . $start_time . ' - ' . $end_time . '</td>
        </tr>';
    }
} else {
    $ticket_html .= '
    <tr>
        <td colspan="4">No records found</td>
    </tr>';
}
$ticket_html .= '
            </tbody>

              


        </table>
        <br>
<table class="ticket-table" style="border: none;">
            <tr style="border: none;">
                <td style="text-align: center; padding-top: 40px; border: none;">Student Signature</td>
                <td style="text-align: center; padding-top: 40px; border: none;">Controller of Exams</td>
                <td style="text-align: center; padding-top: 40px; border: none;">Principal</td>
            </tr>
        </table>

    </div>
    </div>


<div class="ticket-header">
        <h3>.........Instructions to Students........</h3>
        <p>
            1. Students must carry their hall ticket and college ID card.<br>
            2. Electronic gadgets are strictly prohibited.<br>
            3. Late entry beyond 30 minutes from the exam start is not allowed.<br>
            4. Students must adhere to the seating arrangement.<br>
            5. Misconduct will lead to disciplinary action.
        </p>
    </div>
<div class="ticket-footer">
        <p>&copy; ' . date("Y") . ' GCET. All rights reserved.</p>
    </div>
</body>
</html>';
$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($ticket_html);
$mpdf->Output();
?>
