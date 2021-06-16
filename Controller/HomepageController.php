<?php


namespace Controller;


use Model\Diaper;
use Model\Item;
use Model\Player;
use Model\Scene;
use Model\Transition;

class HomepageController
{
    public function render()
    {
        session_start();

        $scenes = [
            'openingScene' => new Scene('Welcome to the game,', 'The world is gone. The only thing left in the rubble is a road. The way up is blocked by angry crows! To the right you see a skeleton and zombies! To the left there are traces of a unicorn. Which way do you go?'),
            'unicorn' => new Scene('Search for the unicorn.', 'You are looking for the unicorn. But you do not see him, only some hoofs left in the poop. But there is something else in the poop... namely, a key! All shiny.'),
            'unicornPoop' => new Scene('Search for the unicorn.', 'Pilfering through the magical pony\'s poop you find a key. How\'d that get there? You decide to pocket it'),
            'zombieFight' => new Scene('Fight against the zombies!', 'Do you fight the zombies or do you walk away? After all, there a super slow!'),
            'pitOfDoom' => new Scene("big pit of doom!", "before you, the path suddenly halts as a giant crevice opens in the earth and stops your progress. you have no choice but to return to whence you came."),
            'theShack' => new Scene("The abandoned shack", "It's an old abandoned shack! It looks as if it might collapse at any moment. This shack might hold a lot of useful tools for you to use! The door is locked."),
            'insideTheShack' => new Scene("you entered the shack", "You enter the old, croacking woouden shack. Some dim lights shines on you from the crevices. In the darkness you can see a bottle of water on the ground.") //@todo write more stuffs
        ];
        $items = [
            'key' => new Item('key', 'You unlock the wooden door'),
            'diaper' => new Diaper('Mr.dirty diaper', 'Ypu scoop of the magic'),
            'butterfly' => new Item("butterfly", "The butterfly distracts the zombies away."),
            'torch' => new Item('torch', "You light up everywhere and the spirits run to the darkness"),
            'bottle of water' => new Item('water', 'You give water to the magic tree an receive a gift.'),
            'machete' =>new Item('machete', 'cleave'),
        ];

        $scenes['openingScene']->addTransition(new Transition('go to the shack!', $scenes['theShack']));
        $scenes['openingScene']->addTransition(new Transition('unicorn yeih!', $scenes['unicorn']));
        $scenes['openingScene']->addItem($items['butterfly']);


        $scenes['zombieFight']->addTransition(new Transition('unicorn yeih!', $scenes['unicorn']));
        $scenes['zombieFight']->addTransition(new Transition('Go tp the Doom', $scenes['pitOfDoom']));
        $scenes['zombieFight']->addItem($items["diaper"]);

        $scenes['unicorn']->addTransition(new Transition('Go back to the beginning', $scenes['openingScene']));
        $scenes['unicorn']->addTransition(new Transition('Go for the zombies', $scenes['zombieFight']));
        $scenes['unicorn']->addTransition(new Transition('poop', $scenes['unicornPoop']));

        $scenes['unicornPoop']->addTransition(new Transition('Go back to the beginning', $scenes['openingScene']));
        $scenes['unicornPoop']->addTransition(new Transition('Go for the zombies', $scenes['zombieFight']));
        $scenes['unicornPoop']->addItem($items['key']);

        $scenes['pitOfDoom']->addTransition(new Transition('left', $scenes['zombieFight']));
        $scenes['pitOfDoom']->addTransition(new Transition('right', $scenes['theShack']));

        $scenes['theShack']->addTransition(new Transition('left', $scenes['pitOfDoom']));
        $scenes['theShack']->addTransition(new Transition('right', $scenes['openingScene']));
        $scenes['theShack']->addTransition(new Transition('enter the shack', $scenes['insideTheShack'], $items['key']));

        // @ Todo check if item is stored in player

        //pit--unicorn--openingScene--zombie

        $activeScene = (isset($_SESSION['currentScene']) && $_SESSION['currentScene'] instanceof Scene)?
            $_SESSION['currentScene']:$scenes['openingScene'];

        $player = (isset($_SESSION['player']) && $_SESSION['player'] instanceof Player)?
            $_SESSION['player']:new Player('Dummy');


        if (isset($_POST['playerName'])) {

           $player->setName($_POST['playerName']);

        }

        if (!empty($_POST['command'])) {

            $nextScene = $activeScene->getSceneByCommand($_POST['command']);

            if ($nextScene instanceof Scene) {
                $activeScene->resolve($nextScene);
                $activeScene = $nextScene;
                // die('Someboy or somegirl do this better than me!');//@todo!
            }
        }


        if (!empty($activeScene->getItems())) {
            foreach ($activeScene->getItems() as $item) {

                $player->addItem($item);
                $activeScene->removeItem($item);
            }

        }


        if (!empty($_GET['action'])) {
            if ($_GET['action'] === 'use') {
                foreach ($activeScene->getItems() as $item) {
                    $item->use();
                }
            }
        }

        if (isset($_GET['action']) && isset($_GET['item_id'])) {
            if ($_GET['action'] === 'use') {
                //todo $the_item = $activeScene->getItemById($_GET['item_id']);
                //todo $the_item->use();
            }
        }
        $_SESSION['currentScene'] =  $activeScene ;
        $_SESSION['player'] =  $player ;


        require 'View/homepage.php';
    }
}
