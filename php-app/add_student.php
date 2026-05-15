<?php
session_start();
include 'config.php';

// Security: only admin can access
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}

// ADD STUDENT
if(isset($_POST['submit'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];

    // 1. Insert into students table
    mysqli_query($conn,
        "INSERT INTO students(name,email)
         VALUES('$name','$email')"
    );

    // 2. Get inserted student ID
    $student_id = mysqli_insert_id($conn);

    // 3. Create login user automatically
    $password = password_hash("student123", PASSWORD_DEFAULT);

    mysqli_query($conn,
        "INSERT INTO users(email,password,role,student_id)
         VALUES('$email','$password','student',$student_id)"
    );

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<h2>Add Student</h2>

<form method="POST">

    <label>Name</label><br>
    <input type="text" name="name" required><br><br>

    <label>Email</label><br>
    <input type="email" name="email" required><br><br>

    <button type="submit" name="submit">
        Add Student
    </button>

</form>

<br>

<a href="index.php">Back</a>

</body>
</html>
