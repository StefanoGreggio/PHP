async function deleteProductModal(productId) {
    let serverURL = `http://127.0.0.1:8081/products/${productId}`;
    let modalBody = document.querySelector('.modal-body');
    let deleteButton = document.createElement('button');
    let response = await fetch(serverURL);
    let productData = await response.json();
    let productInfo = `
        <p><strong>ID:</strong> ${productData.data.id}</p>
        <p><strong>Nome:</strong> ${productData.data.attributes.nome}</p>
        <p><strong>Marca:</strong> ${productData.data.attributes.marca}</p>
        <p><strong>Prezzo:</strong> ${productData.data.attributes.prezzo}</p>
    `;

    modalBody.innerHTML = productInfo;

    // Add a delete button to the modal
    deleteButton.textContent = 'Delete Product';
    deleteButton.classList.add('btn-danger');
    deleteButton.addEventListener('click', () => deleteProduct(productData.data.id));
    modalBody.appendChild(deleteButton);

    // Show the modal (you can customize this part based on your modal implementation)
    let modal = new bootstrap.Modal(document.getElementById('modal'));
    modal.show();
}

function deleteProduct(productId) {
    let serverURL = `http://127.0.0.1:8081/products/${productId}`;
    try {
        let response = fetch(serverURL, { method: 'DELETE' });
        if (response.ok) {
            throw new Error('Error while deleting the product');
        }

        // Hide the modal after successful deletion
        let modal = bootstrap.Modal.getInstance((document.getElementById('modal')));
        // Display a success message or reload the page
        alert('Product deleted successfully');
        modal.hide();


        // Remove the row containing the deleted product
        let tbody = document.getElementById('tableBody');
        let rows = tbody.rows;
        for (let i = 0; i < rows.length; i++) {
            let row = rows[i];
            let idCell = row.cells[0];
            if (idCell.textContent.trim() === productId.toString()) {
                tbody.removeChild(row);
                break;
            }
        }

    } catch (error) {
        console.error(error);
    }
}
