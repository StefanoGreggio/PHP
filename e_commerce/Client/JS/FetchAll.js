let serverURL = 'http://127.0.0.1:8081/products';

document.addEventListener('DOMContentLoaded', function () {
    fetch(serverURL)
        .then(response => response.json())
        .then(data => {
            let tableBody = document.getElementById('tableBody');
            tableBody.innerHTML = '';
            data.data.forEach(product => {
                let row = document.createElement('tr');
                row.id = product.id;
                row.innerHTML = `
          <td>${product.id}</td>
          <td>${product.attributes.nome}</td>
          <td>${product.attributes.marca}</td>
          <td>${product.attributes.prezzo}</td>
          <td>
            <button class="btn btn-primary show-btn"  data-id="${product.id}">Show</button>
            <button class="btn btn-primary edit-btn" data-id="${product.id}">Edit</button>
            <button class="btn btn-danger delete-btn"  data-id="${product.id}">Delete</button>
          </td>
        `;
                tableBody.appendChild(row);
            });

            addEventListeners();
        });
});

function addEventListeners() {
    // Add event listeners for show, edit, and delete buttons
    document.querySelectorAll('.show-btn').forEach(button => {
        button.addEventListener('click', () => {
            let productId = button.getAttribute('data-id');
            showProductModal(productId);
        });
    });

    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', () => {
            let productId = button.getAttribute('data-id');
            editProductModal(productId)
        });
    });

    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', () => {
            let productId = button.getAttribute('data-id');
            deleteProductModal(productId);
        });
    });

    document.getElementById('createButton').addEventListener('click', createProductModal);
}