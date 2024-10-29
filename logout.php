<?php
session_start();
session_destroy(); // Завершаем сессию
header("Location: index.php"); // Возвращаем пользователя на главную страницу
exit();
?>
