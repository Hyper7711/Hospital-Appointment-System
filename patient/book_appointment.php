<?php
session_start();

if (!isset($_SESSION['patient_id'])) {
    header("Location: ../login.php");
    exit();
}

include("../db_connect.php");

$message = "";

// Book Appointment
if (isset($_POST['book'])) {

    $patient_id = $_SESSION['patient_id'];
    $doctor_id = $_POST['doctor_id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];

    $sql = "INSERT INTO appointments
            (patient_id, doctor_id, appointment_date, appointment_time, status)
            VALUES
            ('$patient_id','$doctor_id','$appointment_date','$appointment_time','Pending')";

    if (mysqli_query($conn, $sql)) {

        $message = "Appointment Booked Successfully!";

    } else {

        $message = "Something went wrong.";

    }
}

// Fetch Doctors
$doctors = mysqli_query($conn,"
SELECT doctors.id,
       doctors.name,
       departments.department_name
FROM doctors
INNER JOIN departments
ON doctors.department_id = departments.id
");
?>

<!DOCTYPE html>
<html>

<head>

<title>Book Appointment</title>

<style>

body{

    font-family:Arial;
    background:#f5f5f5;

}

.container{

    width:500px;
    margin:40px auto;
    background:white;
    padding:25px;
    border-radius:10px;
    box-shadow:0px 0px 10px rgba(0,0,0,.2);

}

input,
select{

    width:100%;
    padding:10px;
    margin:10px 0;

}

button{

    width:100%;
    padding:10px;
    background:#007bff;
    color:white;
    border:none;
    cursor:pointer;

}

button:hover{

    background:#0056b3;

}

.msg{

    color:green;
    text-align:center;
    margin-bottom:10px;

}

a{

    text-decoration:none;

}

</style>

</head>

<body>

<div class="container">

<h2 align="center">Book Appointment</h2>

<?php

if($message!=""){

    echo "<div class='msg'>$message</div>";

}

?>

<form method="POST">

<select name="doctor_id" required>

<option value="">Select Doctor</option>

<?php

while($row=mysqli_fetch_assoc($doctors)){

?>

<option value="<?php echo $row['id']; ?>">

<?php

echo $row['name']." - ".$row['department_name'];

?>

</option>

<?php

}

?>

</select>

<input
type="date"
name="appointment_date"
required>

<input
type="time"
name="appointment_time"
required>

<button
type="submit"
name="book">

Book Appointment

</button>

</form>

<br>

<center>

<a href="dashboard.php">

⬅ Back to Dashboard

</a>

</center>

</div>

</body>

</html>