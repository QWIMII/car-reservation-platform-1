<?php
/**
 * Модель для работы с автомобилями
 */
class Car extends BaseModel
{
    protected $table = 'cars';
    
    /**
     * Получение автомобиля вместе с категорией
     */
    public function findWithCategory($id)
    {
        $sql = "SELECT c.*, cc.name as category_name 
                FROM {$this->table} c 
                JOIN car_categories cc ON c.category_id = cc.id 
                WHERE c.id = ?";
        
        $car = $this->db->fetch($sql, [$id]);
        
        if ($car) {
            // Добавление особенностей автомобиля
            $car['features'] = $this->getFeaturesList($id);
            
            // Добавление изображений автомобиля
            $car['images'] = $this->getImages($id);
        }
        
        return $car;
    }
    
    /**
     * Проверка доступности автомобиля на указанные даты
     */
    public function isAvailable($carId, $startDate, $endDate)
    {
        // Получение всех активных бронирований для автомобиля
        $sql = "SELECT * FROM reservations 
                WHERE car_id = ? 
                AND status IN ('active', 'pending') 
                AND ((start_date <= ? AND end_date >= ?) OR 
                     (start_date <= ? AND end_date >= ?) OR 
                     (start_date >= ? AND end_date <= ?))";
        
        $params = [
            $carId,
            $startDate, $startDate,   // Проверка, попадает ли начало запрашиваемого периода в существующее бронирование
            $endDate, $endDate,       // Проверка, попадает ли конец запрашиваемого периода в существующее бронирование
            $startDate, $endDate      // Проверка, находится ли существующее бронирование внутри запрашиваемого периода
        ];
        
        $bookings = $this->db->fetchAll($sql, $params);
        
        // Если есть пересекающиеся бронирования, автомобиль недоступен
        return empty($bookings);
    }
    
    /**
     * Получение особенностей автомобиля
     */
    public function getFeatures($carId)
    {
        $sql = "SELECT * FROM car_features WHERE car_id = ?";
        return $this->db->fetch($sql, [$carId]);
    }
    
    /**
     * Получение списка особенностей автомобиля в виде массива строк
     */
    public function getFeaturesList($carId)
    {
        // Получение особенностей автомобиля
        $features = $this->getFeatures($carId);
        
        if (!$features) {
            return [];
        }
        
        // Формирование списка особенностей
        $featuresList = [];
        
        if ($features['air_conditioner']) {
            $featuresList[] = 'Кондиционер';
        }
        
        if ($features['navigation']) {
            $featuresList[] = 'Навигационная система';
        }
        
        if ($features['auto_parking']) {
            $featuresList[] = 'Автоматическая парковка';
        }
        
        if ($features['autopilot']) {
            $featuresList[] = 'Автопилот';
        }
        
        if ($features['bluetooth']) {
            $featuresList[] = 'Bluetooth';
        }
        
        // Добавление стандартных особенностей в зависимости от категории автомобиля
        $car = $this->find($carId);
        
        if ($car) {
            switch ($car['category_id']) {
                case 1: // Спорткар
                    $featuresList[] = 'Спортивный режим';
                    $featuresList[] = 'Карбоновые элементы';
                    break;
                case 2: // Премиум
                    $featuresList[] = 'Кожаный салон';
                    $featuresList[] = 'Панорамная крыша';
                    break;
                case 3: // Бизнес
                    $featuresList[] = 'Подогрев сидений';
                    $featuresList[] = 'Премиальная аудиосистема';
                    break;
                case 4: // Внедорожник
                    $featuresList[] = 'Полный привод';
                    $featuresList[] = 'Увеличенный клиренс';
                    break;
                case 5: // Эконом
                    $featuresList[] = 'USB-разъемы';
                    $featuresList[] = 'Экономичный расход';
                    break;
                case 6: // Электромобиль
                    $featuresList[] = 'Быстрая зарядка';
                    $featuresList[] = 'Большой запас хода';
                    break;
                case 7: // Кабриолет
                    $featuresList[] = 'Складная крыша';
                    $featuresList[] = 'Ветрозащита';
                    break;
                case 8: // Купе
                    $featuresList[] = 'Спортивный дизайн';
                    $featuresList[] = 'Аэродинамические элементы';
                    break;
                case 9: // Супербизнес
                    $featuresList[] = 'Массаж сидений';
                    $featuresList[] = 'Индивидуальная отделка';
                    $featuresList[] = 'Холодильник';
                    break;
            }
        }
        
        return $featuresList;
    }
    
