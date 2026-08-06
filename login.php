<?php
session_start();
include("db_connect.php");

$message = "";

if (isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM patients WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {

        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['password'])) {

            $_SESSION['patient_id'] = $row['id'];
            $_SESSION['patient_name'] = $row['name'];

            header("Location: patient/dashboard.php");
            exit();

        } else {

            $message = "Invalid Password!";

        }

    } else {

        $message = "Email not registered!";

    }
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Patient Login</title>

    <style>

        body{
            font-family: Arial, Helvetica, sans-serif;
            background:#f5f5f5;
        }

        .container{
            width:400px;
            margin:80px auto;
            background:white;
            padding:25px;
            border-radius:8px;
            box-shadow:0px 0px 10px rgba(0,0,0,.2);
        }

        h2{
            text-align:center;
        }

        input{
            width:100%;
            padding:10px;
            margin:10px 0;
        }

        button{
            width:100%;
            padding:10px;
            background:#28a745;
            color:white;
            border:none;
            cursor:pointer;
        }

        button:hover{
            background:#218838;
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

    <h2>Patient Login</h2>

    <?php
    if($message!=""){
        echo "<div class='msg'>$message</div>";
    }
    ?>

    <form method="POST">

        <input type="email"
               name="email"
               placeholder="Email Address"
               required>

        <input type="password"
               name="password"
               placeholder="Password"
               required>

        <button type="submit" name="login">
            Login
        </button>

    </form>

    <br>

    <center>

        Don't have an account?

        <a href="register.php">
            Register Here
        </a>

    </center>

</div>

</body>

</html>