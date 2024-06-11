const ruta_categoria = ruta_producto_categoria.substring(
  0,
  ruta_producto_categoria.length - 1
);

$(".categorias-btn").on("click", function () {
  console.log(ruta_categoria + $(this).data("categoria"));
  $(".categorias-btn").removeClass("active");
  $(this).addClass("active");
  solicitarProductos($(this).data("categoria"));
});
function solicitarProductos(categoria) {
  $.ajax({
    type: "get",
    url: ruta_categoria + categoria,
    success: function (response) {
      console.log(response);
      mostrarProductos(categoria, response);
    },
  });
}
function mostrarProductos(categoria, productos) {
  console.log("Entrando en categoria");
  $("#categoryTabContent").empty();
  $("#categoryTabContent")
    .append(`<div class="tab-pane fade show active" id="content-${categoria}" role="tabpanel" aria-labelledby="tab-${categoria}">
    <div id="products" class="product-list">
    </div>
    </div>
    `);
  productos.forEach((element) => {
    $("#products").append(`<div class="product-card">
    <img src="${element.imagen}" alt="${element.nombre}">
    <h3>${element.nombre}</h3>
    <p class="price">
        <span class="current-price">${element.precio}€</span>
    </p>
    <button class="add-to-cart" data-id="${element.id}" data-nombre="${element.nombre}" data-precio="${element.precio}">Añadir al carrito</button>
    </div>`);
  });
}