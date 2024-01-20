function fetchCards(boardId) {
    fetch(`/api/cards?boardId=${boardId}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(cards => {
        cards.forEach(card => {
            const cardElement = document.createElement('a');
            cardElement.href = "#";
            cardElement.setAttribute("data-bs-toggle", "modal");
            cardElement.setAttribute("data-bs-target", "#editCardModal");
            cardElement.setAttribute("onclick", `updateEditCardModal('${boardId}', '${card.id}')`);
            cardElement.innerHTML = `
                <div class="card bg-light-subtle hover-overlay mt-3">
                    <div class="card-body">
                        <h5 class="card-title">${card.name}</h5>
                        <p class="card-text">${card.description}</p>
                    </div>
                    <div class="card-footer">
                        ${card.dueDate}
                    </div>
                    <div class="card mask" style="background-color: rgba(255,255,255, 0.1);"></div>
                </div>
            `;
            const listContainer = document.getElementById(`list-${card.listId}`);
            listContainer.appendChild(cardElement);
        });
    })
    .catch(error => console.error('Error fetching cards:', error));
}

function addCard(boardId, listId) {
    
    const cardName = document.getElementById('cardName').value;
    const cardDescription = document.getElementById('cardDescription').value;
    const cardDueDate = document.getElementById('dueDate').value;
    
    if (cardName.trim() === '' || cardDescription.trim() === '' || cardDueDate.trim() === '') {
        alert('Please fill in all fields');
        return;
    }    

    if (cardName.length > 32) {
        alert('Card name cannot exceed 32 characters.');
        return;
    }
    
    fetch('/api/cards/create', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            boardId: boardId,
            listId: listId,
            cardName: cardName,
            cardDescription: cardDescription,
            cardDueDate: cardDueDate
        }),
    })
    .then(response => response.json())
    .then(result => {
        const listContainer = document.getElementById(`list-${listId}`);
        const cardElement = document.createElement('a');
        cardElement.href = "#";
        cardElement.setAttribute("data-bs-toggle", "modal");
        cardElement.setAttribute("data-bs-target", "#editCardModal");
        cardElement.setAttribute("onclick", `updateEditCardModal('${boardId}', '${result.cardId}')`);
        cardElement.innerHTML = `
            <div class="card bg-light-subtle hover-overlay mt-3">
                <div class="card-body">
                    <h5 class="card-title">${cardName}</h5>
                    <p class="card-text">${cardDescription}</p>
                </div>
                <div class="card-footer">
                    ${dueDate}
                </div>
                <div class="card mask" style="background-color: rgba(255,255,255, 0.1);"></div>
            </div>
        `;
        listContainer.appendChild(cardElement);

        // Clear the modal fields
        document.getElementById('cardName').value = '';
        document.getElementById('cardDescription').value = '';
        document.getElementById('dueDate').value = '';

        // Close the modal
        const addCardModal = document.getElementById('addCardModal');
        const modal = bootstrap.Modal.getInstance(addCardModal);
        modal.hide();
    })
    .catch(error => console.error('Error adding card:', error));
}

function updateEditCardModal(boardId, cardId) {
    fetch(`/api/cards/card?boardId=${boardId}&cardId=${cardId}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(card => {
        // Update card modal fields
        document.getElementById('editCardModalLabel').innerText = card.name;
        document.getElementById('editCardDescription').value = card.description;
        document.getElementById('editDueDate').value = card.dueDate;
        document.getElementById('editCardId').value = card.id; // Set the card ID in the hidden input field
    })
    .catch(error => console.error('Error fetching card:', error));
}

function updateCardName() {
    var cardId = document.getElementById('editCardId').value;
    var cardName = document.getElementById('editCardModalLabel').innerText;
    
    if (cardName.length > 32) {
        alert('Card name cannot exceed 32 characters.');
        return;
    }
    
    // Call JavaScript function to update card name
    alert('Card name updated to: ' + cardName);
}

function updateCardDescription() {
    var cardId = document.getElementById('editCardId').value;
    var cardDescription = document.getElementById('editCardDescription').value;
    // Call JavaScript function to update card description
    alert('Card description updated to: ' + cardDescription);
}

function updateDueDate() {
    var cardId = document.getElementById('editCardId').value;
    var dueDate = document.getElementById('editDueDate').value;
    // Call JavaScript function to update due date
    alert('Due date updated to: ' + dueDate);
}

function deleteCard() {
    var cardId = document.getElementById('editCardId').value;
    // Call JavaScript function to delete card
    alert('Card deleted.');
}