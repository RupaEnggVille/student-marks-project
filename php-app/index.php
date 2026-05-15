<?php

session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if($_SESSION['role'] != 'admin'){
    header("Location: student_dashboard.php");
    exit();
}

include 'config.php';

?>

<!DOCTYPE html>
<html>
<head>

    <title>Student Management System</title>

    <link rel="stylesheet" href="style.css">

    <!-- UI IMPROVEMENT (optional but recommended) -->
<style>
body {
    font-family: Arial, sans-serif;
}

/* TABLE BASE */
table {
    border-collapse: collapse;
    width: 80%;
    margin: auto;
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
}

/* HEADER */
th {
    background: #0d6efd;   /* Bootstrap blue */
    color: white;
    padding: 12px;
    text-align: center;
}

/* CELLS */
td {
    padding: 12px;
    text-align: center;
    color: #000;
}

/* ROW COLORS (BLUE STYLE) */
tr:nth-child(even) {
    background: #f2f7ff;
}

tr:nth-child(odd) {
    background: #ffffff;
}

/* HOVER EFFECT */
tr:hover {
    background: #dbe9ff;
}

/* LINKS */
td a {
    color: #0d6efd;
    text-decoration: none;
    font-weight: 500;
}

td a:hover {
    color: #084298;
    text-decoration: underline;
}

/* PAGE ALIGNMENT */
.container {
    text-align: center;
}
</style>
</head>

<body>

<!-- HEADER -->
<div style="display:flex; justify-content:space-between; align-items:center; padding:15px 20px; border-bottom:1px solid #ccc;">

    <h1 style="margin:0;">Student Management System</h1>

    <div>
        <span style="margin-right:15px; font-weight:bold;">
            Welcome Admin
        </span>

        <a href="logout.php"
           style="background:red; color:white; padding:8px 14px; text-decoration:none; border-radius:5px;">
            Logout
        </a>
    </div>

</div>

<br>

<!-- ADD STUDENT -->
<div style="text-align:center; margin-bottom:20px;">

    <a href="add_student.php"
       style="background:green; color:white; padding:8px 12px; text-decoration:none; border-radius:5px;">
        ➕ Add Student
    </a>

</div>

<!-- SEARCH -->
<form action="search.php" method="GET" style="text-align:center; margin-bottom:20px;">

    <input type="text"
           name="search"
           placeholder="Search student by Name"
           style="padding:8px; width:250px;">

    <button type="submit" style="padding:8px;">
        Search
    </button>

</form>

<!-- STUDENT TABLE -->
<div style="display:flex; justify-content:center;">

<table border="1" cellspacing="0" cellpadding="10" style="text-align:center;">

    <tr style="background:#333; color:white;">
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Action</th>
    </tr>

    <?php

    // SAFE QUERY (explicit columns)
    $result = mysqli_query($conn, "SELECT id, name, email FROM students");

    if(!$result){
        echo "<tr><td colspan='4'>Database error</td></tr>";
    }
    else if(mysqli_num_rows($result) == 0){
        echo "<tr><td colspan='4'>No students found</td></tr>";
    }
    else {

        while($row = mysqli_fetch_assoc($result)) {
    ?>

    <tr>

        <td><?php echo $row['id']; ?></td>

        <td>
            <a href="student_subjects.php?id=<?php echo $row['id']; ?>"
               style="text-decoration:none; color:blue;">
                <?php echo $row['name']; ?>
            </a>
        </td>

        <td><?php echo $row['email']; ?></td>

        <td>

            <a href="edit_student.php?id=<?php echo $row['id']; ?>"
               style="color:green; text-decoration:none;">
                Edit
            </a>

            |

            <a href="delete_student.php?id=<?php echo $row['id']; ?>"
               style="color:red; text-decoration:none;"
               onclick="return confirm('Are you sure you want to delete this student?');">
                Delete
            </a>

        </td>

    </tr>

    <?php
        }
    }
    ?>

</table>

</div>

</body>
</html>
