<?php
include_once __DIR__ . '/../header.php';
?>

<!-- Check if user is not logged in -->
<?php if (!isset($_SESSION['user_id'])) : ?>
    <?php redirect('/account/login'); ?>
<?php endif; ?>

<div class="row mt-5">
    <div class="col-md-3">
        <div class="list-group">
            <a href="/account" class="list-group-item active">Profile</a>
            <a href="/account/settings" class="list-group-item">Settings</a>
            <a href="/account/security" class="list-group-item">Security</a>
        </div>
    </div>

    <div class="col-md-9 mt-3 mt-md-0">
        <h1>Profile</h1>
        <p>Welcome, <?php echo $_SESSION['user_name']; ?></p>
        <a href="/account/logout" class="btn btn-danger">Logout</a>
    </div>
</div>

<?php
include_once __DIR__ . '/../footer.php';
?>