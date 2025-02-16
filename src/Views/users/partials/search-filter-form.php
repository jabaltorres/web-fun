<form method="GET" class="mb-4">
    <div class="row">
        <div class="col-md-6">
            <div class="input-group">
                <input type="text" 
                       class="form-control" 
                       placeholder="Search by name, email, or username" 
                       name="search"
                       value="<?= htmlspecialchars($search) ?>">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <select name="role" class="form-control" onchange="this.form.submit()">
                <option value="">All Roles</option>
                <?php foreach ($validRoles as $role): ?>
                    <option value="<?= htmlspecialchars($role) ?>" 
                            <?= $roleFilter === $role ? 'selected' : '' ?>>
                        <?= htmlspecialchars($role) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <?php if ($search || $roleFilter): ?>
                <a href="index.php" class="btn btn-outline-secondary">Clear Filters</a>
            <?php endif; ?>
        </div>
    </div>
</form> 