<?php

class BaseFlowersTwigController extends TwigBaseController
{

    public function getContext(): array
    {
        $context = parent::getContext();
        // создаем запрос к БД
        $query = $this->pdo->query("SELECT DISTINCT type FROM type_flowers ORDER BY 1");
        // стягиваем данные
        $types = $query->fetchAll();
        // создаем глобальную переменную в $twig, которая будет достпна из любого шаблона
        $context['types'] = $types;

        $sql = "SELECT * FROM type_flowers";
        $types = $this->pdo->query($sql)->fetchAll();
        $context['types'] = $types;


        return $context;
    }
}