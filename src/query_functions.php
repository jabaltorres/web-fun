<?php

// Subjects
function find_all_subjects($options = [])
{
    global $db;

    $visible = $options['visible'] ?? false;

    $sql = "SELECT * FROM subjects ";

    if ($visible) {
        $sql .= "WHERE visible = true ";
    }

    $sql .= "ORDER BY position ASC";
    //echo $sql;
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}

function find_subject_by_id($id, $options = [])
{
    global $db;

    $visible = $options['visible'] ?? false;

    $sql = "SELECT * FROM subjects ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "' ";

    if ($visible) {
        $sql .= "AND visible = true";
    }

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $subject = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $subject; // returns an assoc. array
}

function validate_subject($subject)
{
    $errors = [];

    // menu_name
    if (is_blank($subject['menu_name'])) {
        $errors[] = "Name cannot be blank.";
    } elseif (!has_length($subject['menu_name'], ['min' => 2, 'max' => 255])) {
        $errors[] = "Name must be between 2 and 255 characters.";
    }

    // position
    // Make sure we are working with an integer
    $postion_int = (int)$subject['position'];
    if ($postion_int <= 0) {
        $errors[] = "Position must be greater than zero.";
    }
    if ($postion_int > 999) {
        $errors[] = "Position must be less than 999.";
    }

    // visible
    // Make sure we are working with a string
    $visible_str = (string)$subject['visible'];
    if (!has_inclusion_of($visible_str, ["0", "1"])) {
        $errors[] = "Visible must be true or false.";
    }

    return $errors;
}

