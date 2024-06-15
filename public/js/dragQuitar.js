function dragStart(ev) {
  ev.dataTransfer.setData('text/plain', ev.target.id);
}

function dragEndEliminar(ev) {
  let id = ev.currentTarget.getAttribute('data-id');
  let elementoProducto = $(ev.currentTarget).closest('.producto-en-carrito');

  $.ajax({
    type: "post",
    url: ruta_carrito_eliminarT,
    data: {
      id: id
    },
    dataType: "json",
    success: function(response) {
        elementoProducto.remove();
    }
  });
}
