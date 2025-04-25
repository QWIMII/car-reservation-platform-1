<?php
/**
 * Файл конфигурации приложения
 * Содержит основные настройки сайта и переменные среды
 */

// Режим разработки (development) или продакшн (production)
define('APP_ENV', 'development');

// Показывать ошибки в режиме разработки
if (APP_ENV === 'development') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    error_reporting(0);
}

// Базовая конфигурация сайта
define('SITE_NAME', 'MEOWVEST');
define('SITE_URL', 'http://localhost'); // Измените на реальный URL в продакшн
define('BASE_PATH', __DIR__);
define('TEMPLATE_PATH', __DIR__ . '/views');

// Конфигурация базы данных
define('DB_HOST', 'localhost');
define('DB_NAME', 'meowvest_db');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Настройки для загрузки файлов
define('UPLOAD_PATH', __DIR__ . '/public/uploads');
define('MAX_FILE_SIZE', 5242880); // 5MB в байтах
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif']);

// Конфигурация почты
define('MAIL_HOST', 'smtp.example.com');
define('MAIL_PORT', 587);
define('MAIL_USERNAME', 'info@meowvest.com');
define('MAIL_PASSWORD', 'your-password');
define('MAIL_FROM_ADDRESS', 'info@meowvest.com');
define('MAIL_FROM_NAME', 'MEOWVEST');

// Настройки безопасности
define('AUTH_SALT', 'уникальная-строка-для-хеширования');
define('SESSION_LIFETIME', 3600); // Время жизни сессии в секундах (1 час)

// Настройки пагинации
define('ITEMS_PER_PAGE', 12);

// Настройки кэширования
define('CACHE_ENABLED', true);
define('CACHE_PATH', __DIR__ . '/cache');
define('CACHE_LIFETIME', 3600); // Время жизни кэша в секундах (1 час)

// Социальные сети
define('SOCIAL_LINKS', [
    'facebook' => 'https://facebook.com/meowvest',
    'instagram' => 'https://instagram.com/meowvest',
    'twitter' => 'https://twitter.com/meowvest',
    'telegram' => 'https://t.me/meowvest'
]);

// Контактная информация
define('CONTACT_INFO', [
    'phone' => '+7 (999) 123-45-67',
    'email' => 'info@meowvest.com',
    'address' => 'г. Москва, ул. Примерная, д. 123'
]);

// Часы работы
define('WORKING_HOURS', [
    'Понедельник - Пятница: 9:00 - 20:00',
    'Суббота: 10:00 - 18:00',
    'Воскресенье: 10:00 - 16:00'
]);
