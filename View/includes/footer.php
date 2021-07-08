<script src="https://code.responsivevoice.org/responsivevoice.js?key=JSWppBdu"></script>

<script>
    let message = "<?php echo $activeScene->getDescription() ?>";
    let health = <?php echo $player->getHealth() ?>;

    console.log(message);
    // responsiveVoice.speak(message);
</script>
<script src="public/Javascript/typewriter.js"></script>

</body>
</html>
