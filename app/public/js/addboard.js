function validateAddBoardForm() {
    const title = document.getElementById('boardTitle').value;
    const description = document.getElementById('boardDescription').value;

    if (title.trim() === '' || description.trim() === '') {
        alert('Please fill in all fields');
        return false;
    }

    if (title.length > 32) {
        alert('Title should not exceed 32 characters');
        return false;
    }

    if (description.length > 128) {
        alert('Description should not exceed 128 characters');
        return false;
    }    

    return true;
}

function addBoard() {
    if (!validateAddBoardForm()) {
        return;
    }
    
    const boardTitle = document.getElementById('boardTitle').value;
    const boardDescription = document.getElementById('boardDescription').value;

    const boardData = {
        addboard: true,
        boardTitle: boardTitle,
        boardDescription: boardDescription,
    };

    fetch('/api/boards', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(boardData),
    })
    .then(response => response.json())
    .then(data => {
        console.log(data.message);

        if (data.boardId) {
            // Redirect to the newly created board
            window.location.href = '/boards/board?id=' + data.boardId;
        }
    })
    .catch(error => console.error('Error:', error));
}

// Fetch boards when the page loads
document.addEventListener('DOMContentLoaded', function () {
    fetch('/api/boards', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(boards => {
        // Process the boards and dynamically add them to the page
        const boardsContainer = document.getElementById('boardsContainer');
        boards.forEach(board => {
            const boardElement = document.createElement('div');
            boardElement.className = 'col-xl-2 col-lg-3 col-md-4 col-sm-5 mt-3 hover-overlay';
            boardElement.innerHTML = `
                <a href="/boards/board?id=${board.id}" class="card text-decoration-none">
                    <div class="card-body">
                        <h5 class="card-title">${board.name}</h5>
                        <p class="card-text">${board.description}</p>
                    </div>
                    <div class="card mask" style="background-color: rgba(255,255,255, 0.1);"></div>
                </a>
            `;
            boardsContainer.appendChild(boardElement);
        });
    })
    .catch(error => console.error('Error fetching boards:', error));
});