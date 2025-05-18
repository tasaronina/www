<?php

class BaseFlowersTwigController extends TwigBaseController
{

    public function getContext(): array
    {   $context = parent::getContext();
        // Получаем только уникальные типы!
        $query = $this->pdo->query("SELECT DISTINCT type FROM type_flowers ORDER BY 1");
        $types = $query->fetchAll();
        $context['types'] = $types;
        return $context;
    }
}