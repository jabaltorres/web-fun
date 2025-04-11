<div class="bg-dark">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="nav justify-content-center">
                    <?php
                    // Define navigation items with ids
                    $navItems = [
                        ['label' => 'Users', 'url' => '/users/', 'id' => 'users'],
                        ['label' => 'Contacts', 'url' => '/contacts/index.php', 'id' => 'contacts'],
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
