<?php

// Show PHP errors during development
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("db_connect.php");

$message = "";

if (isset($_POST['register'])) {

    $name = trim($_POST['name']);
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];


    // =========================
    // NAME VALIDATION
    // =========================

    if (!preg_match("/^[A-Za-z ]{3,50}$/", $name)) {

        $message = "Invalid name! Use only letters and spaces.";

    }


    // =========================
    // GENDER VALIDATION
    // =========================

    elseif (!in_array($gender, ['Male', 'Female', 'Other'])) {

        $message = "Please select a valid gender.";

    }


    // =========================
    // AGE VALIDATION
    // =========================

    elseif (
        !filter_var($age, FILTER_VALIDATE_INT) ||
        $age < 1 ||
        $age > 120
    ) {

        $message = "Age must be between 1 and 120.";

    }


    // =========================
    // PHONE VALIDATION
    // =========================

    elseif (!preg_match("/^[6-9][0-9]{9}$/", $phone)) {

        $message = "Invalid phone number! Enter a valid 10-digit number.";

    }


    // =========================
    // EMAIL VALIDATION
    // =========================

    elseif (
        !preg_match(
            "/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/",
            $email
        )
    ) {

        $message = "Invalid email address.";

    }


    // =========================
    // ADDRESS VALIDATION
    // =========================

    elseif (strlen($address) < 5) {

        $message = "Address must contain at least 5 characters.";

    }


    // =========================
    // PASSWORD VALIDATION
    // =========================

    elseif (
        !preg_match(
            "/^(?=.*[A-Za-z])(?=.*[0-9]).{6,}$/",
            $password
        )
    ) {

        $message = "Password must be at least 6 characters and contain letters and numbers.";

    }


    // =========================
    // CONFIRM PASSWORD
    // =========================

    elseif ($password !== $confirm_password) {

        $message = "Passwords do not match.";

    }


    else {

        // =========================
        // CHECK DUPLICATE EMAIL
        // =========================

        $check_email = mysqli_query(
            $conn,
            "SELECT * FROM patients WHERE email='$email'"
        );

        if (mysqli_num_rows($check_email) > 0) {

            $message = "Email already registered!";

        }

        else {

            // =========================
            // CHECK DUPLICATE PHONE
            // =========================

            $check_phone = mysqli_query(
                $conn,
                "SELECT * FROM patients WHERE phone='$phone'"
            );

            if (mysqli_num_rows($check_phone) > 0) {

                $message = "Phone number already registered!";

            }

            else {

                // =========================
                // HASH PASSWORD
                // =========================

                $hashedPassword = password_hash(
                    $password,
                    PASSWORD_DEFAULT
                );


                // =========================
                // INSERT PATIENT
                // =========================

                $sql = "INSERT INTO patients
                        (name, gender, age, phone, email, address, password)
                        VALUES
                        ('$name',
                         '$gender',
                         '$age',
                         '$phone',
                         '$email',
                         '$address',
                         '$hashedPassword')";


                if (mysqli_query($conn, $sql)) {

                    echo "<script>

                            alert('Registration Successful!');

                            window.location='login.php';

                          </script>";

                    exit();

                }

                else {

                    $message = "Something went wrong: " .
                               mysqli_error($conn);

                }

            }

        }

    }

}

?>


<!DOCTYPE html>

<html>

<head>

    <title>Patient Registration</title>

    <style>

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f5f5;
        }

        .container {
            width: 450px;
            margin: 40px auto;
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0,0,0,.2);
        }

        h2 {
            text-align: center;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }

        .msg {
            color: red;
            text-align: center;
            margin-bottom: 10px;
            font-weight: bold;
        }

        a {
            text-decoration: none;
        }

    </style>

</head>


<body>


<div class="container">


    <h2>Patient Registration</h2>


    <?php

    if ($message != "") {

        echo "<div class='msg'>";
        echo htmlspecialchars($message);
        echo "</div>";

    }

    ?>


    <form method="POST">


        <input
            type="text"
            name="name"
            placeholder="Full Name"
            required
        >


        <select
            name="gender"
            required
        >

            <option value="">
                Select Gender
            </option>

            <option value="Male">
                Male
            </option>

            <option value="Female">
                Female
            </option>

            <option value="Other">
                Other
            </option>

        </select>


        <input
            type="number"
            name="age"
            placeholder="Age"
            min="1"
            max="120"
            required
        >


        <input
            type="text"
            name="phone"
            placeholder="Phone Number"
            maxlength="10"
            required
        >


        <input
            type="email"
            name="email"
            placeholder="Email Address"
            required
        >


        <textarea
            name="address"
            placeholder="Address"
            required
        ></textarea>


        <input
            type="password"
            name="password"
            placeholder="Password"
            required
        >


        <input
            type="password"
            name="confirm_password"
            placeholder="Confirm Password"
            required
        >


        <button
            type="submit"
            name="register"
        >
            Register
        </button>


    </form>


    <br>


    <center>

        Already have an account?

        <a href="login.php">
            Login Here
        </a>

    </center>


</div>


</body>

</html>