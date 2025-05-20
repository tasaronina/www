
<?php
require_once "BaseFlowersTwigController.php";

class ObjectController extends BaseFlowersTwigController {
    public $template = "__object.twig"; // универсальный шаблон «общего» вида

    public function getContext(): array {
        $context = parent::getContext();

        $id = isset($this->params[1]) ? (int)$this->params[1] : 0;
        $query = $this->pdo->prepare("SELECT * FROM type_flowers WHERE id = :id");
        $query->bindValue("id", $id, PDO::PARAM_INT);
        $query->execute();
        $context['object'] = $query->fetch(PDO::FETCH_ASSOC) ?: [];

        return $context;
    }
}
