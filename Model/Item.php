<?php

namespace Model;

class Item implements ItemInterface
{
    private string $name;
    private string $action;
    private string $image;

    /**
     * Item constructor.
     * @param string $name
     * @param string $action
     * * @param string $image
     */
    public function __construct(string $name, string $action, string $image)
    {
        $this->name = $name;
        $this->action =$action;
        $this->image =$image;
    }

    /**
 * @return string
 */
public function getImage(): string
{
    return $this->image;
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
