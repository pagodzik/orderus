<?php
//autoloader
//require_once 'config/paths.php';
require_once 'config/database.php';

require_once 'libs/Bootstrap.php';
require_once 'libs/Controller.php';
require_once 'libs/Model.php';
require_once 'libs/View.php';

require_once 'controllers/Skills.php';
require_once 'controllers/Player.php';
require_once 'controllers/Battle.php';

$app = new Bootstrap();
