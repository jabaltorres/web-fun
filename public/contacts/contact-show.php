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
    $id = (int)($_GET['id'] ?? 0);
    
    if ($id === 0) {
        throw new InvalidArgumentException('Invalid contact ID');
    }

    // Fetch the contact
    $contact = $contactManager->findContactById($id);
    
    if (!$contact) {
        throw new RuntimeException('Contact not found');
    }

    $title = "Contact Details";
    $page_heading = "Contact Information";
    $page_subheading = "View contact details";
    $custom_class = "contact-details-page";

    // Start output buffering
    ob_start();
    
    // Include header
    include('../../src/Views/templates/header.php');
?>

<style>
    .card .fas {
        font-size: 1rem;
    }
    .card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
    }

    .btn-group {
        display: flex;
        gap: 0.5rem;
    }

    .btn-group .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .favorite-badge {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #ffc107;
    }
</style>

<main>
    <div class="container py-5 <?php echo h($custom_class); ?>">
        <div class="row">
            <div class="col">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h2"><?php echo h($page_heading); ?></h1>
                    <a class="btn btn-outline-primary" href="<?php echo url_for('/contacts/index.php'); ?>">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>

                <div class="card">
                    <div class="card-body">
                        <!-- Contact details content -->
                        <div class="row">
                            <!-- Image column -->
                            <div class="col-md-3 text-center mb-3">
                                <?php if (empty($contact['image'])): ?>
                                    <img src="<?php echo url_for('/assets/images/no-image.png'); ?>" 
                                            alt="No image available" 
                                            class="img-fluid rounded">
                                <?php else: ?>
                                    <img src="<?php echo url_for('/contacts/uploads/' . h($contact['image'])); ?>" 
                                            alt="Contact image" 
                                            class="img-fluid rounded">
                                <?php endif; ?>
                            </div>

                            <!-- Details column -->
                            <div class="col-md-9">
                                <h2 class="h3 mb-4">
                                    <?php echo h($contact['first_name']) . " " . h($contact['last_name']); ?>
                                </h2>

                                <dl class="row">
                                    <dt class="col-sm-3">Contact Number</dt>
                                    <dd class="col-sm-9">
                                        <?php if ($contact['contact_number']): ?>
                                            <a href="tel:<?php echo h($contact['contact_number']); ?>" class="text-decoration-none">
                                                <i class="fas fa-phone"></i> <?php echo h($contact['contact_number']); ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">No contact number</span>
                                        <?php endif; ?>
                                    </dd>

                                    <dt class="col-sm-3">Email</dt>
                                    <dd class="col-sm-9">
                                        <?php if ($contact['email']): ?>
                                            <a href="mailto:<?php echo h($contact['email']); ?>" class="text-decoration-none">
                                                <i class="fas fa-envelope"></i> <?php echo h($contact['email']); ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">No email address</span>
                                        <?php endif; ?>
                                    </dd>

                                    <dt class="col-sm-3">Ranking</dt>
                                    <dd class="col-sm-9">
                                        <?php if ($contact['rank_description']): ?>
                                            <span class="badge badge-info"><?php echo h($contact['rank_description']); ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">No ranking assigned</span>
                                        <?php endif; ?>
                                    </dd>

                                    <dt class="col-sm-3">Comments</dt>
                                    <dd class="col-sm-9">
                                        <?php if ($contact['comments']): ?>
                                            <p class="text-muted mb-0"><?php echo h($contact['comments']); ?></p>
                                        <?php else: ?>
                                            <p class="text-muted mb-0">No comments</p>
                                        <?php endif; ?>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div><!-- end card-body -->

                    <div class="card-footer bg-light">
                        <div class="btn-group">
                            <a class="btn btn-outline-primary" href="<?= $urlHelper->urlFor('/contacts/contact-edit.php?id=' . $contact['id']); ?>">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a class="btn btn-outline-primary" href="<?= $urlHelper->urlFor('/contacts/contact-message.php?id=' . $contact['id']); ?>">
                                <i class="fas fa-envelope"></i> Message
                            </a>
                            <a class="btn btn-outline-danger" href="<?= $urlHelper->urlFor('/contacts/contact-delete.php?id=' . $contact['id']); ?>"
                                onclick="return confirm('Are you sure you want to delete this contact?');">
                                <i class="fas fa-trash"></i> Delete
                            </a>
                        </div>

                        <?php if (!empty($contact['favorite'])): ?>
                            <div class="favorite-badge">
                                <i class="fas fa-star text-warning"></i>
                                <span>Favorite Contact</span>
                            </div>
                        <?php endif; ?>
                    </div><!-- end card-footer -->
                </div><!-- end card -->
            </div><!-- end col -->
        </div><!-- end row -->
    </div><!-- end container -->
</main>

<?php
    // Include footer
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
