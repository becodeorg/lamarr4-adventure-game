<?php

declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use Controller\HomepageController;

require 'Controller/HomepageController.php';
require 'Model/ItemInterface.php';
require 'Model/Item.php';
require 'Model/Player.php';
require 'Model/Scene.php';
require 'Model/Transition.php';
require 'Model/Diaper.php';
require 'Model/Monster.php';

$controller = new HomepageController();
$controller->render();
