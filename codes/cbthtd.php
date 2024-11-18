<?php
require_once __DIR__ .'/vendor/autoload.php';

$servername = "localhost";
$username = "root";
$password = "";
session_start();
$db=$_SESSION['db'];
$table=$_SESSION['table'];
$z=strtoupper($table);
$conn = new mysqli($servername, $username, $password, $db);
$r=$_SESSION['roll'];
$odb=$_SESSION['odb'];
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$con = new mysqli($servername, $username, $password, $odb);
if ($con->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql1 = "SELECT * FROM $table";
$result1 = $con->query($sql1);
$ticket_html = '
<!DOCTYPE html>
<html>
<head>
    <title>CBT Hall Ticket</title>
    <style>
        .ticket {
            border: 2px solid black;
            padding: 20px;
            margin: 20px;
        }
        .ticket-header {
            text-align: center;
            margin-bottom: 20px;
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
        <h2>CBT Hall Ticket</h2>
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
while ($row1 = $result1->fetch_assoc()) {
    $subject=$row1['subject'];
    $sql2 = "SELECT * FROM $table where roll='$r'";
    $result2 = $conn->query($sql2);
    $rest = $result2->fetch_assoc();
        if ($rest[$subject] != 'no' && $rest[$subject]!=NULL) {
            $nid=$row1['id'];
            $nsub=$row1['subject'];
            if($rest[$subject] != 'yes'){
                $xs=substr($nsub,0,1);
                $tab="pe";
            if($xs=='o'){
                $tab="oe";
            }

                $con3 = new mysqli($servername, $username, $password, "electives");
            if ($con3->connect_error) {
                die("Connection failed: " . $con3->connect_error);
                    }
                    $sqlq="SELECT * from $tab where roll='$r' ";
                    $result3 = $con3->query($sqlq);
                    $row3 = $result3->fetch_assoc();
                    $subid=$row3[$nsub];
                    $nid=$subid;
                    $tab="pes";
                    if($xs=='o'){
                        $tab="oes";
                    }
                    $sqlq="SELECT * from $tab where id='$subid' ";
                    $result3 = $con3->query($sqlq);
                    $row3 = $result3->fetch_assoc();
                    $nsub=$row3['subject'];
                    $con3->close();
            }
            $ticket_html .= '
        <tr>
            <td>' . $nid . '</td>
            <td>' . $nsub . '</td>
            <td>' . $row1['date'] . '</td>
            <td>' . "2:00-4:00". '</td>
        </tr>';
        }
        
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

// Create an instance of the Mpdf class
$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($ticket_html);
$mpdf->Output();
?>
