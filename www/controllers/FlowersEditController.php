<?php
require_once "BaseFlowersTwigController.php";

class FlowersEditController extends BaseFlowersTwigController {
    public $template = "flowers_edit.twig"; // Название шаблона для формы редактирования

    public function getContext(): array {
        $context = parent::getContext();
        $id = $this->params[1];

        // Получаем текущие данные объекта
        $sql = "SELECT * FROM type_flowers WHERE id = :id";
        $query = $this->pdo->prepare($sql);
        $query->bindValue("id", $id);
        $query->execute();
        $context['object'] = $query->fetch();

        return $context;
    }

    public function post(array $context) {
        $id = $this->params[1];
        $title = $_POST['title'];
        $info = $_POST['info'];
        // Если есть поле image, обработай его аналогично добавлению

        $sql = "UPDATE type_flowers SET title = :title, info = :info WHERE id = :id";
        $query = $this->pdo->prepare($sql);
        $query->bindValue("id", $id);
        $query->bindValue("title", $title);
        $query->bindValue("info", $info);
        $query->execute();

        // После обновления перенаправляем на просмотр объекта или на главную
        header("Location: /type-flowers/$id");
        exit;
    }
}
