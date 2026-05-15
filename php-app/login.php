<?php

session_start();
include 'config.php';

/*
|--------------------------------------------------------------------------
| AUTO CREATE DEFAULT ADMIN
|--------------------------------------------------------------------------
*/

$admin_email = "admin@gmail.com";
$admin_password = "admin123";

// Check admin exists
$check = mysqli_query(
    $conn,
    "SELECT * FROM users WHERE email='$admin_email'"
);

$hashed_password = password_hash(
    $admin_password,
    PASSWORD_DEFAULT
);

if(mysqli_num_rows($check) == 0){

    // Create admin
    mysqli_query(
        $conn,
        "INSERT INTO users(email,password,role)
         VALUES(
            '$admin_email',
            '$hashed_password',
            'admin'
         )"
    );

} else {

    // Always reset admin password correctly
    mysqli_query(
        $conn,
        "UPDATE users
         SET password='$hashed_password'
         WHERE email='$admin_email'"
    );
}

/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/

if(isset($_POST['login'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = mysqli_query(
        $conn,
        "SELECT * FROM users WHERE email='$email'"
    );

    if(mysqli_num_rows($query) > 0){

        $user = mysqli_fetch_assoc($query);

        if(password_verify($password, $user['password'])){

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['student_id'] = $user['student_id'];

            header("Location: index.php");
            exit();

        } else {

            $error = "Invalid login details";
        }

    } else {

        $error = "Invalid login details";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

    <style>

        body{
            margin:0;
            padding:0;
            font-family: Arial;
            background: linear-gradient(to right,#141e30,#4b2cbf);
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .login-box{
            width:350px;
            padding:40px;
            text-align:center;
        }

        h1{
            color:#38b6ff;
            margin-bottom:30px;
        }

        input{
            width:100%;
            padding:12px;
            margin:10px 0;
            border:none;
            border-radius:5px;
            font-size:16px;
        }

        button{
            background:#4da3ff;
            color:white;
            border:none;
            padding:12px 25px;
            border-radius:5px;
            cursor:pointer;
            font-size:16px;
        }

        button:hover{
            background:#2f89fc;
        }

        .error{
            color:red;
            margin-top:20px;
        }

    </style>

</head>

<body>

<div class="login-box">

    <h1>Login</h1>

    <form method="POST">

        <input type="email"
               name="email"
               placeholder="Email"
               required>

        <input type="password"
               name="password"
               placeholder="Password"
               required>

        <button type="submit" name="login">
            Login
        </button>

    </form>

    <?php
    if(isset($error)){
        echo "<p class='error'>$error</p>";
    }
    ?>

</div>

</body>
</html>


