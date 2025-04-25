<?php
/**
 * Модель для работы с бронированиями
 */
class Reservation extends BaseModel
{
    protected $table = 'reservations';
    
    /**
     * Получение бронирований пользователя с возможностью фильтрации по статусу
     */
    public function getUserReservations($userId, $status = null)
    {
        $sql = "SELECT r.*, c.name as car_name, c.brand as car_brand, c.model as car_model, 
                c.image_url as car_image, c.price_per_day 
                FROM {$this->table} r 
                JOIN cars c ON r.car_id = c.id 
                WHERE r.user_id = ?";
        
        $params = [$userId];
        
        // Если указан статус, добавляем фильтрацию
        if ($status) {
            // Если статус содержит запятые, значит это список статусов
            if (strpos($status, ',') !== false) {
                $statuses = explode(',', $status);
                $placeholders = implode(',', array_fill(0, count($statuses), '?'));
                $sql .= " AND r.status IN ({$placeholders})";
                $params = array_merge([$userId], $statuses);
            } else {
                $sql .= " AND r.status = ?";
                $params[] = $status;
            }
        }
        
        $sql .= " ORDER BY r.created_at DESC";
        
        return $this->db->fetchAll($sql, $params);
    }
    
    /**
     * Получение детальной информации о бронировании
     */
    public function getReservationDetails($id)
    {
        $sql = "SELECT r.*, c.name as car_name, c.brand as car_brand, c.model as car_model, 
                c.image_url as car_image, c.price_per_day, u.first_name, u.last_name, u.email, u.phone 
                FROM {$this->table} r 
                JOIN cars c ON r.car_id = c.id 
                JOIN users u ON r.user_id = u.id 
                WHERE r.id = ?";
        
        return $this->db->fetch($sql, [$id]);
    }
    
    /**
     * Создание нового бронирования
     */
    public function createReservation($data)
    {
        // Расчет продолжительности аренды в днях
        $startDate = new DateTime($data['start_date']);
        $endDate = new DateTime($data['end_date']);
        $interval = $startDate->diff($endDate);
        $days = $interval->days + 1; // +1 т.к. считаем и день начала, и день окончания
        
        // Получение автомобиля для расчета стоимости
        $carModel = new Car();
        $car = $carModel->find($data['car_id']);
        
        if (!$car) {
            return false;
        }
        
        // Проверка доступности автомобиля на выбранные даты
        if (!$carModel->isAvailable($data['car_id'], $data['start_date'], $data['end_date'])) {
            return false;
        }
        
        // Расчет стоимости бронирования
        $totalPrice = $car['price_per_day'] * $days;
        
        // Добавляем дополнительные услуги к стоимости
        if (!empty($data['options'])) {
            foreach ($data['options'] as $option => $value) {
                if ($value) {
                    switch ($option) {
                        case 'insurance':
                            $totalPrice += 1000 * $days; // Страховка 1000р в день
                            break;
                        case 'baby_seat':
                            $totalPrice += 500 * $days; // Детское кресло 500р в день
                            break;
                        case 'additional_driver':
                            $totalPrice += 800 * $days; // Доп. водитель 800р в день
                            break;
                        case 'gps':
                            $totalPrice += 300 * $days; // GPS-навигатор 300р в день
                            break;
                    }
                }
            }
        }
        
        // Подготовка данных для сохранения
        $reservationData = [
            'car_id' => $data['car_id'],
            'user_id' => $data['user_id'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'total_price' => $totalPrice,
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s'),
            'options' => json_encode($data['options'] ?? []),
            'pickup_location' => $data['pickup_location'] ?? null,
            'return_location' => $data['return_location'] ?? null,
            'special_requests' => $data['special_requests'] ?? null
        ];
        
        // Создание бронирования
        return $this->create($reservationData);
    }
    
    /**
     * Получение статистики по бронированиям
     */
    public function getReservationsStats()
    {
        $sql = "SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active,
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed,
                SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) as cancelled,
                SUM(total_price) as total_revenue,
                SUM(CASE WHEN status = 'completed' THEN total_price ELSE 0 END) as completed_revenue,
                SUM(CASE WHEN created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY) THEN 1 ELSE 0 END) as last_month_count,
                SUM(CASE WHEN created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY) THEN total_price ELSE 0 END) as last_month_revenue
                FROM {$this->table}";
        
        return $this->db->fetch($sql);
    }
    
    /**
     * Получение списка бронирований для админ-панели
     */
    public function getReservationsForAdmin($filters = [], $limit = null, $offset = null)
    {
        $conditions = [];
        $params = [];
        
        // Добавление условий фильтрации
        if (!empty($filters['status'])) {
            $conditions[] = "r.status = ?";
            $params[] = $filters['status'];
        }
        
        if (!empty($filters['user_id'])) {
            $conditions[] = "r.user_id = ?";
            $params[] = $filters['user_id'];
        }
        
        if (!empty($filters['car_id'])) {
            $conditions[] = "r.car_id = ?";
            $params[] = $filters['car_id'];
        }
        
        if (!empty($filters['date_from'])) {
            $conditions[] = "r.start_date >= ?";
            $params[] = $filters['date_from'];
        }
        
        if (!empty($filters['date_to'])) {
            $conditions[] = "r.end_date <= ?";
            $params[] = $filters['date_to'];
        }
        
        if (!empty($filters['search'])) {
            $conditions[] = "(c.name LIKE ? OR c.brand LIKE ? OR c.model LIKE ? OR u.first_name LIKE ? OR u.last_name LIKE ? OR u.email LIKE ?)";
            $searchTerm = '%' . $filters['search'] . '%';
            $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm]);
        }
        
        // Формирование SQL запроса
        $sql = "SELECT r.*, c.name as car_name, c.brand as car_brand, c.model as car_model, 
                c.image_url as car_image, u.first_name, u.last_name, u.email 
                FROM {$this->table} r 
                JOIN cars c ON r.car_id = c.id 
                JOIN users u ON r.user_id = u.id";
        
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        
        $sql .= " ORDER BY r.created_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT {$limit}";
            
            if ($offset) {
                $sql .= " OFFSET {$offset}";
            }
        }
        
        return $this->db->fetchAll($sql, $params);
    }
}
