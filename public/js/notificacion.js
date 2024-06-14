$(document).ready(function() {
    // Manejar clic en el botón "Notificarme cuando haya stock"
    $(document).on('click', '.notify-me', function() {
        let id = $(this).data('id');
        let nombre = $(this).data('nombre');
        let email = $(this).data('email');

        // Verificar que el email no esté vacío
        if (!email) {
            alert('Debes iniciar sesión para recibir notificaciones.');
            return;
        }

        // Enviar la solicitud AJAX para registrar la notificación
        $.ajax({
            type: 'POST',
            url: ruta_notificacion,
            data: {
                id: id,
                nombre: nombre,
                email: email
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert('Te notificaremos cuando haya más stock del producto ' + nombre + '.');
                } else {
                    alert('Hubo un problema al solicitar la notificación. Por favor, intenta de nuevo.');
                }
            },
            error: function() {
                alert('Ocurrió un error en el servidor. Por favor, intenta de nuevo más tarde.');
            }
        });
    });
});