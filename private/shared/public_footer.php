<footer class="mt-5">
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex">
                <div class="d-inline-block mx-2">&copy; <?php echo date('Y'); ?> KrateCMS</div>
                <div class="d-inline-block mx-2">All rights reserved.</div>
                <div class="d-inline-block mx-2">Made with love by FiveTwoFive</div>
            </div>
        </div>
    </div>
</footer>

<script src="<?php echo $url; ?>/dist/scripts/scripts.min.js"></script>
</body>
</html>

<?php
db_disconnect($db);
?>
