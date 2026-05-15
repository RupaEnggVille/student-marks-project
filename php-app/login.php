<?php
session_start();
include 'config.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    $user = mysqli_fetch_assoc($result);

   # if ($user && password_verify($password, $user['password'])) {
    if ($user && $password == $user['password']) {

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        // FIX: only set student_id if exists
        $_SESSION['student_id'] = $user['student_id'];

        if ($user['role'] == 'admin') {
            header("Location: index.php");
        } else {
            header("Location: student_dashboard.php");
        }
        exit();

    } else {
        $error = "Invalid login details";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div style="text-align:center; margin-top:100px;">

    <h2>Login</h2>

    <form method="POST">

        <input type="email" name="email" placeholder="Email" required><br><br>

        <input type="password" name="password" placeholder="Password" required><br><br>

        <button type="submit">Login</button>

    </form>

    <p style="color:red;"><?php echo $error; ?></p>

</div>

</body>
</html>

