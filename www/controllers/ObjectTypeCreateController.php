<?php
class ObjectTypeCreateController extends BaseFlowersTwigController {
    public $template = "object_type_create.twig";


    public function post(array $context) {
        $title = $_POST['title'];
        $image_url = "";
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $tmp_name = $_FILES['image']['tmp_name'];
            $name = basename($_FILES['image']['name']);
            $unique_name = uniqid() . "_" . $name;
            move_uploaded_file($tmp_name, "../public/media/$unique_name");
            $image_url = "/media/$unique_name";
        }
        $sql = "INSERT INTO object_types(title, image) VALUES(:title, :image)";
        $query = $this->pdo->prepare($sql);
        $query->bindValue("title", $title);
        $query->bindValue("image", $image_url);
        $query->execute();
        $context['message'] = 'Тип успешно добавлен!';
        $this->get($context);
    }
}
