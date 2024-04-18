async function createProduct() {
    let serverURL = `http://127.0.0.1:8081/products`;
    let data = {
        data: {
            attributes: {
                nome: document.getElementById('nome').value,
                marca: document.getElementById("marca").value,
                prezzo: document.getElementById("prezzo").value
            }
        }
    };

    try {
        let response = await fetch(serverURL, {method: 'POST', body: JSON.stringify(data)});
        if (!response.ok) {
            throw new Error('Error while creating the product');
        }
        let product = await response.json();
        let tBody = document.getElementById("tableBody");
        let row = document.createElement('tr');
        row.innerHTML = `
          <td>${product.data.id}</td>
          <td>${product.data.attributes.nome}</td>
          <td>${product.data.attributes.marca}</td>
          <td>${product.data.attributes.prezzo}</td>
          <td>
            <button class="btn btn-primary show-btn"  data-id="${product.data.id}">Show</button>
            <button class="btn btn-primary edit-btn" data-id="${product.data.id}">Edit</button>
            <button class="btn btn-danger delete-btn"  data-id="${product.data.id}">Delete</button>
          </td>
        `;
        console.log(product.data.id);
        tBody.appendChild(row);
        let modal = bootstrap.Modal.getInstance((document.getElementById('modal')));
        // Display a success message or reload the page
        alert('Product created successfully');
        modal.hide();
        addEventListeners();
    } catch (error) {
        console.error(error);
    }
}


function createProductModal() {
    let modalBody = document.querySelector('.modal-body');
    let createButton = document.createElement('button');


    let productInfo = `
        <p><strong>Nome:</strong></p>
        <input type="text" id="nome">
        <p><strong>Marca:</strong></p>
        <input type="text" id="marca">
        <p><strong>Prezzo:</strong></p>
        <input type="number" id="prezzo">
        <p></p>
        `;

    modalBody.innerHTML = productInfo;

    // Add a create button to the modal
    createButton.textContent = 'Create Product';
    createButton.classList.add('btn-primary');
    createButton.addEventListener('click', () => createProduct());
    modalBody.appendChild(createButton);


    let modal = new bootstrap.Modal(document.getElementById('modal'));
    modal.show();
}