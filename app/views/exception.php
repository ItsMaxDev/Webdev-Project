<?php
include_once __DIR__ . '/header.php';
?>

<div class="row justify-content-center">
    <div class="col-sm-10 col-md-8 col-lg-7 col-xl-6">
        <div class="card">
            <div class="card-body">
                <h1 class="text-center">Something went wrong!</h1>
                <div class="alert alert-danger mt-4"><?php echo $errorMessage;?></div>
                <div class="text-center mt-3">
                    <a href="/" class="btn btn-primary">Go back to homepage</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include_once __DIR__ . '/footer.php';
?>