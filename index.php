<?php

class Item {}

class Player {
    private string $name;

    /**
     * Player constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }


}

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

    public function findValidTransition(string $command)
    {
        foreach($this->getTransitions() AS $transition) {
            if($transition->getCommand() === $command) {
                return $transition->getScene();
            }
        } return null;
    }
}
session_start();

$scenes = [
    'unicorn' => new Scene('Search for the unicorn.', 'You are looking for the unicorn. But you do not see him, only some hoofs left in the poop. But there is something else in the poop... namely, a key! All shiny.'),
    'zombiefight' => new Scene('Fight against the zombies!', 'Do you fight the zombies or do you walk away? After all, there a super slow!'),
    'openingscene' => new Scene('Welcome to the game,', 'The world is gone. The only thing left in the rubble is a road. The way up is blocked by angry crows! To the right you see a skeleton and zombies! To the left there are traces of a unicorn. Which way do you go?')
];

$scenes['openingscene']->addTransition(new Transition('left', $scenes['unicorn']));
$scenes['openingscene']->addTransition(new Transition('right', $scenes['zombiefight']));

$activeScene = $scenes['openingscene'];

if(isset($_POST['player'])) {
    $player = new Player($_POST['player']);
    $_SESSION['player'] = $player;

} else if(isset($_SESSION['player'])){
    $player = $_SESSION['player'];
}
else {
    $player = new Player('Dummy');
}

if(!empty($_GET['command'])) {
    $activeScene = $activeScene->findValidTransition($_GET['command']);

    if($activeScene === null) {
        die('Someboy or somegirl do this better than me!');//@todo!
    }
}


echo '<h2>'. $player->getName() .'</h2>';
echo '<h1>'. $activeScene->getTitle() .'</h1>';
echo '<p id="message"></p>';
foreach($activeScene->getTransitions() AS $transition) {
    echo '<li><a href="?command='. $transition->getCommand() .'">'. $transition->getCommand() .'</a></li>';
}
?>
<form action="" method="post">
    <label for="player">
        <input type="text" name="player">
    </label>
</form>

<script type="text/javascript">
    let message = "<?php echo $activeScene->getDescription() ?>";
    console.log(message);
    let number = 0;
    function typeWriter(message){
        for(let i = 0; i < message.length; i++){
            let random = Math.floor(Math.random() * 100);
            number += random;
            setTimeout(function (){
                document.getElementById('message').innerHTML += message[i];
            }, number);
        }
    }

    typeWriter(message);
</script>