<?php

// сначала создадим класс под один маршрут


// сначала создадим класс под один маршрут
class Route {
    public string $route_regexp; // тут получается шаблона url
    public $controller; // а это класс контроллера

    // просто конструктор
    public function __construct($route_regexp, $controller)
    {
        $this->route_regexp = $route_regexp;
        $this->controller = $controller;
    }
}

class Router {
    /**
     * @var Route[]
     */
    protected $routes = []; // список маршрутов и контроллеров

    protected $twig; // twig и pdo
    protected $pdo;

    // конструктор
    public function __construct($twig, $pdo)
    {
        $this->twig = $twig;
        $this->pdo = $pdo;
    }

    // добавляем маршрут
    public function add($route_regexp, $controller) {
        array_push($this->routes, new Route("#^$route_regexp$#", $controller));
    }

    // ищем маршрут и вызываем контроллер
    public function get_or_default($default_controller) {
        $url = $_SERVER["REQUEST_URI"]; // текущий URL
       
        $path = parse_url($url, PHP_URL_PATH); // вытаскиваем адрес
        //echo $path; // выводим
        //echo "<pre>"; // чтобы красивее выводил
        //print_r($_GET); // выведем содержимое $_GET
        //echo "</pre>";

        $controller = $default_controller;
        $matches = [];

        foreach($this->routes as $route) {
            if (preg_match($route->route_regexp, $path, $matches)) {
                $controller = $route->controller;
                break;
            }
        }

        // создаём экземпляр контроллера
        $controllerInstance = new $controller();

        // передаём pdo
        $controllerInstance->setPDO($this->pdo);

        // передаём параметры из URL (массив $matches)
        $controllerInstance->setParams($matches);

        // если контроллер наследник TwigBaseController, передаём twig
        if ($controllerInstance instanceof TwigBaseController) {
            $controllerInstance->setTwig($this->twig);
        }

        // вызываем метод get контроллера и возвращаем результат
        return $controllerInstance->get();
    }
}
