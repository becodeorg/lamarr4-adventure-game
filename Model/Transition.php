<?php

namespace Model;

use Model\Scene;

class Transition
{ //inmutable
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