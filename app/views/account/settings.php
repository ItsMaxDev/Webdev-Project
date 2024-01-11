<?php
include_once __DIR__ . '/../header.php';
?>

<div class="row mt-5">
    <div class="col-md-3">
        <div class="list-group">
            <a href="/account" class="list-group-item">Profile</a>
            <a href="/account/settings" class="list-group-item active">Settings</a>
            <a href="/account/security" class="list-group-item">Security</a>
        </div>
    </div>

    <div class="col-md-9 mt-3 mt-md-0">
        <h1>Settings</h1>
        <p>Welcome, <?php echo $_SESSION['user_name']; ?></p>
    </div>
</div>

<?php
include_once __DIR__ . '/../footer.php';
?>