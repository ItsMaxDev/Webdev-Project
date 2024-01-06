<?php
include_once __DIR__ . '/../header.php';
?>

<h1 class="mt-5"><?php echo $board->name; ?></h1>
<p><?php echo $board->description; ?></p>

<div id="listsContainer" class="row">
    <!-- Lists will be dynamically added here using JavaScript -->
    <div id="addListButton" class="col-xl-3 col-lg-4 col-md-5 col-sm-6 mt-3">
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

<button type="button" class="btn btn-danger mt-5" data-bs-toggle="modal" data-bs-target="#confirmRemovalModal">Remove Board</button>

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
                <h1 class="modal-title fs-5" id="editCardModalLabel" contenteditable="true" onblur="updateCardName()"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="editCardDescription" class="form-label">Card Description</label>
                    <textarea class="form-control" id="editCardDescription" rows="3" onblur="updateCardDescription()"></textarea>
                </div>
                <div class="mb-3">
                    <label for="editDueDate" class="form-label">Due Date</label>
                    <input type="datetime-local" class="form-control" id="editDueDate" onblur="updateDueDate()">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="deleteCardButton" onclick="deleteCard()">Delete</button>
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
<script>fetchLists(<?php echo $board->id; ?>);</script>

<?php
include_once __DIR__ . '/../footer.php';
?>