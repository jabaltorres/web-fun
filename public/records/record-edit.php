<?php

require_once('../../src/initialize.php');

$success_message = '';

// Function to update a vinyl record
function updateVinylRecord($id, $title, $artist, $genre, $release_year, $label, $catalog_number, $format, $speed, $condition, $purchase_date, $purchase_price, $notes, $front_image_path, $back_image_path) {
    global $db;

    // Prepare SQL query
    $sql = "UPDATE vinyl_records SET title = ?, artist = ?, genre = ?, release_year = ?, label = ?, catalog_number = ?, format = ?, speed = ?, `condition` = ?, purchase_date = ?, purchase_price = ?, notes = ?, front_image = ?, back_image = ? WHERE record_id = ?";

    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, 'ssssssssssdsssi', $title, $artist, $genre, $release_year, $label, $catalog_number, $format, $speed, $condition, $purchase_date, $purchase_price, $notes, $front_image_path, $back_image_path, $id);
    return mysqli_stmt_execute($stmt);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $record_id = $_GET['id'] ?? null;

    if (!$record_id) {
        echo "Record not found!";
        exit;
    }

    // Get form data
    $title = $_POST['title'];
    $artist = $_POST['artist'];
    $genre = $_POST['genre'];
    $release_year = $_POST['release_year'];
    $label = $_POST['label'];
    $catalog_number = $_POST['catalog_number'];
    $format = $_POST['format'];
    $speed = $_POST['speed'];
    $condition = $_POST['condition'];
    $purchase_date = $_POST['purchase_date'];
    $purchase_price = $_POST['purchase_price'];
    $notes = $_POST['notes'];

    // Get existing image paths from hidden fields
    $front_image_path = $_POST['existing_front_image'] ?? null;
    $back_image_path = $_POST['existing_back_image'] ?? null;

    // Define upload directory
    $upload_dir = '../../public/records/uploads/';

    // Ensure directory exists
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    // Handle image uploads or keep existing images
    if (!empty($_FILES['front_image']['name'])) {
        $front_image_path = $upload_dir . basename($_FILES['front_image']['name']);
        move_uploaded_file($_FILES['front_image']['tmp_name'], $front_image_path);
    }

    if (!empty($_FILES['back_image']['name'])) {
        $back_image_path = $upload_dir . basename($_FILES['back_image']['name']);
        move_uploaded_file($_FILES['back_image']['tmp_name'], $back_image_path);
    }

    // Update the record in the database
    if (updateVinylRecord($record_id, $title, $artist, $genre, $release_year, $label, $catalog_number, $format, $speed, $condition, $purchase_date, $purchase_price, $notes, $front_image_path, $back_image_path)) {
        $success_message = "Record updated successfully!";
    } else {
        echo "Error updating record.";
    }
}

