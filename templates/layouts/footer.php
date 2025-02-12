<footer class="site-footer">
    <div class="container text-center">
        <span>&copy; <?php echo date("Y") . "&nbsp;" . $config['site']['owner']; ?></span>
        <ul class="d-inline-block">
            <li><a href="https://github.com/jabaltorres/web-fun" target="_blank">Github Repo</a></li>
            <li><a href="https://github.com/jabaltorres/web-fun/issues" target="_blank">Github Issues</a></li>
            <li><a href="https://github.com/jabaltorres/web-fun/wiki" target="_blank">Github Wiki</a></li>
            <li><a href="https://github.com/users/jabaltorres/projects/2" target="_blank">Github Project</a></li>
        </ul>
        
        <?php echo displaySocialLinks($settingsManager); ?>
    </div>
</footer>

<?php if ($settingsManager->getSetting('audio_player_on')): ?>
    <?php include __DIR__ . '/../components/audio-player.php'; ?>
<?php endif; ?>

<script src="<?php echo SCRIPTS_PATH; ?>/main.min.js"></script>

</body>
</html>