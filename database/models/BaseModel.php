<?php
require_once __DIR__ . '/../Database.php';

/**
 * Базовый класс модели
 */
abstract class BaseModel
{
    protected $db;
    protected $table;
    protected $primaryKey = 'id';
    
    public function __construct()
    {
        $this->db = Database::getInstance();
    }
    
    /**
     * Получение всех записей
     */
    public function all($orderBy = null, $limit = null, $offset = null)
    {
        $sql = "SELECT * FROM {$this->table}";
        
        if ($orderBy) {
            $sql .= " ORDER BY {$orderBy}";
        }
        
        if ($limit) {
            $sql .= " LIMIT {$limit}";
            
            if ($offset) {
                $sql .= " OFFSET {$offset}";
            }
        }
        
        return $this->db->fetchAll($sql);
    }
    
    /**
     * Получение записи по ID
     */
    public function find($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?";
        return $this->db->fetch($sql, [$id]);
    }
    
    /**
     * Получение записей по условию
     */
    public function where($conditions, $params = [], $orderBy = null, $limit = null)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$conditions}";
        
        if ($orderBy) {
            $sql .= " ORDER BY {$orderBy}";
        }
        
        if ($limit) {
            $sql .= " LIMIT {$limit}";
        }
        
        return $this->db->fetchAll($sql, $params);
    }
    
    /**
     * Получение одной записи по условию
     */
    public function findWhere($conditions, $params = [])
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$conditions} LIMIT 1";
        return $this->db->fetch($sql, $params);
    }
    
    /**
     * Создание записи
     */
    public function create($data)
    {
        $fields = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        
        $sql = "INSERT INTO {$this->table} ({$fields}) VALUES ({$placeholders})";
        
        $this->db->query($sql, array_values($data));
        return $this->db->lastInsertId();
    }
    
    /**
     * Обновление записи
     */
    public function update($id, $data)
    {
        $fields = array_map(function ($field) {
            return "{$field} = ?";
        }, array_keys($data));
        
        $fieldsString = implode(', ', $fields);
        
        $sql = "UPDATE {$this->table} SET {$fieldsString} WHERE {$this->primaryKey} = ?";
        
        $values = array_values($data);
        $values[] = $id;
        
        return $this->db->query($sql, $values);
    }
    
    /**
     * Удаление записи
     */
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?";
        return $this->db->query($sql, [$id]);
    }
    
    /**
     * Количество записей
     */
    public function count($conditions = '1', $params = [])
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE {$conditions}";
        $result = $this->db->fetch($sql, $params);
        return $result['count'];
    }
}
