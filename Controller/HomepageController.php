<?php


namespace Controller;


use Model\Diaper;
use Model\Item;
use Model\Monster;
use Model\Player;
use Model\Scene;
use Model\StoryManager;
use Model\Transition;

class HomepageController
{

    private Scene $currentScene;
    private Player $player;
    private StoryManager $storyManager;

    /**
     * HomepageController constructor.
     */
    public function __construct()
    {
        $this->storyManager = new StoryManager();
        $this->storyManager->initializeLevel();

    }




    public function render()
    {
        session_start();
        // @ Todo check if item is stored in player

        $this->selectCurrentScene($_SESSION, $this->storyManager->getScenes()['openingScene']);

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


           foreach($this->currentScene->getMonsters() AS $monster) {
                $monster->getName();
            }


        if (!empty($_GET['action']))
        {
            switch ($_GET['action']){
                case 'use':
                    foreach ($this->currentScene->getItems() as $item)
                    {
                        $item->use();
                    }
                    break;
                case 'attack':
                    foreach ($this->currentScene->getMonsters() as $monster)
                    {
                        $monster->getName();
                        $this->player->attack($monster);
                        $monster->attack($this->player);
                        if ($monster->getHealth() == 0){
                            $this->currentScene->killMonster($monster);
                            $this->currentScene->getMonsters(); //todo watch out its not finished, monsters need to be filled in! Also watch out, this switch case must replace the other if statements from line 97 till 112
                        }
                    }

            }
        }

        if (isset($_GET['action'], $_GET['item_id']))
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

    private function selectCurrentScene(array $session, Scene $openingScene): void
    {
        $this->currentScene = (isset($session['currentScene']) && $session['currentScene'] instanceof Scene) ? $session['currentScene'] : $openingScene;
    }

    private function selectCurrentPlayer(array $session, Player $defaultPlayer ): void
    {
        $this->player = (isset($session['player']) && $session['player'] instanceof Player) ? $session['player'] : $defaultPlayer;
    }

    private function redefinePlayerName(array $post): void
    {
        if (isset($_POST['playerName']))
        {

            $this->player->setName($_POST['playerName']);

        }
    }
}
