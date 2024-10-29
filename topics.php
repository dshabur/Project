<?php
// Получение параметра курса
$course = isset($_GET['course']) ? intval($_GET['course']) : 1;

// Пример тем для курсов (эти данные можно позже извлечь из базы данных)
$topics = [
    1 => ["Математика", "История", "Программирование"],
    2 => ["Физика", "Философия", "Веб-разработка"],
    3 => ["Химия", "Экономика", "Алгоритмы"],
    4 => ["Биология", "Социология", "Машинное обучение"]
];

// Проверка на наличие тем для выбранного курса
$courseTopics = array_key_exists($course, $topics) ? $topics[$course] : [];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Выбор тем | eduHUB</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <div class="container">
        <h1>Темы для <?php echo $course; ?> курса</h1>

        <?php
        // Добавляем описание курса
        $courseDescriptions = [
            1 => "Этот курс охватывает основные концепции и методы.",
            2 => "Курс включает углубленные темы и практические занятия.",
            3 => "Третий курс включает исследования и проектные работы.",
            4 => "Заключительный курс фокусируется на итоговых проектах."
        ];
        ?>
        <p><?php echo $courseDescriptions[$course]; ?></p>

        <?php if (!empty($courseTopics)): ?>
            <ul class="topics-list">
                <?php foreach ($courseTopics as $topic): ?>
                    <li>
                        <a href="articles.php?course=<?php echo $course; ?>&topic=<?php echo urlencode($topic); ?>">
                            <?php echo htmlspecialchars($topic); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Темы для этого курса не найдены.</p>
        <?php endif; ?>

        <!-- Кнопка возврата на страницу выбора курса -->
        <button class="start-button" onclick="window.location.href='courses.php'">Вернуться к выбору курсов</button>
    </div>

   
   

    <script>
        
    </script>
</body>
</html>
