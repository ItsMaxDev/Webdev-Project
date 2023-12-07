<?php
include_once __DIR__ . '/../header.php';
?>

<!-- Check if user is logged in -->
<?php if (!isset($_SESSION['user_id'])) : ?>
    <h1>Account</h1>
    <p>You are not logged in. Please <a href="/account/login">login</a> or <a href="/account/signup">sign up</a>.</p>
    <?php
    include_once __DIR__ . '/../footer.php';
    return;
endif; ?>

<h1>Account</h1>
<p>Welcome, <?php echo $_SESSION['user_name']; ?></p>

<?php
include_once __DIR__ . '/../footer.php';
?>