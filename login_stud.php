<?php
    header("Content-Security-Policy: default-src 'self'; script-src 'self' https://ajax.googleapis.com https://maxcdn.bootstrapcdn.com; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://maxcdn.bootstrapcdn.com; img-src 'self' data:; object-src 'none';");
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include('config.php');

        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            
            if (md5($password) == $user['password']) {
                $_SESSION['email'] = $email;

                // Set a secure HttpOnly session cookie
                setcookie(session_name(), session_id(), [
                    'expires' => time() + 3600, // 1 hour for example
                    'path' => '/',
                    'domain' => $_SERVER['HTTP_HOST'],
                    'secure' => true, // ensures the cookie is sent over HTTPS
                    'httponly' => true, // makes the cookie inaccessible to JavaScript
                    'samesite' => 'Strict' // strict same-site policy to avoid CSRF
                ]);

                header("Location: stud_details.php");
                exit;
            } else {
                $_SESSION['login_error'] = "Invalid email or password";
            }
        } else {
            $_SESSION['login_error'] = "Invalid email or password";
        }

        $stmt->close();
        $conn->close();
        
        header("Location: login_stud.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Login</title>
    <style>
        .login-container {
            width: 380px;
            margin: auto;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5 login-container">
        <h2 class="mb-4">Login</h2>
        <form action="login_stud.php" method="post">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required autocomplete="off">
            </div><br>
            <button type="submit" class="btn btn-primary btn-block">Login</button><br>
        </form>
        <div class="container mt-3">
                <p>Don't have an account?<a href="signup_stud.php" onclick="validate_user()" class="btn btn-link">Sign up here</a></p>
        </div>  
    </div>

    <script src="stud_details.html"></script>
</body>
</html>