function validaLogin(ev) {
    var correo = document.getElementById("username").value;
    var pass = document.getElementById("password").value;
    // Expresión regular para validar el correo
    const patronCorreo = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,3}$/;
    const patronPass = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$/;
    if (correo == "") {
        alert("Correo vacío");
        ev.preventDefault();
    }
    else {
        if (!patronCorreo.test(correo)) {
            alert("Correo inválido, debe contener al menos un caracter, un @, otro carácter, un punto y dos o tres caracteres");
            ev.preventDefault();
        }
        else {
            if (pass == "") {
                alert("Contraseña vacía");
                ev.preventDefault();
            }
            else {
                if (pass.length < 6) {
                    alert("Contraseña de menos de 6 caracteres");
                    ev.preventDefault();
                }
                else {
                    if (!patronPass.test(pass)) {
                        alert("La contraseña no es válida. Debe contener al menos 6 caracteres, un número, una letra mayúscula y una letra minúscula");
                        ev.preventDefault();
                    }
                }
            }
        }
    }
}

function validaRespuesta(ev) {
    var post = document.getElementById("mensaje").value;
    if (post == "") {
        alert("Post está vacío");
        ev.preventDefault();
    }
    else {
        if (post.length > 200) {
            alert("El post excede los 200 caracteres");
            ev.preventDefault();

        }
    }
}

function validaComentario(ev, id) {
    var comentario = document.getElementById(id).value;
    if (comentario == "") {
        alert("comentario está vacío");
        ev.preventDefault();
    }
    else {
        if (comentario.length > 200) {
            alert("El comentario excede los 200 caracteres");
            ev.preventDefault();

        }
    }
}

function cambiarModo() {
    var body = document.body;
    var modo = localStorage.getItem('modo');

    if (modo === 'oscuro') {
        body.classList.remove('dark-mode');
        localStorage.setItem('modo', 'claro');
    } else {
        body.classList.add('dark-mode');
        localStorage.setItem('modo', 'oscuro');
    }
}

// Aplicar el modo oscuro al cargar la página si está seleccionado
window.onload = function() {
    var modo = localStorage.getItem('modo');
    if (modo === 'oscuro') {
        document.body.classList.add('dark-mode');
    }
}