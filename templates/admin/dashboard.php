<?php
// Ensure this file isn't accessed directly
if (!defined('PRIVATE_PATH')) {
    exit('Direct access not permitted');
}

// Verify CSRF token if handling form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add CSRF verification here
}
?>

<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Admin Dashboard</h1>
            
            <?php if ($loggedIn): ?>
                <section class="card mb-4">
                    <div class="card-body">
                        <h2 class="card-title h4">Welcome</h2>
                        <p class="card-text">
                            Hello, <?= htmlspecialchars($_SESSION['first_name'] ?? 'Administrator') ?>!
                        </p>
                    </div>
                </section>
            <?php endif; ?>

            <?php if ($isAdmin && $users && $users->num_rows > 0): ?>
                <section class="card mb-4">
                    <ul class="nav justify-content-center">
                        <li class="nav-item"><a class="nav-link" href="/staff/admins/">Admins</a></li>
                        <li class="nav-item"><a class="nav-link" href="/staff/admins/new.php">Create New Admin</a></li>
                        <li class="nav-item"><a class="nav-link" href="/users/">Users</a></li>
                        <li class="nav-item"><a class="nav-link" href="/users/user-add.php">User Add</a></li>
                        <li class="nav-item"><a class="nav-link" href="/staff/index.php">Staff</a></li>
                        <li class="nav-item"><a class="nav-link" href="/staff/pages/index.php">Pages</a></li>
                        <li class="nav-item"><a class="nav-link" href="/staff/subjects/index.php">Subjects</a></li>
                        <li class="nav-item"><a class="nav-link" href="/contacts/index.php">Contacts</a></li>
                        <li class="nav-item"><a class="nav-link" href="/demos/index.php">Demos</a></li>
                    </ul>
                </section>
                
                <section class="card mb-4">
                    <div class="card-body">
                        <h2 class="card-title h4">Site Settings</h2>
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
                                    class="btn btn-primary btn-add-setting" 
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle edit button clicks
    document.querySelectorAll('.edit-setting').forEach(button => {
        button.addEventListener('click', function() {
            const setting = JSON.parse(this.dataset.setting);
            const modal = document.querySelector('#editSettingModal');
            
            // Fill the form fields with setting data
            modal.querySelector('#edit_setting_id').value = setting.setting_id;
            modal.querySelector('#edit_setting_key').value = setting.setting_key;
            
            // Handle the value field based on type
            const valueInput = modal.querySelector('#edit_setting_value');
            const typeSelect = modal.querySelector('#edit_setting_type');
            
            typeSelect.value = setting.setting_type;
            updateValueField(setting.setting_type, valueInput, setting.setting_value);
            
            modal.querySelector('#edit_category').value = setting.category;
            modal.querySelector('#edit_description').value = setting.description;
            modal.querySelector('#edit_is_private').checked = setting.is_private === '1';
            
            // Add change event listener for type select
            typeSelect.addEventListener('change', function() {
                updateValueField(this.value, valueInput, valueInput.value);
            });
        });
    });
    
    // Handle delete button clicks
    document.querySelectorAll('.delete-setting').forEach(button => {
        button.addEventListener('click', function() {
            if (confirm(`Are you sure you want to delete the setting "${this.dataset.settingKey}"?`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.style.display = 'none';
                
                const inputs = {
                    'action': 'delete_setting',
                    'setting_id': this.dataset.settingId
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

    // Add event listener for type change in add modal
    const addTypeSelect = document.querySelector('#add_setting_type');
    const addValueInput = document.querySelector('#add_setting_value');
    
    addTypeSelect.addEventListener('change', function() {
        updateValueField(this.value, addValueInput);
    });

    // Add sorting functionality
    const table = document.getElementById('settingsTable');
    const headers = table.querySelectorAll('th.sortable');
    let currentSort = { column: null, direction: 'asc' };

    headers.forEach(header => {
        header.addEventListener('click', () => {
            const column = header.dataset.sort;
            const direction = currentSort.column === column && currentSort.direction === 'asc' ? 'desc' : 'asc';
            
            // Update sort indicators
            headers.forEach(h => h.querySelector('i').className = 'fas fa-sort');
            header.querySelector('i').className = `fas fa-sort-${direction === 'asc' ? 'up' : 'down'}`;
            
            // Sort the table
            sortTable(column, direction);
            
            currentSort = { column, direction };
        });
    });

    // Add filtering functionality
    const filterInput = document.getElementById('settingsFilter');
    const clearFilterBtn = document.getElementById('clearFilter');
    
    filterInput.addEventListener('input', filterTable);
    
    clearFilterBtn.addEventListener('click', () => {
        filterInput.value = '';
        filterTable();
        filterInput.focus();
    });

    // Show/hide clear button based on filter input
    filterInput.addEventListener('input', () => {
        clearFilterBtn.style.display = filterInput.value ? 'block' : 'none';
    });
    
    // Initial state
    clearFilterBtn.style.display = 'none';

    function sortTable(column, direction) {
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));
        
        const sortedRows = rows.sort((a, b) => {
            const aValue = a.querySelector(`.${column}`).textContent.trim().toLowerCase();
            const bValue = b.querySelector(`.${column}`).textContent.trim().toLowerCase();
            
            if (direction === 'asc') {
                return aValue.localeCompare(bValue);
            } else {
                return bValue.localeCompare(aValue);
            }
        });
        
        // Clear the table
        while (tbody.firstChild) {
            tbody.removeChild(tbody.firstChild);
        }
        
        // Add sorted rows
        sortedRows.forEach(row => tbody.appendChild(row));
    }

    function filterTable() {
        const filterValue = filterInput.value.toLowerCase();
        const rows = table.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const text = Array.from(row.querySelectorAll('td'))
                .map(cell => cell.textContent.toLowerCase())
                .join(' ');
            
            row.style.display = text.includes(filterValue) ? '' : 'none';
        });
    }

    // Initialize tooltips if using Bootstrap's tooltip component
    $('[data-toggle="tooltip"]').tooltip();
});

function updateValueField(type, input, currentValue = '') {
    switch(type) {
        case 'boolean':
            // Create a select element for boolean values
            const select = document.createElement('select');
            select.className = 'form-control';
            select.name = input.name;
            select.id = input.id;
            
            const options = [
                { value: '1', text: 'True' },
                { value: '0', text: 'False' }
            ];
            
            options.forEach(opt => {
                const option = document.createElement('option');
                option.value = opt.value;
                option.textContent = opt.text;
                option.selected = currentValue === opt.value;
                select.appendChild(option);
            });
            
            input.parentNode.replaceChild(select, input);
            break;
            
        case 'json':
        case 'array':
            const textarea = document.createElement('textarea');
            textarea.className = 'form-control';
            textarea.name = input.name;
            textarea.id = input.id;
            textarea.value = currentValue;
            
            input.parentNode.replaceChild(textarea, input);
            break;
            
        case 'integer':
            input.type = 'number';
            input.step = '1';
            input.value = currentValue;
            break;
            
        case 'float':
            input.type = 'number';
            input.step = '0.01';
            input.value = currentValue;
            break;
            
        default:
            input.type = 'text';
            input.value = currentValue;
    }
}
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
</style> 