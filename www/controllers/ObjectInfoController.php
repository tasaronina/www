<?php
require_once "ObjectController.php";

class ObjectInfoController extends ObjectController {
    public $template = "object_info.twig";

    public function getContext(): array {
        $context = parent::getContext();
        return $context;
    }
}