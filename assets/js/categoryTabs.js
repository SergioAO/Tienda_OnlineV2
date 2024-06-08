// assets/js/categoryTabs.js
import $ from 'jquery';
$(document).ready(function () {
    // Función para cargar productos de una categoría
    function cargarProductos(categoria) {
        var contentPane = $('#content-' + categoria + ' .product-list');
        $.ajax({
            url: '/productos/' + categoria,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                contentPane.empty(); // Limpiar el contenido anterior
                data.forEach(function (producto) {
                    var productCard = `
                        <div class="product-card">
                            <img src="${producto.imagen}" alt="${producto.nombre}">
                            <h3>${producto.nombre}</h3>
                            <p class="price">
                                <span class="current-price">${producto.precio}€</span>
                            </p>
                            <button class="add-to-cart">Añadir al carrito</button>
                        </div>
                    `;
                    contentPane.append(productCard);
                });
            },
            error: function (error) {
                console.error('Error:', error);
            }
        });
    }

    // Cargar productos de la primera categoría al inicio
    cargarProductos($('.nav-link.active').data('categoria'));

    // Evento de clic para las pestañas de categoría
    $('.nav-link').on('click', function () {
        var categoriaSeleccionada = $(this).data('categoria');
        cargarProductos(categoriaSeleccionada);
    });
});
