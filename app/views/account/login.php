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
        <div class="col-sm-8 col-md-6 col-lg-5 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <?php flash('login'); ?>
                    <h1 class="text-center">Login</h1>
                    <p class="text-center">Don't have an account? <a href="/account/signup">Sign up</a></p>
                    <form method="post">
                        <div class="form-group mt-4 mb-3">
                            <label for="username">Username/Email</label>
                            <input name="username/email" id="username/email" class="form-control" />
                        </div>
                        <div class="form-group mb-4">
                            <div class="d-flex justify-content-between">
                                <label for="password">Password</label>
                                <a href="/account/forgotpassword">Forgot Password?</a>
                            </div>
                            <input name="password" id="password" class="form-control" type="password" />
                        </div>
                        <button type="submit" class="btn btn-primary rounded-pill col-12" value="login">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

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