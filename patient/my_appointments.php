<?php
session_start();

if (!isset($_SESSION['patient_id'])) {
    header("Location: ../login.php");
    exit();
}

include("../db_connect.php");

$patient_id = $_SESSION['patient_id'];

$sql = "SELECT
            appointments.*,
            doctors.name AS doctor_name,
            departments.department_name
        FROM appointments
        INNER JOIN doctors
            ON appointments.doctor_id = doctors.id
        INNER JOIN departments
            ON doctors.department_id = departments.id
        WHERE appointments.patient_id = '$patient_id'
        ORDER BY appointment_date DESC, appointment_time DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>

<head>

    <title>My Appointments</title>

    <style>

        body{
            font-family: Arial, sans-serif;
            background:#f4f4f4;
        }

        .container{
            width:90%;
            margin:40px auto;
            background:white;
            padding:20px;
            border-radius:8px;
            box-shadow:0 0 10px rgba(0,0,0,.2);
        }

        h2{
            text-align:center;
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:20px;
        }

        table, th, td{
            border:1px solid #ccc;
        }

        th{
            background:#007bff;
            color:white;
        }

        th, td{
            padding:12px;
            text-align:center;
        }

        tr:nth-child(even){
            background:#f2f2f2;
        }

        a{
            text-decoration:none;
            color:#007bff;
            font-weight:bold;
        }

    </style>

</head>

<body>

<div class="container">

<h2>My Appointments</h2>

<table>

<tr>

    <th>Doctor</th>
    <th>Department</th>
    <th>Date</th>
    <th>Time</th>
    <th>Status</th>

</tr>

<?php

if(mysqli_num_rows($result) > 0){

    while($row = mysqli_fetch_assoc($result)){

?>

<tr>

<td><?php echo $row['doctor_name']; ?></td>

<td><?php echo $row['department_name']; ?></td>

<td><?php echo $row['appointment_date']; ?></td>

<td><?php echo date("h:i A", strtotime($row['appointment_time'])); ?></td>

<td><?php echo $row['status']; ?></td>

</tr>

<?php

    }

}else{

?>

<tr>

<td colspan="5">No Appointments Found.</td>

</tr>

<?php

}

?>

</table>

<br>

<center>

<a href="dashboard.php">⬅ Back to Dashboard</a>

</center>

</div>

</body>

</html>