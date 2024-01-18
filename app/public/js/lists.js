function fetchLists(boardId) {
    fetch(`/api/lists?boardId=${boardId}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(lists => {
        const listsContainer = document.getElementById('listsContainer');
        lists.forEach(list => {
            const listElement = document.createElement('div');
            listElement.className = 'col-xl-3 col-lg-4 col-md-5 col-sm-6 mt-3';
            listElement.innerHTML = `
                <div class="card">
                    <div class="card-header">
                        ${list.name}
                    </div>
                    <div class="card-body" id="list-${list.id}">
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary" id="addCardButton" onclick="addCardModal(${boardId}, ${list.id})">Add a card</button>
                    </div>
                </div>
            `;
            const addListButton = document.getElementById('addListButton');
            listsContainer.insertBefore(listElement, addListButton);
        });
    })
    .catch(error => console.error('Error fetching lists:', error));
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
        listElement.className = 'col-xl-3 col-lg-4 col-md-5 col-sm-6 mt-3';
        listElement.innerHTML = `
            <div class="card">
                <div class="card-header">
                    ${listName}
                </div>
                <div class="card-body" id="list-${result.listId}">
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-primary" id="addCardButton" data-bs-toggle="modal" data-bs-target="#addCardModal">Add a card</button>
                </div>
            </div>
        `;
        const addListButton = document.getElementById('addListButton');
        listsContainer.insertBefore(listElement, addListButton);

        // Close the modal
        const addListModal = document.getElementById('addListModal');
        const modal = bootstrap.Modal.getInstance(addListModal);
        modal.hide();
    })
    .catch(error => console.error('Error adding list:', error));
}