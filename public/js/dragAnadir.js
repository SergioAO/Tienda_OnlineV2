function drag(ev) {
	var producto = {
		id: ev.currentTarget.getAttribute('data-id'),
		nombre: ev.currentTarget.getAttribute('data-nombre'),
		precio: ev.currentTarget.getAttribute('data-precio'),
		imagen: ev.currentTarget.getAttribute('data-imagen'),
		stock: ev.currentTarget.getAttribute('data-stock')
	};
	ev.dataTransfer.setData("text", JSON.stringify(producto));
}

function allowDrop(ev) {
	ev.preventDefault();
}

function drop(ev) {
	ev.preventDefault();
	var producto = JSON.parse(ev.dataTransfer.getData("text"));

	$.ajax({
		type: "post",
		url: ruta_carrito_agregar,
		data: producto,
		dataType: "json",
		success: function(response) {
			console.log(response);
		  // Buscar si el producto ya está en el carrito
		  let productoExistente = $(".producto-en-carrito[data-id='" + producto.id + "']");
		  if (productoExistente.length) {
			// Producto ya existe, actualizar cantidad y precio
			let cantidadActual = parseInt(productoExistente.find('.cantidad-producto').text());
			productoExistente.find('.cantidad-producto').text(cantidadActual + 1);
			productoExistente.find('.precio-producto').text((producto.precio * (cantidadActual + 1)).toFixed(2) + "€");
		  } else {
			// Producto no existe, añadir nuevo elemento al carrito
			$(".carrito-compra").append(
				`<li class="list-group-item">
					<div class="producto-en-carrito d-flex align-items-center ${producto.stock === 0 ? 'out-of-stock' : ''}" data-id="${producto.id}" draggable="true" ondragstart="dragStart(event)" ondragend="dragEndEliminar(event)">
						<img src="${producto.imagen}" class="img-thumbnail me-3" style="width: 50px; height: 50px;" alt="${producto.nombre}">
						<div class="flex-grow-1">
							<strong>${producto.nombre}</strong> - 
							<span class="precio-producto">${producto.precio}€</span>
						</div>
						<button data-id="${producto.id}" class="btn btn-danger btn-sm eliminar-producto-carrito me-2">
							<i class="bi bi-trash"></i>
						</button>
						<span class="cantidad-producto badge bg-primary rounded-pill">1</span>
					</div>
				</li>`
			);
		  }
	
		  // Calcular la cantidad total de todos los productos en el carrito
		  let cantidadTotal = 0;
		  $(".producto-en-carrito .cantidad-producto").each(function() {
			cantidadTotal += parseInt($(this).text());
		  });
	
		  // Actualizar la insignia de cantidad en el carrito
		  $(".cart-badge").html(cantidadTotal);
		}
	  });
}
