<?php
session_start();
include 'db.php';

if (isset($_POST['username']) && isset($_SESSION['username'])) {
    $currentUsername = $_SESSION['username'];
    $newUsername = trim($_POST['username']);

    if (strlen($newUsername) >= 3) {
        // Обновляем имя пользователя в базе данных
        $stmt = $pdo->prepare("UPDATE users SET username = :newUsername WHERE username = :currentUsername");
        $stmt->execute(['newUsername' => $newUsername, 'currentUsername' => $currentUsername]);

        // Обновляем имя пользователя в сессии
        $_SESSION['username'] = $newUsername;
        header("Location: profile.php");
    } else {
        echo "Имя пользователя должно быть не менее 3 символов.";
    }
}
?>
