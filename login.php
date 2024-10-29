<?php
session_start();
include 'db.php'; // Подключаем файл с подключением к базе данных

$error = ""; // Переменная для хранения сообщения об ошибке

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Получение данных из формы
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Проверка существования пользователя с данной почтой
    $stmt = $pdo->prepare("SELECT username, password FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    // Проверка пароля
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        header("Location: index.php");
        exit();
    } else {
        $error = "Неверная почта или пароль.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <h2>Вход</h2>
    
    <!-- Вывод ошибки, если есть -->
    <?php if (!empty($error)): ?>
        <div class="error-message">
            <p><?php echo $error; ?></p>
        </div>
    <?php endif; ?>

    <form action="login.php" method="post">
        <input type="email" name="email" placeholder="Почта" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit">Войти</button>
    </form>
</body>
</html>
