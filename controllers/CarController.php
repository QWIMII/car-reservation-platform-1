<?php
/**
 * Контроллер для работы с автомобилями
 */
class CarController
{
    private $carModel;
    private $categoryModel;
    
    public function __construct()
    {
        $this->carModel = new Car();
        $this->categoryModel = new CarCategory();
    }
    
    /**
     * Отображение каталога автомобилей
     */
    public function index()
    {
        // Получение параметров пагинации
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = ITEMS_PER_PAGE;
        $offset = ($page - 1) * $limit;
        
        // Получение категорий для фильтрации
        $categories = $this->categoryModel->all('name ASC');
        
        // Получение списка автомобилей
        $cars = $this->carModel->getAllWithCategory($limit, $offset);
        
        // Общее количество автомобилей для пагинации
        $totalCars = $this->carModel->count();
        $totalPages = ceil($totalCars / $limit);
        
        // Получение автомобилей по типам для отдельных секций
        $businessCars = $this->carModel->getBusiness(8);
        $porscheCars = $this->carModel->getPorsche(8);
        $superBusinessCars = $this->carModel->getSuperBusiness(8);
        $economyCars = $this->carModel->getEconomy(8);
        
        // Рендеринг представления
        require_once TEMPLATE_PATH . '/catalog.php';
    }
    
    /**
     * Отображение детальной информации об автомобиле
     */
    public function show($id)
    {
        // Получение данных автомобиля
        $car = $this->carModel->findWithCategory($id);
        
        if (!$car) {
            // Автомобиль не найден
            header('HTTP/1.0 404 Not Found');
            require_once TEMPLATE_PATH . '/404.php';
            return;
        }
        
        // Получение дополнительной информации
        $features = $this->carModel->getFeatures($id);
        $images = $this->carModel->getImages($id);
        $reviews = $this->carModel->getReviews($id);
        $averageRating = $this->carModel->getAverageRating($id);
        
        // Получение похожих автомобилей
        $similarCars = $this->carModel->findByCategory($car['category_id'], 4);
        
        // Рендеринг представления
        require_once TEMPLATE_PATH . '/car-details.php';
    }
    
    /**
     * Отображение автомобилей по категории
     */
    public function byCategory($id)
    {
        // Получение параметров пагинации
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = ITEMS_PER_PAGE;
        $offset = ($page - 1) * $limit;
        
        // Получение категории
        $category = $this->categoryModel->find($id);
        
        if (!$category) {
            // Категория не найдена
            header('HTTP/1.0 404 Not Found');
            require_once TEMPLATE_PATH . '/404.php';
            return;
        }
        
        // Получение автомобилей по категории
        $cars = $this->carModel->findByCategory($id, $limit, $offset);
        
        // Общее количество автомобилей для пагинации
        $totalCars = $this->carModel->count('category_id = ?', [$id]);
        $totalPages = ceil($totalCars / $limit);
        
        // Получение всех категорий для фильтрации
        $categories = $this->categoryModel->all('name ASC');
        
        // Рендеринг представления
        require_once TEMPLATE_PATH . '/category.php';
    }
    
    /**
     * Поиск автомобилей
     */
    public function search()
    {
        // Получение поискового запроса
        $query = isset($_GET['query']) ? trim($_GET['query']) : '';
        
        if (empty($query)) {
            // Если запрос пустой, перенаправляем на каталог
            header('Location: /catalog');
            exit;
        }
        
        // Получение параметров пагинации
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = ITEMS_PER_PAGE;
        $offset = ($page - 1) * $limit;
        
        // Поиск автомобилей
        $cars = $this->carModel->search($query, $limit, $offset);
        
        // Общее количество найденных автомобилей для пагинации
        $totalCars = count($this->carModel->search($query));
        $totalPages = ceil($totalCars / $limit);
        
        // Получение категорий для фильтрации
        $categories = $this->categoryModel->all('name ASC');
        
        // Рендеринг представления
        require_once TEMPLATE_PATH . '/search-results.php';
    }
}
