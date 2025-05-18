<?php
require_once "BaseController.php";

class TwigBaseController extends BaseController {
    protected \Twig\Environment $twig;

    public $title = "";
    public $template = "";
    public $temp = "";

    public $nav = [
        [
            "title" => "Главная",
            "url" => "/",
        ],
        [
            "title" => "Лилия",
            "url" => "/lily",
        ],
        [
            "title" => "Орхидея",
            "url" => "/orchid",
        ]
    ];
    public $menuLily = [
        [
            "btn" => "primary",
            "title" => "Лилия",
            "url" => "/lily",
        ],
        [
            "btn" => "link",
            "title" => "Картинка",
            "url" => "/lily/image",
        ],
        [
            "btn" => "link",
            "title" => "Описание",
            "url" => "/lily/info",
        ]
    ];

    public $menuOrchid = [
        [
            "btn" => "primary",
            "title" => "Орхидея",
            "url" => "/orchid",
        ],
        [
            "btn" => "link",
            "title" => "Картинка",
            "url" => "/orchid/image",
        ],
        [
            "btn" => "link",
            "title" => "Описание",
            "url" => "/orchid/info",
        ]
    ];

    public $newnav = [
        [
            "title" => "Картинка",
            "url" => "image",
        ],
        [
            "title" => "Описание",
            "url" => "info",
        ]
    ];

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
        $context['title'] = $this->title;
        $context['nav'] = $this->nav;
        $context['menuLily'] = $this->menuLily;
        $context['menuOrchid'] = $this->menuOrchid;
        $context['newnav'] = $this->newnav;
        $context['temp'] = $this->temp;

        return $context;
    }

    // Реализация абстрактного метода get()
    public function get() {
        echo $this->twig->render($this->template, $this->getContext());
    }
}
