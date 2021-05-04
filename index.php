<?php
class Item {}

class Transition { //inmutable
    private string $command;
    private Scene $scene;

    public function __construct(string $command, Scene $scene)
    {
        $this->command = $command;
        $this->scene = $scene;
    }

    public function getCommand(): string
    {
        return $this->command;
    }

    public function getScene(): Scene
    {
        return $this->scene;
    }
}

class Scene {
    /** @var Transition[] */
    private array $transitions = [];

    private string $title;
    private string $description;

    /** @var Item[] */
    private array $items = [];

    public function __construct(string $title, string $description)
    {
        $this->title = $title;
        $this->description = $description;
    }

    public function addTransition(Transition $transition)
    {
        $this->transitions[] = $transition;
    }

    public function getTransitions(): array
    {
        return $this->transitions;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function findValidTransation(string $command)
    {
        foreach($this->getTransitions() AS $transition) {
            
        }
    }
}

$scenes = [
    'unicorn' => new Scene('Search for the unicorn.', 'You are looking for the unicorn. But you do not see him, only some hoofs left in the poo. But there is something else in the poo... namely, a key! All "shiny".'),
    'zombiefight' => new Scene('Fight against the zombies!', 'Do you fight the zombies or do you walk away? After all, there a super slow!'),
    'openingscene' => new Scene('Welcome to the game', 'The world is gone. The only thing left in the rubble is a road. The way up is blocked by angry crows! To the right you see a skelleton and zombies! To the left there are traces of a unicorn. Which way do you go?')
];

$scenes['openingscene']->addTransition(new Transition('left', $scenes['unicorn']));
$scenes['openingscene']->addTransition(new Transition('right', $scenes['zombiefight']));

$activeScene = $scenes['openingscene'];

if(!empty($_GET['command'])) {
    $activeScene = $activeScene->findValidTransation($_GET['command']);

    if($activeScene === null) {
        die('Someboy do this better than me!');//@todo!
    }
}

echo '<h1>'. $activeScene->getTitle() .'</h1>';
echo '<p>'. $activeScene->getDescription() .'</p>';
foreach($activeScene->getTransitions() AS $transition) {
    echo '<li><a href="?command='. $transition->getCommand() .'">'. $transition->getCommand() .'</a></li>';
}