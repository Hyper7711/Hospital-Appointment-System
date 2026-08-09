<?php
session_start();

include("../db_connect.php");

$message = "";

if (isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM doctors WHERE email='$email'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {

        $doctor = mysqli_fetch_assoc($result);

        /*
         * For this college project, doctors do not have
         * a password column in the database yet.
         *
         * We will use a simple fixed password for now.
         */

        if ($password == "doctor123") {

            $_SESSION['doctor_id'] = $doctor['id'];
            $_SESSION['doctor_name'] = $doctor['name'];
            $_SESSION['doctor_email'] = $doctor['email'];
            $_SESSION['doctor_department'] = $doctor['department_id'];

            header("Location: dashboard.php");
            exit();

        } else {

            $message = "Invalid Password!";

        }

    } else {

        $message = "Doctor Email not found!";

    }
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Doctor Login</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
        }

        .container {
            width: 400px;
            margin: 100px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }

        h2 {
            text-align: center;
            color: #007bff;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }

        .message {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }

        .back {
            text-align: center;
            margin-top: 15px;
        }

        a {
            text-decoration: none;
            color: #007bff;
        }

        .info {
            background: #e7f1ff;
            padding: 10px;
            margin-top: 15px;
            text-align: center;
            font-size: 14px;
        }

    </style>

</head>

<body>

<div class="container">

    <h2>👨‍⚕️ Doctor Login</h2>

    <?php

    if ($message != "") {
        echo "<div class='message'>$message</div>";
    }

    ?>

    <form method="POST">

        <input
            type="email"
            name="email"
            placeholder="Doctor Email"
            required
        >

        <input
            type="password"
            name="password"
            placeholder="Password"
            required
        >

        <button type="submit" name="login">
            Login
        </button>

    </form>

    <div class="info">

        Demo Doctor Password:
        <strong>doctor123</strong>

    </div>

    <div class="back">

        <a href="../index.php">
            ← Back to Home
        </a>

    </div>

</div>

</body>

</html>