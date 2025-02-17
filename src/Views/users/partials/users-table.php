<?php
$columns = [
    'user_id' => 'ID',
    'first_name' => 'First Name',
    'last_name' => 'Last Name',
    'email' => 'Email',
    'username' => 'Username',
    'role' => 'Role'
];
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>All Users</h3>
    <span class="text-muted"><?= $users ? $users->num_rows : 0 ?> users found</span>
</div>

<table class="table table-striped">
    <thead class="thead-dark">
        <tr>
            <?php foreach ($columns as $field => $label): ?>
                <th>
                    <a href="<?= $userController->getSortUrl($field, $sortField, $sortOrder, $search, $roleFilter) ?>"
                       class="text-white text-decoration-none">
                        <?= $label ?> <?= $userController->getSortIndicator($field, $sortField, $sortOrder) ?>
                    </a>
                </th>
            <?php endforeach; ?>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($row = $users->fetch_assoc()): ?>
        <tr>
            <?php foreach (array_keys($columns) as $field): ?>
                <td><?= htmlspecialchars((string)$row[$field]) ?></td>
            <?php endforeach; ?>
            <td>
                <a href="edit.php?id=<?= htmlspecialchars((string)$row['user_id']) ?>" 
                   class="btn btn-primary btn-sm">
                    Edit
                </a>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table> 