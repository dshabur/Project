<?php
session_start();
include 'db.php'; // Подключение к базе данных

// Проверка авторизации пользователя
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Получение данных пользователя из базы данных
$username = $_SESSION['username'];
$stmt = $pdo->prepare("SELECT avatar, username FROM users WHERE username = :username");
$stmt->execute(['username' => $username]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль пользователя</title>
    <link rel="stylesheet" href="profile.css">
    <script src="profile.js" defer></script> <!-- Подключаем profile.js -->
</head>
<body>
    <div class="profile-container">
        <h2>Профиль пользователя</h2>

        <!-- Отображение аватара и имени пользователя -->
        <div class="profile-info">
            <img src="<?php echo $user['avatar']; ?>" alt="Аватар пользователя" class="avatar-large">
            <p>Имя пользователя: <span><?php echo $user['username']; ?></span></p>
            <button onclick="openModal('avatarModal')">Изменить аватар</button>
            <button onclick="openModal('usernameModal')">Изменить имя пользователя</button>
        </div>

        <!-- Список загруженных статей -->
        <div class="user-articles">
            <h3>Ваши статьи</h3>
            <ul>
                <?php
                $stmt = $pdo->prepare("SELECT id, title FROM articles WHERE user_id = :user_id");
                $stmt->execute(['user_id' => $_SESSION['user_id']]);
                while ($article = $stmt->fetch()):
                ?>
                    <li><a href="view_article.php?id=<?php echo $article['id']; ?>"><?php echo htmlspecialchars($article['title']); ?></a></li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>

    <!-- Модальные окна -->
    <div id="avatarModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('avatarModal')">&times;</span>
            <h2>Изменить аватар</h2>
            <form action="update_avatar.php" method="post" enctype="multipart/form-data">
                <input type="file" name="avatar" accept="image/*" required>
                <button type="submit">Загрузить новый аватар</button>
            </form>
        </div>
    </div>

    <div id="usernameModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('usernameModal')">&times;</span>
            <h2>Изменить имя пользователя</h2>
            <form action="update_username.php" method="post">
                <input type="text" name="username" placeholder="Введите новое имя пользователя" required>
                <button type="submit">Сохранить изменения</button>
            </form>
        </div>
    </div>
</body>
</html>

