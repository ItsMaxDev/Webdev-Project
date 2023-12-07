<?php
include_once __DIR__ . '/../header.php';
include_once __DIR__ . '/../../helpers/session_helper.php';
?>

<!-- Check if user is already logged in -->
<?php if (isset($_SESSION['user_id'])) : ?>
    <?php redirect('/account'); ?>
<?php endif; ?>

<?php flash('register'); ?>

<h1>Sign Up</h1>
<form method="post">
    <div class="form-group mt-3 mb-2">
        <label for="name">Name</label>
        <input name="name" id="name" class="form-control" />
    </div>
    <div class="form-group mb-2">
        <label for="email">Email</label>
        <input name="email" id="email" class="form-control" />
    </div>
    <div class="form-group mb-2">
        <label for="username">Username</label>
        <input name="username" id="username" class="form-control" />
    </div>
    <div class="form-group mb-2">
        <label for="password">Password</label>
        <input name="password" id="password" class="form-control" type="password" />
    </div>
    <div class="form-group mb-3">
        <label for="confirmPassword">Confirm Password</label>
        <input name="confirmPassword" id="confirmPassword" class="form-control" type="password" />
    </div>
    <button type="submit" class="btn btn-primary" value="signup">Sign Up</button>
</form>

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