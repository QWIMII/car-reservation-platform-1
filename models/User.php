<?php
/**
 * Модель для работы с пользователями
 */
class User extends BaseModel
{
    protected $table = 'users';
    
    /**
     * Поиск пользователя по email
     */
    public function findByEmail($email)
    {
        $sql = "SELECT * FROM {$this->table} WHERE email = ?";
        return $this->db->fetch($sql, [$email]);
    }
    
    /**
     * Поиск пользователя по коду активации
     */
    public function findByActivationCode($code)
    {
        $sql = "SELECT * FROM {$this->table} WHERE activation_code = ?";
        return $this->db->fetch($sql, [$code]);
    }
    
    /**
     * Обновление профиля пользователя
     */
    public function updateProfile($userId, $data)
    {
        // Проверка доступности email, если он меняется
        if (isset($data['email'])) {
            $user = $this->findByEmail($data['email']);
            if ($user && $user['id'] != $userId) {
                return false;
            }
        }
        
        return $this->update($userId, $data);
    }
    
    /**
     * Изменение пароля пользователя
     */
    public function changePassword($userId, $currentPassword, $newPassword)
    {
        // Получение данных пользователя
        $user = $this->find($userId);
        
        if (!$user) {
            return false;
        }
        
        // Проверка текущего пароля
        if (!password_verify($currentPassword, $user['password'])) {
            return false;
        }
        
        // Хеширование нового пароля
        $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
        
        // Обновление пароля
        return $this->update($userId, [
            'password' => $passwordHash
        ]);
    }
    
    /**
     * Получение списка пользователей с возможностью фильтрации
     */
    public function getUsers($filters = [], $limit = null, $offset = null)
    {
        $conditions = [];
        $params = [];
        
        // Добавление условий фильтрации
        if (!empty($filters['role'])) {
            $conditions[] = "role = ?";
            $params[] = $filters['role'];
        }
        
        if (!empty($filters['status'])) {
            $conditions[] = "status = ?";
            $params[] = $filters['status'];
        }
        
        if (!empty($filters['search'])) {
            $conditions[] = "(email LIKE ? OR first_name LIKE ? OR last_name LIKE ? OR phone LIKE ?)";
            $searchTerm = '%' . $filters['search'] . '%';
            $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
        }
        
        // Формирование SQL запроса
        $sql = "SELECT * FROM {$this->table}";
        
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        
        $sql .= " ORDER BY created_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT {$limit}";
            
            if ($offset) {
                $sql .= " OFFSET {$offset}";
            }
        }
        
        return $this->db->fetchAll($sql, $params);
    }
    
    /**
     * Получение статистики по пользователям
     */
    public function getUsersStats()
    {
        $sql = "SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN role = 'admin' THEN 1 ELSE 0 END) as admins,
                SUM(CASE WHEN role = 'client' THEN 1 ELSE 0 END) as clients,
                SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active,
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = 'blocked' THEN 1 ELSE 0 END) as blocked,
                COUNT(DISTINCT CASE WHEN last_login >= DATE_SUB(NOW(), INTERVAL 30 DAY) THEN id END) as active_last_month
                FROM {$this->table}";
        
        return $this->db->fetch($sql);
    }
}
