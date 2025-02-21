<?php
// Verify required services are available
if (!isset($socialLinksService) || !isset($htmlHelper) || !isset($config) || !isset($settingsManager)) {
    throw new RuntimeException('Required services not available in footer');
}
?>
<footer class="site-footer">
    <div class="container text-center">
        <span>&copy; <?= date("Y") . "&nbsp;" . $htmlHelper->escape($config['site']['owner']) ?></span>
        <ul class="d-inline-block">
            <li><a href="https://github.com/jabaltorres/web-fun" target="_blank">Github Repo</a></li>
            <li><a href="https://github.com/jabaltorres/web-fun/issues" target="_blank">Github Issues</a></li>
            <li><a href="https://github.com/jabaltorres/web-fun/wiki" target="_blank">Github Wiki</a></li>
            <li><a href="https://github.com/users/jabaltorres/projects/2" target="_blank">Github Project</a></li>
        </ul>
        
        <?= $socialLinksService->displayLinks() ?>
    </div>
</footer>

<?php if ($settingsManager->getSetting('audio_player_on')): ?>
    <?php include ROOT_PATH . '/templates/components/audio-player.php'; ?>
<?php endif; ?>

<script src="<?= $urlHelper->urlFor('/assets/js/main.min.js') ?>"></script>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
</body>
</html>