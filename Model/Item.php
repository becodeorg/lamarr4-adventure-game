<?php

namespace Model;

class Item implements ItemInterface
{
    private string $name;
    private string $action;

    /**
     * Item constructor.
     * @param string $name
     * @param string $action
     */
    public function __construct(string $name, string $action)
    {
        $this->name = $name;
        $this->action =$action;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function attack(Player $player): int {
        $randNum = rand(0,10);
        $skill_level = $player->getSkill();
        $randNum += $skill_level;
        return $randNum;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }


    public function use(): void {


    }

}
