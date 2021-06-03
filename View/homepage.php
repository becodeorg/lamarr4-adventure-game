<?php

use Model\Player;
use Model\Scene;
include './View/includes/header.php';

/** @var Player $player
 * @var Scene $activeScene
 */

?>

<main>
    <section class="first-section">
        <form class="textcontent text-center mx-auto" action="" method="post">
            <label for="player">Your name</label>
            <input type="text" name="player" id="player">
            <input class= "buttonz" type="submit" value="submit name">
        </form>
        <div class="textcontent text-center mx-auto">

            <div class ="nameBox">
                <h2 data-text="<?php echo $player->getName();?>"><?php echo $player->getName();?></h2>
            </div>
                <h1 class="title"><?php echo $activeScene->getTitle();?></h1>


            <p id="message"></p>

        <form class="textcontent text-center mx-auto" action="" method="post">
            <label for="command">What do you do?</label>
            <select class="form-control form-select-lg mb-5" aria-label="Default select example" name="command">
                <option selected>--Select Movement--</option>
                <?php foreach ($activeScene->getTransitions() as $transition):?>
                <option value="<?php echo $transition->getCommand();?>">
                    <?php echo $transition->getCommand();?>
                </option>

           <?php endforeach;?>


            <input class= "buttonz" type="submit" value="Command!">
            </select>
        </form>

    </section>
    <div class="background-container">
        <div class="layer background"></div>
        <div class="layer moon"></div>
        <div class="layer moutain"></div>
        <div class="layer fog1"></div>
        <div class="layer hills"></div>
        <div class="layer fog2"></div>
        <div class="layer crows"></div>
        <div class="layer unicorn"></div>
        <div class="layer foreground"></div>
    </div>

    <div class="container">
        <div class="dragon wings">
        </div>
        <div class="dragon body">
        </div>
        <div class="dragon head">
        </div>
    </div>

</main>



<?php
include './View/includes/footer.php';
