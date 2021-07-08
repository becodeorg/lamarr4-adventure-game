<?php

use Model\Player;
use Model\Scene;
include './View/includes/header.php';

/** @var Player $player
 * @var Scene $activeScene
 * @var Model\Monster $monster
 */

?>

<main>
    <section class="first-section">

        <div class="game-container">
            <form class="playerName text-center mx-auto" action="" method="post">
                <label for="player">Your name</label>
                <input type="text" name="playerName" id="player">
                <input class= "buttonz" type="submit" value="submit name">
            </form>
            <div class="textcontent text-center mx-auto">

                <div class ="nameBox">
                    <h2 data-text="<?php echo $player->getName();?>"><?php echo $player->getName();?></h2>
                </div>
                <h1 class="title"><?php echo $activeScene->getTitle();?></h1>


                <p id="message"></p>

               <?php if (isset($monster)){?>

                    <h3>Your Opponent is:</h3>
                    <h1><?php echo $monster->getName(); ?></h1>
                   <form class="attackMonster" method="GET">
                    <label for="attack"></label>
                    <input name="action" class="buttonz" type="submit" value="attack">
                </form>
                <?php } ?>



                <div class="inner-container">
                    <div class="playerHealth"><?php echo $player->getHealth(); ?>
                        </div>
                        <div class="content">
                            <div class="inventory">
                                <h1 class="invTitle">Inventory</h1>
                                <div class="slot">
                                    <?php foreach ($player->getItems() AS $item): ?>
                                        <li class="items"><img src="<?php echo $item->getImage() ;?>" alt=""></li>
                                    <?php endforeach;?>
                                </div>
                            </div>
                        </div>
                    </div>

                <form class="textcontent text-center mx-auto" action="" method="post">
                    <label for="command">What do you do?</label>
                    <select class="form-control form-select-lg mb-5" aria-label="Default select example" name="command">
                        <option selected>--Select Movement--</option>
                        <?php foreach ($activeScene->getValidTransitions($player) as $transition):?>
                            <option value="<?php echo $transition->getCommand();?>">
                                <?php echo $transition->getCommand();?>
                            </option>

                        <?php endforeach;?>


                        <input class= "buttonz" type="submit" value="Command!">
                    </select>
                </form>

            </div>


            </div>



    </section>
    <?php
include($activeScene->getView()); ?>
</main>



<?php
include './View/includes/footer.php';