function insert_subject($subject)
{
    global $db;

    $errors = validate_subject($subject);
    if (!empty($errors)) {
        return $errors;
    }

    $sql = "INSERT INTO subjects ";
    $sql .= "(menu_name, position, visible) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $subject['menu_name']) . "',";
    $sql .= "'" . db_escape($db, $subject['position']) . "',";
    $sql .= "'" . db_escape($db, $subject['visible']) . "'";
    $sql .= ")";
    $result = mysqli_query($db, $sql);
    // For INSERT statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function update_subject($subject)
{
    global $db;

    $errors = validate_subject($subject);
    if (!empty($errors)) {
        return $errors;
    }

    $sql = "UPDATE subjects SET ";
    $sql .= "menu_name='" . db_escape($db, $subject['menu_name']) . "', ";
    $sql .= "position='" . db_escape($db, $subject['position']) . "', ";
    $sql .= "visible='" . db_escape($db, $subject['visible']) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $subject['id']) . "' ";
    $sql .= "LIMIT 1";

    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function delete_subject($id)
{
    global $db;

    $sql = "DELETE FROM subjects ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    // For DELETE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // DELETE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}


// Pages
function find_all_pages()
{
    global $db;

    $sql = "SELECT * FROM pages ";
    $sql .= "ORDER BY subject_id ASC, position ASC";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}

function find_page_by_id($id, $options = [])
{
    global $db;

    $visible = $options['visible'] ?? false;

    $sql = "SELECT * FROM pages ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "' ";

    if ($visible) {
        $sql .= "AND visible = true";
    }

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $page = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $page; // returns an assoc. array
}

function validate_page($page)
{
    $errors = [];

    // subject_id
    if (is_blank($page['subject_id'])) {
        $errors[] = "Subject cannot be blank.";
    }

    // menu_name
    if (is_blank($page['menu_name'])) {
        $errors[] = "Name cannot be blank.";
    } elseif (!has_length($page['menu_name'], ['min' => 2, 'max' => 255])) {
        $errors[] = "Name must be between 2 and 255 characters.";
    }
    $current_id = $page['id'] ?? '0';
    if (!has_unique_page_menu_name($page['menu_name'], $current_id)) {
        $errors[] = "Menu name must be unique.";
    }


    // position
    // Make sure we are working with an integer
    $postion_int = (int)$page['position'];
    if ($postion_int <= 0) {
        $errors[] = "Position must be greater than zero.";
    }
    if ($postion_int > 999) {
        $errors[] = "Position must be less than 999.";
    }

    // visible
    // Make sure we are working with a string
    $visible_str = (string)$page['visible'];
    if (!has_inclusion_of($visible_str, ["0", "1"])) {
        $errors[] = "Visible must be true or false.";
    }

    // content
    if (is_blank($page['content'])) {
        $errors[] = "Content cannot be blank.";
    }

    return $errors;
}

function insert_page($page)
{
    global $db;

    $errors = validate_page($page);
    if (!empty($errors)) {
        return $errors;
    }

    $sql = "INSERT INTO pages ";
    $sql .= "(subject_id, menu_name, position, visible, content) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $page['subject_id']) . "',";
    $sql .= "'" . db_escape($db, $page['menu_name']) . "',";
    $sql .= "'" . db_escape($db, $page['position']) . "',";
    $sql .= "'" . db_escape($db, $page['visible']) . "',";
    $sql .= "'" . db_escape($db, $page['content']) . "'";
    $sql .= ")";
    $result = mysqli_query($db, $sql);
    // For INSERT statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function update_page($page)
{
    global $db;

    $errors = validate_page($page);
    if (!empty($errors)) {
        return $errors;
    }

    $sql = "UPDATE pages SET ";
    $sql .= "subject_id='" . db_escape($db, $page['subject_id']) . "', ";
    $sql .= "menu_name='" . db_escape($db, $page['menu_name']) . "', ";
    $sql .= "position='" . db_escape($db, $page['position']) . "', ";
    $sql .= "visible='" . db_escape($db, $page['visible']) . "', ";
    $sql .= "content='" . db_escape($db, $page['content']) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $page['id']) . "' ";
    $sql .= "LIMIT 1";

    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function delete_page($id)
{
    global $db;

    $sql = "DELETE FROM pages ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    // For DELETE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // DELETE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function find_pages_by_subject_id($subject_id, $options = [])
{
    global $db;

    $visible = $options['visible'] ?? false;

    $sql = "SELECT * FROM pages ";
    $sql .= "WHERE subject_id='" . db_escape($db, $subject_id) . "' ";

    if ($visible) {
        $sql .= "AND visible = true ";
    }

    $sql .= "ORDER BY position ASC";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}


// Contacts
function find_all_contacts($sort = 'id')
{
    global $db;

    // Define a whitelist of sortable columns
    $valid_sort_columns = ['id', 'first_name', 'last_name', 'email', 'favorite'];
    // Ensure the provided sort parameter is in the whitelist
    if (!in_array($sort, $valid_sort_columns)) {
        $sort = 'id'; // Default to 'id' if an invalid sort parameter is provided
    }

    $sql = "SELECT * FROM contact_list ";
    // Check if the sort parameter is 'favorite', then sort DESC, otherwise sort ASC
    if ($sort == 'favorite') {
        $sql .= "ORDER BY " . $sort . " DESC"; // Favorited contacts will appear at the top
    } else {
        $sql .= "ORDER BY " . $sort . " ASC"; // Ascending order for other columns
    }

    // echo $sql; // For debugging

    // Execute the SQL query
    $result = mysqli_query($db, $sql);
    confirm_result_set($result); // Check the result set
    return $result;
}

function find_contact_by_id($id)
{
    global $db;
    $sql = "SELECT contact_list.*, rankings.rank_description FROM contact_list ";
    $sql .= "LEFT JOIN rankings ON contact_list.rank_id = rankings.rank_id ";
    $sql .= "WHERE contact_list.id='" . db_escape($db, $id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $contact = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $contact;
}

function validate_contact($contact)
{
    $errors = [];

    // first_name
    if (is_blank($contact['first_name'])) {
        $errors[] = "Name cannot be blank.";
    } elseif (!has_length($contact['first_name'], ['min' => 2, 'max' => 255])) {
        $errors[] = "Name must be between 2 and 255 characters.";
    }

    // last_name
    if (is_blank($contact['last_name'])) {
        $errors[] = "Name cannot be blank.";
    } elseif (!has_length($contact['last_name'], ['min' => 2, 'max' => 255])) {
        $errors[] = "Name must be between 2 and 255 characters.";
    }

    // email
    $email_regex = '/\A[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\Z/i';
    if (preg_match($email_regex, $contact['email']) !== 1) {
        $errors[] = "Email address must be valid.";
    }
    return $errors;
}

function insert_contact($contact)
{
    global $db;

    $errors = validate_contact($contact);
    if (!empty($errors)) {
        return $errors;
    }

    $sql = "INSERT INTO contact_list ";
    $sql .= "(first_name, last_name, email) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $contact['first_name']) . "',";
    $sql .= "'" . db_escape($db, $contact['last_name']) . "',";
    $sql .= "'" . db_escape($db, $contact['email']) . "'";
    $sql .= ")";
    $result = mysqli_query($db, $sql);
    // For INSERT statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function update_contact($contact)
{
    global $db;

    $rank_id = empty($contact['rank_id']) ? 'NULL' : db_escape($db, $contact['rank_id']); // Handle empty rank_id

    $errors = validate_contact($contact);
    if (!empty($errors)) {
        return $errors;
    }

    $sql = "UPDATE contact_list SET ";
    $sql .= "first_name='" . db_escape($db, $contact['first_name']) . "', ";
    $sql .= "last_name='" . db_escape($db, $contact['last_name']) . "', ";
    $sql .= "email='" . db_escape($db, $contact['email']) . "', ";
    $sql .= "comments='" . db_escape($db, $contact['comments']) . "', ";
    $sql .= "contact_number='" . db_escape($db, $contact['contact_number']) . "', ";
    $sql .= "favorite=" . (int)$contact['favorite'] . ", "; // Update favorite status
    $sql .= "rank_id=" . $rank_id; // Directly use NULL if rank_id is not set

    // Add the image field only if a new image was uploaded
    if (!empty($contact['image'])) {
        $sql .= ", image='" . db_escape($db, $contact['image']) . "'";
    }

    $sql .= " WHERE id='" . db_escape($db, $contact['id']) . "' LIMIT 1";

    $result = mysqli_query($db, $sql);
    if ($result) {
        return true;
    } else {
        // More informative error message for debugging
        $error = mysqli_error($db);
        echo "SQL Error: " . $error;
        db_disconnect($db);
        exit;
    }
}

function delete_contact($id)
{
    global $db;

    $sql = "DELETE FROM contact_list ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    // For DELETE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // DELETE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}


// Admins

// Find all admins, ordered last_name, first_name
function find_all_admins()
{
    global $db;

    $sql = "SELECT * FROM admins ";
    $sql .= "ORDER BY last_name ASC, first_name ASC";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}

function find_admin_by_id($id)
{
    global $db;

    $sql = "SELECT * FROM admins ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $admin = mysqli_fetch_assoc($result); // find first
    mysqli_free_result($result);
    return $admin; // returns an assoc. array
}

function find_admin_by_username($username)
{
    global $db;

    $sql = "SELECT * FROM admins ";
    $sql .= "WHERE username='" . db_escape($db, $username) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $admin = mysqli_fetch_assoc($result); // find first
    mysqli_free_result($result);
    return $admin; // returns an assoc. array
}

function validate_admin($admin, $options = [])
{

    $password_required = $options['password_required'] ?? true;

    if (is_blank($admin['first_name'])) {
        $errors[] = "First name cannot be blank.";
    } elseif (!has_length($admin['first_name'], ['min' => 2, 'max' => 255])) {
        $errors[] = "First name must be between 2 and 255 characters.";
    }

    if (is_blank($admin['last_name'])) {
        $errors[] = "Last name cannot be blank.";
    } elseif (!has_length($admin['last_name'], ['min' => 2, 'max' => 255])) {
        $errors[] = "Last name must be between 2 and 255 characters.";
    }

    if (is_blank($admin['email'])) {
        $errors[] = "Email cannot be blank.";
    } elseif (!has_length($admin['email'], ['max' => 255])) {
        $errors[] = "Last name must be less than 255 characters.";
    } elseif (!has_valid_email_format($admin['email'])) {
        $errors[] = "Email must be a valid format.";
    }

    if (is_blank($admin['username'])) {
        $errors[] = "Username cannot be blank.";
    } elseif (!has_length($admin['username'], ['min' => 8, 'max' => 255])) {
        $errors[] = "Username must be between 8 and 255 characters.";
    } elseif (!has_unique_username($admin['username'], $admin['id'] ?? 0)) {
        $errors[] = "Username not allowed. Try another.";
    }

    if ($password_required) {
        if (is_blank($admin['password'])) {
            $errors[] = "Password cannot be blank.";
        } elseif (!has_length($admin['password'], ['min' => 12])) {
            $errors[] = "Password must contain 12 or more characters";
        } elseif (!preg_match('/[A-Z]/', $admin['password'])) {
            $errors[] = "Password must contain at least 1 uppercase letter";
        } elseif (!preg_match('/[a-z]/', $admin['password'])) {
            $errors[] = "Password must contain at least 1 lowercase letter";
        } elseif (!preg_match('/[0-9]/', $admin['password'])) {
            $errors[] = "Password must contain at least 1 number";
        } elseif (!preg_match('/[^A-Za-z0-9\s]/', $admin['password'])) {
            $errors[] = "Password must contain at least 1 symbol";
        }

        if (is_blank($admin['confirm_password'])) {
            $errors[] = "Confirm password cannot be blank.";
        } elseif ($admin['password'] !== $admin['confirm_password']) {
            $errors[] = "Password and confirm password must match.";
        }
    }

    return $errors;
}

function insert_admin($admin)
{
    global $db;

    $errors = validate_admin($admin);
    if (!empty($errors)) {
        return $errors;
    }

    $hashed_password = password_hash($admin['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO admins ";
    $sql .= "(first_name, last_name, email, username, hashed_password) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $admin['first_name']) . "',";
    $sql .= "'" . db_escape($db, $admin['last_name']) . "',";
    $sql .= "'" . db_escape($db, $admin['email']) . "',";
    $sql .= "'" . db_escape($db, $admin['username']) . "',";
    $sql .= "'" . db_escape($db, $hashed_password) . "'";
    $sql .= ")";
    $result = mysqli_query($db, $sql);

    // For INSERT statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // INSERT failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function update_admin($admin)
{
    global $db;

    $password_sent = !is_blank($admin['password']);

    $errors = validate_admin($admin, ['password_required' => $password_sent]);
    if (!empty($errors)) {
        return $errors;
    }

    $hashed_password = password_hash($admin['password'], PASSWORD_BCRYPT);

    $sql = "UPDATE admins SET ";
    $sql .= "first_name='" . db_escape($db, $admin['first_name']) . "', ";
    $sql .= "last_name='" . db_escape($db, $admin['last_name']) . "', ";
    $sql .= "email='" . db_escape($db, $admin['email']) . "', ";
    if ($password_sent) {
        $sql .= "hashed_password='" . db_escape($db, $hashed_password) . "', ";
    }
    $sql .= "username='" . db_escape($db, $admin['username']) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $admin['id']) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    // For UPDATE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // UPDATE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}

function delete_admin($admin)
{
    global $db;

    $sql = "DELETE FROM admins ";
    $sql .= "WHERE id='" . db_escape($db, $admin['id']) . "' ";
    $sql .= "LIMIT 1;";
    $result = mysqli_query($db, $sql);

    // For DELETE statements, $result is true/false
    if ($result) {
        return true;
    } else {
        // DELETE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}


// JT Test - being used on demos/forms/forms.php
function validate_jt_test_form($jtMessage)
{
    $errors = [];

    if (is_blank($jtMessage['name'])) {
        $errors[] = "Name cannot be blank.";
    } elseif (!has_length($jtMessage['name'], ['min' => 2, 'max' => 255])) {
        $errors[] = "Name must be between 2 and 255 characters.";
    }

    if (!has_valid_email_format($jtMessage['email'])) {
        $errors[] = "Invalid email format";
    }

    if (is_blank($jtMessage['message'])) {
        $errors[] = "Message cannot be blank.";
    } elseif (!has_length($jtMessage['message'], ['min' => 10, 'max' => 255])) {
        $errors[] = "Message must be between 10 and 255 characters.";
    }


    if (!empty($errors)) {
        return $errors;
    }

    // Testing the return statement.
    echo '<ul>';
    foreach ($jtMessage as $jtMessageItem) {
        echo "<li>" . h($jtMessageItem) . "</li>";
    }
    echo '</ul>';
}

function find_all_rankings()
{
    global $db;
    $sql = "SELECT rank_id, rank_description FROM rankings ORDER BY rank_id";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $rankings = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
    return $rankings;
}

?>
