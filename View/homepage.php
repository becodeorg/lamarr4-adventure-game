<?php

use Model\Player;
use Model\Scene;
include './View/includes/head.php';

/** @var Player $player
 * @var Scene $activeScene
 */

?>

<header>
    <div class="textcontent">
    <?php
echo '<h2>' . $player->getName() . '</h2>';
echo '<h1>' . $activeScene->getTitle() . '</h1>';
echo '<p id="message"></p>';
foreach ($activeScene->getTransitions() as $transition) {
    echo '<li><a href="?command=' . $transition->getCommand() . '">' . $transition->getCommand() . '</a></li>';
}

?>
    </div>
<form action="" method="post">
    <label for="player">Your name</label>
    <input type="text" name="player" id="player">
    <input type="submit" value="submit name">

</form>

</header>

<div class="container">
    <div class="layer background"></div>
    <div class="layer foreground"></div>
</div>

<?php
include './View/includes/footer.php';
