<?php
include_once __DIR__ . '/../header.php';
include_once __DIR__ . '/../../helpers/session_helper.php';
?>

<!-- Check if user is not logged in -->
<?php if (!isset($_SESSION['user_id'])) : ?>
    <?php redirect('/account/login'); ?>
<?php endif; ?>

<?php flash('boards'); ?>
<h1>Boards</h1>

<?php
include_once __DIR__ . '/../footer.php';
?>