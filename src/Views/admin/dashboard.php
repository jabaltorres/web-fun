<?php
    
    // Ensure this file isn't accessed directly
    if (!defined('PRIVATE_PATH')) {
        exit('Direct access not permitted');
    }

    // Handle POST actions
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Verify CSRF token
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die('Invalid CSRF token');
        }

        switch ($_POST['action']) {
            case 'edit_setting':
                if (isset($_POST['setting_id'], $_POST['setting_value'])) {
                    $setting_id = filter_var($_POST['setting_id'], FILTER_SANITIZE_NUMBER_INT);
                    $setting_value = trim(htmlspecialchars($_POST['setting_value'], ENT_QUOTES, 'UTF-8'));
                    $setting_type = trim(htmlspecialchars($_POST['setting_type'], ENT_QUOTES, 'UTF-8'));
                    $category = trim(htmlspecialchars($_POST['category'], ENT_QUOTES, 'UTF-8'));
                    $description = trim(htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8'));
                    $is_private = isset($_POST['is_private']) ? 1 : 0;

                    $sql = "UPDATE settings 
                        SET setting_value = ?, setting_type = ?, category = ?, 
                            description = ?, is_private = ? 
                        WHERE setting_id = ?";
                    
                    $stmt = $db->prepare($sql);
                    $stmt->bind_param('ssssii', 
                        $setting_value, 
                        $setting_type, 
                        $category, 
                        $description, 
                        $is_private, 
                        $setting_id
                    );
                    $stmt->execute();
                }
                break;

            case 'add_setting':
                if (isset($_POST['setting_key'], $_POST['setting_value'])) {
                    $setting_key = trim(htmlspecialchars($_POST['setting_key'], ENT_QUOTES, 'UTF-8'));
                    $setting_value = trim(htmlspecialchars($_POST['setting_value'], ENT_QUOTES, 'UTF-8'));
                    $setting_type = trim(htmlspecialchars($_POST['setting_type'], ENT_QUOTES, 'UTF-8'));
                    $category = trim(htmlspecialchars($_POST['category'], ENT_QUOTES, 'UTF-8'));
                    $description = trim(htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8'));
                    $is_private = isset($_POST['is_private']) ? 1 : 0;

                    $sql = "INSERT INTO settings 
                        (setting_key, setting_value, setting_type, category, description, is_private) 
                        VALUES (?, ?, ?, ?, ?, ?)";
                    
                    $stmt = $db->prepare($sql);
                    $stmt->bind_param('sssssi', 
                        $setting_key, 
                        $setting_value, 
                        $setting_type, 
                        $category, 
                        $description, 
                        $is_private
                    );
                    $stmt->execute();
                }
                break;

            case 'delete_setting':
                if (isset($_POST['setting_id'])) {
                    $setting_id = filter_var($_POST['setting_id'], FILTER_SANITIZE_NUMBER_INT);
                    $sql = "DELETE FROM settings WHERE setting_id = ?";
                    $stmt = $db->prepare($sql);
                    $stmt->bind_param('i', $setting_id);
                    $stmt->execute();
                }
                break;
        }

        // Redirect to prevent form resubmission
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }

    // Generate CSRF token if not exists
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    // Get the first name of the user
    $first_name = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : '';
?>

<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4"><?= $pageTitle ?></h1>
            <p class="mb-4 h4"><?= $pageDescription ?></p>
            
            <!-- Dark Mode Toggle Button -->
            <button id="darkModeToggle" class="btn btn-secondary mb-4">Toggle Dark Mode</button>
            
            <?php if ($loggedIn): ?>
                <section class="card mb-4">
                    <div class="card-body">
                        <p class="card-text h2">Hello, <?= htmlspecialchars($first_name ?? 'there') ?>!</p>
                        
                        <!-- Display current date and time -->
                        <div class="current-datetime mb-4">
                            <p id="currentDateTime">Current Date and Time: <?= date('Y-m-d H:i:s') ?></p>
                        </div>
                    </div>
                </section>
            <?php endif; ?>

            <?php if ($isAdmin && $users && $users->num_rows > 0): ?>
                
                <section class="card mb-4">
                    <div class="card-header">
                        <h2 class="h4 mb-0">Environment Configs</h2>
                    </div>
                    <div class="card-body">
                        <p>These core settings are managed through environment variables in the <code>.env</code> file. For security reasons, they can only be modified by updating the environment configuration.</p>
                        <dl class="row">
                            <dt class="col-sm-3">Site Owner</dt>
                            <dd class="col-sm-9"><?= htmlspecialchars($config['site']['owner']) ?></dd>
                            
                            <dt class="col-sm-3">Site Name</dt>
                            <dd class="col-sm-9"><?= htmlspecialchars($config['site']['name']) ?></dd>
                            
                            <dt class="col-sm-3">Site Tagline</dt>
                            <dd class="col-sm-9"><?= htmlspecialchars($config['site']['tagline']) ?></dd>
                            
                            <dt class="col-sm-3">Site Description</dt>
                            <dd class="col-sm-9"><?= htmlspecialchars($config['site']['description']) ?></dd>
                            
                            <dt class="col-sm-3">Site Author</dt>
                            <dd class="col-sm-9"><?= htmlspecialchars($config['site']['author']) ?></dd>
                        </dl>
                    </div>
                </section>

                <section class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="h4 mb-0">System Settings</h2>
                        <div class="settings-header-controls d-flex gap-3">
                            <div class="input-group">
                                <input type="text" 
                                       id="settingsFilter" 
                                       class="form-control" 
                                       placeholder="Filter settings...">
                                <button class="btn" 
                                        type="button" 
                                        id="clearFilter"
                                        title="Clear filter">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <button type="button" 
                                    class="btn btn-primary btn-add-setting ml-2" 
                                    data-toggle="modal" 
                                    data-target="#addSettingModal">
                                Add Setting
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($settings)): ?>
                            <div class="table-responsive">
                                <table class="table table-hover" id="settingsTable">
                                    <thead>
                                        <tr>
                                            <th class="sortable" data-sort="key">Key <i class="fas fa-sort"></i></th>
                                            <th class="sortable" data-sort="value">Value <i class="fas fa-sort"></i></th>
                                            <th class="sortable" data-sort="type">Type <i class="fas fa-sort"></i></th>
                                            <th class="sortable" data-sort="category">Category <i class="fas fa-sort"></i></th>
                                            <th class="sortable" data-sort="description">Description <i class="fas fa-sort"></i></th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($settings as $setting): ?>
                                            <tr>
                                                <td class="key"><?= htmlspecialchars($setting['setting_key']) ?></td>
                                                <td class="value">
                                                    <?php if ($setting['is_private']): ?>
                                                        <em class="text-muted">Hidden</em>
                                                    <?php else: ?>
                                                        <?= htmlspecialchars($setting['setting_value']) ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="type"><?= htmlspecialchars($setting['setting_type']) ?></td>
                                                <td class="category"><?= htmlspecialchars($setting['category']) ?></td>
                                                <td class="description"><?= htmlspecialchars($setting['description']) ?></td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <button class="btn btn-outline-primary edit-setting" 
                                                                data-setting='<?= htmlspecialchars(json_encode($setting)) ?>'
                                                                data-toggle="modal" 
                                                                data-target="#editSettingModal">
                                                            Edit
                                                        </button>
                                                        <button class="btn btn-outline-danger delete-setting"
                                                                data-setting-id="<?= $setting['setting_id'] ?>"
                                                                data-setting-key="<?= htmlspecialchars($setting['setting_key']) ?>">
                                                            Delete
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-muted">No settings found. Click "Add New Setting" to create one.</p>
                        <?php endif; ?>
                    </div>
                </section>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Edit Setting Modal -->
