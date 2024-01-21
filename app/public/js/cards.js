async function fetchCards(boardId) {
    try {
        const response = await fetch(`/api/cards?boardId=${boardId}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        });
        const cards = await response.json();
        cards.forEach(card => {
            const cardElement = document.createElement('a');
            cardElement.href = "#";
            cardElement.setAttribute("data-bs-toggle", "modal");
            cardElement.setAttribute("data-bs-target", "#editCardModal");
            cardElement.setAttribute("onclick", `updateEditCardModal('${boardId}', '${card.id}')`);
            cardElement.innerHTML = `
                <div id="card-${card.id}" class="card bg-light-subtle hover-overlay mt-3">
                    <div class="card-body">
                        <h5 class="card-title">${card.name}</h5>
                        <p class="card-text">${card.description}</p>
                    </div>
                    <div class="card-footer">
                        ${card.dueDate ? new Date(card.dueDate).toLocaleString(undefined, { dateStyle: 'short', timeStyle: 'short' }) : ''}
                    </div>
                    <div class="card mask" style="background-color: rgba(255,255,255, 0.1);"></div>
                </div>
            `;
            const listContainer = document.getElementById(`list-${card.listId}`);
            listContainer.appendChild(cardElement);
        });
    } catch (error) {
        console.error('Error fetching cards:', error);
    }
}

function addCard(boardId, listId) {
    
    const cardName = document.getElementById('cardName').value;
    const cardDescription = document.getElementById('cardDescription').value;
    const cardDueDate = document.getElementById('dueDate').value;
    
    if (cardName.trim() === '' || cardDescription.trim() === '') {
        alert('Please fill in all fields');
        return;
    }

    if (cardName.length > 32) {
        alert('Card name cannot exceed 32 characters.');
        return;
    }
    
    const requestBody = {
        boardId: boardId,
        listId: listId,
        cardName: cardName,
        cardDescription: cardDescription
    };

    // Add due date to request body if it is not empty
    if (cardDueDate.trim() !== '') {
        requestBody.cardDueDate = cardDueDate;
    }
    
    fetch('/api/cards/create', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(requestBody),
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
            <div id="card-${result.cardId}" class="card bg-light-subtle hover-overlay mt-3">
                <div class="card-body">
                    <h5 class="card-title">${cardName}</h5>
                    <p class="card-text">${cardDescription}</p>
                </div>
                <div class="card-footer">
                    ${cardDueDate ? new Date(cardDueDate).toLocaleString(undefined, { dateStyle: 'short', timeStyle: 'short' }) : ''}
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

function updateCard(boardId) {
    const cardId = document.getElementById('editCardId').value;
    const cardName = document.getElementById('editCardModalLabel').innerText;
    const cardDescription = document.getElementById('editCardDescription').value;
    const cardDueDate = document.getElementById('editDueDate').value;

    if (cardName.trim() === '' || cardDescription.trim() === '') {
        alert('Please fill in all fields');
        return;
    }

    if (cardName.length > 32) {
        alert('Card name cannot exceed 32 characters.');
        return;
    }

    const requestBody = {
        cardId: cardId,
        boardId: boardId,
        cardName: cardName,
        cardDescription: cardDescription
    };

    // Add due date to request body if it is not empty
    if (cardDueDate.trim() !== '') {
        requestBody.cardDueDate = cardDueDate;
    }

    fetch(`/api/cards/update`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(requestBody)
    })
    .then(response => response.json())
    .then(data => {
        // Log the message from the JSON response
        console.log(data.message);
        
        // Update the card
        document.getElementById(`card-${cardId}`).querySelector('.card-title').innerText = cardName;
        document.getElementById(`card-${cardId}`).querySelector('.card-text').innerText = cardDescription;
        document.getElementById(`card-${cardId}`).querySelector('.card-footer').innerText = cardDueDate;

        // Close the modal
        const editCardModal = document.getElementById('editCardModal');
        const modal = bootstrap.Modal.getInstance(editCardModal);
        modal.hide();
    })
    .catch(error => {
        // Handle any errors
        console.error('Error updating card:', error);
    });
}
