<?php

namespace Controller;

use Model\Player;
use Model\Scene;
use Model\Transition;

class HomepageController
{
    public function render(){

        session_start();

        $scenes = [
            'unicorn' => new Scene('Search for the unicorn.', 'You are looking for the unicorn. But you do not see him, only some hoofs left in the poop. But there is something else in the poop... namely, a key! All shiny.'),
            'zombiefight' => new Scene('Fight against the zombies!', 'Do you fight the zombies or do you walk away? After all, there a super slow!'),
            'openingscene' => new Scene('Welcome to the game,', 'The world is gone. The only thing left in the rubble is a road. The way up is blocked by angry crows! To the right you see a skeleton and zombies! To the left there are traces of a unicorn. Which way do you go?')
        ];

        $scenes['openingscene']->addTransition(new Transition('left', $scenes['unicorn']));
        $scenes['openingscene']->addTransition(new Transition('right', $scenes['zombiefight']));

        $activeScene = $scenes['openingscene'];

        if (isset($_POST['player'])) {
            $player = new Player($_POST['player']);
            $_SESSION['player'] = $player;

        } else if (isset($_SESSION['player'])) {
            $player = $_SESSION['player'];
        } else {
            $player = new Player('Dummy');
        }

        if (!empty($_GET['command'])) {
            $activeScene = $activeScene->findValidTransition($_GET['command']);

            if ($activeScene === null) {
                die('Someboy or somegirl do this better than me!');//@todo!
            }
        }

        require 'View/homepage.php';
    }
}