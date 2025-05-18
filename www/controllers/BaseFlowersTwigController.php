<?php

class BaseFlowersTwigController extends TwigBaseController
{

    public function getContext(): array
    {   $context = parent::getContext();
        // Получаем только уникальные типы!
        $query = $this->pdo->query("SELECT DISTINCT type FROM type_flowers ORDER BY 1");
        $types = $query->fetchAll();
        $context['types'] = $types;
        
        
        // Получаем все object_types для навигации и форм
        $sql = "SELECT * FROM object_types";
        $query = $this->pdo->query($sql);
        $context['object_types'] = $query->fetchAll(PDO::FETCH_ASSOC);


        return $context;
    }
}