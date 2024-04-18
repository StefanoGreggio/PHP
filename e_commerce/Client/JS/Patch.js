async function editProduct(productId) {
    let serverURL = `http://127.0.0.1:8081/products/${productId}`;
    console.log(productId);
    let data = {
        data: {
            id: productId,
            attributes: {
                nome: document.getElementById('nome').value,
                marca: document.getElementById("marca").value,
                prezzo: document.getElementById("prezzo").value
            }
        }
    };

    try {
        let response = await fetch(serverURL, {method: 'PATCH', body: JSON.stringify(data)});
        let product = await response.json()
        if (!response.ok) {
            throw new Error('Error while editing the product');
        }
        let row = document.getElementById(productId);
        row.cells[1].innerHTML = product.data.attributes.nome;
        row.cells[2].innerHTML = product.data.attributes.marca;
        row.cells[3].innerHTML = product.data.attributes.prezzo;


        
        let modal = bootstrap.Modal.getInstance((document.getElementById('modal')));
        // Display a success message or reload the page
        alert('Product edited successfully');
        modal.hide();
    } catch (error) {
        console.error(error);
    }
}


async function editProductModal(productId) {
    let serverURL = `http://127.0.0.1:8081/products/${productId}`;
    let modalBody = document.querySelector('.modal-body');
    let editButton = document.createElement('button');
    let response = await fetch(serverURL);
    let productData = await response.json();
    let productInfo = `
        <p><strong>ID:</strong> ${productData.data.id}</p>        
        <p><strong>Nome:</strong> ${productData.data.attributes.nome}</p>
        <input type="text" id="nome">
        <p><strong>Marca:</strong> ${productData.data.attributes.marca}</p>
        <input type="text" id="marca">
        <p><strong>Prezzo:</strong> ${productData.data.attributes.prezzo}</p>
        <input type="number" id="prezzo">
        <p></p>
    `;

    modalBody.innerHTML = productInfo;

    // Add a delete button to the modal
    editButton.textContent = 'Edit Product';
    editButton.classList.add('btn-primary');
    editButton.addEventListener('click', () => editProduct(productData.data.id));
    modalBody.appendChild(editButton);


    let modal = new bootstrap.Modal(document.getElementById('modal'));
    modal.show();
}