<?php
include_once __DIR__ . '/../header.php';
include_once __DIR__ . '/../../helpers/session_helper.php';
?>

<!-- Check if user is not logged in -->
<?php if (!isset($_SESSION['user_id'])) : ?>
    <?php redirect('/account/login'); ?>
<?php endif; ?>

<?php flash('boards'); ?>
<h1 class="mt-5"><?php echo $_SESSION['user_username'] . "'s boards"; ?></h1>

<div class="col-xl-2 col-lg-3 col-md-4 col-sm-5 hover-overlay">
    <a href="#" class="card text-decoration-none">
        <div class="card-body">
            <h5 class="card-title">Add a Board</h5>
        </div>
        <div
            class="card mask"
            style="background-color: rgba(255,255,255, 0.1);"
        ></div>
    </a>
</div>

<?php
include_once __DIR__ . '/../footer.php';
?>