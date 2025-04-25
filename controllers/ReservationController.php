<?php
/**
 * Контроллер для работы с бронированиями
 */
class ReservationController
{
    private $reservationModel;
    private $carModel;
    
    public function __construct()
    {
        $this->reservationModel = new Reservation();
        $this->carModel = new Car();
    }
    
    /**
     * Отображение формы бронирования автомобиля
     */
    public function bookForm($id)
    {
        // Проверка авторизации
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['login_redirect'] = "/car/{$id}/book";
            Router::redirect('/login');
            return;
        }
        
        // Получение данных автомобиля
        $car = $this->carModel->findWithCategory($id);
        
        if (!$car) {
            // Автомобиль не найден
            header('HTTP/1.0 404 Not Found');
            require_once TEMPLATE_PATH . '/404.php';
            return;
        }
        
        // Получение доступных дат (можно реализовать более сложную логику)
        $availableDates = $this->getAvailableDates($id);
        
        // Получение дополнительных опций
        $options = [
            'insurance' => [
                'name' => 'Страхование ОСАГО',
                'price' => 1000,
                'description' => 'Полное страхование автомобиля на период аренды (1000₽ в день)'
            ],
            'baby_seat' => [
                'name' => 'Детское кресло',
                'price' => 500,
                'description' => 'Установка детского кресла (500₽ в день)'
            ],
            'additional_driver' => [
                'name' => 'Дополнительный водитель',
                'price' => 800,
                'description' => 'Разрешение на управление автомобилем дополнительным водителем (800₽ в день)'
            ],
            'gps' => [
                'name' => 'GPS-навигатор',
                'price' => 300,
                'description' => 'Предоставление GPS-навигатора (300₽ в день)'
            ]
        ];
        
        // Передача сообщения об ошибке, если есть
        $error = isset($_SESSION['booking_error']) ? $_SESSION['booking_error'] : '';
        unset($_SESSION['booking_error']);
        
