<?php
include_once __DIR__ . '/../header.php';
include_once __DIR__ . '/../../helpers/session_helper.php';
?>

<?php flash('register'); ?>

<h1>Login</h1>
<form method="post">
    <div class="form-group mt-3 mb-2">
        <label for="username">Username</label>
        <input name="username" id="username" class="form-control" />
    </div>
    <div class="form-group mb-3">
        <label for="password">Password</label>
        <input name="password" id="password" class="form-control" type="password" />
    </div>
    <button type="submit" class="btn btn-primary" value="login">Login</button>
</form>

<?php
include_once __DIR__ . '/../footer.php';
?>