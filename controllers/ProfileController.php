<?php
/**
 * Контроллер для работы с профилем пользователя
 */
class ProfileController
{
    private $userModel;
    private $reservationModel;
    private $reviewModel;
    
    public function __construct()
    {
        // Проверка авторизации
        if (!isset($_SESSION['user_id'])) {
            Router::redirect('/login');
            exit;
        }
        
        $this->userModel = new User();
        $this->reservationModel = new Reservation();
        $this->reviewModel = new Review();
    }
    
    /**
     * Отображение личного кабинета
     */
    public function index()
    {
        $userId = $_SESSION['user_id'];
        
        // Получение данных пользователя
        $user = $this->userModel->find($userId);
        
        if (!$user) {
            Router::redirect('/logout');
            return;
        }
        
        // Получение активных бронирований пользователя
        $activeReservations = $this->reservationModel->getUserReservations($userId, 'active');
        
        // Получение истории бронирований
        $reservationHistory = $this->reservationModel->getUserReservations($userId, 'completed,cancelled');
        
        // Получение отзывов пользователя
        $reviews = $this->reviewModel->getUserReviews($userId);
        
        require_once TEMPLATE_PATH . '/profile/index.php';
    }
    
    /**
     * Отображение формы редактирования профиля
     */
    public function editForm()
    {
        $userId = $_SESSION['user_id'];
        
        // Получение данных пользователя
        $user = $this->userModel->find($userId);
        
        if (!$user) {
            Router::redirect('/logout');
            return;
        }
        
        // Передача сообщения об ошибке или успехе, если есть
        $error = isset($_SESSION['profile_error']) ? $_SESSION['profile_error'] : '';
        $success = isset($_SESSION['profile_success']) ? $_SESSION['profile_success'] : '';
        unset($_SESSION['profile_error'], $_SESSION['profile_success']);
        
        require_once TEMPLATE_PATH . '/profile/edit.php';
    }
    
    /**
     * Обработка обновления профиля
     */
    public function update()
    {
        // Если метод не POST, перенаправляем в профиль
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Router::redirect('/profile');
            return;
        }
        
        $userId = $_SESSION['user_id'];
        
