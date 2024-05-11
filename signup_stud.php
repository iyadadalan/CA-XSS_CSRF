<?php
    header("Content-Security-Policy: default-src 'self'; script-src 'self' https://ajax.googleapis.com https://maxcdn.bootstrapcdn.com; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://maxcdn.bootstrapcdn.com; img-src 'self' data:; object-src 'none';");
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include('config.php');
    
        $email = $_POST['email'];
        $password = $_POST['password'];
        $passwordHashed = md5($password);

        $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $passwordHashed);
        
        if ($stmt->execute()) {
            $_SESSION['email'] = $email;
            header("Location: login_stud.php");
        } else {
            echo "Error: " . $conn->error;
        }
    
        $stmt->close();
        $conn->close();
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
    <style>
        .signup-container {
            width: 380px;
            margin: auto;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5 signup-container">
        <h2 class="mb-4">Sign up</h2>
        <form action="signup_stud.php" method="post">
            <div class="form-group">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required autocomplete="off">
            </div><br>
            <button type="submit" class="btn btn-primary">Sign Up</button>
        </form>
        <div class="container mt-3">
            <p>Already have an account?<a href="login_stud.php" class="btn btn-link">Log in here</a></p>
        </div>  
    </div>
</body>
</html>
