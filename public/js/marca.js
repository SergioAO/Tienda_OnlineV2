const ruta_marca = ruta_producto_marca.substring(
    0, ruta_producto_marca.length -1
);

$(".marcas-btn").on("click", function () {
   console.log(ruta_marca + $(this).data("marca"));
   $(".marcas-btn").removeClass("active");
   $(this).addClass("active");
   solicitarMarcas($(this).data("marca"));
});

function solicitarMarcas(marca) {
   $.ajax({
      type: 'get',
      url: ruta_marca + marca,
      success: function (response) {
         console.log(response);
         mostrarMarcas(marca, response);
      },
   });
}

function mostrarMarcas(marca, productos) {
   console.log($("#marcaTabContent").html());
   $("#marcaTabContent").empty();
   $("#marcaTabContent").append(`<div class="tab-pane fade show active" id="content-${marca}" role="tabpanel" aria-labelledby="tab-${marca}">
    <div id="products-marca" class="product-list">
    </div>
    </div>
    `);

   productos.forEach((element) => {
      $("#products-marca").append(`<div class="product-card">
    <img src="${element.imagen}" alt="${element.nombre}">
    <h3>${element.nombre}</h3>
    <p class="price">
        <span class="current-price">${element.precio}€</span>
    </p>
    <button class="add-to-cart" data-id="${element.id}" data-nombre="${element.nombre}" data-precio="${element.precio}">Añadir al carrito</button>
    </div>`);
   });
}