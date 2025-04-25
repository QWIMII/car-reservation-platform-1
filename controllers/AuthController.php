<?php
/**
 * Контроллер для работы с аутентификацией
 */
class AuthController
{
    private $userModel;
    
    public function __construct()
    {
        $this->userModel = new User();
    }
    
    /**
     * Отображение формы входа
     */
    public function loginForm()
    {
        // Если пользователь уже авторизован, перенаправляем на главную
        if (isset($_SESSION['user_id'])) {
            Router::redirect('/');
            return;
        }
        
        // Передача сообщения об ошибке, если есть
        $error = isset($_SESSION['login_error']) ? $_SESSION['login_error'] : '';
        unset($_SESSION['login_error']);
        
        require_once TEMPLATE_PATH . '/auth/login.php';
    }
    
    /**
     * Обработка входа пользователя
     */
    public function login()
    {
        // Если метод не POST, перенаправляем на форму входа
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Router::redirect('/login');
            return;
        }
        
        // Получение данных из формы
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'] ?? '';
        
        // Проверка обязательных полей
        if (empty($email) || empty($password)) {
            $_SESSION['login_error'] = 'Все поля обязательны для заполнения';
            Router::redirect('/login');
            return;
        }
        
        // Поиск пользователя по email
        $user = $this->userModel->findByEmail($email);
        
        // Проверка существования пользователя и пароля
        if (!$user || !password_verify($password, $user['password'])) {
            $_SESSION['login_error'] = 'Неверный email или пароль';
            Router::redirect('/login');
            return;
        }
        
        // Если аккаунт не активирован
        if ($user['status'] !== 'active') {
            $_SESSION['login_error'] = 'Ваш аккаунт не активирован';
            Router::redirect('/login');
            return;
        }
        
        // Авторизация пользователя
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
        
        // Обновление времени последнего входа
        $this->userModel->update($user['id'], [
            'last_login' => date('Y-m-d H:i:s')
        ]);
        
        // Перенаправление в зависимости от роли
        if ($user['role'] === 'admin') {
            Router::redirect('/admin');
        } else {
            Router::redirect('/profile');
        }
    }
    
    /**
     * Отображение формы регистрации
     */
    public function registerForm()
    {
        // Если пользователь уже авторизован, перенаправляем на главную
        if (isset($_SESSION['user_id'])) {
            Router::redirect('/');
            return;
        }
        
        // Передача сообщения об ошибке, если есть
        $error = isset($_SESSION['register_error']) ? $_SESSION['register_error'] : '';
        unset($_SESSION['register_error']);
        
        require_once TEMPLATE_PATH . '/auth/register.php';
    }
    
    /**
     * Обработка регистрации пользователя
     */
    public function register()
    {
        // Если метод не POST, перенаправляем на форму регистрации
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Router::redirect('/register');
            return;
        }
        
        // Получение данных из формы
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $firstName = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);
        $lastName = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
        $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
        $password = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['password_confirm'] ?? '';
        
        // Проверка обязательных полей
        if (empty($email) || empty($firstName) || empty($lastName) || empty($phone) || empty($password) || empty($passwordConfirm)) {
            $_SESSION['register_error'] = 'Все поля обязательны для заполнения';
            Router::redirect('/register');
            return;
        }
        
        // Проверка совпадения паролей
        if ($password !== $passwordConfirm) {
            $_SESSION['register_error'] = 'Пароли не совпадают';
            Router::redirect('/register');
            return;
        }
        
        // Проверка сложности пароля
        if (strlen($password) < 8) {
            $_SESSION['register_error'] = 'Пароль должен содержать не менее 8 символов';
            Router::redirect('/register');
            return;
        }
        
        // Проверка уникальности email
        if ($this->userModel->findByEmail($email)) {
            $_SESSION['register_error'] = 'Пользователь с таким email уже существует';
            Router::redirect('/register');
            return;
        }
        
        // Хеширование пароля
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        
        // Генерация кода активации
        $activationCode = bin2hex(random_bytes(16));
        
        // Создание нового пользователя
        $userId = $this->userModel->create([
            'email' => $email,
            'password' => $passwordHash,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'phone' => $phone,
            'role' => 'client', // По умолчанию - клиент
            'status' => 'active', // В реальном проекте можно использовать 'pending' и отправлять письмо для активации
            'activation_code' => $activationCode,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        if (!$userId) {
            $_SESSION['register_error'] = 'Ошибка при регистрации пользователя';
            Router::redirect('/register');
            return;
        }
        
        // В реальном проекте здесь можно отправить письмо с ссылкой активации
        // $activationLink = SITE_URL . '/activate/' . $activationCode;
        // mail($email, 'Активация аккаунта', 'Для активации аккаунта перейдите по ссылке: ' . $activationLink);
        
        // Авторизация пользователя
        $_SESSION['user_id'] = $userId;
        $_SESSION['user_role'] = 'client';
        $_SESSION['user_name'] = $firstName . ' ' . $lastName;
        
        // Перенаправление в личный кабинет
        Router::redirect('/profile');
    }
    
    /**
     * Активация аккаунта по коду
     */
    public function activate($code)
    {
        // Поиск пользователя по коду активации
        $user = $this->userModel->findByActivationCode($code);
        
        if (!$user) {
            $_SESSION['login_error'] = 'Неверный код активации';
            Router::redirect('/login');
            return;
        }
        
        // Активация аккаунта
        $this->userModel->update($user['id'], [
            'status' => 'active',
            'activation_code' => null
        ]);
        
        $_SESSION['login_success'] = 'Ваш аккаунт успешно активирован. Теперь вы можете войти.';
        Router::redirect('/login');
    }
    
    /**
     * Выход пользователя
     */
    public function logout()
    {
        // Удаление всех переменных сессии
        $_SESSION = [];
        
        // Если используется cookie для идентификатора сессии
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        
        // Уничтожение сессии
        session_destroy();
        
        // Перенаправление на главную
        Router::redirect('/');
    }
}
