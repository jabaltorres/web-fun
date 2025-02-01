<div id="content" class="content">
    <div class="row">
        <div class="col-12">
            <?php if (isset($successMessage)) { ?>
                <div class="alert alert-success mt-2"><?= $successMessage ?></div>
            <?php } elseif (isset($errorMessage)) { ?>
                <div class="alert alert-danger mt-2"><?= $errorMessage ?></div>
            <?php } ?>
        </div>
    </div>

    <?php
    global $loggedIn;
    if ($loggedIn) :
        // Fetch the current user's details
        $userDetails = $userManager->getCurrentUserDetails();
    ?>
        <div class="row mt-4">
            <div class="col-12">
                <h2>Logged In User Contact Us</h2>
                <form action="contact.php" method="POST" class="border p-3">
                    <div class="form-group">
                        <label for="name">Your Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($userDetails['first_name'] . ' ' . $userDetails['last_name']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Your Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($userDetails['email']) ?>" required>
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>

                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <select class="form-control" name="subject" id="subject" required>
                            <option>Hello</option>
                            <option>Compliment</option>
                            <option>Insult</option>
                            <option>Inquiry</option>
                            <option>Sales Pitch</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="message">Your Message</label>
                        <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>