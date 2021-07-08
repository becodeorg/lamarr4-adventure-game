<?php

namespace Model;

use Model\Scene;

class Transition
{ //inmutable
    private string $command;
    private Scene $scene;
    private ?Item $requiredItem = null;

    public function __construct(string $command, Scene $scene, Item $requiredItem = null)
    {
        $this->command = $command;
        $this->scene = $scene;
        $this->requiredItem = $requiredItem;
    }

    public function getCommand(): string
    {
        return $this->command;
    }

    public function getScene(): Scene
    {
        return $this->scene;
    }

    public function getRequiredItem(): ?Item
    {
        return $this->requiredItem;
    }

    public function isValid(Player $player) : bool
    {
        if($this->requiredItem === null) {
            return true;
        }

        return $player->findItem($this->requiredItem);
    }
}