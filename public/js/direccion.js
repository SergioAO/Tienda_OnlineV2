// public/js/direccion.js
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


