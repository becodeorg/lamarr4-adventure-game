<?php

use Model\Player;
use Model\Scene;

/** @var Player $player
 * @var Scene $activeScene
 */



echo '<h2>' . $player->getName() . '</h2>';
echo '<h1>' . $activeScene->getTitle() . '</h1>';
echo '<p id="message"></p>';
foreach ($activeScene->getTransitions() as $transition) {
    echo '<li><a href="?command=' . $transition->getCommand() . '">' . $transition->getCommand() . '</a></li>';
}

?>

<form action="" method="post">
    <label for="player">Your name</label>
    <input type="text" name="player">
    <input type="submit" value="submit name">

</form>

<script>
    let message = "<?php echo $activeScene->getDescription() ?>";
    console.log(message);
</script>
<script src="Javascript/typewriter.js"></script>
