<?php
/**
 * Модель для работы с категориями автомобилей
 */
class CarCategory extends BaseModel
{
    protected $table = 'car_categories';
    
    /**
     * Получение категории с количеством автомобилей
     */
    public function getAllWithCarCount()
    {
        $sql = "SELECT car_categories.*, COUNT(cars.id) as car_count 
                FROM {$this->table} 
                LEFT JOIN cars ON car_categories.id = cars.category_id 
                GROUP BY car_categories.id 
                ORDER BY car_categories.name ASC";
        
        return $this->db->fetchAll($sql);
    }
    
    /**
     * Поиск категории по имени
     */
    public function findByName($name)
    {
        return $this->findWhere('name = ?', [$name]);
    }
    
    /**
     * Получение количества автомобилей в категории
     */
    public function getCarCount($categoryId)
    {
        $sql = "SELECT COUNT(*) as count FROM cars WHERE category_id = ?";
        $result = $this->db->fetch($sql, [$categoryId]);
        
        return $result['count'];
    }
}