        // Получение данных из формы
        $firstName = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);
        $lastName = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
        $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        
        // Проверка обязательных полей
        if (empty($firstName) || empty($lastName) || empty($phone) || empty($email)) {
            $_SESSION['profile_error'] = 'Все поля обязательны для заполнения';
            Router::redirect('/profile/edit');
            return;
        }
        
        // Получение текущих данных пользователя
        $user = $this->userModel->find($userId);
        
        if (!$user) {
            Router::redirect('/logout');
            return;
        }
        
        // Проверка изменения email
        if ($email !== $user['email']) {
            // Проверка уникальности email
            if ($this->userModel->findByEmail($email)) {
                $_SESSION['profile_error'] = 'Пользователь с таким email уже существует';
                Router::redirect('/profile/edit');
                return;
            }
        }
        
        // Обновление данных профиля
        $result = $this->userModel->updateProfile($userId, [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'phone' => $phone,
            'email' => $email
        ]);
        
        if (!$result) {
            $_SESSION['profile_error'] = 'Ошибка при обновлении профиля';
            Router::redirect('/profile/edit');
            return;
        }
        
        // Обновление имени пользователя в сессии
        $_SESSION['user_name'] = $firstName . ' ' . $lastName;
        
        $_SESSION['profile_success'] = 'Профиль успешно обновлен';
        Router::redirect('/profile/edit');
    }
    
    /**
     * Отображение формы смены пароля
     */
    public function passwordForm()
    {
        $userId = $_SESSION['user_id'];
        
        // Получение данных пользователя
        $user = $this->userModel->find($userId);
        
        if (!$user) {
            Router::redirect('/logout');
            return;
        }
        
        // Передача сообщения об ошибке или успехе, если есть
        $error = isset($_SESSION['password_error']) ? $_SESSION['password_error'] : '';
        $success = isset($_SESSION['password_success']) ? $_SESSION['password_success'] : '';
        unset($_SESSION['password_error'], $_SESSION['password_success']);
        
        require_once TEMPLATE_PATH . '/profile/password.php';
    }
    
    /**
     * Обработка смены пароля
     */
    public function changePassword()
    {
        // Если метод не POST, перенаправляем в профиль
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Router::redirect('/profile');
            return;
        }
        
        $userId = $_SESSION['user_id'];
        
        // Получение данных из формы
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $passwordConfirm = $_POST['password_confirm'] ?? '';
        
        // Проверка обязательных полей
        if (empty($currentPassword) || empty($newPassword) || empty($passwordConfirm)) {
            $_SESSION['password_error'] = 'Все поля обязательны для заполнения';
            Router::redirect('/profile/password');
            return;
        }
        
        // Проверка совпадения паролей
        if ($newPassword !== $passwordConfirm) {
            $_SESSION['password_error'] = 'Новые пароли не совпадают';
            Router::redirect('/profile/password');
            return;
        }
        
        // Проверка сложности пароля
        if (strlen($newPassword) < 8) {
            $_SESSION['password_error'] = 'Пароль должен содержать не менее 8 символов';
            Router::redirect('/profile/password');
            return;
        }
        
        // Изменение пароля
        $result = $this->userModel->changePassword($userId, $currentPassword, $newPassword);
        
        if (!$result) {
            $_SESSION['password_error'] = 'Неверный текущий пароль';
            Router::redirect('/profile/password');
            return;
        }
        
        $_SESSION['password_success'] = 'Пароль успешно изменен';
        Router::redirect('/profile/password');
    }
    
    /**
     * Отображение списка бронирований пользователя
     */
    public function reservations()
    {
        $userId = $_SESSION['user_id'];
        
        // Получение всех бронирований пользователя
        $reservations = $this->reservationModel->getUserReservations($userId);
        
        require_once TEMPLATE_PATH . '/profile/reservations.php';
    }
    
    /**
     * Отображение деталей бронирования
     */
    public function reservationDetails($id)
    {
        $userId = $_SESSION['user_id'];
        
        // Получение данных бронирования
        $reservation = $this->reservationModel->getReservationDetails($id);
        
        // Проверка доступа
        if (!$reservation || $reservation['user_id'] != $userId) {
            Router::redirect('/profile/reservations');
            return;
        }
        
        require_once TEMPLATE_PATH . '/profile/reservation-details.php';
    }
    
    /**
     * Отмена бронирования
     */
    public function cancelReservation($id)
    {
        $userId = $_SESSION['user_id'];
        
        // Получение данных бронирования
        $reservation = $this->reservationModel->find($id);
        
        // Проверка доступа
        if (!$reservation || $reservation['user_id'] != $userId) {
            Router::redirect('/profile/reservations');
            return;
        }
        
        // Проверка возможности отмены (например, за 24 часа до начала)
        $startDate = strtotime($reservation['start_date']);
        $now = time();
        $hoursLeft = ($startDate - $now) / 3600;
        
        if ($hoursLeft < 24) {
            $_SESSION['reservation_error'] = 'Бронирование невозможно отменить менее чем за 24 часа до начала';
            Router::redirect('/profile/reservation/' . $id);
            return;
        }
        
        // Отмена бронирования
        $result = $this->reservationModel->update($id, [
            'status' => 'cancelled',
            'cancelled_at' => date('Y-m-d H:i:s')
        ]);
        
        if (!$result) {
            $_SESSION['reservation_error'] = 'Ошибка при отмене бронирования';
            Router::redirect('/profile/reservation/' . $id);
            return;
        }
        
        $_SESSION['reservation_success'] = 'Бронирование успешно отменено';
        Router::redirect('/profile/reservations');
    }
    
    /**
     * Отображение списка отзывов пользователя
     */
    public function reviews()
    {
        $userId = $_SESSION['user_id'];
        
        // Получение отзывов пользователя
        $reviews = $this->reviewModel->getUserReviews($userId);
        
        require_once TEMPLATE_PATH . '/profile/reviews.php';
    }
}
