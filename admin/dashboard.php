<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include("../db_connect.php");

// Get total doctors
$doctor_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM doctors");
$doctor_data = mysqli_fetch_assoc($doctor_query);
$total_doctors = $doctor_data['total'];

// Get total patients
$patient_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM patients");
$patient_data = mysqli_fetch_assoc($patient_query);
$total_patients = $patient_data['total'];

// Get total appointments
$appointment_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM appointments");
$appointment_data = mysqli_fetch_assoc($appointment_query);
$total_appointments = $appointment_data['total'];

// Get total departments
$department_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM departments");
$department_data = mysqli_fetch_assoc($department_query);
$total_departments = $department_data['total'];
?>

<!DOCTYPE html>
<html>

<head>

    <title>Admin Dashboard</title>

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
            margin: 30px 0;
        }

        .cards {
            width: 90%;
            margin: auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .card {
            background: white;
            padding: 25px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        .card h3 {
            margin: 10px 0;
            color: #555;
        }

        .number {
            font-size: 35px;
            font-weight: bold;
            color: #007bff;
        }

        .menu {
            width: 90%;
            margin: 35px auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .menu a {
            background: white;
            padding: 25px;
            text-align: center;
            text-decoration: none;
            color: #007bff;
            font-size: 20px;
            font-weight: bold;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        .menu a:hover {
            background: #007bff;
            color: white;
        }

        @media(max-width: 800px) {

            .cards {
                grid-template-columns: repeat(2, 1fr);
            }

            .menu {
                grid-template-columns: 1fr;
            }

        }

    </style>

</head>

<body>

<div class="header">

    <h2>🏥 Hospital Admin Panel</h2>

    <a href="logout.php" class="logout">
        Logout
    </a>

</div>

<div class="welcome">

    <h2>
        Welcome, <?php echo $_SESSION['admin_username']; ?> 👋
    </h2>

    <p>Hospital Appointment & OPD Management System</p>

</div>


<!-- Statistics -->

<div class="cards">

    <div class="card">

        <div class="number">
            <?php echo $total_doctors; ?>
        </div>

        <h3>👨‍⚕️ Doctors</h3>

    </div>


    <div class="card">

        <div class="number">
            <?php echo $total_patients; ?>
        </div>

        <h3>👥 Patients</h3>

    </div>


    <div class="card">

        <div class="number">
            <?php echo $total_appointments; ?>
        </div>

        <h3>📅 Appointments</h3>

    </div>


    <div class="card">

        <div class="number">
            <?php echo $total_departments; ?>
        </div>

        <h3>🏥 Departments</h3>

    </div>

</div>


<!-- Admin Menu -->

<div class="menu">

    <a href="doctors.php">
        👨‍⚕️<br><br>
        Manage Doctors
    </a>

    <a href="patients.php">
        👥<br><br>
        Manage Patients
    </a>

    <a href="appointments.php">
        📅<br><br>
        Manage Appointments
    </a>

</div>

</body>

</html>