// Fetch existing record and display form for editing
if ($_SERVER['REQUEST_METHOD'] === 'GET' || !empty($success_message)) {
    $record_id = $_GET['id'] ?? null;

    if (!$record_id) {
        echo "Record not found!";
        exit;
    }

    // Function to get the vinyl record details
    function getVinylRecordById($id): ?array {
        global $db;

        $sql = "SELECT * FROM vinyl_records WHERE record_id = ?";
        $stmt = mysqli_prepare($db, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        return mysqli_fetch_assoc($result) ?: null;  // Return the record or null if not found
    }

    $record = getVinylRecordById($record_id);

    if (!$record) {
        echo "Record not found!";
        exit;
    }

    include('../../templates/layout/header.php');
    ?>

    <!-- Display the form -->
    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-4">Edit Vinyl Record: <?php echo $record['title']; ?> by <?php echo $record['artist']; ?></h1>

                <?php if (!empty($success_message)): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $success_message; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="record-edit.php?id=<?php echo $record['record_id']; ?>" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?php echo $record['title']; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="artist">Artist</label>
                        <input type="text" class="form-control" id="artist" name="artist" value="<?php echo $record['artist']; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="genre">Genre</label>
                        <input type="text" class="form-control" id="genre" name="genre" value="<?php echo $record['genre']; ?>">
                    </div>

                    <div class="form-group">
                        <label for="release_year">Release Year</label>
                        <input type="number" class="form-control" id="release_year" name="release_year" value="<?php echo $record['release_year']; ?>">
                    </div>

                    <div class="form-group">
                        <label for="label">Label</label>
                        <input type="text" class="form-control" id="label" name="label" value="<?php echo $record['label']; ?>">
                    </div>

                    <div class="form-group">
                        <label for="catalog_number">Catalog Number</label>
                        <input type="text" class="form-control" id="catalog_number" name="catalog_number" value="<?php echo $record['catalog_number']; ?>">
                    </div>

                    <div class="form-group">
                        <label for="format">Format</label>
                        <select class="form-control" id="format" name="format">
                            <option value="12&quot;" <?php echo ($record['format'] == '12"') ? 'selected' : ''; ?>>12"</option>
                            <option value="10&quot;" <?php echo ($record['format'] == '10"') ? 'selected' : ''; ?>>10"</option>
                            <option value="7&quot;" <?php echo ($record['format'] == '7"') ? 'selected' : ''; ?>>7"</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="speed">Speed</label>
                        <select class="form-control" id="speed" name="speed">
                            <option value="33 1/3 RPM" <?php echo ($record['speed'] == '33 1/3 RPM') ? 'selected' : ''; ?>>33 1/3 RPM</option>
                            <option value="45 RPM" <?php echo ($record['speed'] == '45 RPM') ? 'selected' : ''; ?>>45 RPM</option>
                            <option value="78 RPM" <?php echo ($record['speed'] == '78 RPM') ? 'selected' : ''; ?>>78 RPM</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="condition">Condition</label>
                        <select class="form-control" id="condition" name="condition">
                            <option value="Mint" <?php echo ($record['condition'] == 'Mint') ? 'selected' : ''; ?>>Mint</option>
                            <option value="Near Mint" <?php echo ($record['condition'] == 'Near Mint') ? 'selected' : ''; ?>>Near Mint</option>
                            <option value="Very Good" <?php echo ($record['condition'] == 'Very Good') ? 'selected' : ''; ?>>Very Good</option>
                            <option value="Good" <?php echo ($record['condition'] == 'Good') ? 'selected' : ''; ?>>Good</option>
                            <option value="Fair" <?php echo ($record['condition'] == 'Fair') ? 'selected' : ''; ?>>Fair</option>
                            <option value="Poor" <?php echo ($record['condition'] == 'Poor') ? 'selected' : ''; ?>>Poor</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="purchase_date">Purchase Date</label>
                        <input type="date" class="form-control" id="purchase_date" name="purchase_date" value="<?php echo $record['purchase_date']; ?>">
                    </div>

                    <div class="form-group">
                        <label for="purchase_price">Purchase Price</label>
                        <input type="text" class="form-control" id="purchase_price" name="purchase_price" value="<?php echo $record['purchase_price']; ?>">
                    </div>

                    <div class="form-group">
                        <label for="notes">Notes</label>
                        <textarea class="form-control" id="notes" name="notes"><?php echo $record['notes']; ?></textarea>
                    </div>

                    <!-- Front Image -->
                    <div class="form-group">
                        <label for="front_image">Front Image</label>
                        <input type="file" class="form-control" id="front_image" name="front_image" accept="image/*">
                        <?php if (!empty($record['front_image'])): ?>
                            <p>Current Front Image: <img src="<?php echo '/records/uploads/' . basename($record['front_image']); ?>" alt="Front Image" style="max-width: 100px;"></p>
                            <!-- Hidden input to retain the existing front image -->
                            <input type="hidden" name="existing_front_image" value="<?php echo $record['front_image']; ?>">
                        <?php endif; ?>
                    </div>

                    <!-- Back Image -->
                    <div class="form-group">
                        <label for="back_image">Back Image</label>
                        <input type="file" class="form-control" id="back_image" name="back_image" accept="image/*">
                        <?php if (!empty($record['back_image'])): ?>
                            <p>Current Back Image: <img src="<?php echo '/records/uploads/' . basename($record['back_image']); ?>" alt="Back Image" style="max-width: 100px;"></p>
                            <!-- Hidden input to retain the existing back image -->
                            <input type="hidden" name="existing_back_image" value="<?php echo $record['back_image']; ?>">
                        <?php endif; ?>
                    </div>

                    <button type="submit" class="btn btn-primary">Save Changes</button>

                    <a class="btn btn-info" href="<?php echo url_for('/records/record-details.php?id=' . $record['record_id']); ?>">View Record</a>
                </form>
            </div>
        </div>
    </div>

    <?php include('../../templates/layout/footer.php'); ?>
    <?php
}
?>