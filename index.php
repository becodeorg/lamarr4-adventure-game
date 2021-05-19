<?php

declare(strict_types=1);

use Controller\HomepageController;

require 'Controller/HomepageController.php';
require 'Model/ItemInterface.php';
require 'Model/Item.php';
require 'Model/Player.php';
require 'Model/Scene.php';
require 'Model/Transition.php';
require 'Model/Diaper.php';

$controller = new HomepageController();
$controller->render();

?>