    /**
     * Получение изображений автомобиля
     */
    public function getImages($carId)
    {
        $sql = "SELECT * FROM car_images WHERE car_id = ? ORDER BY is_primary DESC, id ASC";
        return $this->db->fetchAll($sql, [$carId]);
    }
    
    /**
     * Обновление особенностей автомобиля
     */
    public function updateFeatures($carId, $features)
    {
        // Проверяем, есть ли уже особенности для этого автомобиля
        $existingFeatures = $this->getFeatures($carId);
        
        if ($existingFeatures) {
            // Обновление существующих особенностей
            $sql = "UPDATE car_features SET 
                    air_conditioner = ?, 
                    navigation = ?, 
                    auto_parking = ?, 
                    autopilot = ?, 
                    bluetooth = ? 
                    WHERE car_id = ?";
                    
            $params = [
                $features['air_conditioner'] ?? $existingFeatures['air_conditioner'],
                $features['navigation'] ?? $existingFeatures['navigation'],
                $features['auto_parking'] ?? $existingFeatures['auto_parking'],
                $features['autopilot'] ?? $existingFeatures['autopilot'],
                $features['bluetooth'] ?? $existingFeatures['bluetooth'],
                $carId
            ];
            
            return $this->db->execute($sql, $params);
        } else {
            // Добавление новых особенностей
            $sql = "INSERT INTO car_features (car_id, air_conditioner, navigation, auto_parking, autopilot, bluetooth) 
                    VALUES (?, ?, ?, ?, ?, ?)";
                    
            $params = [
                $carId,
                $features['air_conditioner'] ?? 0,
                $features['navigation'] ?? 0,
                $features['auto_parking'] ?? 0,
                $features['autopilot'] ?? 0,
                $features['bluetooth'] ?? 0
            ];
            
            return $this->db->execute($sql, $params);
        }
    }
    
