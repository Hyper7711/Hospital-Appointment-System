<?php
session_start();

if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php");
    exit();
}

include("../db_connect.php");

$doctor_id = $_SESSION['doctor_id'];
$message = "";

/* =========================
   UPDATE APPOINTMENT STATUS
========================= */

if (isset($_POST['update_status'])) {

    $appointment_id = $_POST['appointment_id'];
    $status = $_POST['status'];

    $sql = "UPDATE appointments
            SET status='$status'
            WHERE id='$appointment_id'
            AND doctor_id='$doctor_id'";

    if (mysqli_query($conn, $sql)) {

        $message = "Appointment status updated successfully!";

    } else {

        $message = "Failed to update appointment.";

    }
}


/* =========================
   FETCH DOCTOR APPOINTMENTS
========================= */

$sql = "SELECT
            appointments.id,
            appointments.appointment_date,
            appointments.appointment_time,
            appointments.status,

            patients.name AS patient_name,
            patients.gender,
            patients.age,
            patients.phone,

            departments.department_name

        FROM appointments

        INNER JOIN patients
        ON appointments.patient_id = patients.id

        INNER JOIN doctors
        ON appointments.doctor_id = doctors.id

        INNER JOIN departments
        ON doctors.department_id = departments.id

        WHERE appointments.doctor_id = '$doctor_id'

        ORDER BY
            appointments.appointment_date DESC,
            appointments.appointment_time DESC";

$appointments = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>

<head>

    <title>My Appointments</title>

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

        .message {
            background: #d4edda;
            color: #155724;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 5px;
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

        select {
            padding: 7px;
        }

        button {
            padding: 7px 12px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background: #218838;
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

    <h2>📅 My Appointments</h2>


    <?php

    if ($message != "") {

        echo "<div class='message'>$message</div>";

    }

    ?>


    <table>

        <tr>

            <th>ID</th>
            <th>Patient</th>
            <th>Gender</th>
            <th>Age</th>
            <th>Phone</th>
            <th>Department</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>

        </tr>


        <?php

        if (mysqli_num_rows($appointments) > 0) {

            while ($appointment = mysqli_fetch_assoc($appointments)) {

        ?>

        <tr>

            <td>
                <?php echo $appointment['id']; ?>
            </td>

            <td>
                <?php
                echo htmlspecialchars(
                    $appointment['patient_name']
                );
                ?>
            </td>

            <td>
                <?php echo $appointment['gender']; ?>
            </td>

            <td>
                <?php echo $appointment['age']; ?>
            </td>

            <td>
                <?php
                echo htmlspecialchars(
                    $appointment['phone']
                );
                ?>
            </td>

            <td>
                <?php
                echo htmlspecialchars(
                    $appointment['department_name']
                );
                ?>
            </td>

            <td>
                <?php
                echo $appointment['appointment_date'];
                ?>
            </td>

            <td>
                <?php

                echo date(
                    "h:i A",
                    strtotime(
                        $appointment['appointment_time']
                    )
                );

                ?>
            </td>

            <td>

                <form method="POST">

                    <input
                        type="hidden"
                        name="appointment_id"
                        value="<?php echo $appointment['id']; ?>"
                    >

                    <select name="status">

                        <option
                            value="Pending"
                            <?php
                            if ($appointment['status'] == "Pending")
                                echo "selected";
                            ?>
                        >
                            Pending
                        </option>

                        <option
                            value="Completed"
                            <?php
                            if ($appointment['status'] == "Completed")
                                echo "selected";
                            ?>
                        >
                            Completed
                        </option>

                        <option
                            value="Cancelled"
                            <?php
                            if ($appointment['status'] == "Cancelled")
                                echo "selected";
                            ?>
                        >
                            Cancelled
                        </option>

                    </select>

                    <br><br>

                    <button
                        type="submit"
                        name="update_status"
                    >
                        Update
                    </button>

                </form>

            </td>

        </tr>

        <?php

            }

        } else {

        ?>

        <tr>

            <td
                colspan="9"
                class="no-data"
            >
                No appointments assigned to you.
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