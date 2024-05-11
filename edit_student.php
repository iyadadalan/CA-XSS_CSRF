<?php
    header("Content-Security-Policy: default-src 'self'; script-src 'self' https://ajax.googleapis.com https://maxcdn.bootstrapcdn.com; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://maxcdn.bootstrapcdn.com; img-src 'self' data:; object-src 'none';");
    session_start();

    // Redirect if not logged in
    if (!isset($_SESSION['email'])) {
        header('Location: login_stud.php');
        exit;
    }

    include('config.php');

    // Generate CSRF token if not already set
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));  // Use bin2hex(random_bytes(32)) for a secure token
    }

    // Fetch the student's current details if there's an ID in the session or being posted
    if (isset($_POST['id'])) {
        $_SESSION['current_edit_id'] = $_POST['id'];
    }

    if (isset($_SESSION['current_edit_id'])) {
        $id = $_SESSION['current_edit_id'];

        // Verify CSRF token on form submission
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die('CSRF token validation failed.');
            }
            
            $name = $_POST['name'];
            $matricNo = $_POST['matricNo'];
            $currentAddress = $_POST['currentAddress'];
            $homeAddress = $_POST['homeAddress'];
            $email = $_POST['email'];
            $mobilePhoneNo = $_POST['mobilePhoneNo'];
            $homePhoneNo = $_POST['homePhoneNo'];

            $stmt = $conn->prepare("UPDATE students SET name = ?, matricNo = ?, currentAddress = ?, homeAddress = ?, email = ?, mobilePhoneNo = ?, homePhoneNo = ? WHERE id = ?");
            $stmt->bind_param("sssssssi", $name, $matricNo, $currentAddress, $homeAddress, $email, $mobilePhoneNo, $homePhoneNo, $id);
            $stmt->execute();
            $stmt->close();
            
            header('Location: view_stud_details.php'); // Redirect to avoid re-submission
            exit;
        }

        // Load the form with the current student data
        $stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $student = $result->fetch_assoc();
        }
        $stmt->close();
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="stud_details.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h1>Edit Student Details</h1>
        <form action="edit_student.php" method="post" onsubmit="return validate_stud();">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <input type="hidden" name="update" value="1">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="mb-3">
                <label class="form-label">Name:</label>
                <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($student['name']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Matric No:</label>
                <input type="text" class="form-control" name="matricNo" value="<?php echo htmlspecialchars($student['matricNo']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Current Address:</label>
                <textarea class="form-control" name="currentAddress" required><?php echo htmlspecialchars($student['currentAddress']); ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Home Address:</label>
                <textarea class="form-control" name="homeAddress" required><?php echo htmlspecialchars($student['homeAddress']); ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Email:</label>
                <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Mobile Phone No:</label>
                <input type="text" class="form-control" name="mobilePhoneNo" value="<?php echo htmlspecialchars($student['mobilePhoneNo']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Home Phone No:</label>
                <input type="text" class="form-control" name="homePhoneNo" value="<?php echo htmlspecialchars($student['homePhoneNo']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="view_stud_details.php" class="btn btn-secondary">Back to List</a>
        </form>
    </div>
</body>
</html>
