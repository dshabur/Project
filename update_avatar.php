<?php
session_start();
include 'db.php';

if (isset($_FILES['avatar']) && isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $avatar = 'avatars/' . basename($_FILES['avatar']['name']);
    
    // Загрузка файла
    if (move_uploaded_file($_FILES['avatar']['tmp_name'], $avatar)) {
        $stmt = $pdo->prepare("UPDATE users SET avatar = :avatar WHERE username = :username");
        $stmt->execute(['avatar' => $avatar, 'username' => $username]);
        header("Location: profile.php");
    } else {
        echo "Ошибка загрузки файла.";
    }
}
?>
