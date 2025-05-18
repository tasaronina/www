<?php
require_once "BaseFlowersTwigController.php";

class ObjectController extends BaseFlowersTwigController {
    public $template = "__object.twig"; // универсальный шаблон

    public function getContext(): array {
        $context = parent::getContext();
    
        $id = isset($this->params[1]) ? (int)$this->params[1] : 0;
        $show = $_GET['show'] ?? null;
    
        $query = $this->pdo->prepare("SELECT * FROM type_flowers WHERE id = :my_id");
        $query->bindValue("my_id", $id);
        $query->execute();
        $data = $query->fetch();
    
        $context['title'] = $data['title'] ?? 'Нет названия';
        $context['description'] = $data['description'] ?? 'Нет описания';
        $context['info'] = $data['info'] ?? 'Нет информации';
        $context['image'] = $data['image'] ?? '';
        $context['id'] = $id;
    
        // Определяем, что показывать
        if ($show === 'image') {
            $context['show_image'] = true;
            $context['show_info'] = false;
            $context['show_main'] = false;
            $context['temp'] = "Картинка";
        } elseif ($show === 'info') {
            $context['show_image'] = false;
            $context['show_info'] = true;
            $context['show_main'] = false;
            $context['temp'] = "Описание";
        } else {
            $context['show_image'] = false;
            $context['show_info'] = false;
            $context['show_main'] = true;
            $context['temp'] = "Общее";
        }
    
        return $context;
    }
}
