<?php
session_start();

if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php");
    exit();
}

include("../db_connect.php");

$doctor_id = $_SESSION['doctor_id'];

/* =========================
   FETCH DOCTOR'S PATIENTS
========================= */

$sql = "SELECT DISTINCT
            patients.id,
            patients.name,
            patients.gender,
            patients.age,
            patients.phone,
            patients.email,
            patients.address

        FROM patients

        INNER JOIN appointments
        ON patients.id = appointments.patient_id

        WHERE appointments.doctor_id = '$doctor_id'

        ORDER BY patients.id DESC";

$patients = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>

<head>

    <title>My Patients</title>

    <style>

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f9;
        }

        .header {
            background: #007bff;
            color: white;
            padding: 18px;
        }

        .header a {
            color: white;
            text-decoration: none;
            float: right;
            margin-left: 20px;
        }

        .container {
            width: 95%;
            margin: 30px auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,.15);
        }

        th {
            background: #007bff;
            color: white;
        }

        th,
        td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        tr:nth-child(even) {
            background: #f8f9fa;
        }

        .no-data {
            padding: 20px;
        }

        @media(max-width: 900px) {

            table {
                font-size: 12px;
            }

            th,
            td {
                padding: 7px;
            }

        }

    </style>

</head>

<body>


<div class="header">

    <strong>🏥 Doctor Panel</strong>

    <a href="logout.php">
        Logout
    </a>

    <a href="dashboard.php">
        Dashboard
    </a>

</div>


<div class="container">

    <h2>👥 My Patients</h2>

    <p>
        Patients who have appointments with you.
    </p>


    <table>

        <tr>

            <th>ID</th>
            <th>Name</th>
            <th>Gender</th>
            <th>Age</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Address</th>

        </tr>


        <?php

        if (mysqli_num_rows($patients) > 0) {

            while ($patient = mysqli_fetch_assoc($patients)) {

        ?>

        <tr>

            <td>
                <?php echo $patient['id']; ?>
            </td>

            <td>
                <?php
                echo htmlspecialchars(
                    $patient['name']
                );
                ?>
            </td>

            <td>
                <?php echo $patient['gender']; ?>
            </td>

            <td>
                <?php echo $patient['age']; ?>
            </td>

            <td>
                <?php
                echo htmlspecialchars(
                    $patient['phone']
                );
                ?>
            </td>

            <td>
                <?php
                echo htmlspecialchars(
                    $patient['email']
                );
                ?>
            </td>

            <td>
                <?php
                echo htmlspecialchars(
                    $patient['address']
                );
                ?>
            </td>

        </tr>

        <?php

            }

        } else {

        ?>

        <tr>

            <td
                colspan="7"
                class="no-data"
            >

                No patients found.

            </td>

        </tr>

        <?php

        }

        ?>

    </table>


    <br>

    <a href="dashboard.php">
        ← Back to Dashboard
    </a>

</div>


</body>

</html>