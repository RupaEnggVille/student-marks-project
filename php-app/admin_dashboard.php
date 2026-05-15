<?php
session_start();
include 'config.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if($_SESSION['role'] != 'admin'){
    header("Location: student_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="header">

    <h1>Student Management System</h1>

    <a href="logout.php" class="logout-btn">Logout</a>

</div>

<div class="center">

    <a href="add_student.php" class="btn-green">➕ Add Student</a>

</div>

<div class="center">

<form action="search.php" method="GET">

    <input type="text" name="search" placeholder="Search student">

    <button type="submit">Search</button>

</form>

</div>

<div class="center">

<table>

<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Action</th>
</tr>

<?php
$result = mysqli_query($conn, "SELECT * FROM students");

while($row = mysqli_fetch_assoc($result)) {
?>

<tr>
    <td><?php echo $row['id']; ?></td>

    <td>
        <a href="student_subjects.php?id=<?php echo $row['id']; ?>">
            <?php echo $row['name']; ?>
        </a>
    </td>

    <td><?php echo $row['email']; ?></td>

    <td>
        <a href="edit_student.php?id=<?php echo $row['id']; ?>">Edit</a> |
        <a href="delete_student.php?id=<?php echo $row['id']; ?>"
           onclick="return confirm('Delete?')">Delete</a>
    </td>
</tr>

<?php } ?>

</table>

</div>

</body>
</html>
