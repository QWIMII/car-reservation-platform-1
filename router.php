<?php
/**
 * Маршрутизатор для обработки HTTP-запросов
 * Направляет запросы к соответствующим контроллерам
 */
class Router
{
    /**
     * Массив с зарегистрированными маршрутами
     */
    private $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'DELETE' => []
    ];
    
    /**
     * Параметры текущего маршрута
     */
    private $params = [];
    
    /**
     * Добавление GET-маршрута
     */
    public function get($route, $handler)
    {
        $this->addRoute('GET', $route, $handler);
    }
    
    /**
     * Добавление POST-маршрута
     */
    public function post($route, $handler)
    {
        $this->addRoute('POST', $route, $handler);
    }
    
    /**
     * Добавление PUT-маршрута
     */
    public function put($route, $handler)
    {
        $this->addRoute('PUT', $route, $handler);
    }
    
    /**
     * Добавление DELETE-маршрута
     */
    public function delete($route, $handler)
    {
        $this->addRoute('DELETE', $route, $handler);
    }
    
    /**
     * Добавление маршрута в массив маршрутов
     */
    private function addRoute($method, $route, $handler)
    {
        // Преобразование параметров маршрута в регулярное выражение
        $route = preg_replace('/\/{([^\/]+)}/', '/(?P<$1>[^/]+)', $route);
        $route = '#^' . $route . '$#';
        
        $this->routes[$method][$route] = $handler;
    }
    
    /**
     * Поиск маршрута, соответствующего текущему запросу
     */
    private function match($method, $uri)
    {
        if (!isset($this->routes[$method])) {
            return false;
        }
        
        foreach ($this->routes[$method] as $route => $handler) {
            if (preg_match($route, $uri, $matches)) {
                // Удаление численных ключей из массива совпадений
                foreach ($matches as $key => $match) {
                    if (is_int($key)) {
                        unset($matches[$key]);
                    }
                }
                
                $this->params = $matches;
                return $handler;
            }
        }
        
        return false;
    }
    
    /**
     * Вызов соответствующего обработчика для текущего маршрута
     */
    private function callHandler($handler)
    {
        if (is_callable($handler)) {
            return call_user_func_array($handler, $this->params);
        }
        
        // Обработка строки вида 'Controller@action'
        if (is_string($handler) && strpos($handler, '@') !== false) {
            list($controller, $action) = explode('@', $handler, 2);
            
            $controllerPath = 'controllers/' . $controller . '.php';
            
            if (file_exists($controllerPath)) {
                require_once $controllerPath;
                
                $controllerInstance = new $controller();
                
                if (method_exists($controllerInstance, $action)) {
                    return call_user_func_array([$controllerInstance, $action], $this->params);
                }
            }
        }
        
        // Если обработчик не найден, возвращаем 404
        $this->notFound();
    }
    
    /**
     * Отображение страницы 404
     */
    private function notFound()
    {
        header('HTTP/1.0 404 Not Found');
        
        if (file_exists(TEMPLATE_PATH . '/404.php')) {
            require TEMPLATE_PATH . '/404.php';
        } else {
            echo '<h1>404 Not Found</h1>';
            echo '<p>Запрашиваемая страница не найдена.</p>';
        }
        
        exit;
    }
    
    /**
     * Обработка текущего HTTP-запроса
     */
    public function dispatch()
    {
        // Получение метода запроса
        $method = $_SERVER['REQUEST_METHOD'];
        
        // Проверка для методов PUT и DELETE через _method в POST
        if ($method === 'POST' && isset($_POST['_method'])) {
            if (in_array($_POST['_method'], ['PUT', 'DELETE'])) {
                $method = $_POST['_method'];
            }
        }
        
        // Получение URI запроса
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Удаление завершающего слеша
        $uri = rtrim($uri, '/');
        
        // Добавление слеша в начало, если его нет
        if (empty($uri)) {
            $uri = '/';
        }
        
        // Поиск соответствующего маршрута
        $handler = $this->match($method, $uri);
        
        if ($handler) {
            // Вызов обработчика маршрута
            $this->callHandler($handler);
        } else {
            // Маршрут не найден
            $this->notFound();
        }
    }
    
    /**
     * Получение параметров текущего маршрута
     */
    public function getParams()
    {
        return $this->params;
    }
    
    /**
     * Перенаправление на другой URL
     */
    public static function redirect($url)
    {
        header('Location: ' . $url);
        exit;
    }
    
    /**
     * Получение базового URL сайта
     */
    public static function baseUrl()
    {
        return SITE_URL;
    }
    
    /**
     * Генерация URL для маршрута
     */
    public static function url($path = '')
    {
        return self::baseUrl() . '/' . ltrim($path, '/');
    }
}
