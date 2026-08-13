<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (!isset($_SESSION['patient_id'])) {
    header("Location: ../login.php");
    exit();
}

include("../db_connect.php");

$message = "";
$message_type = "";


/* =========================
   BOOK APPOINTMENT
========================= */

if (isset($_POST['book'])) {

    $patient_id = $_SESSION['patient_id'];

    $doctor_id = $_POST['doctor_id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];


    // =========================
    // DOCTOR VALIDATION
    // =========================

    if (!filter_var($doctor_id, FILTER_VALIDATE_INT)) {

        $message = "Please select a valid doctor.";
        $message_type = "error";

    }


    // =========================
    // DATE FORMAT VALIDATION
    // =========================

    elseif (
        !preg_match(
            "/^\d{4}-\d{2}-\d{2}$/",
            $appointment_date
        )
    ) {

        $message = "Invalid date format.";
        $message_type = "error";

    }


    else {

        // Check actual date
        $date_object = DateTime::createFromFormat(
            'Y-m-d',
            $appointment_date
        );

        if (
            !$date_object ||
            $date_object->format('Y-m-d') !== $appointment_date
        ) {

            $message = "Please enter a valid appointment date.";
            $message_type = "error";

        }

        // =========================
        // PREVENT PAST DATE
        // =========================

        elseif ($appointment_date < date('Y-m-d')) {

            $message = "Appointment date cannot be in the past.";
            $message_type = "error";

        }

        // =========================
        // TIME FORMAT VALIDATION
        // =========================

        elseif (
            !preg_match(
                "/^(?:[01]\d|2[0-3]):[0-5]\d$/",
                $appointment_time
            )
        ) {

            $message = "Invalid appointment time.";
            $message_type = "error";

        }

        else {

            // =========================
            // CHECK DOCTOR EXISTS
            // =========================

            $doctor_check = mysqli_query(
                $conn,
                "SELECT id FROM doctors WHERE id='$doctor_id'"
            );

            if (mysqli_num_rows($doctor_check) == 0) {

                $message = "Selected doctor does not exist.";
                $message_type = "error";

            }

            else {

                // =========================
                // CHECK DUPLICATE APPOINTMENT
                // =========================

                $duplicate_check = mysqli_query(
                    $conn,
                    "SELECT id
                     FROM appointments
                     WHERE doctor_id='$doctor_id'
                     AND appointment_date='$appointment_date'
                     AND appointment_time='$appointment_time'
                     AND status != 'Cancelled'"
                );

                if (mysqli_num_rows($duplicate_check) > 0) {

                    $message = "This time slot is already booked. Please select another time.";
                    $message_type = "error";

                }

                else {

                    // =========================
                    // INSERT APPOINTMENT
                    // =========================

                    $sql = "INSERT INTO appointments
                            (
                                patient_id,
                                doctor_id,
                                appointment_date,
                                appointment_time,
                                status
                            )
                            VALUES
                            (
                                '$patient_id',
                                '$doctor_id',
                                '$appointment_date',
                                '$appointment_time',
                                'Pending'
                            )";


                    if (mysqli_query($conn, $sql)) {

                        $message = "Appointment booked successfully!";
                        $message_type = "success";

                    }

                    else {

                        $message = "Something went wrong: " .
                                   mysqli_error($conn);

                        $message_type = "error";

                    }

                }

            }

        }

    }

}


/* =========================
   FETCH DOCTORS
========================= */

$doctors = mysqli_query(
    $conn,
    "SELECT
        doctors.id,
        doctors.name,
        departments.department_name
     FROM doctors
     INNER JOIN departments
     ON doctors.department_id = departments.id
     ORDER BY doctors.name"
);

?>

<!DOCTYPE html>

<html>

<head>

    <title>Book Appointment</title>

    <style>

        body {

            font-family: Arial, sans-serif;

            background: #f5f5f5;

        }

        .container {

            width: 500px;

            margin: 40px auto;

            background: white;

            padding: 25px;

            border-radius: 10px;

            box-shadow:
                0px 0px 10px rgba(0,0,0,.2);

        }

        h2 {

            text-align: center;

            color: #0077b6;

        }

        label {

            display: block;

            margin-top: 12px;

            font-weight: bold;

        }

        input,
        select {

            width: 100%;

            padding: 10px;

            margin: 8px 0;

            box-sizing: border-box;

        }

        button {

            width: 100%;

            padding: 11px;

            background: #007bff;

            color: white;

            border: none;

            cursor: pointer;

            border-radius: 5px;

            margin-top: 10px;

        }

        button:hover {

            background: #0056b3;

        }

        .message {

            text-align: center;

            padding: 10px;

            margin-bottom: 15px;

            border-radius: 5px;

            font-weight: bold;

        }

        .success {

            background: #d4edda;

            color: #155724;

        }

        .error {

            background: #f8d7da;

            color: #721c24;

        }

        .back {

            text-align: center;

            margin-top: 20px;

        }

        .back a {

            text-decoration: none;

            color: #007bff;

        }

    </style>

</head>


<body>


<div class="container">


    <h2>
        📅 Book Appointment
    </h2>


    <?php

    if ($message != "") {

        echo "<div class='message $message_type'>";
        echo htmlspecialchars($message);
        echo "</div>";

    }

    ?>


    <form method="POST">


        <!-- DOCTOR -->

        <label>
            Select Doctor
        </label>

        <select
            name="doctor_id"
            required
        >

            <option value="">
                Select Doctor
            </option>


            <?php

            while ($doctor = mysqli_fetch_assoc($doctors)) {

            ?>

                <option
                    value="<?php echo $doctor['id']; ?>"
                >

                    <?php

                    echo htmlspecialchars(
                        $doctor['name']
                    );

                    echo " - ";

                    echo htmlspecialchars(
                        $doctor['department_name']
                    );

                    ?>

                </option>

            <?php

            }

            ?>

        </select>


        <!-- DATE -->

        <label>
            Appointment Date
        </label>

        <input
            type="date"
            name="appointment_date"
            min="<?php echo date('Y-m-d'); ?>"
            required
        >


        <!-- TIME -->

        <label>
            Appointment Time
        </label>

        <input
            type="time"
            name="appointment_time"
            required
        >


        <button
            type="submit"
            name="book"
        >

            Book Appointment

        </button>


    </form>


    <div class="back">

        <a href="dashboard.php">

            ← Back to Dashboard

        </a>

    </div>


</div>


</body>

</html>