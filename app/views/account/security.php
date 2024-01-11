<?php
include_once __DIR__ . '/../header.php';
?>

<div class="row mt-5">
    <div class="col-md-3">
        <div class="list-group">
            <a href="/account" class="list-group-item">Profile</a>
            <a href="/account/settings" class="list-group-item">Settings</a>
            <a href="/account/security" class="list-group-item active">Security</a>
        </div>
    </div>

    <div class="col-md-9 mt-3 mt-md-0">
        <?php if (isset($error)) : ?>
            <div class="alert alert-danger"><?php echo $error;?></div>
        <?php endif; ?>
        <?php if (isset($success)) : ?>
            <div class="alert alert-success"><?php echo $success;?></div>
        <?php endif; ?>
        <h1>Security</h1>
        <p>Welcome, <?php echo $_SESSION['user_name']; ?></p>
        
        <h2 class="mt-5">Change Password</h2>
        <form method="POST">
            <div class="form-group mt-3 mb-2">
                <label for="current_password">Current Password</label>
                <input type="password" name="current_password" id="current_password" class="form-control" required>
            </div>
            <div class="form-group mb-2">
                <label for="new_password">New Password</label>
                <input type="password" name="new_password" id="new_password" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary" name="changepassword">Change Password</button>
        </form>
    </div>
</div>

<?php
include_once __DIR__ . '/../footer.php';
?>