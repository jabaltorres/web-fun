<div id="hero" class="jumbotron jumbotron-fluid px-4">
    <div class="container">
        <h1 class="display-4">Contact Us</h1>
        <p class="lead">A simple record management system built with PHP and MySQL.</p>
    </div>
</div>

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

    <div class="row">
        <div class="col-12 col-md-4">
            <div class="card p-3">
                <h3>LinkedIn</h3>
                <p>Bacon ipsum dolor amet turducken jowl flank strip steak pork shank.</p>
                <a href="https://www.linkedin.com/in/jabaltorres/" class="btn btn-primary">LinkedIn</a>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card p-3">
                <h3>Facebook</h3>
                <p>Bacon ipsum dolor amet turducken jowl flank strip steak pork shank.</p>
                <a href="https://www.facebook.com/jabal.torres" class="btn btn-primary">Facebook</a>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card p-3">
                <h3>Instagram</h3>
                <p>Bacon ipsum dolor amet turducken jowl flank strip steak pork shank.</p>
                <a href="https://www.instagram.com/jabaltorres/" class="btn btn-primary">Instagram</a>
            </div>
        </div>
    </div>

    <?php
    global $loggedIn;
    if ($loggedIn) :?>

        <div class="row mt-4">
            <div class="col-12">
                <h2>Logged In User Contact Us</h2>
                <form action="contact.php" method="POST" class="border p-3">
                    <div class="form-group">
                        <label for="name">Your Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Your Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
                            else.</small>
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