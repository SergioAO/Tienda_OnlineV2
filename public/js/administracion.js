$("input[type='file']").on("change", function () {
  $(this)
    .parent()
    .next()
    .attr("src", URL.createObjectURL($(this)[0].files[0]));
});

$(".productos-agregar").on("click", function () {
  toggle(".container_productos_agregar");
  $(".container_productos_eliminar").css("display", "none");
  $(".container_usuarios").css("display", "none");
});
$(".productos-eliminar").on("click", function () {
  toggle(".container_productos_eliminar");
  $(".container_productos_agregar").css("display", "none");
  $(".container_usuarios").css("display", "none");
});
$(".usuario-eliminar").on("click", function () {
  toggle(".container_usuarios");
  $(".container_productos_agregar").css("display", "none");
  $(".container_productos_eliminar").css("display", "none");
});
function toggle(param) {
  $(param).slideToggle();
}
function buscarUsuario(nombre) {
  $.ajax({
    type: "post",
    url: ruta_buscador_usuario,
    data: {
      usuario: nombre,
    },
    dataType: "json",
    success: function (response) {
      $(".container_users").empty();
      response.forEach((element) => {
        $(".container_users").append(`<div>
				<img src="${element.photo}" alt="foto">
				<div>${element.email}</div>
				<button class="eliminar-user" data-id="${element.id}">Eliminar</button>
			</div>`);
      });
      console.log(response);
    },
  });
}

function buscarProducto(nombre) {
  $.ajax({
    type: "post",
    url: ruta_buscador_producto,
    data: {
      producto: nombre,
    },
    dataType: "json",
    success: function (response) {
      $(".container_productos").empty();
      response.forEach((element) => {
        $(".container_productos").append(`
          <div>
              <img src="${element.imagen}" alt="foto" class="product-image">
              <div>${element.nombre}</div>
              <button class="eliminar-product" data-id="${element.id}">Eliminar</button>
          </div>
        `);
      });
    },
  });
}

$(document).on("click", ".eliminar-product", function () {
  let id = $(this).data("id");

  $.ajax({
    type: "post",
    url: ruta_eliminar_productos,
    data: {
      id: id,
    },
    success: function (response) {
      window.location.href = '/confirmacion?accion=eliminado&tipo=producto';
    },
  });
});

$(document).on("click", ".eliminar-user", function () {
  let id = $(this).data("id");

  $.ajax({
    type: "post",
    url: ruta_eliminar_usuario,
    data: {
      id: id,
    },
    success: function (response) {
        window.location.href = '/confirmacion?accion=eliminado&tipo=usuario';
    },
  });
});

$("form").on("submit", function (e) {
  e.preventDefault();
  const form = $(this);
  const action = form.attr('action');
  const formData = new FormData(this);

  $.ajax({
    type: "post",
    url: action,
    data: formData,
    processData: false,
    contentType: false,
    success: function (response) {
      if (action.includes('nuevoProducto')) {
        window.location.href = '/confirmacion?accion=agregado&tipo=producto';
      } else if (action.includes('/cambiar-contrasena')) {
        window.location.href = '/confirmacion?accion=cambiada&tipo=contraseña';
      }
    },
  });
});

$("#buscador-producto").keyup(function (e) {
  var nombre = $(this).val();
  buscarProducto(nombre);
});

$("#buscador-usuario").keyup(function (e) {
  var nombre = $(this).val();
  buscarUsuario(nombre);
});
