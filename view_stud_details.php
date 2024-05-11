<?php
header("Content-Security-Policy: default-src 'self'; script-src 'self' https://ajax.googleapis.com https://maxcdn.bootstrapcdn.com; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://maxcdn.bootstrapcdn.com; img-src 'self' data:; object-src 'none';");
session_start();

// Redirect if not logged in
if (!isset($_SESSION['email'])) {
    header('Location: login_stud.php');
    exit;
}

include('config.php');

// Fetch Students
$result = $conn->query("SELECT * FROM students");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        .container {
            margin-top: 20px;
        }
        .table {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Student Details</h1>
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Matric No</th>
                    <th>Current Address</th>
                    <th>Home Address</th>
                    <th>Email</th>
                    <th>Mobile Phone No</th>
                    <th>Home Phone No</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['matricNo']); ?></td>
                    <td><?php echo htmlspecialchars($row['currentAddress']); ?></td>
                    <td><?php echo htmlspecialchars($row['homeAddress']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['mobilePhoneNo']); ?></td>
                    <td><?php echo htmlspecialchars($row['homePhoneNo']); ?></td>
                    <td>
                        <form action="edit_student.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="btn btn-primary">Edit</button>
                        </form>
                        <a href="delete_student.php?id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this?');">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="stud_details.php" class="btn btn-secondary">Add New Student</a>
    </div>
</body>
</html>
