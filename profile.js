document.addEventListener("DOMContentLoaded", function() {
    // Проверка доступных модальных окон
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        console.log("Доступное модальное окно с id:", modal.id);
    });

    // Функции для открытия и закрытия модальных окон
    function openModal(id) {
        const modal = document.getElementById(id);
        if (modal) { // Проверяем, существует ли элемент с таким id
            modal.style.display = 'block';
        } else {
            console.error(`Элемент с id "${id}" не найден`);
        }
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.style.display = 'none';
        } else {
            console.error(`Элемент с id "${id}" не найден`);
        }
    }

    // Закрытие модального окна при клике вне его
    window.onclick = function(event) {
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    };

    // Делаем функции глобально доступными
    window.openModal = openModal;
    window.closeModal = closeModal;
});
