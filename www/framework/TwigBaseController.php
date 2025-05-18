<?php
require_once "BaseController.php";

class TwigBaseController extends BaseController {
    protected \Twig\Environment $twig;

    public $title = "";
    public $template = "";
    public $temp = "";

    // Оставляем только Главную в базовом меню
    public $nav = [
        [
            "title" => "Главная",
            "url" => "/",
        ],
    ];

    // Объявляем свойства, чтобы избежать ошибок
    public $menuLily = [];
    public $menuOrchid = [];
    public $newnav = [];

    // Меню для Лилии и Орхидеи можно убрать или перенести в другие контроллеры, если нужно

    public function __construct()
    {
        global $twig; // если у вас Twig глобальный объект
        $this->twig = $twig;
    }

    public function setTwig($twig) {
        $this->twig = $twig;
    }

    public function getContext(): array
    {
        $context = parent::getContext();

        // Получаем все типы из базы
        $sql = "SELECT * FROM object_types ORDER BY title";
        $query = $this->pdo->query($sql);
        $all_types = $query->fetchAll(PDO::FETCH_ASSOC);
    
        // Для поиска - все типы
        $context['types'] = $all_types;
    
        // Для навигации - исключаем Лилию и Орхидею
        $nav_types = array_filter($all_types, function($type) {
            return !in_array($type['title'], ['Лилия', 'Орхидея']);
        });
    
        // Стандартные пункты меню (например, Главная)
        $base_nav = [
            [
                "title" => "Главная",
                "url" => "/",
            ],
        ];
    
        // Формируем навигацию с исключением Лилии и Орхидеи
        $dynamic_nav = [];
        foreach ($nav_types as $type) {
            $dynamic_nav[] = [
                "title" => $type['title'],
                "url" => "/?type=" . urlencode($type['title']),
                "image" => $type['image'] ?? null,
            ];
        }
    
        $context['nav'] = array_merge($base_nav, $dynamic_nav);
    
        // Остальные параметры
        $context['menuLily'] = $this->menuLily ?? [];
        $context['menuOrchid'] = $this->menuOrchid ?? [];
        $context['newnav'] = $this->newnav ?? [];
        $context['temp'] = $this->temp;
    
        return $context;
    }

    // Реализация абстрактного метода get()
    public function get(array $context) { // добавил аргумент в get
        echo $this->twig->render($this->template, $context); // а тут поменяем getContext на просто $context
    }
}
