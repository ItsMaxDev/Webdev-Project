async function fetchLists(boardId) {
    try {
        const response = await fetch(`/api/lists?boardId=${boardId}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        });
        const lists = await response.json();
        const listsContainer = document.getElementById('listsContainer');
        lists.forEach(list => {
            const listElement = document.createElement('div');
            listElement.id = `listelement-${list.id}`;
            listElement.className = 'col-xl-3 col-lg-4 col-md-5 col-sm-6';
            listElement.innerHTML = `
                <div class="card mh-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span contenteditable="true" onblur="updateList(${boardId}, ${list.id})">${list.name}</span>
                        <i class="fa-solid fa-trash" onclick="deleteList(${boardId}, ${list.id})" style="cursor: pointer"></i>
                    </div>
                    <div class="card-body overflow-y-auto pt-0" id="list-${list.id}">
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary w-100" id="addCardButton" onclick="addCardModal(${boardId}, ${list.id})">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fa-solid fa-plus me-2"></i>
                                <span>Add a card</span>
                            </div>
                        </button>
                    </div>
                </div>
            `;
            const addListButton = document.getElementById('addListButton');
            listsContainer.insertBefore(listElement, addListButton);
        });
    } catch (error) {
        console.error('Error fetching lists:', error);
    }
}

function deleteList(boardId, listId) {
    fetch(`/api/lists/delete`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            boardId: boardId,
            listId: listId
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log(data.message);

        // Remove the list from the DOM
        document.getElementById(`listelement-${listId}`).remove();
    })
    .catch(error => {
        console.error('Error deleting list:', error);
    });
}

function addCardModal(boardid, listId) {
    // Open the add card modal
    const addCardModal = new bootstrap.Modal(document.getElementById('addCardModal'));
    addCardModal.show();

    // Update the saveCardButton to pass along the correct listId
    const saveCardButton = document.getElementById('saveCardButton');
    saveCardButton.onclick = function() {
        addCard(boardid, listId);
    };
}

function addList(boardId) {
    const listName = document.getElementById('listName').value;
    
    if (listName.trim() === '' || listName.trim() === '') {
        alert('Please fill in all fields');
        return;
    }

    if (listName.length > 32) {
        alert('List name cannot exceed 32 characters.');
        return;
    }
    
    fetch('/api/lists/create', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            boardId: boardId,
            listName: listName
        }),
    })
    .then(response => response.json())
    .then(result => {
        const listsContainer = document.getElementById('listsContainer');
        const listElement = document.createElement('div');
        listElement.id = `listelement-${result.listId}`;
        listElement.className = 'col-xl-3 col-lg-4 col-md-5 col-sm-6';
        listElement.innerHTML = `
            <div class="card mh-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span contenteditable="true" onblur="updateList(${boardId}, ${result.listId})">${listName}</span>
                    <i class="fa-solid fa-trash" onclick="deleteList(${boardId}, ${result.listId})" style="cursor: pointer"></i>
                </div>
                <div class="card-body overflow-y-auto pt-0" id="list-${result.listId}">
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-primary w-100" id="addCardButton" onclick="addCardModal(${boardId}, ${result.listId})">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-plus me-2"></i>
                            <span>Add a card</span>
                        </div>
                    </button>
                </div>
            </div>
        `;
        const addListButton = document.getElementById('addListButton');
        listsContainer.insertBefore(listElement, addListButton);

        // Close the modal
        const addListModal = document.getElementById('addListModal');
        const modal = bootstrap.Modal.getInstance(addListModal);
        modal.hide();

        // Clear the modal fields
        document.getElementById('listName').value = '';
    })
    .catch(error => console.error('Error adding list:', error));
}

function updateList(boardId, listId) {
    const listName = document.getElementById(`listelement-${listId}`).querySelector('span').textContent;

    fetch('/api/lists/update', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            boardId: boardId,
            listId: listId,
            listName: listName
        }),
    })
    .then(response => response.json())
    .then(result => {
        console.log(result.message);
    })
    .catch(error => console.error('Error updating list:', error));
}