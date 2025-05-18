
    <div class="container">
        <?php 
        require_once '../vendor/autoload.php';
        require_once '../framework/autoload.php';

        require_once "../controllers/MainController.php";
        require_once "../controllers/LilyController.php";
        require_once "../controllers/LilyImageController.php";
        require_once "../controllers/LilyInfoController.php";
        require_once "../controllers/OrchidController.php";
        require_once "../controllers/OrchidImageController.php";
        require_once "../controllers/OrchidInfoController.php";
        require_once "../controllers/Controller404.php";
        require_once "../controllers/ObjectController.php"; 
        require_once "../controllers/SearchController.php";
        require_once "../controllers/FlowersCreateController.php";
        require_once "../controllers/ObjectTypeCreateController.php";
        require_once "../controllers/FlowersDeleteController.php";
        require_once "../controllers/FlowersEditController.php";
       
        
        require_once "../controllers/ObjectController.php";

        $loader = new \Twig\Loader\FilesystemLoader('../views');
        $twig = new \Twig\Environment($loader);

        $loader = new \Twig\Loader\FilesystemLoader('../views');
        $twig = new \Twig\Environment($loader, [
            "debug" => true // добавляем тут debug режим
        ]);
        $twig->addExtension(new \Twig\Extension\DebugExtension()); // и активируем расширение


        // создаем экземпляр класса и передаем в него параметры подключения
        // создание класса автоматом открывает соединение
        $pdo = new PDO("mysql:host=localhost;dbname=flowers_know;charset=utf8", "root", "");

        //var_dump($_SERVER["REQUEST_URI"]);

        $router = new Router($twig, $pdo);
        $router->add("/", MainController::class);
        $router->add("/lily", LilyController::class);
        // помните нашу регулярку, которую выше, делали, собственно вот сюда ее и загнали
        

        // Добавляем универсальные маршруты для info и image
        $router->add("/type-flowers/(\d+)", ObjectController::class);

        $router->add("/search", SearchController::class);
        $router->add("/flowers/create", FlowersCreateController::class);
        $router->add("/object-types/create", ObjectTypeCreateController::class);
        $router->add("/type-flowers/(\d+)/delete", FlowersDeleteController::class);
        $router->add("/type-flowers/(\d+)/edit", FlowersEditController::class);





       

        $router->get_or_default(Controller404::class);


        ?>
    </div>
    