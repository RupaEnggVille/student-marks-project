<?php
include 'config.php';

$name = $_POST['name'];
$email = $_POST['email'];

$stmt = $conn->prepare("INSERT INTO students (name, email) VALUES (?, ?)");
$stmt->bind_param("ss", $name, $email);

if ($stmt->execute()) {
        #echo "Student Added Successfully<br><br>";
        #echo '<a href="students.php">⬅ Go back</a>';
        header("Location: index.php");
        exit();
} else {
    echo "Error: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
