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
                    <h1 class="text-center">Login</h1>
                    <p class="text-center">Don't have an account? <a href="/account/signup">Sign up</a></p>
                    <form method="post">
                        <div class="form-group mt-4 mb-3">
                            <label for="username/email">Username/Email</label>
                            <input name="username/email" id="username/email" class="form-control" value="<?= $savedUsernameEmailInput ?? '' ?>" required />
                        </div>
                        <div class="form-group mb-4">
                            <div class="d-flex justify-content-between">
                                <label for="password">Password</label>
                                <!-- <a href="/account/forgotpassword">Forgot Password?</a> -->
                            </div>
                            <input name="password" id="password" class="form-control" type="password" required />
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