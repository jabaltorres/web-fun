<?php
require_once('../../private/initialize.php');

require_login();

if (!isset($_GET['id'])) {
    redirect_to(url_for('/index.php'));
}
$id = $_GET['id'];

if (is_post_request()) {

    $contact = [];
    $contact['id'] = $id;
    $contact['first_name'] = $_POST['first_name'] ?? '';
    $contact['last_name'] = $_POST['last_name'] ?? '';
    $contact['email'] = $_POST['email'] ?? '';
    $contact['comments'] = $_POST['comments'] ?? '';
    $contact['contact_number'] = $_POST['contact_number'] ?? '';
    $contact['rank_id'] = $_POST['rank_id'] ?? '';
    $contact['favorite'] = isset($_POST['favorite']) ? 1 : 0; // Add favorite status from checkbox

    // File upload handling
    if (!empty($_FILES['image']['name'])) {
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_ext = strtolower(end(explode('.',$_FILES['image']['name'])));

        $extensions= array("jpeg","jpg","png");
        if(in_array($file_ext, $extensions) === false){
            $errors[]="extension not allowed, please choose a JPEG or PNG file.";
        }

        if(empty($errors)==true){
            $new_filename = uniqid('img_', true) . '.' . $file_ext;
            $file_destination = 'uploads/' . $new_filename;
            if(move_uploaded_file($file_tmp, $file_destination)) {
                $contact['image'] = $new_filename;  // Update array to include image file name
            } else {
                $errors[] = "Failed to move uploaded file.";
            }
        }
    }

    $result = update_contact($contact);
    if($result === true) {
        redirect_to(url_for('/contacts/index.php'));
    } else {
        $errors = $result;
        //var_dump($errors);
    }

} else {

    $contact = find_contact_by_id($id);

}

$title = "Edit Contact";
$page_heading = "Edit the contact";
$page_subheading = "Test the database functionality";
$custom_class = "edit-contact-page";

include_once(SHARED_PATH . '/site-header.php');
include_once(SHARED_PATH . '/navigation.php');

?>

<div class="container <?php echo $custom_class; ?>">

    <section id="form-section">
        <?php include_once(SHARED_PATH . '/headline-page.php');?>

        <?php echo display_errors($errors); ?>

        <a class="btn btn-outline-info mb-4 font-weight-bold" href="<?php echo url_for('/contacts/index.php'); ?>">&laquo; Back to List</a>

        <form id="form" method="post" action="<?php echo url_for('/contacts/contact-edit.php?id=' . h(u($id))); ?>" enctype="multipart/form-data">

            <div class="contact-image">
                <img src="<?php echo url_for('contacts/uploads/' . $contact['image']); ?>" alt="image" class="mb-4" style="max-width: 200px; display: block; margin: 0 auto;">
            </div>

            <label for="favorite">Favorite:</label>
            <input type="checkbox" id="favorite" name="favorite" <?php echo ($contact['favorite'] ? 'checked' : ''); ?>><br />

            <label for="first_name">First name:</label>
            <input type="text" name="first_name" value="<?php echo h($contact['first_name']); ?>" /><br />

            <label for="last_name">Last name:</label>
            <input type="text" name="last_name" value="<?php echo h($contact['last_name']); ?>" /><br />

            <label for="contact_number">Contact Number:</label>
            <input type="text" name="contact_number" value="<?php echo h($contact['contact_number']); ?>" /><br />

            <label for="email">Email:</label>
            <input type="text" id="email" name="email" value="<?php echo h($contact['email']); ?>" /><br />

            <label for="comments">Comment:</label>
            <textarea id="comments" name="comments"><?php echo h($contact['comments']); ?></textarea><br />

            <label for="rank_id">Rank:</label>
            <select name="rank_id" id="rank_id">
                <!-- Option for no ranking -->
                <option value="">No Ranking</option>
                <?php
                $rankings = find_all_rankings(); // Assume this function fetches ranking data correctly
                foreach ($rankings as $ranking) {
                    echo "<option value=\"" . h($ranking['rank_id']) . "\"";
                    if (isset($contact['rank_id']) && $ranking['rank_id'] == $contact['rank_id']) {
                        echo " selected";
                    }
                    echo ">" . h($ranking['rank_description']) . "</option>";
                }
                ?>
            </select><br />

            <label for="image">Upload Image:</label>
            <input type="file" name="image" id="image"><br />

            <input type="submit" name="submit" value="Edit Contact" id="button" class="btn btn-warning" />
            <a class="btn btn-danger" href="<?php echo url_for('/contacts/contact-remove.php'); ?>">Delete Contact(s)</a>

        </form>
    </section>
</div>

<?php include_once(SHARED_PATH . '/site-footer.php');?>
