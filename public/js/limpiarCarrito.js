$(document).ready(function() {
    // Hacer una petición AJAX para limpiar el carrito
    $.ajax({
        url: ruta_limpiar_carrito,
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        success: function(response) {
            console.log('Carrito limpiado:', response);
        },
        error: function(xhr, status, error) {
            console.error('Error al limpiar el carrito:', error);
        }
    });
});
