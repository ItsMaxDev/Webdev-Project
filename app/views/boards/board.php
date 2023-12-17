<?php
include_once __DIR__ . '/../header.php';
?>

<h1 class="mt-5"><?php echo $board->name; ?></h1>
<p><?php echo $board->description; ?></p>

<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmRemovalModal">Remove</button>

<!-- Confirm Removal Modal -->
<div class="modal fade" id="confirmRemovalModal" tabindex="-1" aria-labelledby="confirmRemovalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="confirmRemovalModalLabel">Confirm Removal</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to remove this board?</p>
            </div>
            <div class="modal-footer">
                <form method="POST">
                    <input type="hidden" name="board" value="<?php echo htmlspecialchars(json_encode($board)); ?>">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" name="removeboard">Remove</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include_once __DIR__ . '/../footer.php';
?>