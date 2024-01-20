<?php
include_once __DIR__ . '/../header.php';
?>

<h1 class="mt-5 d-flex flex-column flex-sm-row align-items-sm-center">
    <?php echo $_SESSION['user_username'] . "'s boards"; ?>
    <button type="button" class="btn btn-primary mt-2 mt-sm-0 ms-0 ms-sm-3" data-bs-toggle="modal" data-bs-target="#addBoardModal">Add a Board</button>
</h1>

<div id="boardsContainer" class="row">
    <!-- Boards will be dynamically added here using JavaScript -->
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
            <form id="boardForm">
                <div class="mb-3">
                    <label for="boardTitle" class="form-label">Title</label>
                    <input type="text" class="form-control" id="boardTitle" name="boardTitle">
                </div>
                <div class="mb-3">
                    <label for="boardDescription" class="form-label">Description</label>
                    <textarea class="form-control" id="boardDescription" name="boardDescription"></textarea>
                </div>
                <div class="text-end">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="addBoard()">Create</button>
                </div>
            </form>
        </div>
        </div>
    </div>
</div>

<script src="/js/boards.js"></script>

<?php
include_once __DIR__ . '/../footer.php';
?>