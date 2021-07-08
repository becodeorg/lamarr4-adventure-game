<?php


namespace Controller;


use Model\Battle;
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
    private Battle $battle;

    /**
     * HomepageController constructor.
     */
    public function __construct()
    {
        $this->storyManager = new StoryManager();
        $this->storyManager->initializeLevel();
        $this->battle = new Battle();

    }


    public function render()
    {
        session_start();
        // @ Todo check if item is stored in player

        $this->selectCurrentScene($_SESSION, $this->storyManager->getScenes()['openingScene']);

        $this->selectCurrentPlayer($_SESSION, new Player('Dummy'));
        $this->redefinePlayerName($_POST);

        if (!empty($_POST['command'])) {

            $nextScene = $this->currentScene->getSceneByCommand($_POST['command']);

            if ($nextScene instanceof Scene) {
                $this->currentScene->resolve($nextScene);
                $this->currentScene = $nextScene;
                $this->redirect();
                // die('Someboy or somegirl do this better than me!');//@todo!
            }
        }


//        if (!empty($activeScene->getItems())) {
        foreach ($this->currentScene->getItems() as $item) {

            $this->player->addItem($item);
            $this->currentScene->removeItem($item);
        }

//        }


        if (!empty($_GET['action'])) {

            switch ($_GET['action']) {
                case 'use':
                    foreach ($this->currentScene->getItems() as $item) {
                        $item->use();
                    }
                    break;
                case 'attack':
                    foreach ($this->currentScene->getMonsters() as $monster) {

                        $this->battle->battle($monster, $this->player, $this->currentScene);

                    }
            }
            $this->redirect();
        }

        if ($this->player->getHealth() <= 0) {
            $this->storeInSession();
            require_once "View/game_over.php";
            exit;
        }

        foreach ($this->currentScene->getMonsters() as $monster) {
            $monster->getName();
        }

        if (isset($_GET['action'], $_GET['item_id'])) {
            if ($_GET['action'] === 'use') {
                //todo $the_item = $activeScene->getItemById($_GET['item_id']);
                //todo $the_item->use();
            }
        }

        $this->storeInSession();
        $activeScene = $this->currentScene;
        $player = $this->player;

        require 'View/homepage.php';
    }

    private function selectCurrentScene(array $session, Scene $openingScene): void
    {
        $this->currentScene = (isset($session['currentScene']) && $session['currentScene'] instanceof Scene) ? $session['currentScene'] : $openingScene;
    }

    private function selectCurrentPlayer(array $session, Player $defaultPlayer): void
    {
        $this->player = (isset($session['player']) && $session['player'] instanceof Player) ? $session['player'] : $defaultPlayer;
    }

    private function redefinePlayerName(array $post): void
    {
        if (isset($_POST['playerName'])) {

            $this->player->setName($_POST['playerName']);

        }
    }

    private function storeInSession(): void
    {
        $_SESSION['currentScene'] = $this->currentScene;
        $_SESSION['player'] = $this->player;
    }

    private function redirect()
    {
        $this->storeInSession();
        header("Location:index.php");
        exit;
    }
}
