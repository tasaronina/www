<?php
require_once "BaseFlowersTwigController.php";

class FlowersDeleteController extends BaseFlowersTwigController {
    public function post(array $context) {
        $id = $this->params[1]; // Получаем id из URL

        $sql = "DELETE FROM type_flowers WHERE id = :id";
        $query = $this->pdo->prepare($sql);
        $query->bindValue("id", $id);
        $query->execute();

        // Перенаправляем на главную или страницу списка после удаления
        header("Location: /");
        exit;
    }
}
