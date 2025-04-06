<?php
require_once('../../../config/constants.php');
require_once('../../../config/db_config.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . PUBLIC_URL . "login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $firstName = trim($_POST['first_name']);
    $lastName = trim($_POST['last_name']);
    $aboutMe = trim($_POST['about_me']);
    $profilePicName = $_SESSION['profile_pic']; // fallback to existing one

    // Handle profile picture upload if one was submitted
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profile_pic']['tmp_name'];
        $fileName = basename($_FILES['profile_pic']['name']);
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileExt, $allowedExts)) {
            $newFileName = uniqid('pfp_', true) . '.' . $fileExt;
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . BASE_URL . 'assets/img/profiles/';
            $destPath = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $profilePicName = $newFileName;
            } else {
                die('Failed to move uploaded file.');
            }
        } else {
            die('Invalid file type. Allowed: jpg, jpeg, png, gif.');
        }
    }

    try {
        // Update database
        $stmt = $pdo->prepare("UPDATE users SET first_name = :first_name, last_name = :last_name, about_me = :about_me, profile_pic = :profile_pic WHERE id = :id");
        $stmt->execute([
            ':first_name' => $firstName,
            ':last_name' => $lastName,
            ':about_me' => $aboutMe,
            ':profile_pic' => $profilePicName,
            ':id' => $userId
        ]);

        // Update session variables
        $_SESSION['first_name'] = $firstName;
        $_SESSION['last_name'] = $lastName;
        $_SESSION['about_me'] = $aboutMe;
        $_SESSION['profile_pic'] = $profilePicName;

        header("Location: " . USER_URL . "profile.php?update=success");
        exit();
    } catch (PDOException $e) {
        echo "Update failed: " . $e->getMessage();
    }
}
