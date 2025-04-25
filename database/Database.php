<?php
/**
 * Класс для работы с базой данных
 */
class Database
{
    private static $instance = null;
    private $pdo;

    /**
     * Конструктор создает соединение с базой данных
     */
    private function __construct()
    {
        $config = require_once __DIR__ . '/config.php';
        
        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
        
        try {
            $this->pdo = new PDO($dsn, $config['username'], $config['password'], $config['options']);
        } catch (PDOException $e) {
            throw new Exception("Ошибка соединения с базой данных: " . $e->getMessage());
        }
    }

    /**
     * Получение экземпляра класса (Singleton)
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Выполнение запроса к БД
     */
    public function query($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Получение одной записи
     */
    public function fetch($sql, $params = [])
    {
        return $this->query($sql, $params)->fetch();
    }

    /**
     * Получение всех записей
     */
    public function fetchAll($sql, $params = [])
    {
        return $this->query($sql, $params)->fetchAll();
    }

    /**
     * Получение последнего добавленного ID
     */
    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

    /**
     * Выполнение транзакции
     */
    public function transaction(callable $callback)
    {
        try {
            $this->pdo->beginTransaction();
            $result = $callback($this);
            $this->pdo->commit();
            return $result;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
}
