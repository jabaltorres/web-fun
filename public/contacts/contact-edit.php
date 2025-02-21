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

    $errors = [];
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Process form submission
        $contact = [
            'id' => $id,
            'first_name' => $_POST['first_name'] ?? '',
            'last_name' => $_POST['last_name'] ?? '',
            'email' => $_POST['email'] ?? '',
            'comments' => $_POST['comments'] ?? '',
            'contact_number' => $_POST['contact_number'] ?? '',
            'rank_id' => $_POST['rank_id'] ?? null,
            'favorite' => isset($_POST['favorite']) ? 1 : 0
        ];

        // Handle file upload
        if (!empty($_FILES['image']['name'])) {
            $uploadDir = __DIR__ . '/uploads/';
            $fileInfo = pathinfo($_FILES['image']['name']);
            $extension = strtolower($fileInfo['extension']);

            // Validate file extension
            $allowedExtensions = ['jpeg', 'jpg', 'png'];
            if (!in_array($extension, $allowedExtensions, true)) {
                throw new InvalidArgumentException('Invalid file type. Please upload a JPEG or PNG file.');
            }

            // Generate unique filename
            $newFilename = uniqid('img_', true) . '.' . $extension;
            $destination = $uploadDir . $newFilename;

            // Move uploaded file
            if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                $contact['image'] = $newFilename;
            } else {
                throw new RuntimeException('Failed to move uploaded file.');
            }
        }

        try {
            $contactManager->updateContact($contact);
            redirect_to(url_for('/contacts/index.php'));
        } catch (InvalidArgumentException $e) {
            $errors = explode(', ', $e->getMessage());
        }
    } else {
        // Fetch existing contact data
        $contact = $contactManager->findContactById($id);
        
        if (!$contact) {
            throw new RuntimeException('Contact not found');
        }
    }

    $title = "Edit Contact";
    $page_heading = "Edit Contact";
    $page_subheading = "Update contact information";
    $custom_class = "edit-contact-page";

    include('../../src/Views/templates/header.php');
?>

    <div class="container py-5 <?php echo h($custom_class); ?>">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h2"><?php echo h($page_heading); ?></h1>
                    <a class="btn btn-outline-primary" href="<?php echo url_for('/contacts/index.php'); ?>">
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
                        <form method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-4 text-center mb-3">
                                    <?php if (!empty($contact['image'])): ?>
                                        <img src="<?php echo url_for('/contacts/uploads/' . h($contact['image'])); ?>" 
                                             alt="Current contact image" 
                                             class="img-fluid rounded mb-3">
                                    <?php else: ?>
                                        <img src="<?php echo url_for('/assets/images/no-image.png'); ?>" 
                                             alt="No image available" 
                                             class="img-fluid rounded mb-3">
                                    <?php endif; ?>
                                    
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="image" name="image">
                                        <label class="custom-file-label" for="image">Choose file</label>
                                    </div>
                                </div>
                                
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="favorite" 
                                                   name="favorite" <?php echo ($contact['favorite'] ? 'checked' : ''); ?>>
                                            <label class="custom-control-label" for="favorite">Mark as Favorite</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="first_name">First Name</label>
                                        <input type="text" class="form-control" id="first_name" name="first_name" 
                                               value="<?php echo h($contact['first_name']); ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="last_name">Last Name</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name" 
                                               value="<?php echo h($contact['last_name']); ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" 
                                               value="<?php echo h($contact['email']); ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="contact_number">Contact Number</label>
                                        <input type="tel" class="form-control" id="contact_number" name="contact_number" 
                                               value="<?php echo h($contact['contact_number']); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="comments">Comments</label>
                                        <textarea class="form-control" id="comments" name="comments" 
                                                  rows="3"><?php echo h($contact['comments']); ?></textarea>
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
                                                <option value="<?php echo h($ranking['rank_id']); ?>"
                                                    <?php echo ($contact['rank_id'] == $ranking['rank_id']) ? 'selected' : ''; ?>>
                                                    <?php echo h($ranking['rank_description']); ?>
                                                </option>
                                            <?php 
                                                endforeach;
                                            } catch (Exception $e) {
                                                error_log('Failed to load rankings: ' . $e->getMessage());
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="text-right mt-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Update file input label with selected filename
        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            var fileName = e.target.files[0].name;
            var label = e.target.nextElementSibling;
            label.innerHTML = fileName;
        });
    </script>

<?php 
    include('../../src/Views/templates/footer.php');
} catch (Exception $e) {
    // Log the error
    error_log($e->getMessage());
    // Redirect to error page
    redirect_to('/error.php');
}
?>
