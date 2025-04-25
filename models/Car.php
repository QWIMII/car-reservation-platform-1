<?php
/**
 * Модель для работы с автомобилями
 */
class Car extends BaseModel
{
    protected $table = 'cars';
    
    /**
     * Получение всех автомобилей с информацией о категории
     */
    public function getAllWithCategory($limit = null, $offset = null)
    {
        $sql = "SELECT cars.*, car_categories.name as category_name 
                FROM {$this->table} 
                JOIN car_categories ON cars.category_id = car_categories.id";
        
        if ($limit) {
            $sql .= " LIMIT {$limit}";
            
            if ($offset) {
                $sql .= " OFFSET {$offset}";
            }
        }
        
        return $this->db->fetchAll($sql);
    }
    
    /**
     * Получение автомобиля по ID с информацией о категории
     */
    public function findWithCategory($id)
    {
        $sql = "SELECT cars.*, car_categories.name as category_name 
                FROM {$this->table} 
                JOIN car_categories ON cars.category_id = car_categories.id 
                WHERE cars.id = ?";
        
        return $this->db->fetch($sql, [$id]);
    }
    
    /**
     * Получение автомобилей по категории
     */
    public function findByCategory($categoryId, $limit = null, $offset = null)
    {
        $sql = "SELECT cars.*, car_categories.name as category_name 
                FROM {$this->table} 
                JOIN car_categories ON cars.category_id = car_categories.id 
                WHERE cars.category_id = ?";
        
        if ($limit) {
            $sql .= " LIMIT {$limit}";
            
            if ($offset) {
                $sql .= " OFFSET {$offset}";
            }
        }
        
        return $this->db->fetchAll($sql, [$categoryId]);
    }
    
    /**
     * Получение автомобилей бизнес-класса
     */
    public function getBusiness($limit = null, $offset = null)
    {
        $sql = "SELECT cars.*, car_categories.name as category_name 
                FROM {$this->table} 
                JOIN car_categories ON cars.category_id = car_categories.id 
                WHERE car_categories.name = 'Бизнес' OR car_categories.name = 'Премиум'";
        
        if ($limit) {
            $sql .= " LIMIT {$limit}";
            
            if ($offset) {
                $sql .= " OFFSET {$offset}";
            }
        }
        
        return $this->db->fetchAll($sql);
    }
    
    /**
     * Получение автомобилей Porsche
     */
    public function getPorsche($limit = null, $offset = null)
    {
        $sql = "SELECT cars.*, car_categories.name as category_name 
                FROM {$this->table} 
                JOIN car_categories ON cars.category_id = car_categories.id 
                WHERE cars.brand = 'Porsche'";
        
        if ($limit) {
            $sql .= " LIMIT {$limit}";
            
            if ($offset) {
                $sql .= " OFFSET {$offset}";
            }
        }
        
        return $this->db->fetchAll($sql);
    }
    
    /**
     * Получение автомобилей супербизнес-класса
     */
    public function getSuperBusiness($limit = null, $offset = null)
    {
        $sql = "SELECT cars.*, car_categories.name as category_name 
                FROM {$this->table} 
                JOIN car_categories ON cars.category_id = car_categories.id 
                WHERE car_categories.name = 'Супербизнес'";
        
        if ($limit) {
            $sql .= " LIMIT {$limit}";
            
            if ($offset) {
                $sql .= " OFFSET {$offset}";
            }
        }
        
        return $this->db->fetchAll($sql);
    }
    
    /**
     * Получение эконом-автомобилей
     */
    public function getEconomy($limit = null, $offset = null)
    {
        $sql = "SELECT cars.*, car_categories.name as category_name 
                FROM {$this->table} 
                JOIN car_categories ON cars.category_id = car_categories.id 
                WHERE car_categories.name = 'Эконом'";
        
        if ($limit) {
            $sql .= " LIMIT {$limit}";
            
            if ($offset) {
                $sql .= " OFFSET {$offset}";
            }
        }
        
        return $this->db->fetchAll($sql);
    }
    
    /**
     * Поиск автомобилей
     */
    public function search($query, $limit = null, $offset = null)
    {
        $sql = "SELECT cars.*, car_categories.name as category_name 
                FROM {$this->table} 
                JOIN car_categories ON cars.category_id = car_categories.id 
                WHERE cars.name LIKE ? OR cars.brand LIKE ? OR cars.model LIKE ? OR car_categories.name LIKE ?";
        
        $params = array_fill(0, 4, '%' . $query . '%');
        
        if ($limit) {
            $sql .= " LIMIT {$limit}";
            
            if ($offset) {
                $sql .= " OFFSET {$offset}";
            }
        }
        
        return $this->db->fetchAll($sql, $params);
    }
    
    /**
     * Получение особенностей автомобиля
     */
    public function getFeatures($carId)
    {
        $sql = "SELECT * FROM car_features WHERE car_id = ?";
        return $this->db->fetchAll($sql, [$carId]);
    }
    
    /**
     * Получение изображений автомобиля
     */
    public function getImages($carId)
    {
        $sql = "SELECT * FROM car_images WHERE car_id = ?";
        return $this->db->fetchAll($sql, [$carId]);
    }
    
    /**
     * Получение отзывов для автомобиля
     */
    public function getReviews($carId)
    {
        $sql = "SELECT reviews.*, users.first_name, users.last_name, users.avatar 
                FROM reviews 
                JOIN users ON reviews.user_id = users.id 
                WHERE reviews.car_id = ? 
                ORDER BY reviews.created_at DESC";
        
        return $this->db->fetchAll($sql, [$carId]);
    }
    
    /**
     * Получение средней оценки автомобиля
     */
    public function getAverageRating($carId)
    {
        $sql = "SELECT AVG(rating) as average FROM reviews WHERE car_id = ?";
        $result = $this->db->fetch($sql, [$carId]);
        
        return $result ? (float) $result['average'] : 0;
    }
    
    /**
     * Проверка доступности автомобиля на даты
     */
    public function isAvailable($carId, $startDate, $endDate)
    {
        $sql = "SELECT COUNT(*) as count FROM reservations 
                WHERE car_id = ? AND status = 'active' 
                AND ((start_date BETWEEN ? AND ?) OR (end_date BETWEEN ? AND ?) 
                OR (start_date <= ? AND end_date >= ?))";
        
        $params = [
            $carId, 
            $startDate, 
            $endDate, 
            $startDate, 
            $endDate, 
            $startDate, 
            $endDate
        ];
        
        $result = $this->db->fetch($sql, $params);
        
        return $result['count'] == 0;
    }
}
