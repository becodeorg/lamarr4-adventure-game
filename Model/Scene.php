<?php


namespace Model;


class Scene
{
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

    public function addItem(Item $item):void
    {
        $this->items[] = $item;
    }

    public function getSceneByCommand(string $command) : ?Scene
    {
        foreach ($this->getTransitions() as $transition) {
            if ($transition->getCommand() === $command) {
                return $transition->getScene();
            }
        }
        return null;
    }
}