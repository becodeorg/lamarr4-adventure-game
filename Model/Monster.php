<?php


namespace Model;


class Monster
{
    private int $health = 2;
    private int $damage = 3;
    // Monster do still need an attack method ! TODO
    // Maybe also implement a defense method, because some monsters are more resilient against some weapons ! TODO

    /**
     * Monster constructor.
     * @param int $health
     * @param int $damage
     */
    public function __construct(int $health, int $damage)
    {
        $this->health = $health;
        $this->damage = $damage;
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
    public function damageHealth(int $health): void
    {
        $this->health -= $health;
    }

    /**
     * @return int
     */
    public function getDamage(): int
    {
        return $this->damage;
    }



}