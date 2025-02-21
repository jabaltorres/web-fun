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

use Fivetwofive\KrateCMS\Middleware\AuthMiddleware;

try {
    // Check authentication
    AuthMiddleware::requireLogin($userManager);

    $title = "Add Contact";
    $page_heading = "Add New Contact";
    $page_subheading = "Create a new contact record";
    $custom_class = "add-contact-page";
    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $contact = [
            'first_name' => $_POST['first_name'] ?? '',
            'last_name' => $_POST['last_name'] ?? '',
            'email' => $_POST['email'] ?? '',
            'contact_number' => $_POST['contact_number'] ?? '',
            'comments' => $_POST['comments'] ?? '',
            'rank_id' => $_POST['rank_id'] ?? null,
            'favorite' => isset($_POST['favorite']) ? 1 : 0
        ];

        try {
            if ($contactManager->insertContact($contact)) {
                $_SESSION['message'] = 'Contact added successfully';
                redirect_to('/contacts/index.php');
            }
        } catch (InvalidArgumentException $e) {
            $errors = explode(', ', $e->getMessage());
        }
    }

    // Start output buffering
    ob_start();
    
    include('../../src/Views/templates/header.php');
?>

<div class="container py-5 <?php echo h($custom_class); ?>">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h2"><?php echo h($page_heading); ?></h1>
                <a class="btn btn-outline-primary" href="<?= $urlHelper->urlFor('/contacts/index.php'); ?>">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo h($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-body">
                    <form method="post" action="<?= $urlHelper->urlFor('/contacts/contact-add.php'); ?>">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" 
                                   value="<?= h($_POST['first_name'] ?? ''); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" 
                                   value="<?= h($_POST['last_name'] ?? ''); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?= h($_POST['email'] ?? ''); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="contact_number">Contact Number</label>
                            <input type="tel" class="form-control" id="contact_number" name="contact_number" 
                                   value="<?= h($_POST['contact_number'] ?? ''); ?>">
                        </div>

                        <div class="form-group">
                            <label for="rank_id">Rank</label>
                            <select class="form-control" id="rank_id" name="rank_id">
                                <option value="">No Ranking</option>
                                <?php 
                                try {
                                    $rankings = $app['rankingService']->getAllRankings();
                                    foreach ($rankings as $ranking): 
                                ?>
                                    <option value="<?= h($ranking['rank_id']); ?>"
                                            <?= ($_POST['rank_id'] ?? '') == $ranking['rank_id'] ? 'selected' : ''; ?>>
                                        <?= h($ranking['rank_description']); ?>
                                    </option>
                                <?php 
                                    endforeach;
                                } catch (Exception $e) {
                                    error_log('Failed to load rankings: ' . $e->getMessage());
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="comments">Comments</label>
                            <textarea class="form-control" id="comments" name="comments" 
                                      rows="3"><?= h($_POST['comments'] ?? ''); ?></textarea>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="favorite" name="favorite" 
                                       <?= isset($_POST['favorite']) ? 'checked' : ''; ?>>
                                <label class="custom-control-label" for="favorite">Mark as Favorite</label>
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Contact
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    include('../../src/Views/templates/footer.php');
    
    // End output buffering and flush
    ob_end_flush();
} catch (Exception $e) {
    // Log the error
    error_log($e->getMessage());
    // Clean output buffer
    ob_end_clean();
    // Redirect to error page
    redirect_to('/error.php');
}
?>
