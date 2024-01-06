function fetchCards(listIds) {
    fetch(`/api/cards?listIds=${listIds.join(',')}`, {
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
            cardElement.setAttribute("onclick", `updateEditCardModal('${card.id}')`);
            cardElement.innerHTML = `
                <div class="card bg-light-subtle hover-overlay">
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

function updateEditCardModal(cardId) {
    // Create an example card object
    var card = {
        id: cardId, // Pass the card ID
        listId: 1,
        name: 'Card Name',
        description: 'Card Description',
        dueDate: '2021-10-01T12:00'
    };

    // Update card modal fields
    document.getElementById('editCardModalLabel').innerText = card.name;
    document.getElementById('editCardDescription').value = card.description;
    document.getElementById('editDueDate').value = card.dueDate;
    document.getElementById('editCardId').value = card.id; // Set the card ID in the hidden input field
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