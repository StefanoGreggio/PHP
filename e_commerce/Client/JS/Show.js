async function showProductModal(productId) {
    let serverURL = `http://127.0.0.1:8081/products/${productId}`;

    try {
        let response = await fetch(serverURL);
        if (!response.ok) {
            throw new Error('Error while fetching the product');
        }

        let productData = await response.json();
        ProductModal(productData);
    } catch (error) {
        console.error(error);
    }
}

function ProductModal(productData) {
    let modalBody = document.querySelector('.modal-body');
    modalBody.innerHTML = '';

    let productInfo = `
        <p><strong>ID:</strong> ${productData.data.id}</p>
        <p><strong>Nome:</strong> ${productData.data.attributes.nome}</p>
        <p><strong>Marca:</strong> ${productData.data.attributes.marca}</p>
        <p><strong>Prezzo:</strong> ${productData.data.attributes.prezzo}</p>
    `;

    modalBody.innerHTML = productInfo;

    // Show the modal (you can customize this part based on your modal implementation)
    let modal = new bootstrap.Modal(document.getElementById('modal'));
    modal.show();
}