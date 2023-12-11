<?php
include_once __DIR__ . '/../header.php';
?>

<!-- Check if user is logged in -->
<?php if (!isset($_SESSION['user_id'])): ?>
    <h1>Account</h1>
    <p>You are not logged in. Please <a href="/account/login">login</a> or <a href="/account/signup">sign up</a>.</p>
    <?php
    include_once __DIR__ . '/../footer.php';
    return;
endif; ?>

<div class="row">
    <div class="col-md-3">
        <div class="list-group">
            <a href="/account" class="list-group-item active">Profile</a>
            <a href="/account/settings" class="list-group-item">Settings</a>
            <a href="/account/security" class="list-group-item">Security</a>
        </div>
    </div>

    <div class="col-md-9">
        <h1>Profile</h1>
        <p>Welcome, <?php echo $_SESSION['user_name']; ?></p>
        <a href="/account/logout" class="btn btn-danger">Logout</a>
    </div>
</div>

<?php
include_once __DIR__ . '/../footer.php';
?>