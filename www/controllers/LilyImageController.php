<?php
require_once "LilyController.php"; 

class LilyImageController extends LilyController {
    public $template = "base_image1.twig";
    public $temp = "Картинка";
    

    public function getContext() : array
    {
        $context = parent::getContext(); 
        
        $context['image'] = "../images/lily.jpg";

        return $context;
    }
}