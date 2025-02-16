<div class="form-group">
    <label for="first_name">First Name</label>
    <input type="text" class="form-control" id="first_name" name="first_name" 
           value="<?= htmlspecialchars($userDetails['first_name']); ?>" required>
</div>
<div class="form-group">
    <label for="last_name">Last Name</label>
    <input type="text" class="form-control" id="last_name" name="last_name" 
           value="<?= htmlspecialchars($userDetails['last_name']); ?>" required>
</div>
<div class="form-group">
    <label for="email">Email</label>
    <input type="email" class="form-control" id="email" name="email" 
           value="<?= htmlspecialchars($userDetails['email']); ?>" required>
</div>
<div class="form-group">
    <label for="role">Role</label>
    <select class="form-control" id="role" name="role" required>
        <?php foreach ($validRoles as $role): ?>
            <option value="<?= htmlspecialchars($role) ?>" 
                    <?= trim($userDetails['role']) === trim($role) ? 'selected' : '' ?>>
                <?= htmlspecialchars($role) ?>
            </option>
        <?php endforeach; ?>
    </select>
</div> 