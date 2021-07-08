<?php


namespace Model;


class Scene
{
    /** @var Transition[] */
    private array $transitions = [];

    private string $title;
    private string $description;
    private string $view = './View/scenes/';



    /** @var Item[] */
    private array $items = [];

    /** @var Item[] */
    private array $requiredItems = [];

    private ?Scene $resolvedBy;

    /** @var Monster[] */
    private array $monsters = [];


    public function __construct(string $title,string $view, string $description)
    {
        $this->title = $title;
        $this->view .= $view;
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getView(): string
    {
        return $this->view;
    }

    public function addTransition(Transition $transition)
    {
        $this->transitions[] = $transition;
    }

    public function getTransitions(): array
    {
        return $this->transitions;
    }

    /** @return Transition[] */
    public function getValidTransitions(Player $player): array
    {
        $transitions = [];
        foreach($this->getTransitions() AS $transition) {
            if($transition->isValid($player)) {
                $transitions[] = $transition;
            }
        }

        return $transitions;
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

    /**
     * @return Item[]
     */
    public function getRequiredItems(): array
    {
        return $this->requiredItems;
    }


    public function addRequiredItem(Item $requiredItem): void
    {
        $this->requiredItems[] = $requiredItem;
    }


    public function removeItem(Item $item):void {


        foreach($this->items as $key => $value){
            if($item->getName() === $value->getName()){
                unset($this->items[$key]);
            }



        }

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

    /**
     * @return Scene|null
     */
    public function getResolvedBy(): ?Scene
    {
        return $this->resolvedBy;
    }

    /**
     * @param Scene|null $resolvedBy
     */
    public function setResolvedBy(?Scene $resolvedBy): void
    {
        $this->resolvedBy = $resolvedBy;
    }

    public function resolve(Scene $scene)
    {
        if(isset($this->resolvedBy) && $scene === $this->resolvedBy)
        {
            $this->transitions = [];
            foreach ($scene->transitions as $transition)
            {
                $this->transitions[] = $transition;
            }
        }
    }

    /**
     * @return Monster[]
     */
    public function getMonsters(): array
    {
        return $this->monsters;
    }

    /**
     * @param Monster[] $monsters
     */
    public function addMonster(Monster $monsters): void
    {
        $this->monsters[] = $monsters;
    }

    public function killMonster(Monster $monster): void{
        if (($key = array_search($monster, $this->monsters)) !== false) {
            unset($this->monsters[$key]);
        }
    }

}
