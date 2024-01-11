<?php
include_once __DIR__ . '/../header.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-sm-8 col-md-6 col-lg-5 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <?php if (isset($error)) : ?>
                        <div class="alert alert-danger"><?php echo $error;?></div>
                    <?php endif; ?>
                    <h1 class="text-center">Sign Up</h1>
                    <p class="text-center">Already have an account? <a href="/account/login">Login</a></p>
                    <form method="post">
                        <div class="form-group mt-4 mb-3">
                            <label for="name">Name</label>
                            <input name="name" id="name" class="form-control" value="<?= $savedNameInput ?? '' ?>" required />
                        </div>
                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input name="email" id="email" class="form-control" value="<?= $savedEmailInput ?? '' ?>" required />
                        </div>
                        <div class="form-group mb-3">
                            <label for="username">Username</label>
                            <input name="username" id="username" class="form-control" value="<?= $savedUsernameInput ?? '' ?>" required />
                        </div>
                        <div class="form-group mb-3">
                            <label for="password">Password</label>
                            <input name="password" id="password" class="form-control" type="password" required />
                        </div>
                        <div class="form-group mb-4">
                            <label for="confirmPassword">Confirm Password</label>
                            <input name="confirmPassword" id="confirmPassword" class="form-control" type="password" required />
                        </div>
                        <button type="submit" class="btn btn-primary rounded-pill col-12" value="signup">Sign Up</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include_once __DIR__ . '/../footer.php';
?>