<?php

namespace Controller;

use Model\Diaper;
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
            'theShack' => new Scene("The abandoned shack", "It's an old abandoned shack! It looks as if it might collapse at any moment. This shack might hold a lot of useful tools for you to use!"),
            'insideTheShack' => new Scene("you entered the shack", "") //@todo write more stuffs
        ];

        $scenes['openingscene']->addTransition(new Transition('go to the shack!', $scenes['theShack']));
        $scenes['openingscene']->addTransition(new Transition('unicorn yeih!', $scenes['unicorn']));

        $scenes['zombiefight']->addTransition(new Transition('unicorn yeih!', $scenes['unicorn']));
        $scenes['zombiefight']->addTransition(new Transition('Go tp the Doom', $scenes['pitOfDoom']));

        $scenes['unicorn']->addTransition(new Transition('Go back to the beginning', $scenes['openingscene']));
        $scenes['unicorn']->addTransition(new Transition('Go for the zombies', $scenes['zombiefight']));

        $scenes['pitOfDoom']->addTransition(new Transition('left', $scenes['zombiefight']));
        $scenes['pitOfDoom']->addTransition(new Transition('right', $scenes['theShack']));

        $scenes['theShack']->addTransition(new Transition('left', $scenes['pitOfDoom']));
        $scenes['theShack']->addTransition(new Transition('right', $scenes['openingscene']));
        // $scenes['theShack']->addTransition(new Transition('enter', $scenes['insideTheShack']));

        //pit--unicorn--openingscene--zombie

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

        if (!empty($_POST['command'])) {

            $nextScene = $activeScene->getSceneByCommand($_POST['command']);

            if ($nextScene === null) {
                $nextScene = $_SESSION['currentScene'];
               // die('Someboy or somegirl do this better than me!');//@todo!
            }
            $activeScene = $nextScene;
        }

        $_SESSION['currentScene'] = $activeScene;

        $scenes['pitOfDoom']->addItem(new Diaper());

        if (!empty($_GET['action'])){
            if ($_GET['action']==='use'){
                foreach ($activeScene->getItems() as $item){
                    $item->use();
                }
            }
        }

        if (!empty($_POST['command']) && $_POST['command'] === "help"){

            $helpmessage = "available commands are 'left, right , use, search";

        }


        if (isset($_GET['action']) && isset($_GET['item_id'])){
            if ($_GET['action'] === 'use'){
               //todo $the_item = $activeScene->getItemById($_GET['item_id']);
                //todo $the_item->use();
            }
        }

        require 'View/homepage.php';
    }
}
