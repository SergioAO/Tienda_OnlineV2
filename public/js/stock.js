$(document).ready(function() {
    // Manejar el clic en el botón de disminuir stock
    $('.stock-decrease').click(function() {
        let id = $(this).data('id');

        $.ajax({
            type: 'POST',
            url: ruta_stock_producto,
            data: { id: id, accion: 'decrease' },
            success: function(response) {
                if (response.success) {
                    location.reload(); // Recargar la página para ver el stock actualizado
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Ocurrió un error al actualizar el stock.');
            }
        });
    });

    // Manejar el clic en el botón de aumentar stock
    $('.stock-increase').click(function() {
        let id = $(this).data('id');

        $.ajax({
            type: 'POST',
            url: ruta_stock_producto,
            data: { id: id, accion: 'increase' },
            success: function(response) {
                if (response.success) {
                    location.reload(); // Recargar la página para ver el stock actualizado
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Ocurrió un error al actualizar el stock.');
            }
        });
    });
});