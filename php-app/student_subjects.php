<?php
include 'config.php';

$student_id = (int)$_GET['id'];

// get student details
$student = mysqli_fetch_assoc(
    mysqli_query($conn,
    "SELECT * FROM students WHERE id=$student_id")
);

// ADD SUBJECT MARKS
if (isset($_POST['add'])) {

    $subject = $_POST['subject'];
    $marks = $_POST['marks'];

    mysqli_query($conn,
        "INSERT INTO subjects(student_id, subject_name, marks)
         VALUES($student_id, '$subject', '$marks')"
    );

    header("Location: student_subjects.php?id=$student_id");
    exit();
}

// DELETE SUBJECT
if (isset($_GET['delete'])) {

    $delete_id = (int)$_GET['delete'];

    mysqli_query($conn,
        "DELETE FROM subjects WHERE id=$delete_id"
    );

    header("Location: student_subjects.php?id=$student_id");
    exit();
}

// EDIT SUBJECT
$edit_data = null;

if (isset($_GET['edit'])) {

    $edit_id = (int)$_GET['edit'];

    $edit_result = mysqli_query($conn,
        "SELECT * FROM subjects WHERE id=$edit_id"
    );

    $edit_data = mysqli_fetch_assoc($edit_result);
}

// UPDATE SUBJECT
if (isset($_POST['update'])) {

    $subject_id = $_POST['subject_id'];

    $subject = $_POST['subject'];
    $marks = $_POST['marks'];

    mysqli_query($conn,
        "UPDATE subjects
         SET subject_name='$subject',
             marks='$marks'
         WHERE id=$subject_id"
    );

    header("Location: student_subjects.php?id=$student_id");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Student Subjects</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container mt-5">

<div class="card shadow p-4">

<h2 class="text-center mb-4">
    Subjects of <?php echo $student['name']; ?>
</h2>

<!-- ADD / EDIT FORM -->

<form method="POST">

<input type="hidden"
       name="subject_id"
       value="<?php echo $edit_data['id'] ?? ''; ?>">

<div class="mb-3">

<label class="text-start d-block">Subject Name</label>

<input type="text"
       class="form-control"
       name="subject"
       value="<?php echo $edit_data['subject_name'] ?? ''; ?>"
       required>

</div>

<div class="mb-3">

<label class="text-start d-block">Marks</label>

<input type="number"
       class="form-control"
       name="marks"
       value="<?php echo $edit_data['marks'] ?? ''; ?>"
       required>

</div>

<?php if ($edit_data) { ?>

<button type="submit"
        name="update"
        class="btn btn-warning">

    Update Marks
</button>

<a href="student_subjects.php?id=<?php echo $student_id; ?>"
   class="btn btn-secondary">

   Cancel
</a>

<?php } else { ?>

<button type="submit"
        name="add"
        class="btn btn-success">

    Add Marks
</button>

<?php } ?>

</form>

<hr>

<!-- DISPLAY SUBJECTS -->

<table class="table table-bordered custom-table">

<thead>

<tr>

<th>ID</th>
<th>Subject</th>
<th>Marks</th>
<th>Action</th>

</tr>

</thead>

<tbody>

<?php

$result = mysqli_query($conn,
    "SELECT * FROM subjects WHERE student_id=$student_id"
);

$total = 0;
$count = 0;

while ($row = mysqli_fetch_assoc($result)) {

    $total += $row['marks'];
    $count++;
?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['subject_name']; ?></td>

<td><?php echo $row['marks']; ?></td>

<td>

<a class="btn btn-sm btn-primary"
   href="student_subjects.php?id=<?php echo $student_id; ?>&edit=<?php echo $row['id']; ?>">

   Edit
</a>

<a class="btn btn-sm btn-danger"
   href="student_subjects.php?id=<?php echo $student_id; ?>&delete=<?php echo $row['id']; ?>"
   onclick="return confirm('Delete subject?')">

   Delete
</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

<?php

$percentage = 0;
$grade = "N/A";

if ($count > 0) {

    $percentage = ($total / ($count * 100)) * 100;

    if ($percentage >= 80) {
        $grade = "A";
    }
    elseif ($percentage >= 60) {
        $grade = "B";
    }
    else {
        $grade = "C";
    }
}
?>

<div class="mt-4">

<h4>Total Marks: <?php echo $total; ?></h4>

<h4>
Percentage:
<?php echo round($percentage, 2); ?>%
</h4>

<h4>
Grade:
<?php echo $grade; ?>
</h4>

</div>

<br>

<a href="index.php"
   class="btn btn-secondary">

   Back
</a>

</div>

</div>

</body>
</html>
