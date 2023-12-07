<?php
include_once __DIR__ . '/../header.php';
include_once __DIR__ . '/../../helpers/session_helper.php';
?>

<!-- Check if user is already logged in -->
<?php if (isset($_SESSION['user_id'])) : ?>
    <?php redirect('/account'); ?>
<?php endif; ?>

<?php flash('login'); ?>

<h1>Login</h1>
<form method="post">
    <div class="form-group mt-3 mb-2">
        <label for="username">Username/Email</label>
        <input name="username/email" id="username/email" class="form-control" />
    </div>
    <div class="form-group mb-3">
        <label for="password">Password</label>
        <input name="password" id="password" class="form-control" type="password" />
    </div>
    <button type="submit" class="btn btn-primary" value="login">Login</button>
</form>

<?php
include_once __DIR__ . '/../footer.php';
?>

<!-- Get form data from local storage and populate form fields -->
<script>
    const loginFormData = localStorage.getItem('loginFormData');
    if (loginFormData) {
        const data = JSON.parse(loginFormData);
        document.getElementById('username/email').value = data.usernameOrEmail;
    }
</script>