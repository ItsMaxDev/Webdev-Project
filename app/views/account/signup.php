<?php
include_once __DIR__ . '/../header.php';
include_once __DIR__ . '/../../helpers/session_helper.php';
?>

<!-- Check if user is already logged in -->
<?php if (isset($_SESSION['user_id'])) : ?>
    <?php redirect('/account'); ?>
<?php endif; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-sm-8 col-md-6 col-lg-5 col-xl-4 bg-dark-subtle p-4 rounded shadow">
            <?php flash('register'); ?>
            <h1 class="text-center">Sign Up</h1>
            <p class="text-center text-secondary-emphasis">Already have an account? <a class="text-secondary-emphasis" href="/account/login">Login</a></p>
            <form method="post">
                <div class="form-group mt-4 mb-3">
                    <label for="name">Name</label>
                    <input name="name" id="name" class="form-control" />
                </div>
                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input name="email" id="email" class="form-control" />
                </div>
                <div class="form-group mb-3">
                    <label for="username">Username</label>
                    <input name="username" id="username" class="form-control" />
                </div>
                <div class="form-group mb-3">
                    <label for="password">Password</label>
                    <input name="password" id="password" class="form-control" type="password" />
                </div>
                <div class="form-group mb-4">
                    <label for="confirmPassword">Confirm Password</label>
                    <input name="confirmPassword" id="confirmPassword" class="form-control" type="password" />
                </div>
                <button type="submit" class="btn btn-primary rounded-pill col-12" value="signup">Sign Up</button>
            </form>
        </div>
    </div>
</div>

<?php
include_once __DIR__ . '/../footer.php';
?>

<!-- Get form data from local storage and populate form fields -->
<script>
    const signupFormData = localStorage.getItem('signupFormData');
    if (signupFormData) {
        const data = JSON.parse(signupFormData);
        document.getElementById('name').value = data.name;
        document.getElementById('email').value = data.email;
        document.getElementById('username').value = data.username;
    }
</script>