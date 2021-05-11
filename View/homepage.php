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
        <div class="textcontent text-center mx-auto">
            <h2><?php echo $player->getName();?></h2>
            <h1><?php echo $activeScene->getTitle();?></h1>
            <p id="message"></p>
            <?php foreach($activeScene->getTransitions() as $transition) :?>
                <li><a href="?command=<?php echo $transition->getCommand();?>"><?php echo $transition->getCommand();?></a></li>
            <?php endforeach;?>
        </div>
        <form action="" method="post">
            <label for="player">Your name</label>
            <input type="text" name="player" id="player">
            <input type="submit" value="submit name">
        </form>
    </section>
    <div class="background-container">
        <div class="layer background"></div>
        <div class="layer foreground"></div>
    </div>
</main>



<?php
include './View/includes/footer.php';
