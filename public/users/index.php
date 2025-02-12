<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php');

use Fivetwofive\KrateCMS\UserManager;

try {
    // Initialize the UserManager
    $userManager = new UserManager($db);

    // Enforce the user is logged in
    $userManager->checkLoggedIn();
    $loggedIn = $userManager->isLoggedIn();
    $isAdmin = isset($_SESSION['user_id']) ? $userManager->isAdmin($_SESSION['user_id']) : false;

    // Get search, filter, and sort parameters
    $search = $_GET['search'] ?? '';
    $roleFilter = $_GET['role'] ?? '';
    $sortField = $_GET['sort'] ?? 'user_id';
    $sortOrder = $_GET['order'] ?? 'ASC';

    // Validate sort field to prevent SQL injection
    $validSortFields = ['user_id', 'first_name', 'last_name', 'email', 'username', 'role'];
    if (!in_array($sortField, $validSortFields)) {
        $sortField = 'user_id';
    }

    // Validate sort order
    $sortOrder = strtoupper($sortOrder) === 'DESC' ? 'DESC' : 'ASC';
    
    // Fetch filtered users if admin
    $result = null;
    if ($isAdmin) {
        $result = $userManager->getFilteredUsers($search, $roleFilter, $sortField, $sortOrder);
    }

    // Function to generate sort URL
    function getSortUrl($field, $currentSort, $currentOrder, $search, $roleFilter) {
        $newOrder = ($field === $currentSort && $currentOrder === 'ASC') ? 'DESC' : 'ASC';
        $params = [
            'sort' => $field,
            'order' => $newOrder
        ];
        if ($search) $params['search'] = $search;
        if ($roleFilter) $params['role'] = $roleFilter;
        return 'index.php?' . http_build_query($params);
    }

    // Function to get sort indicator
    function getSortIndicator($field, $currentSort, $currentOrder) {
        if ($field !== $currentSort) return '↕';
        return $currentOrder === 'ASC' ? '↑' : '↓';
    }

} catch (Exception $e) {
    error_log("Error in user management: " . $e->getMessage());
    $error_message = "An error occurred while processing your request.";
}

include('../../templates/layouts/header.php');
?>

  <div class="container py-5">

    <?php if ($loggedIn): ?>
        <h1>Users Page</h1>
        <section class="user-content mb-4">
            <p class="mb-0">Welcome, <?= htmlspecialchars($_SESSION['first_name']); ?>! Here is the exclusive content for logged-in users.</p>
        </section>

        <section class="mb-4">
            User ID: <?php echo $_SESSION['user_id'] . '</br>'; ?>
            Username: <?php echo $_SESSION['username'] . '</br>'; ?>
            Role: <?php echo $_SESSION['role'] ?? 'No role'; ?><br>
        </section>
    <?php endif; ?>

    <?php if ($isAdmin): ?>
        <!-- Search and Filter Form -->
        <form method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" 
                               class="form-control" 
                               placeholder="Search by name, email, or username" 
                               name="search"
                               value="<?= htmlspecialchars($search) ?>">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit">Search</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <select name="role" class="form-control" onchange="this.form.submit()">
                        <option value="">All Roles</option>
                        <?php foreach ($userManager::VALID_ROLES as $role): ?>
                            <option value="<?= htmlspecialchars($role) ?>" 
                                    <?= $roleFilter === $role ? 'selected' : '' ?>>
                                <?= htmlspecialchars($role) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <?php if ($search || $roleFilter): ?>
                        <a href="index.php" class="btn btn-outline-secondary">Clear Filters</a>
                    <?php endif; ?>
                </div>
            </div>
        </form>

        <?php if ($result && $result->num_rows > 0): ?>
            <section class="user-content">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3>All Users</h3>
                    <span class="text-muted"><?= $result->num_rows ?> users found</span>
                </div>
                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>
                                <a href="<?= getSortUrl('user_id', $sortField, $sortOrder, $search, $roleFilter) ?>" 
                                   class="text-white text-decoration-none">
                                    ID <?= getSortIndicator('user_id', $sortField, $sortOrder) ?>
                                </a>
                            </th>
                            <th>
                                <a href="<?= getSortUrl('first_name', $sortField, $sortOrder, $search, $roleFilter) ?>" 
                                   class="text-white text-decoration-none">
                                    First Name <?= getSortIndicator('first_name', $sortField, $sortOrder) ?>
                                </a>
                            </th>
                            <th>
                                <a href="<?= getSortUrl('last_name', $sortField, $sortOrder, $search, $roleFilter) ?>" 
                                   class="text-white text-decoration-none">
                                    Last Name <?= getSortIndicator('last_name', $sortField, $sortOrder) ?>
                                </a>
                            </th>
                            <th>
                                <a href="<?= getSortUrl('email', $sortField, $sortOrder, $search, $roleFilter) ?>" 
                                   class="text-white text-decoration-none">
                                    Email <?= getSortIndicator('email', $sortField, $sortOrder) ?>
                                </a>
                            </th>
                            <th>
                                <a href="<?= getSortUrl('username', $sortField, $sortOrder, $search, $roleFilter) ?>" 
                                   class="text-white text-decoration-none">
                                    Username <?= getSortIndicator('username', $sortField, $sortOrder) ?>
                                </a>
                            </th>
                            <th>
                                <a href="<?= getSortUrl('role', $sortField, $sortOrder, $search, $roleFilter) ?>" 
                                   class="text-white text-decoration-none">
                                    Role <?= getSortIndicator('role', $sortField, $sortOrder) ?>
                                </a>
                            </th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['user_id']) ?></td>
                            <td><?= htmlspecialchars($row['first_name']) ?></td>
                            <td><?= htmlspecialchars($row['last_name']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= htmlspecialchars($row['username']) ?></td>
                            <td><?= htmlspecialchars($row['role']) ?></td>
                            <td>
                                <a href="edit-user.php?id=<?= htmlspecialchars($row['user_id']) ?>" 
                                   class="btn btn-primary btn-sm">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </section>
        <?php else: ?>
            <p>No users found.</p>
        <?php endif; ?>
    <?php endif; ?>
  </div>

<?php include('../../templates/layouts/footer.php'); ?>