<?php
session_start();
include 'config.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if(!isset($_SESSION['student_id'])){
    echo "Student ID not found in session. Please login again.";
    exit();
}

$student_id = $_SESSION['student_id'];

/* SAFE QUERY */
$student = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM students WHERE id=$student_id")
);

$result = mysqli_query($conn,
    "SELECT * FROM subjects WHERE student_id=$student_id"
);

$total = 0;
$count = 0;

$subjects = [];
$marks = [];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>

    <link rel="stylesheet" href="style.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

<div class="card">

<h2>Welcome <?php echo $student['name'] ?? 'Student'; ?></h2>

<table>

<tr>
    <th>Subject</th>
    <th>Marks</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) {

$total += $row['marks'];
$count++;

$subjects[] = $row['subject_name'];
$marks[] = $row['marks'];
?>

<tr>
    <td><?php echo $row['subject_name']; ?></td>
    <td><?php echo $row['marks']; ?></td>
</tr>

<?php } ?>

</table>

<?php
$percentage = ($count > 0) ? ($total / ($count * 100)) * 100 : 0;
?>

<h3>Total: <?php echo $total; ?></h3>
<h3>Percentage: <?php echo round($percentage,2); ?>%</h3>

<canvas id="chart"></canvas>

<script>
new Chart(document.getElementById('chart'), {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($subjects); ?>,
        datasets: [{
            label: 'Marks',
            data: <?php echo json_encode($marks); ?>,
            backgroundColor: 'blue'
        }]
    },
    options: {
        scales: {
            y: { beginAtZero: true, max: 100 }
        }
    }
});
</script>

<br>

<a href="logout.php">Logout</a>

</div>

</body>
</html>
