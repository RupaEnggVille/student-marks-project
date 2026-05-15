<?php
include 'config.php';

$search = $_GET['search'] ?? '';

$result = mysqli_query($conn, "SELECT * FROM students WHERE name LIKE '%$search%'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Results - Student Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Search Results</h2>
<a href="index.php">⬅ Back</a>

<table border="1">
  <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
  </tr>

<?php
if(mysqli_num_rows($result) > 0) {
    // Loop through results
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>".$row['id']."</td>";
        echo "<td>".$row['name']."</td>";
        echo "<td>".$row['email']."</td>";
        echo "</tr>";
    }
} else {
    // No results found
    echo "<tr><td colspan='3' style='text-align:center;'>No students found</td></tr>";
}
?>

</table>

</body>
</html>
