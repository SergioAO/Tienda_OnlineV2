function toggleSidebar(element) {
  let sidebar = document.getElementById(element);
  if (sidebar.style.width === "250px") {
    sidebar.style.width = "0";
  } else {
    sidebar.style.width = "250px";
  }
}
function categorias() {
  $.ajax({
    type: "get",
    url: ruta_categorias,
    success: function (response) {
      console.log(response);

      response.forEach((element) => {
        $(".categorias").append(
          `<li><a href="#">${element.categoria}</a></li>`
        );
      });
    },
  });
}
function marcas() {
  $.ajax({
    type: "get",
    url: ruta_marcas,
    success: function (response) {
      console.log(response);
      response.forEach((element) => {
        if (element.marca != null) {
          $(".marcas").append(`<li><a href="#">${element.marca}</a></li>`);
        }
      });
    },
  });
}
$(".full-categorias").on("click", function () {
  toggleSidebar("miCategoria");
});
function pedirCarrito() {
  $.ajax({
    type: "get",
    url: ruta_carrito,
    success: function (response) {
      console.log(response);
      $(".carrito-compra").empty();
      $(".cart-badge").html(response.length);
      response.forEach((element, index) => {
        $(".carrito-compra").append(
          `<li><div class="producto-en-carrito">${element.nombre} - ${element.precio}<button data-id="${element.id}" class="eliminar-producto-carrito">Eliminar</button></div></li>`
        );
      });
    },
  });
}
$(".mi-carrito").on("click", function () {
  pedirCarrito();
  toggleSidebar("miCarrito");
});
categorias();
marcas();
pedirCarrito();
