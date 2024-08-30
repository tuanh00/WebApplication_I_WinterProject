<?php
include_once 'header.php';
?>
<style>
    .homepage-container {
        background-image: url('img/background_pochacco.webp');
        background-size: 100% auto;
        background-repeat: no-repeat;
        background-attachment: scroll;
        background-position: top center;
        min-height: 90vh;
        width: 100%;
        overflow: hidden;
    }
</style>

<div class="homepage-container">

    <section class="index-intro">
        <h1>Kids' World of Fun Logo</h1>
        <p>This is a paragraph explain the purpose of this project</p>
    </section>

    <!-- Audio player for background music -->
    <audio loop id="background-music">
        <source src="img/pochacco_soundtrack.mp3" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>

    <!-- Button to toggle audio -->
    <button class="audio-control" onclick="toggleAudio()">Play/Pause Music</button>

    <script>
        // Function to play or pause the audio
        function toggleAudio() {
            var audioElem = document.getElementById('background-music');
            if (audioElem.paused)
                audioElem.play();
            else
                audioElem.pause();
        }
    </script>

</div>

<?php
include_once 'footer.php';
?>