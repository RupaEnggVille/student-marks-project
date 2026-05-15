<?php
include 'config.php';

// Get ID from URL
$id = $_GET['id'];

// Fetch existing student data
$result = mysqli_query($conn, "SELECT * FROM students WHERE id=$id");
$row = mysqli_fetch_assoc($result);

// Update logic
if (isset($_POST['update'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];

    $sql = "UPDATE students
            SET name='$name', email='$email'
            WHERE id=$id";

    mysqli_query($conn, $sql);

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Edit Student</h2>

<form method="POST">

    <label>Name:</label><br>
    <input type="text" name="name" value="<?php echo $row['name']; ?>" required>
    <br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?php echo $row['email']; ?>" required>
    <br><br>

    <button type="submit" name="update">Update Student</button>

</form>

<br>
<a href="index.php">⬅ Back</a>

</body>
</html>
