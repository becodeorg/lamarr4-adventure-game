<?php


namespace Controller;


use Model\Diaper;
use Model\Item;
use Model\Monster;
use Model\Player;
use Model\Scene;
use Model\Transition;

class HomepageController
{
    private array $scenes;
    private array $items;
    private array $monsters;

    private Scene $currentScene;
    private Player $player;


    public function render()
    {
        session_start();
//        session_destroy();

        $this->initializeLevel();

        // @ Todo check if item is stored in player


        $this->selectCurrentScene($_SESSION, $this->scenes['openingScene']);

        $this->selectCurrentPlayer($_SESSION, new Player('Dummy'));
        $this->redefinePlayerName($_POST);

        if (!empty($_POST['command']))
        {

            $nextScene = $this->currentScene->getSceneByCommand($_POST['command']);

            if ($nextScene instanceof Scene)
            {
                $this->currentScene->resolve($nextScene);
                $this->currentScene = $nextScene;
                // die('Someboy or somegirl do this better than me!');//@todo!
            }
        }


//        if (!empty($activeScene->getItems())) {
        foreach ($this->currentScene->getItems() as $item)
        {

            $this->player->addItem($item);
            $this->currentScene->removeItem($item);
        }

//        }

//TODO: figure it out for yourself
//            foreach($this->currentScene->getMonsters() AS $monster) {
//                $monster->getName();
//            }


        if (!empty($_GET['action']))
        {
            if ($_GET['action'] === 'use')
            {
                foreach ($this->currentScene->getItems() as $item)
                {
                    $item->use();
                }
            }
        }

        if (isset($_GET['action']) && isset($_GET['item_id']))
        {
            if ($_GET['action'] === 'use')
            {
                //todo $the_item = $activeScene->getItemById($_GET['item_id']);
                //todo $the_item->use();
            }
        }
        $_SESSION['currentScene'] = $this->currentScene;
        $activeScene = $this->currentScene;
        $_SESSION['player'] = $this->player;
        $player = $this->player;


        require 'View/homepage.php';
    }

    private function initializeLevel(): void
    {
        $this->scenes = [
            'openingScene' => new Scene('Welcome to the game,', 'The world is gone. The only thing left in the rubble is a road. The way up is blocked by angry crows! To the right you see a skeleton and zombies! To the left there are traces of a unicorn. Which way do you go?'),
            'unicorn' => new Scene('Search for the unicorn.', 'You are looking for the unicorn. But you do not see him, only some hoofs left in the poop. But there is something else in the poop... namely, a key! All shiny.'),
            'unicornPoop' => new Scene('Search for the unicorn.', 'Pilfering through the magical pony\'s poop you find a key. How\'d that get there? You decide to pocket it'),
            'zombieFight' => new Scene('Fight against the zombies!', 'Do you fight the zombies or do you walk away? After all, there a super slow!'),
            'pitOfDoom' => new Scene("big pit of doom!", "before you, the path suddenly halts as a giant crevice opens in the earth and stops your progress. you have no choice but to return to whence you came."),
            'theShack' => new Scene("The abandoned shack", "It's an old abandoned shack! It looks as if it might collapse at any moment. This shack might hold a lot of useful tools for you to use! The door is locked."),
            'insideTheShack' => new Scene("you entered the shack", "You enter the old, croacking woouden shack. Some dim lights shines on you from the crevices. In the darkness you can see a bottle of water on the ground.") //@todo write more stuffs
        ];
        $this->items = [
            'key' => new Item('key', 'You unlock the wooden door', "img/butterfly.png"),
            'diaper' => new Diaper('Mr.dirty diaper', 'Ypu scoop of the magic', "img/butterfly.png"),
            'butterfly' => new Item("butterfly", "The butterfly distracts the zombies away.", "img/butterfly.png"),
            'torch' => new Item('torch', "You light up everywhere and the spirits run to the darkness", "img/butterfly.png"),
            'bottle of water' => new Item('water', 'You give water to the magic tree an receive a gift.', "img/butterfly.png"),
            'machete' => new Item('machete', 'cleave', "img/butterfly.png"),
        ];
        $this->monsters = [
            'zombie' => new Monster('zombie', 1, 1),
            'dragon' => new Monster('Dragon', 5000, 5)
        ];

        //pit--unicorn--openingScene--zombie
        //TODO: please update map

        $this->scenes['openingScene']->addTransition(new Transition('go to the shack!', $this->scenes['theShack']));
        $this->scenes['openingScene']->addTransition(new Transition('unicorn yeih!', $this->scenes['unicorn']));
        $this->scenes['openingScene']->addItem($this->items['butterfly']);

        $this->scenes['zombieFight']->addTransition(new Transition('unicorn yeih!', $this->scenes['unicorn']));
        $this->scenes['zombieFight']->addTransition(new Transition('Go tp the Doom', $this->scenes['pitOfDoom']));
        $this->scenes['zombieFight']->addItem($this->items["diaper"]);
        $this->scenes['zombieFight']->addMonster($this->monsters['zombie']);

        $this->scenes['unicorn']->addTransition(new Transition('Go back to the beginning', $this->scenes['openingScene']));
        $this->scenes['unicorn']->addTransition(new Transition('Go for the zombies', $this->scenes['zombieFight']));
        $this->scenes['unicorn']->addTransition(new Transition('poop', $this->scenes['unicornPoop']));

        $this->scenes['unicornPoop']->addTransition(new Transition('Go back to the beginning', $this->scenes['openingScene']));
        $this->scenes['unicornPoop']->addTransition(new Transition('Go for the zombies', $this->scenes['zombieFight']));
        $this->scenes['unicornPoop']->addItem($this->items['key']);

        $this->scenes['pitOfDoom']->addTransition(new Transition('left', $this->scenes['zombieFight']));
        $this->scenes['pitOfDoom']->addTransition(new Transition('right', $this->scenes['theShack']));

        $this->scenes['theShack']->addTransition(new Transition('left', $this->scenes['pitOfDoom']));
        $this->scenes['theShack']->addTransition(new Transition('right', $this->scenes['openingScene']));
        $this->scenes['theShack']->addTransition(new Transition('enter the shack', $this->scenes['insideTheShack'], $this->items['key']));

    }

    private function selectCurrentScene(array $session, Scene $openingScene): void
    {
        $this->currentScene = (isset($session['currentScene']) && $session['currentScene'] instanceof Scene) ?
            $session['currentScene'] : $openingScene;
    }

    private function selectCurrentPlayer(array $session, Player $defaultPlayer ): void
    {
        $this->player = (isset($session['player']) && $session['player'] instanceof Player) ?
            $session['player'] : $defaultPlayer;
    }

    private function redefinePlayerName(array $post): void
    {
        if (isset($_POST['playerName']))
        {

            $this->player->setName($_POST['playerName']);

        }
    }
}
