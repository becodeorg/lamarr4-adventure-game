<?php

namespace Model;

class Player
{
    private string $name;
    private array $items = [];
    private int $health = 10;
    private int $skill = 1;

    //Player should be able to increase his/her Skill-Level, because it's a modifier when calculating the attack ! TODO
    //Maybe different kind of Skill-Levels are needed to make the player's character more distinct! One for attack , one for solving puzzle,...? TODO

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

    public function getItems(): array
    {
        return $this->items;
    }

    public function addItem(Item $item): void
    {
        $this->items[] = $item;
    }

    public function findItem(Item $item) : bool
    {
        foreach($this->items AS $potentialItem) {
            if($potentialItem->getName() === $item->getName()) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return int
     */
    public function getHealth(): int
    {
        return $this->health;
    }

    /**
     * @param int $health
     */
    public function damageHealth(int $damage): void
    {
        $this->health -= $damage;
    }

    /**
     * @return int
     */
    public function getSkill(): int
    {
        return $this->skill;
    }

    /**
     * @param int $skill
     */
    public function increaseSkill(int $skill): void
    {
        $this->skill += $skill;
    }

    public function attack(Monster $monster): void {
        $monster->damageHealth($this->getSkill());

    }

}