    /**
     * Получение списка автомобилей с возможностью фильтрации
     */
    public function getCars($filters = [], $limit = null, $offset = null)
    {
        // Базовый SQL-запрос для получения автомобилей
        $sql = "SELECT c.*, cc.name as category_name 
                FROM {$this->table} c 
                JOIN car_categories cc ON c.category_id = cc.id";
        
        $conditions = [];
        $params = [];
        
        // Добавление условий фильтрации
        if (!empty($filters['category_id'])) {
            $conditions[] = "c.category_id = ?";
            $params[] = $filters['category_id'];
        }
        
        if (!empty($filters['brand'])) {
            $conditions[] = "c.brand = ?";
            $params[] = $filters['brand'];
        }
        
        if (!empty($filters['min_price'])) {
            $conditions[] = "c.price_per_day >= ?";
            $params[] = $filters['min_price'];
        }
        
        if (!empty($filters['max_price'])) {
            $conditions[] = "c.price_per_day <= ?";
            $params[] = $filters['max_price'];
        }
        
        if (!empty($filters['transmission'])) {
            $conditions[] = "c.transmission = ?";
            $params[] = $filters['transmission'];
        }
        
        if (!empty($filters['fuel_type'])) {
            $conditions[] = "c.fuel_type = ?";
            $params[] = $filters['fuel_type'];
        }
        
        if (!empty($filters['min_seats'])) {
            $conditions[] = "c.seats >= ?";
            $params[] = $filters['min_seats'];
        }
        
        if (!empty($filters['search'])) {
            $conditions[] = "(c.name LIKE ? OR c.brand LIKE ? OR c.model LIKE ?)";
            $searchTerm = '%' . $filters['search'] . '%';
            $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm]);
        }
        
        // Добавление условия доступности автомобиля
        $conditions[] = "c.status = 'available'";
        
        // Формирование WHERE части запроса
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        
        // Сортировка
        $sortField = !empty($filters['sort_field']) ? $filters['sort_field'] : 'c.price_per_day';
        $sortOrder = !empty($filters['sort_order']) ? $filters['sort_order'] : 'ASC';
        
        $sql .= " ORDER BY {$sortField} {$sortOrder}";
        
        // Ограничение количества результатов
        if ($limit) {
            $sql .= " LIMIT {$limit}";
            
            if ($offset) {
                $sql .= " OFFSET {$offset}";
            }
        }
        
        // Получение списка автомобилей
        $cars = $this->db->fetchAll($sql, $params);
        
        // Если нужно, можно добавить дополнительную информацию для каждого автомобиля
        foreach ($cars as &$car) {
            $car['features'] = $this->getFeaturesList($car['id']);
        }
        
        return $cars;
    }
    
    /**
     * Получение уникальных брендов автомобилей
     */
    public function getUniqueBrands()
    {
        $sql = "SELECT DISTINCT brand FROM {$this->table} ORDER BY brand";
        $result = $this->db->fetchAll($sql);
        
        return array_column($result, 'brand');
    }
    
    /**
     * Получение статистики по автомобилям
     */
    public function getCarsStats()
    {
        $sql = "SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN status = 'available' THEN 1 ELSE 0 END) as available,
                SUM(CASE WHEN status = 'in_use' THEN 1 ELSE 0 END) as in_use,
                SUM(CASE WHEN status = 'maintenance' THEN 1 ELSE 0 END) as maintenance,
                COUNT(DISTINCT brand) as brands_count,
                (SELECT name FROM car_categories WHERE id = (
                    SELECT category_id FROM {$this->table} 
                    GROUP BY category_id 
                    ORDER BY COUNT(*) DESC 
                    LIMIT 1
                )) as popular_category
                FROM {$this->table}";
        
        return $this->db->fetch($sql);
    }
    
    /**
     * Получение списка автомобилей для админ-панели
     */
    public function getCarsForAdmin($filters = [], $limit = null, $offset = null)
    {
        // Базовый SQL-запрос для получения автомобилей
        $sql = "SELECT c.*, cc.name as category_name 
                FROM {$this->table} c 
                JOIN car_categories cc ON c.category_id = cc.id";
        
        $conditions = [];
        $params = [];
        
        // Добавление условий фильтрации
        if (!empty($filters['category_id'])) {
            $conditions[] = "c.category_id = ?";
            $params[] = $filters['category_id'];
        }
        
        if (!empty($filters['brand'])) {
            $conditions[] = "c.brand = ?";
            $params[] = $filters['brand'];
        }
        
        if (!empty($filters['status'])) {
            $conditions[] = "c.status = ?";
            $params[] = $filters['status'];
        }
        
        if (!empty($filters['search'])) {
            $conditions[] = "(c.name LIKE ? OR c.brand LIKE ? OR c.model LIKE ?)";
            $searchTerm = '%' . $filters['search'] . '%';
            $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm]);
        }
        
        // Формирование WHERE части запроса
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        
        // Сортировка
        $sql .= " ORDER BY c.id DESC";
        
        // Ограничение количества результатов
        if ($limit) {
            $sql .= " LIMIT {$limit}";
            
            if ($offset) {
                $sql .= " OFFSET {$offset}";
            }
        }
        
        return $this->db->fetchAll($sql, $params);
    }
}
