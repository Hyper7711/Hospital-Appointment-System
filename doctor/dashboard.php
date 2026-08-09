<?php
session_start();

if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php");
    exit();
}

include("../db_connect.php");

$doctor_id = $_SESSION['doctor_id'];

/* =========================
   GET DOCTOR DETAILS
========================= */

$doctor_query = mysqli_query(
    $conn,
    "SELECT doctors.*, departments.department_name
     FROM doctors
     INNER JOIN departments
     ON doctors.department_id = departments.id
     WHERE doctors.id = '$doctor_id'"
);

$doctor = mysqli_fetch_assoc($doctor_query);


/* =========================
   TOTAL APPOINTMENTS
========================= */

$total_query = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM appointments
     WHERE doctor_id = '$doctor_id'"
);

$total_data = mysqli_fetch_assoc($total_query);

$total_appointments = $total_data['total'];


/* =========================
   PENDING APPOINTMENTS
========================= */

$pending_query = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM appointments
     WHERE doctor_id = '$doctor_id'
     AND status = 'Pending'"
);

$pending_data = mysqli_fetch_assoc($pending_query);

$pending_appointments = $pending_data['total'];


/* =========================
   COMPLETED APPOINTMENTS
========================= */

$completed_query = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM appointments
     WHERE doctor_id = '$doctor_id'
     AND status = 'Completed'"
);

$completed_data = mysqli_fetch_assoc($completed_query);

$completed_appointments = $completed_data['total'];

?>

<!DOCTYPE html>

<html>

<head>

<title>Doctor Dashboard</title>

<style>

body {

    margin: 0;

    font-family: Arial, sans-serif;

    background: #f4f6f9;

}

.header {

    background: #007bff;

    color: white;

    padding: 20px;

    display: flex;

    justify-content: space-between;

    align-items: center;

}

.header h2 {

    margin: 0;

}

.logout {

    background: #dc3545;

    color: white;

    padding: 10px 15px;

    text-decoration: none;

    border-radius: 5px;

}

.welcome {

    text-align: center;

    margin: 30px;

}

.doctor-info {

    width: 90%;

    margin: auto;

    background: white;

    padding: 20px;

    border-radius: 10px;

    box-shadow: 0 2px 8px rgba(0,0,0,.15);

    text-align: center;

}

.cards {

    width: 90%;

    margin: 30px auto;

    display: grid;

    grid-template-columns: repeat(3, 1fr);

    gap: 20px;

}

.card {

    background: white;

    padding: 25px;

    text-align: center;

    border-radius: 10px;

    box-shadow: 0 2px 8px rgba(0,0,0,.15);

}

.number {

    font-size: 35px;

    font-weight: bold;

    color: #007bff;

}

.card h3 {

    color: #555;

}

.menu {

    width: 90%;

    margin: 30px auto;

    display: grid;

    grid-template-columns: repeat(2, 1fr);

    gap: 20px;

}

.menu a {

    background: white;

    padding: 30px;

    text-align: center;

    text-decoration: none;

    color: #007bff;

    font-size: 20px;

    font-weight: bold;

    border-radius: 10px;

    box-shadow: 0 2px 8px rgba(0,0,0,.15);

}

.menu a:hover {

    background: #007bff;

    color: white;

}

@media(max-width: 800px) {

    .cards {

        grid-template-columns: 1fr;

    }

    .menu {

        grid-template-columns: 1fr;

    }

}

</style>

</head>


<body>


<div class="header">

    <h2>🏥 Doctor Panel</h2>

    <a
        href="logout.php"
        class="logout"
    >
        Logout
    </a>

</div>


<div class="welcome">

    <h2>

        Welcome,
        <?php echo htmlspecialchars($doctor['name']); ?>
        👋

    </h2>

    <p>
        Hospital Appointment & OPD Management System
    </p>

</div>


<!-- DOCTOR INFORMATION -->

<div class="doctor-info">

    <h3>
        👨‍⚕️
        <?php echo htmlspecialchars($doctor['name']); ?>
    </h3>

    <p>

        <strong>Department:</strong>

        <?php
        echo htmlspecialchars(
            $doctor['department_name']
        );
        ?>

    </p>

    <p>

        <strong>Specialization:</strong>

        <?php
        echo htmlspecialchars(
            $doctor['specialization']
        );
        ?>

    </p>

    <p>

        <strong>Email:</strong>

        <?php
        echo htmlspecialchars(
            $doctor['email']
        );
        ?>

    </p>

</div>


<!-- STATISTICS -->

<div class="cards">


    <div class="card">

        <div class="number">

            <?php
            echo $total_appointments;
            ?>

        </div>

        <h3>
            📅 Total Appointments
        </h3>

    </div>


    <div class="card">

        <div class="number">

            <?php
            echo $pending_appointments;
            ?>

        </div>

        <h3>
            ⏳ Pending
        </h3>

    </div>


    <div class="card">

        <div class="number">

            <?php
            echo $completed_appointments;
            ?>

        </div>

        <h3>
            ✅ Completed
        </h3>

    </div>


</div>


<!-- MENU -->

<div class="menu">


    <a href="appointments.php">

        📅
        <br><br>

        My Appointments

    </a>


    <a href="patients.php">

        👥
        <br><br>

        My Patients

    </a>


</div>


</body>

</html>