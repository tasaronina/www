<?php
require_once "BaseFlowersTwigController.php";

class FlowersCreateController extends BaseFlowersTwigController {
    public $template = "flowers_create.twig";

    public function get(array $context) // добавили параметр
    {
        echo $_SERVER['REQUEST_METHOD'];
        
        parent::get($context); // пробросили параметр
    }

    public function post(array $context) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $type = $_POST['type'];
        $info = $_POST['info'];
    
        $image_url = ""; // инициализация
    
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $tmp_name = $_FILES['image']['tmp_name'];
            $name = basename($_FILES['image']['name']);
            $unique_name = uniqid() . "_" . $name;
            move_uploaded_file($tmp_name, "../public/media/$unique_name");
            $image_url = "/media/$unique_name";
        }
    
        $sql = <<<EOL
        INSERT INTO type_flowers(title, description, type, info, image)
        VALUES(:title, :description, :type, :info, :image_url)
        EOL;
    
        $query = $this->pdo->prepare($sql);
        $query->bindValue("title", $title);
        $query->bindValue("description", $description);
        $query->bindValue("type", $type);
        $query->bindValue("info", $info);
        $query->bindValue("image_url", $image_url);
    
        $query->execute();
    
        $context['message'] = 'Вы успешно создали объект';
        $context['id'] = $this->pdo->lastInsertId();
    
        $this->get($context);
    }
}