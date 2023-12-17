<?php
include_once __DIR__ . '/../header.php';
?>

<h1 class="mt-5"><?php echo $_SESSION['user_username'] . "'s boards"; ?></h1>

<div class="row">
    <?php foreach ($boards as $board): ?>
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-5 mt-3 mt-sm-0 hover-overlay">
            <a href="/boards/board?id=<?= $board->id ?>" class="card text-decoration-none">
                <div class="card-body">
                    <h5 class="card-title"><?= $board->name ?></h5>
                    <p class="card-text"><?= $board->description ?></p>
                </div>
                <div class="card mask" style="background-color: rgba(255,255,255, 0.1);"></div>
            </a>
        </div>
    <?php endforeach; ?>
    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-5 mt-3 mt-sm-0 hover-overlay">
        <a href="#" class="card text-decoration-none" data-bs-toggle="modal" data-bs-target="#addBoardModal">
            <div class="card-body">
                <h5 class="card-title">Add a Board</h5>
            </div>
            <div class="card mask" style="background-color: rgba(255,255,255, 0.1);"></div>
        </a>
    </div>
</div>

<!-- Add Board Modal -->
<div class="modal fade" id="addBoardModal" tabindex="-1" aria-labelledby="addBoardModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="addBoardModalLabel">Create a New Board</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form method="POST" onsubmit="return validateAddBoardForm()" id="boardForm">
                <div class="mb-3">
                    <label for="boardTitle" class="form-label">Title</label>
                    <input type="text" class="form-control" id="boardTitle" name="boardTitle" required>
                </div>
                <div class="mb-3">
                    <label for="boardDescription" class="form-label">Description</label>
                    <textarea class="form-control" id="boardDescription" name="boardDescription" required></textarea>
                </div>
                <div class="text-end">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" name="addboard">Create</button>
                </div>
            </form>
        </div>
        </div>
    </div>
</div>

<script src="js/addboard.js"></script>

<?php
include_once __DIR__ . '/../footer.php';
?>