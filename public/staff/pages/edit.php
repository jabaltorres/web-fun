<?php
declare(strict_types=1);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// require_once('../../../src/initialize.php');
$app = require_once(__DIR__ . '/../../../config/bootstrap.php');

// RequestHelper
$request = $app['requestHelper'];

// PageService
$pages = $app['pageService']->findAllPages();

// SubjectService
$subjects = $app['subjectService']->findAllSubjects();

// Initialize the errors variable
$errors = []; // Initialize as an empty array

// Function to URL encode a string
$urlHelper = $app['urlHelper'];

if (!isset($_GET['id'])) {
    redirect_to(url_for('/staff/pages/index.php'));
}

// Get the page id and cast it to an integer
$page_id = (int) ($_GET['id'] ?? DEFAULT_PAGE_ID); // Ensure this is cast to an integer

if ($request->isPost()) {
    // Handle form values sent by new.php
    // Validate form data and populate $errors if there are any issues
    // Example:
    if (empty($_POST['menu_name'])) {
        $errors[] = "Menu name cannot be empty.";
    }

    // If there are no errors, proceed with processing
    if (empty($errors)) {
        $page = [];
        $page['id'] = $page_id;
        $page['subject_id'] = $request->post('subject_id') ?? '';
        $page['menu_name'] = $request->post('menu_name') ?? '';
        $page['position'] = $request->post('position') ?? '';
        $page['visible'] = $request->post('visible') ?? '';
        $page['content'] = $request->post('content') ?? '';

        $result = $app['pageService']->updatePage($page);
        if ($result === true) {
            $_SESSION['message'] = 'The page was updated successfully.';
            redirect_to(url_for('/staff/pages/show.php?id=' . $page_id));
        } else {
            $errors = $result;
        }
    }

} else {
    // Fetch the page by ID
    $page = $app['pageService']->findPageById($page_id); // Pass the integer $page_id

    // Check if the page was found
    if (!$page) {
        echo '<p>Page not found.</p>';
    }
}

$page_set = $app['pageService']->findAllPages();

// Check if $page_set is a valid mysqli_result before getting the number of rows
if ($page_set instanceof \mysqli_result) {
    $page_count = $app['databaseConnection']->get_num_rows($page_set);
} else {
    $page_count = 0; // Handle the case where the query did not return a valid result
}

// Free the result set
$app['databaseConnection']->free_result($page_set);

$page_title = 'Edit Page';

?>

<?php include('../../../src/Views/templates/header.php'); ?>

<script>
  tinymce.init({
    selector: 'textarea.wysiwyg',  // Targets all textareas with the class 'wysiwyg'
    plugins: [
      // Core editing features
      'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount', 'code',
    ],
    toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link image | code codesample',  // Toolbar options
    menubar: false,  // Hides the default menubar
    height: 600  // Sets the height of the editor
  });
</script>

<div id="content" class="container">
    <div class="row">
        <div class="col-12">
            <a class="btn btn-outline-info my-4 font-weight-bold" href="<?php echo url_for('/staff/pages/index.php'); ?>">&laquo; Back to List</a>

            <div class="page edit">
                <h1>Edit Page</h1>

                <?php echo $app['htmlHelper']->displayErrors($errors); ?>

                <form action="<?php echo url_for('/staff/pages/edit.php?id=' . h($urlHelper->u((string)$page_id))); ?>" method="post" class="border p-4">
                    <dl>
                        <dt>Subject</dt>
                        <dd>
                            <select name="subject_id">  
                                <?php
                                foreach ($subjects as $subject) {
                                    echo "<option value=\"" . h($subject['id']) . "\"";
                                    if ($page["subject_id"] == $subject['id']) {
                                        echo " selected";
                                    }
                                    echo ">" . h($subject['menu_name']) . "</option>";
                                }
                                ?>
                            </select>
                        </dd>
                    </dl>
                    <dl>
                        <dt>Menu Name</dt>
                        <dd><input type="text" name="menu_name" value="<?php echo h($page['menu_name']); ?>"/></dd>
                    </dl>
                    <dl>
                        <dt>Position</dt>
                        <dd>
                            <select name="position">
                                <?php
                                for ($i = 1; $i <= $page_count; $i++) {
                                    echo "<option value=\"{$i}\"";
                                    if ($page["position"] == $i) {
                                        echo " selected";
                                    }
                                    echo ">{$i}</option>";
                                }
                                ?>
                            </select>
                        </dd>
                    </dl>
                    <dl>
                        <dt>Visible</dt>
                        <dd>
                            <input type="hidden" name="visible" value="0"/>
                            <input type="checkbox" name="visible" value="1"<?php if ($page['visible'] == "1") {
                                echo " checked";
                            } ?> />
                        </dd>
                    </dl>
                    <dl>
                        <label for="content">Content:</label>
                        <textarea id="content" name="content" class="wysiwyg"><?php echo h($page['content']); ?></textarea>
                    </dl>
                    <div id="operations">
                        <input type="submit" class="btn btn-secondary" value="Edit Page"/>
                        <button type="button" class="btn btn-danger" onclick="window.location.href='<?php echo url_for('/staff/pages/delete.php?id=' . h(u($page_id))); ?>'">Delete Page</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<?php include('../../../src/Views/templates/footer.php'); ?>
