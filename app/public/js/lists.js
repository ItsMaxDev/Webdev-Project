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
                        <button type="button" class="btn btn-primary" id="addCardButton" data-bs-toggle="modal" data-bs-target="#addCardModal">Add a card</button>
                    </div>
                </div>
            `;
            const addListButton = document.getElementById('addListButton');
            listsContainer.insertBefore(listElement, addListButton);
        });
    })
    .catch(error => console.error('Error fetching lists:', error));
}