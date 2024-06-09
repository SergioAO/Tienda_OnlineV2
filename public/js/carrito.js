$(".add-to-cart").on("click", function () {
  console.log("precionado");
  console.log($(this).data("nombre"));

  let id = $(this).data("id");
  let nombre =  $(this).data("nombre");
  let precio = $(this).data("precio")

  $.ajax({
    type: "post",
    url: ruta_carrito_agregar,
    data: {
      id: id,
      nombre: nombre,
      precio: precio,
    },
    dataType: "json",
    success: function (response) {
      console.log(response);
      let cantidad = $(".cart-badge").html();
      $(".cart-badge").html(Number(cantidad) + 1);
      $(".carrito-compra").append(
        `<li><div class="producto-en-carrito">${nombre} - ${precio}<button data-id="${id}" class="eliminar-producto-carrito">Eliminar</button></div></li>`
      );
    },
  });
});
$(document).on("click",".eliminar-producto-carrito", function(){
  let id = $(this).data("id")
  $(this).parent().parent().remove();
  
  $.ajax({
    type: "post",
    url: ruta_carrito_eliminar,
    data: {
      id: id
    },
    dataType: "json",
    success: function (response) {
      let cantidad = $(".cart-badge").html();
      $(".cart-badge").html(Number(cantidad) - 1);
      console.log(response);
    }
  });
})