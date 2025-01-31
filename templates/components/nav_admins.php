<div class="bg-dark">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="nav justify-content-center">
                    <?php
                    // Define navigation items with ids
                    $navItems = [
                        ['label' => 'Admins', 'url' => '/staff/admins/', 'id' => 'admins'],
                        ['label' => 'Create New Admin', 'url' => '/staff/admins/new.php', 'id' => 'new-admin'],
                        ['label' => 'Users', 'url' => '/users/', 'id' => 'users'],
                        ['label' => 'User Add', 'url' => '/users/user-add.php', 'id' => 'user-add'],
                        ['label' => 'Staff', 'url' => '/staff/index.php', 'id' => 'staff'],
                        ['label' => 'Pages', 'url' => '/staff/pages/index.php', 'id' => 'pages'],
                        ['label' => 'Subjects', 'url' => '/staff/subjects/index.php', 'id' => 'subjects'],
                        ['label' => 'Contacts', 'url' => '/contacts/index.php', 'id' => 'contacts'],
                        ['label' => 'Demos', 'url' => '/demos/index.php', 'id' => 'demos'],
                    ];

                    // Generate navigation items
                    foreach ($navItems as $item) {
                        echo '<li class="nav-item"><a id="nav-item-' . htmlspecialchars($item['id']) . '" class="text-white nav-link" href="' . htmlspecialchars($item['url']) . '">' . htmlspecialchars($item['label']) . '</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>
