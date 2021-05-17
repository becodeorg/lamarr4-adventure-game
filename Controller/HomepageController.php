<?php

namespace Controller;

use Model\Player;
use Model\Scene;
use Model\Transition;

class HomepageController
{
    public function render()
    {

        session_start();

        $scenes = [
            'openingscene' => new Scene('Welcome to the game,', 'The world is gone. The only thing left in the rubble is a road. The way up is blocked by angry crows! To the right you see a skeleton and zombies! To the left there are traces of a unicorn. Which way do you go?'),
            'unicorn' => new Scene('Search for the unicorn.', 'You are looking for the unicorn. But you do not see him, only some hoofs left in the poop. But there is something else in the poop... namely, a key! All shiny.'),
            'zombiefight' => new Scene('Fight against the zombies!', 'Do you fight the zombies or do you walk away? After all, there a super slow!'),
            'pitOfDoom' => new Scene("big pit of doom!", "before you, the path suddenly halts as a giant crevice opens in the earth and stops your progress. you have no choice but to return to whence you came."),
        ];

        $scenes['openingscene']->addTransition(new Transition('left', $scenes['unicorn']));
        $scenes['openingscene']->addTransition(new Transition('right', $scenes['zombiefight']));

        $scenes['unicorn']->addTransition(new Transition('left', $scenes['pitOfDoom']));
        $scenes['unicorn']->addTransition(new Transition('right', $scenes['openingscene']));

        $scenes['pitOfDoom']->addTransition(new Transition('left', $scenes['unicorn']));

        if (!isset($_SESSION['currentScene'])) {
            $_SESSION['currentScene'] = $scenes['openingscene'];
        }
        $activeScene = $_SESSION['currentScene'];


        if (isset($_POST['player'])) {
            $player = new Player($_POST['player']);
            $_SESSION['player'] = $player;

        } else if (isset($_SESSION['player'])) {
            $player = $_SESSION['player'];
        } else {
            $player = new Player('Dummy');
        }

        if (!empty($_GET['command'])) {

            $nextScene = $_SESSION['currentScene']->findValidTransition($_GET['command']);

            if ($nextScene === null) {
                die('Someboy or somegirl do this better than me!');//@todo!
            }
            $activeScene = $nextScene;
        }


        require 'View/homepage.php';
    }
}
