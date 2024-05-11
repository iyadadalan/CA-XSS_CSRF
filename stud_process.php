<?php
    session_start();
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('CSRF token mismatch.');
    }

    include('config.php');

    $name = htmlspecialchars($_POST['name']);
    $matricNo = htmlspecialchars($_POST['matricNo']);
    $currentAddress = htmlspecialchars($_POST['currentAddress']);
    $homeAddress = htmlspecialchars($_POST['homeAddress']);
    $email = htmlspecialchars($_POST['email']);
    $mobilePhoneNo = htmlspecialchars($_POST['mobilePhoneNo']);
    $homePhoneNo = htmlspecialchars($_POST['homePhoneNo']);

    $stmt = $conn->prepare("INSERT INTO students (name, matricNo, currentAddress, homeAddress, email, mobilePhoneNo, homePhoneNo) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $matricNo, $currentAddress, $homeAddress, $email, $mobilePhoneNo, $homePhoneNo);

    $stmt->execute();

    echo "Student details saved.";

    $stmt->close();
    $conn->close();

    header("Location: view_stud_details.php");
    exit();
?>