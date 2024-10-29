<?php
session_start();
include 'db.php'; // Подключение к базе данных

// Проверка авторизации пользователя
$isLoggedIn = isset($_SESSION['username']);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eduHUB</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <header class="navbar">
        <div class="navbar-logo">
            <a href="index.php">Логотип</a>
        </div>
        
        <div class="navbar-profile">
            <?php if ($isLoggedIn): ?>
                <!-- Профиль авторизованного пользователя -->
                <div class="profile">
                    <img src="path/to/avatar.jpg" alt="Аватар" class="avatar">
                    <span><?php echo $_SESSION['username']; ?></span>
                    <a href="logout.php" class="logout-button">Выйти</a>
                </div>
            <?php else: ?>
                
                <a href="login.php" class="auth-button">Вход</a>
                <a href="register.php" class="auth-button">Регистрация</a>
            <?php endif; ?>
        </div>
    </header>

    <div class="container">
        <h1>Добро пожаловать на <span class="highlight">eduHUB!</span></h1>

        <!-- Поле поиска -->
        <div class="search-container">
            <input type="text" id="search" placeholder="Поиск курсов или статей..." aria-label="Поиск курсов или статей">
            <button class="search-button" onclick="checkAuthorization('search')">🔍</button>
        </div>

        <!-- Кнопка для начала -->
        <button class="start-button" onclick="checkAuthorization('start')">Давайте начнём</button>
    </div>

    <!-- Модальное окно для сообщения об ошибке авторизации -->
    <div id="authModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Требуется авторизация</h2>
            <p>Чтобы продолжить, пожалуйста, войдите в систему или зарегистрируйтесь.</p>
            <div class="modal-buttons">
                <a href="login.php" class="auth-button">Вход</a>
                <a href="register.php" class="auth-button">Регистрация</a>
            </div>
        </div>
    </div>

    <!-- Контейнер для кнопки "Поделиться" -->
    <div class="share-button-container">
        <button class="share-toggle" onclick="toggleShareOptions()">🔗</button>
        <div class="share-options">
            <a href="#" title="Поделиться в Facebook">📘</a>
            <a href="#" title="Поделиться в Twitter">🐦</a>
            <a href="#" title="Поделиться в WhatsApp">📱</a>
        </div>
    </div>

    <script>
        // Получаем переменную авторизации из PHP
        const isLoggedIn = <?php echo json_encode($isLoggedIn); ?>;

        // Функция для проверки авторизации
        function checkAuthorization(action) {
            if (!isLoggedIn) {
                // Показать модальное окно, если пользователь не авторизован
                document.getElementById('authModal').style.display = 'block';
            } else {
                if (action === 'start') {
                    window.location.href = 'courses.php';
                } else if (action === 'search') {
                    const query = document.getElementById('search').value;
                    alert(`Вы искали: ${query}`);
                }
            }
        }

        // Функция для открытия и закрытия модального окна
        function closeModal() {
            document.getElementById('authModal').style.display = 'none';
        }

        // Функция для показа/скрытия опций "поделиться"
        function toggleShareOptions() {
            document.querySelector('.share-options').classList.toggle('show');
        }

        // Закрытие модального окна при клике вне его
        window.onclick = function(event) {
            const modal = document.getElementById('authModal');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        };
    </script>
</body>
</html>
