<?php
    session_start();

    if (!isset($_SESSION['email'])) {
        header('Location: login_stud.php');
        exit;
    }

    include('config.php');

    // Handle Delete
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: view_stud_details.php"); // Redirect to the view page after deletion
    exit;
?>