<?php
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

    // Check if passwords match
    if ($password != $confirm_password) {
        $message = "Passwords do not match!";
    } else {

        // Check if email already exists
        $check = mysqli_query($conn, "SELECT * FROM patients WHERE email='$email'");

        if (mysqli_num_rows($check) > 0) {

            $message = "Email already registered!";

        } else {

            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert data
            $sql = "INSERT INTO patients(name, gender, age, phone, email, address, password)
                    VALUES('$name','$gender','$age','$phone','$email','$address','$hashedPassword')";

            if (mysqli_query($conn, $sql)) {

                echo "<script>
                        alert('Registration Successful!');
                        window.location='login.php';
                      </script>";

                exit();

            } else {

                $message = "Something went wrong!";

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

        body{
            font-family: Arial, Helvetica, sans-serif;
            background:#f5f5f5;
        }

        .container{

            width:450px;
            margin:40px auto;
            background:white;
            padding:25px;
            border-radius:8px;
            box-shadow:0px 0px 10px rgba(0,0,0,.2);

        }

        h2{

            text-align:center;

        }

        input,
        select,
        textarea{

            width:100%;
            padding:10px;
            margin:8px 0;

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

            color:red;
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

    <h2>Patient Registration</h2>

    <?php
    if($message!=""){
        echo "<div class='msg'>$message</div>";
    }
    ?>

    <form method="POST">

        <input type="text" name="name" placeholder="Full Name" required>

        <select name="gender" required>

            <option value="">Select Gender</option>

            <option>Male</option>

            <option>Female</option>

            <option>Other</option>

        </select>

        <input type="number" name="age" placeholder="Age" required>

        <input type="text" name="phone" placeholder="Phone Number" required>

        <input type="email" name="email" placeholder="Email Address" required>

        <textarea name="address" placeholder="Address" required></textarea>

        <input type="password" name="password" placeholder="Password" required>

        <input type="password" name="confirm_password" placeholder="Confirm Password" required>

        <button type="submit" name="register">Register</button>

    </form>

    <br>

    <center>

        Already have an account?

        <a href="login.php">Login Here</a>

    </center>

</div>

</body>

</html>