// public/js/compra.js
ruta_provincia = ruta_provincias_comunidades.substring(0, ruta_provincias_comunidades.length - 1);
$(document).ready(function() {
    $('.comunidad-select').on("change", function() {
        var comunidad = $(this).val(); // Usar .val() para obtener el valor seleccionado
        var provinciaSelect = $('.provincia-select');
        console.log('Comunidad seleccionada: ', comunidad);

        // Limpiar las provincias anteriores
        provinciaSelect.empty();
        provinciaSelect.append('<option value="">Selecciona una provincia</option>');
        console.log('Provincia seleccionada: ', provinciaSelect);
        if (comunidad) {
            // Hacer una petición AJAX para obtener las provincias
            $.ajax({
                url: ruta_provincia + comunidad,
                method: 'GET',
                success: function(response) {
                    response.forEach(function(provincia) {
                        var option = $('<option></option>').val(provincia).text(provincia);
                        provinciaSelect.append(option);
                    });
                },
                error: function() {
                    console.error('No se pudieron cargar las provincias');
                }
            });
        }
    });
});

$(document).ready(function() {
    $('#direccionForm').on('submit', function(event) {
        event.preventDefault(); // Evitar el envío estándar del formulario

        // Recoger todos los datos del formulario por nombre
        var tipoVia = $('select[name="direccion_form[tipo_via]"]').val();
        var direccion = $('input[name="direccion_form[direccion]"]').val();
        var comunidad = $('select[name="direccion_form[comunidad]"]').val();
        var provincia = $('select[name="direccion_form[provincia]"]').val();
        var codigoPostal = $('input[name="direccion_form[codigo_postal]"]').val();

        // Asegurarnos de que los valores no son undefined
        tipoVia = tipoVia || '';
        direccion = direccion || '';
        comunidad = comunidad || '';
        provincia = provincia || '';
        codigoPostal = codigoPostal || '';

        // Formatear la dirección en una única cadena
        var direccionCompleta = tipoVia + ' ' + direccion + ', ' + comunidad + ', ' + provincia + ', ' + codigoPostal;

        // Preparar los datos para enviar
        var dataToSend = {
            fullData: direccionCompleta
        };

        // Loguear los datos para depuración
        console.log("Datos enviados:", dataToSend);

        // Enviar los datos al servidor usando AJAX
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: JSON.stringify(dataToSend),
            contentType: 'application/json',
            success: function(response) {
                console.log("Respuesta del servidor:", response);
                if (response.success) {
                    // Redireccionar o manejar éxito
                    window.location.href = response.redirect_url;
                } else {
                    // Manejar errores
                    console.error('Error:', response.errors);
                    // Aquí puedes mostrar los errores en la interfaz, si es necesario
                }
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud:', error);
            }
        });
    });
});