<div class="modal fade" id="editSettingModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <input type="hidden" name="action" value="edit_setting">
                <input type="hidden" name="setting_id" id="edit_setting_id">
                
                <div class="modal-header">
                    <h5 class="modal-title">Edit Setting</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_setting_key">Setting Key</label>
                        <input type="text" class="form-control" id="edit_setting_key" name="setting_key" required readonly>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_setting_value">Value</label>
                        <input type="text" class="form-control" id="edit_setting_value" name="setting_value" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_setting_type">Type</label>
                        <select class="form-control" id="edit_setting_type" name="setting_type">
                            <option value="string">String</option>
                            <option value="integer">Integer</option>
                            <option value="float">Float</option>
                            <option value="boolean">Boolean</option>
                            <option value="json">JSON</option>
                            <option value="array">Array</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_category">Category</label>
                        <input type="text" class="form-control" id="edit_category" name="category">
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_description">Description</label>
                        <textarea class="form-control" id="edit_description" name="description"></textarea>
                    </div>
                    
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="edit_is_private" name="is_private">
                        <label class="form-check-label" for="edit_is_private">Private Setting</label>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Setting Modal -->
<div class="modal fade" id="addSettingModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <input type="hidden" name="action" value="add_setting">
                
                <div class="modal-header">
                    <h5 class="modal-title">Add New Setting</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                
                <div class="modal-body">
                    <div class="form-group">
                        <label for="add_setting_key">Setting Key</label>
                        <input type="text" class="form-control" id="add_setting_key" name="setting_key" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="add_setting_value">Value</label>
                        <input type="text" class="form-control" id="add_setting_value" name="setting_value" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="add_setting_type">Type</label>
                        <select class="form-control" id="add_setting_type" name="setting_type">
                            <option value="string">String</option>
                            <option value="integer">Integer</option>
                            <option value="float">Float</option>
                            <option value="boolean">Boolean</option>
                            <option value="json">JSON</option>
                            <option value="array">Array</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="add_category">Category</label>
                        <input type="text" class="form-control" id="add_category" name="category" value="general">
                    </div>
                    
                    <div class="form-group">
                        <label for="add_description">Description</label>
                        <textarea class="form-control" id="add_description" name="description"></textarea>
                    </div>
                    
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="add_is_private" name="is_private">
                        <label class="form-check-label" for="add_is_private">Private Setting</label>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Setting</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add this JavaScript at the bottom of the file -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Handle edit button clicks
    document.querySelectorAll('.edit-setting').forEach(button => {
        button.addEventListener('click', () => {
            const setting = JSON.parse(button.dataset.setting);
            const modal = document.querySelector('#editSettingModal');
            
            // Fill the form fields
            modal.querySelector('#edit_setting_id').value = setting.setting_id;
            modal.querySelector('#edit_setting_key').value = setting.setting_key;
            modal.querySelector('#edit_setting_value').value = setting.setting_value;
            modal.querySelector('#edit_setting_type').value = setting.setting_type;
            modal.querySelector('#edit_category').value = setting.category;
            modal.querySelector('#edit_description').value = setting.description;
            modal.querySelector('#edit_is_private').checked = setting.is_private === '1';
        });
    });

    // Handle delete button clicks
    document.querySelectorAll('.delete-setting').forEach(button => {
        button.addEventListener('click', function() {
            if (confirm(`Are you sure you want to delete the setting "${this.dataset.settingKey}"?`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '';
                form.style.display = 'none';
                
                const inputs = {
                    'action': 'delete_setting',
                    'setting_id': this.dataset.settingId,
                    'csrf_token': '<?= $_SESSION['csrf_token'] ?>'
                };
                
                for (const [key, value] of Object.entries(inputs)) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = key;
                    input.value = value;
                    form.appendChild(input);
                }
                
                document.body.appendChild(form);
                form.submit();
            }
        });
    });

    // Initialize filter functionality
    const filterInput = document.getElementById('settingsFilter');
    const clearFilterBtn = document.getElementById('clearFilter');
    
    const filterTable = () => {
        const filterValue = filterInput.value.toLowerCase();
        const rows = document.querySelectorAll('#settingsTable tbody tr');
        
        rows.forEach(row => {
            const text = Array.from(row.querySelectorAll('td'))
                .map(cell => cell.textContent.toLowerCase())
                .join(' ');
            
            row.style.display = text.includes(filterValue) ? '' : 'none';
        });
        
        clearFilterBtn.style.display = filterValue ? 'block' : 'none';
    };
    
    filterInput?.addEventListener('input', filterTable);
    clearFilterBtn?.addEventListener('click', () => {
        filterInput.value = '';
        filterTable();
        filterInput.focus();
    });

    // Add table sorting functionality
    const getCellValue = (tr, idx) => {
        const cell = tr.children[idx];
        return cell?.innerText || cell?.textContent;
    };

    const comparer = (idx, asc) => (a, b) => {
        const v1 = getCellValue(asc ? a : b, idx);
        const v2 = getCellValue(asc ? b : a, idx);
        
        // Handle numeric values
        if (!isNaN(v1) && !isNaN(v2)) {
            return v1 - v2;
        }
        
        return v1.toString().localeCompare(v2);
    };

    document.querySelectorAll('#settingsTable th.sortable').forEach(th => {
        const thIndex = Array.from(th.parentElement.children).indexOf(th);
        let asc = true;
        
        th.addEventListener('click', () => {
            // Remove sort indicators from all headers
            document.querySelectorAll('#settingsTable th.sortable i').forEach(icon => {
                icon.className = 'fas fa-sort';
            });
            
            // Update sort indicator
            const icon = th.querySelector('i');
            icon.className = asc ? 'fas fa-sort-up' : 'fas fa-sort-down';
            
            // Sort the table
            const tbody = th.closest('table').querySelector('tbody');
            Array.from(tbody.querySelectorAll('tr'))
                .sort(comparer(thIndex, asc))
                .forEach(tr => tbody.appendChild(tr));
            
            asc = !asc;
        });
    });

    // Function to update the current date and time
    const updateDateTime = () => {
        const now = new Date(); // Get the current date and time in the browser's timezone
        const formattedDateTime = now.toLocaleString(); // Format to local string
        document.getElementById('currentDateTime').innerText = `Current Date and Time: ${formattedDateTime}`;
    };

    // Update the time every second
    setInterval(updateDateTime, 1000);

    // Dark Mode Toggle Functionality
    const darkModeToggle = document.getElementById('darkModeToggle');
    const body = document.body;

    // Check local storage for dark mode preference
    if (localStorage.getItem('darkMode') === 'enabled') {
        body.classList.add('dark-mode');
    }

    darkModeToggle.addEventListener('click', () => {
        body.classList.toggle('dark-mode');
        // Save preference to local storage
        if (body.classList.contains('dark-mode')) {
            localStorage.setItem('darkMode', 'enabled');
        } else {
            localStorage.removeItem('darkMode');
        }
    });
});
</script>

<style>
    .sortable {
        cursor: pointer;
        user-select: none;
    }

    .sortable i {
        margin-left: 5px;
    }

    #settingsFilter {
        min-width: 200px;
    }

    .card-header .d-flex.gap-2 {
        gap: 0.5rem !important;
    }

    .fa-sort-up,
    .fa-sort-down {
        color: #007bff;
    }

    .dark-mode {
        background-color: #121212;
        color: #ffffff;
    }

    .dark-mode .card {
        background-color: #1e1e1e;
        border-color: #333333;
    }

    .dark-mode .btn {
        background-color: #333333;
        color: #ffffff;
    }
</style> 