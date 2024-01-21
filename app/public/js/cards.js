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
        console.log(result.message);

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
        // Save the original values of the modal fields
        const editCardModalLabel = document.getElementById('editCardModalLabel');
        const editCardDescription = document.getElementById('editCardDescription');
        const editCardDueDate = document.getElementById('editDueDate');
        editCardModalLabel.setAttribute('data-original', card.name);
        editCardDescription.setAttribute('data-original', card.description);
        editCardDueDate.setAttribute('data-original', card.dueDate);

        // Update the modal fields
        editCardModalLabel.innerText = card.name;
        editCardDescription.value = card.description;
        editCardDueDate.value = card.dueDate;
        document.getElementById('editCardId').value = card.id;
    })
    .catch(error => console.error('Error fetching card:', error));
}

function updateCard(boardId) {
    const cardModalLabel = document.getElementById('editCardModalLabel');
    const cardDescriptionElement = document.getElementById('editCardDescription');

    const cardId = document.getElementById('editCardId').value;
    const cardName = cardModalLabel.innerText;
    const cardDescription = cardDescriptionElement.value;
    const cardDueDate = document.getElementById('editDueDate').value;

    if (cardName.trim() === '' || cardDescription.trim() === '') {
        alert('Please fill in all fields');

        // Reset the modal fields to the original values
        cardModalLabel.innerText = cardModalLabel.dataset.original;
        cardDescriptionElement.value = cardDescriptionElement.dataset.original;

        return;
    }

    if (cardName.length > 32) {
        alert('Card name cannot exceed 32 characters.');

        // Reset the modal fields to the original values
        cardModalLabel.innerText = cardModalLabel.dataset.original;
        cardDescriptionElement.value = cardDescriptionElement.dataset.original;

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
        console.log(data.message);
        
        // Update the card
        document.getElementById(`card-${cardId}`).querySelector('.card-title').innerText = cardName;
        document.getElementById(`card-${cardId}`).querySelector('.card-text').innerText = cardDescription;
        document.getElementById(`card-${cardId}`).querySelector('.card-footer').innerText = cardDueDate ? new Date(cardDueDate).toLocaleString(undefined, { dateStyle: 'short', timeStyle: 'short' }) : '';
    })
    .catch(error => {
        console.error('Error updating card:', error);
    });
}

function deleteCard(boardId) {
    const cardId = document.getElementById('editCardId').value;

    fetch(`/api/cards/delete`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            cardId: cardId,
            boardId: boardId
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log(data.message);

        // Remove the card from the DOM
        document.getElementById(`card-${cardId}`).remove();

        // Close the modal
        const editCardModal = document.getElementById('editCardModal');
        const modal = bootstrap.Modal.getInstance(editCardModal);
        modal.hide();
    })
    .catch(error => {
        console.error('Error deleting card:', error);
    });
}
