<?php
session_start();

header("Access-Control-Allow-Origin: *"); // Разрешает запросы из любого источника
header("Access-Control-Allow-Methods: GET, POST, DELETE"); // Разрешенные методы
header("Access-Control-Allow-Headers: Content-Type"); // Заголовки, которые разрешены

// Задаем учетные данные для авторизации
define('USERNAME', 'admin');
define('PASSWORD', 'password');

header('Content-Type: text/plain');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем данные из POST-запроса
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Проверка учетных данных
    if ($username === USERNAME && $password === PASSWORD) {
        $_SESSION['loggedin'] = true;
        echo "Добро пожаловать, $username!";
    } else {
        http_response_code(401); // Не авторизован
        echo "Неверное имя пользователя или пароль.";
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Проверяем, авторизован ли пользователь
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        echo "Вы уже авторизованы!";
    } else {
        // Форма для входа
        echo "Пожалуйста, войдите:\n";
        echo "POST /login с параметрами username и password\n";
    }
} else {
    // Ответ для других методов
    http_response_code(405); // Метод не разрешен
    echo "Метод не поддерживается.";
}

// Для выхода - просто удалить сессию
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    session_destroy();
    echo "Вы вышли из системы.";
}
?>
