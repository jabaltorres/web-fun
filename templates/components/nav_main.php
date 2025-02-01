<?php
// type of array
$navItems = [
        ['href' => '/page.php?subject_id=1', 'label' => 'About'],
        ['href' => '/page.php?subject_id=3', 'label' => 'Documentation'],
        ['href' => '/page.php?subject_id=5', 'label' => 'Resources'],
        ['href' => '/contact-us.php', 'label' => 'Contact Us'],
    ];
?>

<ul class="navbar-nav ml-auto mr-md-2">
    <?php foreach ($navItems as $item): ?>
        <li class="nav-item">
            <a class="nav-link" href="<?= htmlspecialchars($item['href']) ?>"><?= htmlspecialchars($item['label']) ?></a>
        </li>
    <?php endforeach; ?>
</ul>