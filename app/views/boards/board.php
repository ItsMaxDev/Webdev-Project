<?php
include_once __DIR__ . '/../header.php';
?>

<div class="container-fluid">
    <div class="row d-flex justify-content-between">
        <div class="col-md-2 p-5">
            <h1><?php echo $board->name; ?></h1>
            <p><?php echo $board->description; ?></p>
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmRemovalModal">Remove Board</button>
        </div>
        <div class="col-md-10 bg-dark-subtle">
            <div id="listsContainer" class="row d-flex flex-row flex-nowrap overflow-x-auto p-5" style="height: calc(100vh - 58.6px);">
                <!-- Lists will be dynamically added here using JavaScript -->
                <div id="addListButton" class="col-xl-3 col-lg-4 col-md-5 col-sm-6">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#addListModal">
                        <div class="card hover-overlay">
                            <div class="card-body">
                                <h5 class="card-title">Add List</h5>
                            </div>
                            <div class="card mask" style="background-color: rgba(255,255,255, 0.1);"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Card Modal -->
<div class="modal fade" id="addCardModal" tabindex="-1" aria-labelledby="addCardModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addCardModalLabel">Add Card</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="cardName" class="form-label">Card Name</label>
                    <input type="text" class="form-control" id="cardName">
                </div>
                <div class="mb-3">
                    <label for="cardDescription" class="form-label">Card Description</label>
                    <textarea class="form-control" id="cardDescription" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label for="dueDate" class="form-label">Due Date</label>
                    <input type="datetime-local" class="form-control" id="dueDate">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveCardButton">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Card Modal -->
<div class="modal fade" id="editCardModal" tabindex="-1" aria-labelledby="editCardModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editCardModalLabel" contenteditable="true" spellcheck="false" onblur="updateCard(<?= $board->id ?>)"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="editCardDescription" class="form-label">Card Description</label>
                    <textarea class="form-control" id="editCardDescription" rows="3" onblur="updateCard(<?= $board->id ?>)"></textarea>
                </div>
                <div class="mb-3">
                    <label for="editDueDate" class="form-label">Due Date</label>
                    <input type="datetime-local" class="form-control" id="editDueDate" onblur="updateCard(<?= $board->id ?>)">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="deleteCardButton" onclick="deleteCard(<?= $board->id ?>)">Delete</button>
                <input type="hidden" id="editCardId">
            </div>
        </div>
    </div>
</div>

<!-- Confirm Board Removal Modal -->
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

<!-- Add List Modal -->
<div class="modal fade" id="addListModal" tabindex="-1" aria-labelledby="addListModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addListModalLabel">Add List</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="listName" class="form-label">List Name</label>
                    <input type="text" class="form-control" id="listName">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveListButton" onclick="addList(<?php echo $board->id; ?>)">Save</button>
            </div>
        </div>
    </div>
</div>

<script src="/js/lists.js"></script>
<script src="/js/cards.js"></script>
<script>
    (async () => {
        await fetchLists(<?= $board->id ?>);
        await fetchCards(<?= $board->id ?>);
    })();
</script>

<?php
include_once __DIR__ . '/../footer.php';
?>