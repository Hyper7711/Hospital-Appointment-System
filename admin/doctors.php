<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include("../db_connect.php");

$message = "";

/* =========================
   ADD DOCTOR
========================= */

if (isset($_POST['add_doctor'])) {

    $name = trim($_POST['name']);
    $department_id = $_POST['department_id'];
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $specialization = trim($_POST['specialization']);

    $sql = "INSERT INTO doctors
            (name, department_id, phone, email, specialization)
            VALUES
            ('$name', '$department_id', '$phone', '$email', '$specialization')";

    if (mysqli_query($conn, $sql)) {

        $message = "Doctor added successfully!";

    } else {

        $message = "Failed to add doctor.";

    }
}


/* =========================
   DELETE DOCTOR
========================= */

if (isset($_GET['delete'])) {

    $id = $_GET['delete'];

    mysqli_query($conn, "DELETE FROM doctors WHERE id='$id'");

    header("Location: doctors.php");
    exit();
}


/* =========================
   EDIT DOCTOR
========================= */

if (isset($_POST['update_doctor'])) {

    $id = $_POST['id'];

    $name = trim($_POST['name']);
    $department_id = $_POST['department_id'];
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $specialization = trim($_POST['specialization']);

    $sql = "UPDATE doctors SET
            name='$name',
            department_id='$department_id',
            phone='$phone',
            email='$email',
            specialization='$specialization'
            WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {

        $message = "Doctor updated successfully!";

    } else {

        $message = "Failed to update doctor.";

    }
}


/* =========================
   GET DOCTOR FOR EDIT
========================= */

$edit_doctor = null;

if (isset($_GET['edit'])) {

    $id = $_GET['edit'];

    $result = mysqli_query(
        $conn,
        "SELECT * FROM doctors WHERE id='$id'"
    );

    $edit_doctor = mysqli_fetch_assoc($result);
}


/* =========================
   FETCH DEPARTMENTS
========================= */

$departments = mysqli_query(
    $conn,
    "SELECT * FROM departments ORDER BY department_name"
);


/* =========================
   FETCH DOCTORS
========================= */

$doctors = mysqli_query(
    $conn,
    "SELECT doctors.*,
            departments.department_name
     FROM doctors
     INNER JOIN departments
     ON doctors.department_id = departments.id
     ORDER BY doctors.id DESC"
);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Manage Doctors</title>

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

        .form-box {
            background: white;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,.15);
        }

        .form-box h2 {
            margin-top: 0;
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            margin: 8px 0 15px;
            box-sizing: border-box;
        }

        button {
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }

        .cancel {
            background: #6c757d;
            padding: 10px 20px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-left: 5px;
        }

        .message {
            background: #d4edda;
            color: #155724;
            padding: 12px;
            margin-bottom: 15px;
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

        .edit {
            background: #ffc107;
            color: black;
            padding: 7px 12px;
            text-decoration: none;
            border-radius: 4px;
        }

        .delete {
            background: #dc3545;
            color: white;
            padding: 7px 12px;
            text-decoration: none;
            border-radius: 4px;
        }

        @media(max-width: 800px) {

            table {
                font-size: 13px;
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

    <strong>🏥 Hospital Admin Panel</strong>

    <a href="logout.php">Logout</a>

    <a href="dashboard.php">Dashboard</a>

</div>


<div class="container">


<?php

if ($message != "") {

    echo "<div class='message'>$message</div>";

}

?>


<!-- =========================
     ADD / EDIT FORM
========================= -->

<div class="form-box">

<?php if ($edit_doctor) { ?>

    <h2>✏️ Edit Doctor</h2>

    <form method="POST">

        <input
            type="hidden"
            name="id"
            value="<?php echo $edit_doctor['id']; ?>"
        >

        <label>Doctor Name</label>

        <input
            type="text"
            name="name"
            value="<?php echo $edit_doctor['name']; ?>"
            required
        >


        <label>Department</label>

        <select name="department_id" required>

            <option value="">Select Department</option>

            <?php

            mysqli_data_seek($departments, 0);

            while ($department = mysqli_fetch_assoc($departments)) {

                $selected = "";

                if ($department['id'] == $edit_doctor['department_id']) {
                    $selected = "selected";
                }

            ?>

                <option
                    value="<?php echo $department['id']; ?>"
                    <?php echo $selected; ?>
                >

                    <?php echo $department['department_name']; ?>

                </option>

            <?php } ?>

        </select>


        <label>Phone</label>

        <input
            type="text"
            name="phone"
            value="<?php echo $edit_doctor['phone']; ?>"
            required
        >


        <label>Email</label>

        <input
            type="email"
            name="email"
            value="<?php echo $edit_doctor['email']; ?>"
            required
        >


        <label>Specialization</label>

        <input
            type="text"
            name="specialization"
            value="<?php echo $edit_doctor['specialization']; ?>"
            required
        >


        <button
            type="submit"
            name="update_doctor"
        >

            Update Doctor

        </button>


        <a
            href="doctors.php"
            class="cancel"
        >

            Cancel

        </a>

    </form>


<?php } else { ?>


    <h2>➕ Add Doctor</h2>

    <form method="POST">


        <label>Doctor Name</label>

        <input
            type="text"
            name="name"
            placeholder="Enter doctor name"
            required
        >


        <label>Department</label>

        <select name="department_id" required>

            <option value="">Select Department</option>

            <?php

            while ($department = mysqli_fetch_assoc($departments)) {

            ?>

                <option value="<?php echo $department['id']; ?>">

                    <?php echo $department['department_name']; ?>

                </option>

            <?php } ?>

        </select>


        <label>Phone</label>

        <input
            type="text"
            name="phone"
            placeholder="Enter phone number"
            required
        >


        <label>Email</label>

        <input
            type="email"
            name="email"
            placeholder="Enter email"
            required
        >


        <label>Specialization</label>

        <input
            type="text"
            name="specialization"
            placeholder="Example: Cardiologist"
            required
        >


        <button
            type="submit"
            name="add_doctor"
        >

            Add Doctor

        </button>

    </form>


<?php } ?>

</div>


<!-- =========================
     DOCTOR LIST
========================= -->

<h2>👨‍⚕️ Doctor List</h2>


<table>

<tr>

    <th>ID</th>
    <th>Name</th>
    <th>Department</th>
    <th>Phone</th>
    <th>Email</th>
    <th>Specialization</th>
    <th>Action</th>

</tr>


<?php

if (mysqli_num_rows($doctors) > 0) {

    while ($doctor = mysqli_fetch_assoc($doctors)) {

?>

<tr>

    <td>
        <?php echo $doctor['id']; ?>
    </td>

    <td>
        <?php echo $doctor['name']; ?>
    </td>

    <td>
        <?php echo $doctor['department_name']; ?>
    </td>

    <td>
        <?php echo $doctor['phone']; ?>
    </td>

    <td>
        <?php echo $doctor['email']; ?>
    </td>

    <td>
        <?php echo $doctor['specialization']; ?>
    </td>

    <td>

        <a
            href="doctors.php?edit=<?php echo $doctor['id']; ?>"
            class="edit"
        >
            Edit
        </a>

        <a
            href="doctors.php?delete=<?php echo $doctor['id']; ?>"
            class="delete"
            onclick="return confirm('Are you sure you want to delete this doctor?');"
        >
            Delete
        </a>

    </td>

</tr>

<?php

    }

} else {

?>

<tr>

    <td colspan="7">
        No doctors found.
    </td>

</tr>

<?php

}

?>

</table>


</div>

</body>

</html>