<?php
require_once "BaseFlowersTwigController.php";

class FlowersEditController extends BaseFlowersTwigController {
    public $template = "flowers_edit.twig";

    public function getContext(): array {
        $context = parent::getContext();
        $id = (int)$this->params[1];

        // текущие данные
        $q = $this->pdo->prepare("SELECT * FROM type_flowers WHERE id = :id");
        $q->bindValue("id", $id, PDO::PARAM_INT);
        $q->execute();
        $context['object'] = $q->fetch(PDO::FETCH_ASSOC);

        // для выпадающего списка типов
        $sql = "SELECT * FROM object_types ORDER BY title";
        $context['object_types'] = $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

        return $context;
    }

    public function post(array $context) {
        $id = (int)$this->params[1];
        $title       = $_POST['title'];
        $description = $_POST['description'];
        $info        = $_POST['info'];
        $type        = $_POST['type'];

        // если загрузили новое изображение
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $tmp  = $_FILES['image']['tmp_name'];
            $name = uniqid() . "_" . basename($_FILES['image']['name']);
            move_uploaded_file($tmp, "../public/media/$name");
            $image_url = "/media/$name";
        } else {
            // оставляем старый URL
            $q = $this->pdo->prepare("SELECT image FROM type_flowers WHERE id = :id");
            $q->bindValue("id", $id, PDO::PARAM_INT);
            $q->execute();
            $image_url = $q->fetchColumn();
        }

        $sql = <<<SQL
        UPDATE type_flowers
        SET title = :title,
            description = :description,
            info = :info,
            type = :type,
            image = :image
        WHERE id = :id
        SQL;

        $upd = $this->pdo->prepare($sql);
        $upd->bindValue("id",          $id,          PDO::PARAM_INT);
        $upd->bindValue("title",       $title);
        $upd->bindValue("description", $description);
        $upd->bindValue("info",        $info);
        $upd->bindValue("type",        $type);
        $upd->bindValue("image",       $image_url);
        $upd->execute();

        header("Location: /type-flowers/$id");
        exit;
    }
}