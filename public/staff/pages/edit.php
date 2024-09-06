<?php

require_once('../../../src/initialize.php');

if (!isset($_GET['id'])) {
    redirect_to(url_for('/staff/pages/index.php'));
}
$id = $_GET['id'];

if (is_post_request()) {

    // Handle form values sent by new.php

    $page = [];
    $page['id'] = $id;
    $page['subject_id'] = $_POST['subject_id'] ?? '';
    $page['menu_name'] = $_POST['menu_name'] ?? '';
    $page['position'] = $_POST['position'] ?? '';
    $page['visible'] = $_POST['visible'] ?? '';
    $page['content'] = $_POST['content'] ?? '';

    $result = update_page($page);
    if ($result === true) {
        $_SESSION['message'] = 'The page was updated successfully.';
        redirect_to(url_for('/staff/pages/show.php?id=' . $id));
    } else {
        $errors = $result;
    }

} else {
    $page = find_page_by_id($id);
}

$page_set = find_all_pages();
$page_count = mysqli_num_rows($page_set);
mysqli_free_result($page_set);

?>

<?php $page_title = 'Edit Page'; ?>
<?php include('../../../templates/layout/header.php'); ?>

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

                <?php echo display_errors($errors); ?>

                <form action="<?php echo url_for('/staff/pages/edit.php?id=' . h(u($id))); ?>" method="post" class="border">
                    <dl>
                        <dt>Subject</dt>
                        <dd>
                            <select name="subject_id">
                                <?php
                                $subject_set = find_all_subjects();
                                while ($subject = mysqli_fetch_assoc($subject_set)) {
                                    echo "<option value=\"" . h($subject['id']) . "\"";
                                    if ($page["subject_id"] == $subject['id']) {
                                        echo " selected";
                                    }
                                    echo ">" . h($subject['menu_name']) . "</option>";
                                }
                                mysqli_free_result($subject_set);
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
<!--                        <textarea name="content" cols="60" rows="10">--><?php //echo h($page['content']); ?><!--</textarea>-->

                    </dl>
                    <div id="operations">
                        <input type="submit" class="btn btn-secondary" value="Edit Page"/>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<?php include('../../../templates/layout/footer.php'); ?>
