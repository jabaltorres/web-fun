<footer class="site-footer">
    <div class="container text-center">
        <span>&copy; <?php echo date("Y") . "&nbsp;" . $config['site']['owner']; ?></span>
        <ul class="d-inline-block">
            <li><a href="https://github.com/jabaltorres/web-fun" target="_blank">Github Repo</a></li>
            <li><a href="https://github.com/jabaltorres/web-fun/issues" target="_blank">Github Issues</a></li>
            <li><a href="https://github.com/jabaltorres/web-fun/wiki" target="_blank">Github Wiki</a></li>
            <li><a href="https://github.com/users/jabaltorres/projects/2" target="_blank">Github Project</a></li>
        </ul>
    </div>
</footer>

<footer class="fixed-bottom bg-light border-top py-2">
    <div class="container">
        <div class="audio-player" id="mainAudioPlayer">
            <div class="d-flex align-items-center">
                <div class="audio-player__controls d-flex align-items-center">
                    <button class="audio-player__play-pause btn btn-link" data-action="play">
                        <i class="fa-solid fa-play"></i>
                    </button>
                    <button class="audio-player__stop btn btn-link" data-action="stop">
                        <i class="fa-solid fa-stop"></i>
                    </button>
                    <div class="audio-player__progress flex-grow-1 mx-3" style="width: 200px;">
                        <div class="progress-bar"></div>
                    </div>
                    <span class="audio-player__time">0:00</span>
                </div>
                <small class="ml-3 text-muted">
                    <?php echo htmlspecialchars($settingsManager->getSettingDescription('audio_source') ?: 'Background Music'); ?>
                </small>
            </div>
            <audio id="audioElement">
                <source src="<?= htmlspecialchars($config['site']['audio_source_url']) ?>" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>
        </div>
    </div>
</footer>

<script src="<?php echo SCRIPTS_PATH; ?>/main.min.js"></script>
<script src="<?php echo url_for('/assets/js/AudioElement.js'); ?>"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const audioPlayer = new AudioElement('#mainAudioPlayer', {
            playPauseSelector: '.audio-player__play-pause',
            stopSelector: '.audio-player__stop',
            progressBarSelector: '.progress-bar',
            timeDisplaySelector: '.audio-player__time'
        });
    });
</script>

</body>
</html>