<?php
require_once "BaseFlowersTwigController.php";
class MainController extends BaseFlowersTwigController {
    public $template = "main.twig";
    public $title = "Главная";

    // добавим метод getContext()
    public function getContext(): array
    {
        $context = parent::getContext();
        
        // подготавливаем запрос SELECT * FROM space_objects
        // вообще звездочку не рекомендуется использовать, но на первый раз пойдет
        if (isset($_GET['type'])) {
            $query = $this->pdo->prepare("SELECT * FROM type_flowers WHERE type = :type");
            $query->bindValue(':type', $_GET['type']);
            $query->execute();
        } else {
            $query = $this->pdo->query("SELECT * FROM type_flowers");
        }
        
        // стягиваем данные через fetchAll() и сохраняем результат в контекст
        $context['type_flowers'] = $query->fetchAll();

        return $context;
    }
    
}