<?php

namespace Model;

class Item implements ItemInterface
{
    private string $name;

    /**
     * Item constructor.
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

    public function attack(Player $player): int {
        $randNum = rand(0,10);
        $skill_level = $player->getSkill();
        $randNum += $skill_level;
        return $randNum;
    }


    public function use(): void {


    }

}