<?php
/**
 * Главный файл приложения
 * Инициализирует сессию, обрабатывает запросы и отображает страницы
 */

// Запуск сессии
session_start();

// Подключение базовых файлов
require_once 'config.php';
require_once 'router.php';
require_once 'database/Database.php';

// Автозагрузка моделей
spl_autoload_register(function($className) {
    $paths = [
        'models/' . $className . '.php',
        'database/models/' . $className . '.php',
        'controllers/' . $className . '.php'
    ];
    
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

// Инициализация маршрутизатора
$router = new Router();

// Определение маршрутов
$router->get('/', 'HomeController@index');
$router->get('/about', 'PageController@about');
$router->get('/contacts', 'PageController@contacts');

// Маршруты для автомобилей
$router->get('/catalog', 'CarController@index');
$router->get('/car/{id}', 'CarController@show');
$router->get('/car/category/{id}', 'CarController@byCategory');

// Маршруты для пользователей
$router->get('/login', 'AuthController@loginForm');
$router->post('/login', 'AuthController@login');
$router->get('/register', 'AuthController@registerForm');
$router->post('/register', 'AuthController@register');
$router->get('/logout', 'AuthController@logout');
$router->get('/profile', 'ProfileController@index');

// Маршруты для бронирований
$router->get('/car/{id}/book', 'ReservationController@bookForm');
$router->post('/car/{id}/book', 'ReservationController@book');
$router->get('/reservations', 'ReservationController@index');
$router->get('/reservation/{id}', 'ReservationController@show');
$router->get('/reservation/{id}/cancel', 'ReservationController@cancel');

// Маршруты для отзывов
$router->post('/car/{id}/review', 'ReviewController@store');

// Маршруты для админки
$router->get('/admin', 'AdminController@index');
$router->get('/admin/cars', 'AdminController@cars');
$router->get('/admin/users', 'AdminController@users');
$router->get('/admin/reservations', 'AdminController@reservations');

// Обработка текущего запроса
$router->dispatch();
