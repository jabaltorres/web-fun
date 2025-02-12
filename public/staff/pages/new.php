<?php

require_once('../../../src/initialize.php');

if (is_post_request()) {

    $page = [];
    $page['subject_id'] = $_POST['subject_id'] ?? '';
    $page['menu_name'] = $_POST['menu_name'] ?? '';
    $page['position'] = $_POST['position'] ?? '';
    $page['visible'] = $_POST['visible'] ?? '';
    $page['content'] = $_POST['content'] ?? '';

    $result = insert_page($page);
    if ($result === true) {
        $new_id = mysqli_insert_id($db);
        $_SESSION['message'] = 'The page was created successfully.';
        redirect_to(url_for('/staff/pages/show.php?id=' . $new_id));
    } else {
        $errors = $result;
    }

} else {

    $page = [];
    $page['subject_id'] = '';
    $page['menu_name'] = '';
    $page['position'] = '';
    $page['visible'] = '';
    $page['content'] = '';

}

$page_set = find_all_pages();
$page_count = mysqli_num_rows($page_set) + 1;
mysqli_free_result($page_set);

?>

<?php $page_title = 'Create Page'; ?>
<?php include('../../../templates/layouts/header.php'); ?>

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

            <div class="page new">
                <h1>Create Page</h1>

                <?php echo display_errors($errors); ?>

                <form action="<?php echo url_for('/staff/pages/new.php'); ?>" method="post">

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Subject</label>
                        <select id="exampleFormControlSelect1" name="subject_id" class="form-control" >
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
                    </div>

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
                        <dt>Content</dt>
                        <dd>
                            <textarea class="wysiwyg" name="content" cols="60" rows="10"><?php echo h($page['content']); ?></textarea>
                        </dd>
                    </dl>
                    <div id="operations">
                        <input type="submit" value="Create Page" class="btn btn-primary"/>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<?php include('../../../templates/layouts/footer.php'); ?>
