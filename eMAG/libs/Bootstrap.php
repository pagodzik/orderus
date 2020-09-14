<?php


class Bootstrap
{

    /**
     * Bootstrap constructor.
     */
    public function __construct()
    {
        $url = explode('/', rtrim(($_GET['url'] ?? 'index'),'/'));
        $controllerName = ucfirst(strtolower($url[0]));

        $file = 'controllers/' . $controllerName . '.php';

        if (!file_exists($file)) {
            $file = 'controllers/AppError.php';
            $controllerName = 'AppError';
        }
        require_once $file;
        $controller = new $controllerName();
        $controller->index();
        if ($controllerName == 'AppError') {
            return;
        }

        $battle = new Battle('Orderus', 'Monster');
        $battle->hero1->showPlayer();
        $battle->hero2->showPlayer();
        $battle->getFirstAttacker();


        do {
            $battle->turnNumber();

            $battle->turn();

            if (!$battle->ifAlive($battle->defender)) {
                Break;
            }

            $battle->swapRoles();

            $battle->turn();

            if (!$battle->ifAlive($battle->defender)) {
                Break;
            }
            $battle->swapRoles();
            $battle->nextTurn();
        }
        while ($battle->turnNumber <= 20);

        if ($battle->turnNumber >= 20) {
            $battle->view->finalResult = '<b>There are no winner here...</b>';
        }
        $battle->index();

    }

}
