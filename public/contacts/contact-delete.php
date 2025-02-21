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

    // Get contact ID from URL parameters
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    
    if ($id === 0) {
        throw new InvalidArgumentException('Invalid contact ID');
    }

    // Handle POST request (actual deletion)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            if ($contactManager->deleteContact($id)) {
                $_SESSION['message'] = 'Contact deleted successfully';
                redirect_to('/contacts/index.php');
            }
        } catch (Exception $e) {
            error_log('Failed to delete contact: ' . $e->getMessage());
            $_SESSION['error'] = 'Failed to delete contact';
            redirect_to('/contacts/index.php');
        }
    }

    // Fetch contact data for confirmation page
    $contact = $contactManager->findContactById($id);
    
    if (!$contact) {
        throw new RuntimeException('Contact not found');
    }

    $title = "Delete Contact";
    $page_heading = "Delete Contact";
    $page_subheading = "Confirm contact deletion";
    $custom_class = "delete-contact-page";

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

            <div class="card">
                <div class="card-body">
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Warning:</strong> This action cannot be undone.
                    </div>

                    <h2 class="h4 mb-4">Are you sure you want to delete this contact?</h2>

                    <dl class="row">
                        <dt class="col-sm-3">Name</dt>
                        <dd class="col-sm-9">
                            <?php echo h($contact['first_name']) . " " . h($contact['last_name']); ?>
                        </dd>

                        <dt class="col-sm-3">Email</dt>
                        <dd class="col-sm-9">
                            <?php if ($contact['email']): ?>
                                <a href="mailto:<?php echo h($contact['email']); ?>">
                                    <?php echo h($contact['email']); ?>
                                </a>
                            <?php else: ?>
                                <span class="text-muted">No email address</span>
                            <?php endif; ?>
                        </dd>

                        <dt class="col-sm-3">Contact Number</dt>
                        <dd class="col-sm-9">
                            <?php if ($contact['contact_number']): ?>
                                <a href="tel:<?php echo h($contact['contact_number']); ?>">
                                    <?php echo h($contact['contact_number']); ?>
                                </a>
                            <?php else: ?>
                                <span class="text-muted">No contact number</span>
                            <?php endif; ?>
                        </dd>

                        <?php if ($contact['comments']): ?>
                            <dt class="col-sm-3">Comments</dt>
                            <dd class="col-sm-9">
                                <?php echo h($contact['comments']); ?>
                            </dd>
                        <?php endif; ?>
                    </dl>

                    <form action="<?= $urlHelper->urlFor('/contacts/contact-delete.php?id=' . $contact['id']); ?>" 
                          method="post" 
                          class="mt-4">
                        <div class="d-flex justify-content-between">
                            <a href="<?= $urlHelper->urlFor('/contacts/index.php'); ?>" 
                               class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Delete Contact
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