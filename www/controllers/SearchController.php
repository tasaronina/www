<?php
require_once "BaseFlowersTwigController.php";

class SearchController extends BaseFlowersTwigController {
    public $template = "search.twig";
    public $title = "Поиск";

    public function getContext(): array {
        $context = parent::getContext();

    $type = $_GET['type'] ?? '';
    $title = $_GET['title'] ?? '';
    $info = $_GET['info'] ?? ''; // новое поле для полного описания
    

    $sql = "SELECT * FROM type_flowers WHERE 1";
    $params = [];

    if ($title !== '') {
        $sql .= " AND title LIKE :title";
        $params['title'] = "%$title%";
    }
    if ($type !== '' && $type !== 'all') {
        $sql .= " AND type = :type";
        $params['type'] = $type;
    }
    if ($info !== '') {
        $sql .= " AND info LIKE :info";
        $params['info'] = "%$info%";
    }
    

    $query = $this->pdo->prepare($sql);
    foreach ($params as $k => $v) $query->bindValue($k, $v);
    $query->execute();

    $context['objects'] = $query->fetchAll();
    $context['search_title'] = $title;
    $context['search_type'] = $type;
    $context['search_info'] = $info;

    // Получаем все типы из таблицы object_types
    $sql = "SELECT * FROM object_types";
    $query = $this->pdo->query($sql);
    $context['types'] = $query->fetchAll(PDO::FETCH_ASSOC);
    

    return $context;
    

    }
}
