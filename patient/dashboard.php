<?php
session_start();

if (!isset($_SESSION['patient_id'])) {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Patient Dashboard</title>

<style>

body{
    margin:0;
    font-family:Arial, Helvetica, sans-serif;
    background:#f4f6f9;
}

.header{
    background:#0077b6;
    color:white;
    padding:20px;
    text-align:center;
}

.welcome{
    text-align:center;
    margin:30px;
}

.container{

    width:90%;
    margin:auto;

    display:grid;
    grid-template-columns:repeat(2,1fr);

    gap:20px;

}

.card{

    background:white;

    padding:30px;

    border-radius:10px;

    text-align:center;

    box-shadow:0px 2px 10px rgba(0,0,0,.2);

}

.card a{

    text-decoration:none;
    color:#0077b6;
    font-size:20px;
    font-weight:bold;

}

.card:hover{

    transform:scale(1.03);
    transition:.3s;

}

</style>

</head>

<body>

<div class="header">

<h1>Hospital Appointment & OPD Management System</h1>

</div>

<div class="welcome">

<h2>Welcome,
<?php echo $_SESSION['patient_name']; ?>
👋</h2>

</div>

<div class="container">

<div class="card">

<a href="profile.php">

👤<br><br>

My Profile

</a>

</div>

<div class="card">

<a href="book_appointment.php">

📅<br><br>

Book Appointment

</a>

</div>

<div class="card">

<a href="my_appointments.php">

📋<br><br>

My Appointments

</a>

</div>

<div class="card">

<a href="../logout.php">

🚪<br><br>

Logout

</a>

</div>

</div>

</body>
</html>