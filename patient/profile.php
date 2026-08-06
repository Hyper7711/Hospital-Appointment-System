<?php
session_start();

if (!isset($_SESSION['patient_id'])) {
    header("Location: ../login.php");
    exit();
}

include("../db_connect.php");

$patient_id = $_SESSION['patient_id'];
$message = "";

// Update Profile
if(isset($_POST['update'])){

    $name = $_POST['name'];
    $age = $_POST['age'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $update = "UPDATE patients
               SET name='$name',
                   age='$age',
                   phone='$phone',
                   address='$address'
               WHERE id='$patient_id'";

    if(mysqli_query($conn,$update)){

        $_SESSION['patient_name'] = $name;

        $message = "Profile Updated Successfully.";

    }else{

        $message = "Failed to Update Profile.";

    }

}

// Fetch Patient Details
$query = mysqli_query($conn,"SELECT * FROM patients WHERE id='$patient_id'");
$row = mysqli_fetch_assoc($query);

?>

<!DOCTYPE html>
<html>

<head>

<title>My Profile</title>

<style>

body{

    font-family:Arial;
    background:#f5f5f5;

}

.container{

    width:500px;
    margin:40px auto;
    background:white;
    padding:25px;
    border-radius:10px;
    box-shadow:0px 0px 10px rgba(0,0,0,.2);

}

input,
textarea{

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

    text-align:center;
    color:green;
    margin-bottom:10px;

}

</style>

</head>

<body>

<div class="container">

<h2 align="center">My Profile</h2>

<?php

if($message!=""){

    echo "<div class='msg'>$message</div>";

}

?>

<form method="POST">

<label>Full Name</label>

<input
type="text"
name="name"
value="<?php echo $row['name']; ?>"
required>

<label>Email</label>

<input
type="email"
value="<?php echo $row['email']; ?>"
readonly>

<label>Phone</label>

<input
type="text"
name="phone"
value="<?php echo $row['phone']; ?>"
required>

<label>Age</label>

<input
type="number"
name="age"
value="<?php echo $row['age']; ?>"
required>

<label>Address</label>

<textarea
name="address"
required><?php echo $row['address']; ?></textarea>

<button
type="submit"
name="update">

Update Profile

</button>

</form>

<br>

<center>

<a href="dashboard.php">

⬅ Back to Dashboard

</a>

</center>

</div>

</body>

</html>