        require_once TEMPLATE_PATH . '/booking/form.php';
    }
    
    /**
     * Обработка бронирования автомобиля
     */
    public function book($id)
    {
        // Если метод не POST, перенаправляем на форму
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Router::redirect("/car/{$id}/book");
            return;
        }
        
        // Проверка авторизации
        if (!isset($_SESSION['user_id'])) {
            Router::redirect('/login');
            return;
        }
        
        // Получение данных из формы
        $startDate = filter_input(INPUT_POST, 'start_date', FILTER_SANITIZE_STRING);
        $endDate = filter_input(INPUT_POST, 'end_date', FILTER_SANITIZE_STRING);
        $pickupLocation = filter_input(INPUT_POST, 'pickup_location', FILTER_SANITIZE_STRING);
        $returnLocation = filter_input(INPUT_POST, 'return_location', FILTER_SANITIZE_STRING);
        $specialRequests = filter_input(INPUT_POST, 'special_requests', FILTER_SANITIZE_STRING);
        
        // Получение выбранных опций
        $options = [
            'insurance' => isset($_POST['insurance']),
            'baby_seat' => isset($_POST['baby_seat']),
            'additional_driver' => isset($_POST['additional_driver']),
            'gps' => isset($_POST['gps'])
        ];
        
        // Проверка обязательных полей
        if (empty($startDate) || empty($endDate) || empty($pickupLocation)) {
            $_SESSION['booking_error'] = 'Все обязательные поля должны быть заполнены';
            Router::redirect("/car/{$id}/book");
            return;
        }
        
        // Проверка корректности дат
        $today = date('Y-m-d');
        if ($startDate < $today) {
            $_SESSION['booking_error'] = 'Дата начала аренды не может быть в прошлом';
            Router::redirect("/car/{$id}/book");
            return;
        }
        
        if ($endDate < $startDate) {
            $_SESSION['booking_error'] = 'Дата окончания аренды не может быть раньше даты начала';
            Router::redirect("/car/{$id}/book");
            return;
        }
        
        // Получение данных автомобиля
        $car = $this->carModel->find($id);
        
        if (!$car) {
            $_SESSION['booking_error'] = 'Выбранный автомобиль не найден';
            Router::redirect("/catalog");
            return;
        }
        
        // Проверка доступности автомобиля на выбранные даты
        if (!$this->carModel->isAvailable($id, $startDate, $endDate)) {
            $_SESSION['booking_error'] = 'Автомобиль недоступен на выбранные даты';
            Router::redirect("/car/{$id}/book");
            return;
        }
        
        // Подготовка данных для бронирования
        $reservationData = [
            'car_id' => $id,
            'user_id' => $_SESSION['user_id'],
            'start_date' => $startDate,
            'end_date' => $endDate,
            'options' => $options,
            'pickup_location' => $pickupLocation,
            'return_location' => !empty($returnLocation) ? $returnLocation : $pickupLocation,
            'special_requests' => $specialRequests
        ];
        
        // Создание бронирования
        $reservationId = $this->reservationModel->createReservation($reservationData);
        
        if (!$reservationId) {
            $_SESSION['booking_error'] = 'Ошибка при создании бронирования';
            Router::redirect("/car/{$id}/book");
            return;
        }
        
        // Перенаправление на страницу подтверждения бронирования
        Router::redirect("/reservation/{$reservationId}");
    }
    
    /**
     * Отображение списка бронирований пользователя
     */
    public function index()
    {
        // Проверка авторизации
        if (!isset($_SESSION['user_id'])) {
            Router::redirect('/login');
            return;
        }
        
        // Получение списка бронирований пользователя
        $reservations = $this->reservationModel->getUserReservations($_SESSION['user_id']);
        
        require_once TEMPLATE_PATH . '/booking/list.php';
    }
    
    /**
     * Отображение детальной информации о бронировании
     */
    public function show($id)
    {
        // Проверка авторизации
        if (!isset($_SESSION['user_id'])) {
            Router::redirect('/login');
            return;
        }
        
        // Получение данных бронирования
        $reservation = $this->reservationModel->getReservationDetails($id);
        
        // Проверка доступа к бронированию
        if (!$reservation || ($reservation['user_id'] != $_SESSION['user_id'] && $_SESSION['user_role'] != 'admin')) {
            header('HTTP/1.0 404 Not Found');
            require_once TEMPLATE_PATH . '/404.php';
            return;
        }
        
        // Передача сообщения об успехе или ошибке, если есть
        $success = isset($_SESSION['reservation_success']) ? $_SESSION['reservation_success'] : '';
        $error = isset($_SESSION['reservation_error']) ? $_SESSION['reservation_error'] : '';
        unset($_SESSION['reservation_success'], $_SESSION['reservation_error']);
        
        require_once TEMPLATE_PATH . '/booking/details.php';
    }
    
    /**
     * Отмена бронирования
     */
    public function cancel($id)
    {
        // Проверка авторизации
        if (!isset($_SESSION['user_id'])) {
            Router::redirect('/login');
            return;
        }
        
        // Получение данных бронирования
        $reservation = $this->reservationModel->find($id);
        
        // Проверка доступа к бронированию
        if (!$reservation || ($reservation['user_id'] != $_SESSION['user_id'] && $_SESSION['user_role'] != 'admin')) {
            header('HTTP/1.0 404 Not Found');
            require_once TEMPLATE_PATH . '/404.php';
            return;
        }
        
        // Проверка возможности отмены (только для активных или ожидающих бронирований)
        if ($reservation['status'] != 'active' && $reservation['status'] != 'pending') {
            $_SESSION['reservation_error'] = 'Невозможно отменить бронирование с текущим статусом';
            Router::redirect("/reservation/{$id}");
            return;
        }
        
        // Проверка времени до начала бронирования (если оно активное)
        if ($reservation['status'] == 'active') {
            $startDate = strtotime($reservation['start_date']);
            $now = time();
            $hoursLeft = ($startDate - $now) / 3600;
            
            if ($hoursLeft < 24) {
                $_SESSION['reservation_error'] = 'Невозможно отменить бронирование менее чем за 24 часа до начала';
                Router::redirect("/reservation/{$id}");
                return;
            }
        }
        
        // Отмена бронирования
        $result = $this->reservationModel->update($id, [
            'status' => 'cancelled',
            'cancelled_at' => date('Y-m-d H:i:s')
        ]);
        
        if (!$result) {
            $_SESSION['reservation_error'] = 'Ошибка при отмене бронирования';
            Router::redirect("/reservation/{$id}");
            return;
        }
        
        $_SESSION['reservation_success'] = 'Бронирование успешно отменено';
        
        // Перенаправление в зависимости от роли пользователя
        if ($_SESSION['user_role'] == 'admin') {
            Router::redirect("/admin/reservations");
        } else {
            Router::redirect("/profile/reservations");
        }
    }
    
    /**
     * Получение доступных дат для бронирования
     */
    private function getAvailableDates($carId)
    {
        // Получение всех активных бронирований для автомобиля
        $sql = "SELECT start_date, end_date FROM reservations 
                WHERE car_id = ? AND status = 'active'
                ORDER BY start_date";
        
        $bookings = $this->reservationModel->db->fetchAll($sql, [$carId]);
        
        // Создание массива занятых дат
        $bookedDates = [];
        foreach ($bookings as $booking) {
            $start = new DateTime($booking['start_date']);
            $end = new DateTime($booking['end_date']);
            $end->modify('+1 day'); // включая день окончания
            
            $interval = new DateInterval('P1D'); // интервал в 1 день
            $period = new DatePeriod($start, $interval, $end);
            
            foreach ($period as $date) {
                $bookedDates[] = $date->format('Y-m-d');
            }
        }
        
        // Создание массива доступных дат (например, на 2 месяца вперед)
        $availableDates = [];
        $startDate = new DateTime();
        $endDate = new DateTime('+2 months');
        
        $interval = new DateInterval('P1D');
        $period = new DatePeriod($startDate, $interval, $endDate);
        
        foreach ($period as $date) {
            $dateStr = $date->format('Y-m-d');
            if (!in_array($dateStr, $bookedDates)) {
                $availableDates[] = $dateStr;
            }
        }
        
        return $availableDates;
    }
}
