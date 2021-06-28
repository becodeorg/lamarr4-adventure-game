<?php


namespace Model;


class StoryManager
{

    private array $scenes;
    private array $items;

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return array
     */
    public function getMonsters(): array
    {
        return $this->monsters;
    }
    private array $monsters;

    /**
     * @return array
     */
    public function getScenes(): array
    {
        return $this->scenes;
    }


    private function initializeLevel(): void
    {
        $this->scenes = [
            'openingScene' => new Scene('Welcome to the game,','openingScene.php', 'The world is gone. The only thing left in the rubble is a road. The way up is blocked by angry crows! To the right you see a skeleton and zombies! To the left there are traces of a unicorn. Which way do you go?'),
            'unicorn' => new Scene('Search for the unicorn.','unicornScene.php', 'You are looking for the unicorn. But you do not see him, only some hoofs left in the poop. But there is something else in the poop... namely, a key! All shiny.'),
            'unicornPoop' => new Scene('Search for the unicorn.','poopScene.php', 'Pilfering through the magical pony\'s poop you find a key. How\'d that get there? You decide to pocket it'),
            'zombieFight' => new Scene('Fight against the zombies!','zombieScene.php', 'Do you fight the zombies or do you walk away? After all, there a super slow!'),
            'pitOfDoom' => new Scene("big pit of doom!",'doomScene.php', "before you, the path suddenly halts as a giant crevice opens in the earth and stops your progress. you have no choice but to return to whence you came."),
            'theShack' => new Scene("The abandoned shack",'shackScene.php', "It's an old abandoned shack! It looks as if it might collapse at any moment. This shack might hold a lot of useful tools for you to use! The door is locked."),
            'insideTheShack' => new Scene("you entered the shack",'insideTheShackScene.php', "You enter the old, croaking wooden shack. Some dim lights shines on you from the crevices. In the darkness you can see a bottle of water on the ground.")
            //@todo write more stuffs
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
        $this->scenes['openingScene']->addTransition(new Transition('unicorn yeah!', $this->scenes['unicorn']));
        $this->scenes['openingScene']->addItem($this->items['butterfly']);

        $this->scenes['zombieFight']->addTransition(new Transition('unicorn yeah!', $this->scenes['unicorn']));
        $this->scenes['zombieFight']->addTransition(new Transition('Go to the Doom', $this->scenes['pitOfDoom']));
        $this->scenes['zombieFight']->addItem($this->items["diaper"]);
        $this->scenes['zombieFight']->addMonster($this->monsters['zombie']);

        $this->scenes['unicorn']->addTransition(new Transition('Go back to the beginning', $this->scenes['openingScene']));
        $this->scenes['unicorn']->addTransition(new Transition('Go for the zombies', $this->scenes['zombieFight']));
        $this->scenes['unicorn']->addTransition(new Transition('poop', $this->scenes['unicornPoop']));

        $this->scenes['unicornPoop']->addTransition(new Transition('Go back to the beginning', $this->scenes['openingScene']));
        $this->scenes['unicornPoop']->addTransition(new Transition('Go for the zombies', $this->scenes['zombieFight']));
        $this->scenes['unicornPoop']->addItem($this->items['key']);

        $this->scenes['pitOfDoom']->addTransition(new Transition('Shuffle to the zombies ♫', $this->scenes['zombieFight']));
        $this->scenes['pitOfDoom']->addTransition(new Transition('Run to the shack', $this->scenes['theShack']));

        $this->scenes['theShack']->addTransition(new Transition('Go to the Doom', $this->scenes['pitOfDoom']));
        $this->scenes['theShack']->addTransition(new Transition('Go back to the start', $this->scenes['openingScene']));
        $this->scenes['theShack']->addTransition(new Transition('Enter the shack', $this->scenes['insideTheShack'], $this->items['key']));

    }
}