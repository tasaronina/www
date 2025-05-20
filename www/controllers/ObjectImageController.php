
<?php
require_once "ObjectController.php";

class ObjectImageController extends ObjectController {
    public $template = "object_image.twig";

    public function getContext(): array {
        $context = parent::getContext();
        // ничего больше не нужно — шаблон сам найдёт {{ object.image }}
        return $context;
    }
}

