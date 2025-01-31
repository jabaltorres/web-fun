<?php
if (!defined('PRIVATE_PATH')) {
    exit('Direct access not permitted');
}
?>

<section class="fixed-bottom bg-light border-top py-2">
    <div class="container">
        <div class="audio-player" id="mainAudioPlayer">
            <div class="d-flex align-items-center">
                <div class="audio-player__controls d-flex align-items-center">
                    <button class="audio-player__play-pause btn btn-link" title="Play">
                        <i class="fas fa-play"></i>
                    </button>
                    <button class="audio-player__stop btn btn-link" title="Stop">
                        <i class="fas fa-stop"></i>
                    </button>
                    <div class="audio-player__progress flex-grow-1 mx-3">
                        <div class="progress-bar" role="progressbar" style="width: 0%;"></div>
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
</section>

<style>
.audio-player {
    padding: 0.5rem;
}

.audio-player .progress-bar {
    height: 4px;
    cursor: pointer;
}

.audio-player .btn-link {
    color: #333333;
    padding: 0.25rem 0.5rem;
}

.audio-player .btn-link:hover {
    color: #007bff;
}
</style>

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

console.log('Audio Source URL:', '<?= htmlspecialchars($config['site']['audio_source_url']) ?>');
</script>

