<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Productos</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <h1 class="mb-4 text-center">Catálogo de Productos</h1>

    <!-- Formulario para crear producto -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Crear nuevo producto</h5>
            <form id="createProductForm">
                <div class="row mb-2">
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Nombre" name="nombre" required>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Categoría" name="categoria" required>
                    </div>
                </div>
                <div class="mb-2">
                    <input type="text" class="form-control" placeholder="Descripción" name="descripcion" required>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <input type="number" step="0.01" class="form-control" placeholder="Precio" name="precio" required>
                    </div>
                    <div class="col">
                        <input type="url" class="form-control" placeholder="URL" name="url" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Crear Producto</button>
            </form>
        </div>
    </div>

    <!-- Tabla de productos -->
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Categoría</th>
            <th>URL</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody id="productsTable">
        <!-- Aquí se llenarán los productos vía JS -->
        </tbody>
    </table>
</div>

<!-- Bootstrap + Axios + JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
const apiUrl = '/products';

let editingId = null;

function fetchProducts() {
    axios.get(apiUrl)
        .then(res => {
            const table = document.getElementById('productsTable');
            table.innerHTML = '';
            res.data.forEach(product => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${product.id}</td>
                    <td>${product.nombre}</td>
                    <td>${product.descripcion}</td>
                    <td>${product.precio}</td>
                    <td>${product.categoria}</td>
                    <td><a href="${product.url}" target="_blank">Link</a></td>
                    <td>${product.estado ? 'Activo' : 'Inactivo'}</td>
                    <td>
                        <button class="btn btn-sm btn-warning" onclick="editProduct(${product.id})">Editar</button>
                        <button class="btn btn-sm btn-danger" onclick="deleteProduct(${product.id})">Eliminar</button>
                    </td>
                `;
                table.appendChild(row);
            });
        });
}

function deleteProduct(id) {
    axios.delete(`${apiUrl}/${id}`)
        .then(() => fetchProducts());
}

document.getElementById('createProductForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const data = Object.fromEntries(formData.entries());
    data.estado = true;

    if (editingId) {
        // Estamos editando
        axios.put(`${apiUrl}/${editingId}`, data)
            .then(() => {
                this.reset();
                editingId = null; // salimos del modo edición
                fetchProducts();
            });
    } else {
        // Crear nuevo producto
        axios.post(apiUrl, data)
            .then(() => {
                this.reset();
                fetchProducts();
            });
    }
});

function editProduct(id) {
    const product = Array.from(document.querySelectorAll('#productsTable tr'))
        .map(tr => ({
            id: tr.children[0].innerText,
            nombre: tr.children[1].innerText,
            descripcion: tr.children[2].innerText,
            precio: tr.children[3].innerText,
            categoria: tr.children[4].innerText,
            url: tr.children[5].querySelector('a').href
        }))
        .find(p => p.id == id);

    // Llenar formulario
    const form = document.getElementById('createProductForm');
    form.nombre.value = product.nombre;
    form.descripcion.value = product.descripcion;
    form.precio.value = product.precio;
    form.categoria.value = product.categoria;
    form.url.value = product.url;

    // Activar modo edición
    editingId = id;
}

// Guardar la función original para restaurarla
const createSubmitHandler = document.getElementById('createProductForm').onsubmit;

fetchProducts();
</script>
</body>
</html>