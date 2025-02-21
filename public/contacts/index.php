<?php
declare(strict_types=1);

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Load bootstrap and get application container
$app = require_once(__DIR__ . '/../../config/bootstrap.php');

// Get services from the container
$contactManager = $app['contactManager'];
$userManager = $app['userManager'];
$urlHelper = $app['urlHelper'];

// At the top with other use statements
use Fivetwofive\KrateCMS\Middleware\AuthMiddleware;
use Fivetwofive\KrateCMS\Controllers\ContactController;

try {
    // Check authentication
    AuthMiddleware::requireLogin($userManager);

    // Initialize the ContactController
    $contactController = new ContactController($contactManager);
    
    // Get view data from controller
    $viewData = $contactController->index();
    
    // Extract variables for the view
    extract($viewData);

    include('../../src/Views/templates/header.php');
?>

    <div class="<?php echo h($custom_class); ?> container">
        <section class="py-4 mb-2">
            <h1 class="h2"><?php echo h($page_heading); ?></h1>
            <p class="lead"><?php echo h($page_subheading); ?></p>
        </section>

        <div class="row mb-4">
            <div class="col">
                <form action="<?= $urlHelper->urlFor('/contacts/index.php'); ?>" method="get" class="form-inline">
                    <div class="input-group mr-2">
                        <input type="text" name="search" class="form-control" 
                               placeholder="Search contacts..." 
                               value="<?= h($searchTerm); ?>">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                            <?php if (!empty($searchTerm)): ?>
                                <a href="<?= $urlHelper->urlFor('/contacts/index.php'); ?>" 
                                   class="btn btn-secondary">
                                    <i class="fas fa-times"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <select id="sort" class="form-control mr-2" name="sort">
                        <option value="id" <?php echo $sort === 'id' ? 'selected' : ''; ?>>ID</option>
                        <option value="first_name" <?php echo $sort === 'first_name' ? 'selected' : ''; ?>>First Name</option>
                        <option value="last_name" <?php echo $sort === 'last_name' ? 'selected' : ''; ?>>Last Name</option>
                        <option value="email" <?php echo $sort === 'email' ? 'selected' : ''; ?>>Email</option>
                        <option value="favorite" <?php echo $sort === 'favorite' ? 'selected' : ''; ?>>Favorite</option>
                    </select>

                    <select id="direction" class="form-control mr-2" name="direction">
                        <option value="asc" <?php echo $direction === 'asc' ? 'selected' : ''; ?>>Ascending</option>
                        <option value="desc" <?php echo $direction === 'desc' ? 'selected' : ''; ?>>Descending</option>
                    </select>

                    <button type="submit" class="btn btn-primary">Sort</button>
                </form>
            </div>

            <div class="col-auto">
                <a href="contact-add.php" class="btn btn-success">
                    <i class="fas fa-plus"></i> Add New Contact
                </a>
            </div>
        </div>

        <?php if (!empty($searchTerm)): ?>
            <div class="alert alert-info">
                <i class="fas fa-search"></i> 
                Search results for: <strong><?= h($searchTerm) ?></strong>
                <span class="badge badge-pill badge-secondary ml-2">
                    <?= (string)$contact_set->num_rows ?> results
                </span>
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <?php
                        $columns = [
                            'id' => 'ID',
                            'first_name' => 'First Name', 
                            'last_name' => 'Last Name',
                            'email' => 'Email',
                            'favorite' => 'Favorite'
                        ];

                        foreach ($columns as $column => $label): 
                            $newDirection = ($sort === $column && $direction === 'asc') ? 'desc' : 'asc';
                            $sortIcon = '';
                            
                            if ($sort === $column) {
                                $sortIcon = $direction === 'asc' ? 
                                    '<i class="fas fa-sort-up ml-1"></i>' : 
                                    '<i class="fas fa-sort-down ml-1"></i>';
                            } else {
                                $sortIcon = '<i class="fas fa-sort ml-1 text-muted"></i>';
                            }
                        ?>
                            <th>
                                <a href="?sort=<?= $column ?>&direction=<?= $newDirection ?><?= $searchTerm ? '&search=' . h($searchTerm) : '' ?>" 
                                   class="text-white d-flex align-items-center sortable-header"
                                   role="button"
                                   aria-sort="<?= $sort === $column ? ($direction === 'asc' ? 'ascending' : 'descending') : 'none' ?>"
                                   title="Sort by <?= $label ?>">
                                    <?= h($label) ?>
                                    <span class="sort-icon"><?= $sortIcon ?></span>
                                </a>
                            </th>
                        <?php endforeach; ?>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($contact = $contact_set->fetch_assoc()) : ?>
                        <tr>
                            <td><?= h((string)$contact['id']); ?></td>
                            <td><?= h($contact['first_name']); ?></td>
                            <td><?= h($contact['last_name']); ?></td>
                            <td>
                                <a href="mailto:<?= h($contact['email']); ?>">
                                    <?= h($contact['email']); ?>
                                </a>
                            </td>
                            <td>
                                <i class="fas fa-<?= $contact['favorite'] ? 'star text-warning' : 'star-o'; ?>"></i>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="contact-show.php?id=<?= h((string)$contact['id']); ?>" 
                                       class="btn btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="contact-edit.php?id=<?= h((string)$contact['id']); ?>" 
                                       class="btn btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="contact-delete.php?id=<?= h((string)$contact['id']); ?>" 
                                       class="btn btn-danger" title="Delete"
                                       onclick="return confirm('Are you sure you want to delete this contact?');">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    <?php $contact_set->free(); ?>
                </tbody>
            </table>
        </div>
    </div>

<?php 
    include('../../src/Views/templates/footer.php');
} catch (Exception $e) {
    // Log the error
    error_log($e->getMessage());
    // Redirect to error page
    redirect_to('/error.php');
}
?>