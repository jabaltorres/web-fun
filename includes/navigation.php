<?php
$is_logged_in = isset($_SESSION['user_id']); // Check if user is logged in

$pages = [
    ['id' => '1', 'position' => '1', 'visible' => '1', 'menu_name' => 'Contacts', 'page_url' => 'contacts/'],
    ['id' => '2', 'position' => '2', 'visible' => '1', 'menu_name' => 'Users', 'page_url' => 'users/'],
    ['id' => '3', 'position' => '3', 'visible' => '1', 'menu_name' => 'Staff', 'page_url' => 'staff/'],
    ['id' => '4', 'position' => '4', 'visible' => '1', 'menu_name' => 'Admins', 'page_url' => 'staff/admins/'],
    ['id' => '5', 'position' => '5', 'visible' => '1', 'menu_name' => 'Demos', 'page_url' => 'demos/'],
];
?>

<nav class="main-navigation navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="/public/">KrateCMS</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <ul class="navbar-nav mr-auto">
                <?php

                // get the current page url
                $current_url = $_SERVER['REQUEST_URI'];

                // remove forward slash from $current_url
                $current_url = ltrim($current_url, '/');

                foreach ($pages as $page): ?>
                    <?php

                    // TODO: Make this ternaly operator
                    if ($current_url == $page['page_url']) {
                        $activeStyleClass = 'active';
                    } else {
                        $activeStyleClass = '';
                    }
                    // check if page is visible
                    if ($page['visible'] == '1') { ?>
                        <li><a class="nav-link <?php echo $activeStyleClass; ?>" href="<?php echo $url . '/' . h($page['page_url']); ?>"><?php echo h($page['menu_name']); ?></a></li>
                    <?php }
                    ?>

                <?php endforeach; ?>
            </ul>

            <!-- Update navbar text to reflect user status -->
            <span class="navbar-text">
                <?php if ($is_logged_in): ?>
                    Welcome back, <?= htmlspecialchars($_SESSION['first_name']); ?>! <a href="/public/users/logout.php">Log Out</a>
                <?php else: ?>
                    Welcome Guest! Please <a href="/public/users/login.php">Log In</a> or <a href="/public/users/register.php">Register</a>.
                <?php endif; ?>
            </span>
        </div>
    </div>
</nav>