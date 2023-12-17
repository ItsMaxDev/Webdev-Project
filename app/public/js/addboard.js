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