// public/js/comentarios.js

$(document).ready(function() {
    $('.delete-comment').on('click', function() {
        const comentarioId = $(this).data('id');
        const $comentarioElement = $(this).closest('.list-group-item');
        const urlEliminarComentario = ruta_base_eliminar_comentario.replace('ID_PLACEHOLDER', comentarioId);

        if (confirm('¿Estás seguro de que quieres eliminar este comentario?')) {
            $.ajax({
                url: urlEliminarComentario,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Asegúrate de tener el token CSRF en un meta tag
                },
                success: function(response) {
                    if (response.success) {
                        $comentarioElement.remove();
                    } else {
                        alert('Error al eliminar el comentario');
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr);
                    alert('No se pudo eliminar el comentario.');
                }
            });
        }
    });
});
