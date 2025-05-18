<?php
require_once "OrchidController.php"; 

class OrchidImageController extends OrchidController {
    public $template = "base_image2.twig";
    public $temp = "Картинка";
    

    public function getContext() : array
    {
        $context = parent::getContext(); 
        
        $context['image'] = "../images/orchid.jpg";

        return $context;
    }
}