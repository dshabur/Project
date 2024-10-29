<?php
include 'db.php'; // Подключаем файл с подключением к базе данных
session_start();

$errors = []; // Массив для хранения ошибок

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Получение данных из формы
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Проверка длины никнейма
    if (strlen($username) < 3) {
        $errors[] = "Никнейм должен содержать не менее 3 символов.";
    }

    // Проверка никнейма на недопустимые слова
    if (preg_match('/(нежелательное|слово)/i', $username)) {
        $errors[] = "Никнейм содержит недопустимые слова.";
    }

    // Проверка формата почты (только английские буквы и корректная форма)
    if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
        $errors[] = "Почта должна быть написана только на английском.";
    }

    // Проверка уникальности почты и никнейма
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username OR email = :email");
    $stmt->execute(['username' => $username, 'email' => $email]);

    if ($stmt->rowCount() > 0) {
        $errors[] = "Никнейм или почта уже зарегистрированы.";
    }

    // Если ошибок нет, добавляем пользователя в базу данных
    if (empty($errors)) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        $stmt->execute(['username' => $username, 'email' => $email, 'password' => $passwordHash]);

        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <h2>Регистрация</h2>
    
    <!-- Вывод ошибок, если есть -->
    <?php if (!empty($errors)): ?>
        <div class="error-messages">
            <?php foreach ($errors as $error): ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <form action="register.php" method="post">
        <input type="text" name="username" placeholder="Никнейм" required>
        <input type="email" name="email" placeholder="Почта" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit">Зарегистрироваться</button>
    </form>
</body>
</html>
