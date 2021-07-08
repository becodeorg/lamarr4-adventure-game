<?php


namespace Model;


class Battle
{

    private array $messages;

    /**
     * @return array
     */
    public function getMessages(): string
    {
        $message = "";

        foreach ($this->messages as $singleMessage ){

            $message .= $singleMessage ."<br/>";
        }

        return $message;

    }
// TODO display messages

    public function battle(Monster $monster, Player $player, Scene $currentScene){


           // $monster->getName();
            $player->attack($monster);
            $this->messages['playerHit'] = " You hit ". $monster->getName()."for".$player->getSkill() ."hp";
            $monster->attack($player);
            $this->messages['monsterHit'] = $monster->getName()." hitted you for ".$monster->getDamage();
            if ($monster->getHealth() <= 0){
                $currentScene->killMonster($monster);

                //$currentScene->getMonsters(); //todo watch out its not finished, monsters need to be filled in! Also watch out, this switch case must replace the other if statements from line 97 till 112
            }


    }

}
