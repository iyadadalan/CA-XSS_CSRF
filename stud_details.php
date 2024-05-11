<?php
    header("Content-Security-Policy: default-src 'self'; script-src 'self' https://ajax.googleapis.com https://maxcdn.bootstrapcdn.com; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://maxcdn.bootstrapcdn.com; img-src 'self' data:; object-src 'none';");
    session_start();

    if (!isset($_SESSION['email'])) {
        header('Location: login_stud.php');
        exit;
    }

    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));  // Use bin2hex(random_bytes(32)) for a secure token
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Student Details</title>
    <style>
        form{
            width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h1{
            text-align: center;
            margin-top: 50px;
        }

        .invalid-feedback, .valid-feedback{
            text-align: right;
        } 
    </style>
</head>
<body>
    <h1 class="display-6">Student Details</h1>
    
    <form id="studentForm" class="needs-validation" novalidate action="stud_process.php" method="post" onsubmit="return validate_stud();">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <label for="name" class="form-label" class="alert">Name (Legal/Official):</label>
        <input type="text" class="form-control" id="name" name="name" required>

        <label for="matricNo" class="form-label">Matric No:</label>
        <input type="text" class="form-control" id="matricNo" name="matricNo" required>
     
        <label for="currentAddress" class="form-label">Current Address:</label>
        <textarea id="currentAddress" class="form-control" name="currentAddress" required></textarea>

        <label for="homeAddress" class="form-label">Home Address:</label>
        <textarea id="homeAddress" class="form-control" name="homeAddress" required></textarea>

        <label for="email" class="form-label">Email:</label>
        <input type="email" class="form-control" id="email" name="email" required>

        <label for="mobilePhoneNo" class="form-label">Mobile Phone No:</label>
        <input type="tel" class="form-control" id="mobilePhoneNo" name="mobilePhoneNo" required>

        <label for="homePhoneNo" class="form-label">Home Phone No:</label>
        <input type="tel" class="form-control" id="homePhoneNo" name="homePhoneNo" required>

        <br><button onclick="validate_stud()" id="submit" class="btn btn-primary">Submit</button>
        <a href="view_stud_details.php" class="btn btn-secondary">View Student Details</a><br><br>

        <a href="logout_stud.php" class="btn btn-warning">Logout</a>
        
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="stud_details.js"></script>
    <script>
        const form = document.querySelector("form")

        form.addEventListener('submit', (event) => {
            if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
            }
        form.classList.add('was-validated')
        })
    </script>

</body>
</html>
