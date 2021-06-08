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


    public function use() {

    }

}