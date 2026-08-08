<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include("../db_connect.php");

$message = "";

/* =========================
   DELETE PATIENT
========================= */

if (isset($_GET['delete'])) {

    $id = $_GET['delete'];

    mysqli_query($conn, "DELETE FROM patients WHERE id='$id'");

    header("Location: patients.php");
    exit();
}


/* =========================
   SEARCH PATIENT
========================= */

$search = "";

if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
}

if ($search != "") {

    $sql = "SELECT * FROM patients
            WHERE name LIKE '%$search%'
            OR email LIKE '%$search%'
            OR phone LIKE '%$search%'
            ORDER BY id DESC";

} else {

    $sql = "SELECT * FROM patients
            ORDER BY id DESC";
}

$patients = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Manage Patients</title>

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

        .search-box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,.15);
        }

        .search-box input {
            width: 70%;
            padding: 10px;
            box-sizing: border-box;
        }

        .search-box button {
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        .clear {
            margin-left: 10px;
            text-decoration: none;
            color: #007bff;
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

        .delete {
            background: #dc3545;
            color: white;
            padding: 7px 12px;
            text-decoration: none;
            border-radius: 4px;
        }

        .delete:hover {
            background: #b02a37;
        }

        .no-data {
            text-align: center;
            padding: 20px;
        }

        @media(max-width: 800px) {

            .container {
                width: 98%;
            }

            table {
                font-size: 12px;
            }

            th,
            td {
                padding: 7px;
            }

            .search-box input {
                width: 60%;
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

    <h2>👥 Manage Patients</h2>


    <!-- SEARCH -->

    <div class="search-box">

        <form method="GET">

            <input
                type="text"
                name="search"
                placeholder="Search by name, email or phone"
                value="<?php echo htmlspecialchars($search); ?>"
            >

            <button type="submit">
                Search
            </button>

            <?php if ($search != "") { ?>

                <a href="patients.php" class="clear">
                    Clear
                </a>

            <?php } ?>

        </form>

    </div>


    <!-- PATIENT TABLE -->

    <table>

        <tr>

            <th>ID</th>
            <th>Name</th>
            <th>Gender</th>
            <th>Age</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Address</th>
            <th>Action</th>

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
                <?php echo htmlspecialchars($patient['name']); ?>
            </td>

            <td>
                <?php echo htmlspecialchars($patient['gender']); ?>
            </td>

            <td>
                <?php echo $patient['age']; ?>
            </td>

            <td>
                <?php echo htmlspecialchars($patient['phone']); ?>
            </td>

            <td>
                <?php echo htmlspecialchars($patient['email']); ?>
            </td>

            <td>
                <?php echo htmlspecialchars($patient['address']); ?>
            </td>

            <td>

                <a
                    href="patients.php?delete=<?php echo $patient['id']; ?>"
                    class="delete"
                    onclick="return confirm('Are you sure you want to delete this patient?');"
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

            <td colspan="8" class="no-data">
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