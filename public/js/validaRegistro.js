
document.addEventListener("DOMContentLoaded", function () {
    document.getElementsByName('registro_form')[0].addEventListener("submit", validaRegistro, false);
    function validaRegistro(ev) {
    var correo = document.getElementById("registro_form_email").value;
    var nombre= document.getElementById("registro_form_nombre").value;
    var apellidos= document.getElementById("registro_form_apellidos").value;
    var pass = document.getElementById("registro_form_plainPassword").value;
    // Expresión regular para validar el correo
    const patronCorreo = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,3}$/;
    const patronNombre = /^([A-ZÁÉÍÓÚ][a-zA-ZáéíóúÁÉÍÓÚ]{2,}\s*)+$/;
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
            if (nombre == "") {
                alert("Nombre vacío");
                ev.preventDefault();
            }
            else {
                if (nombre.length < 3) {
                    alert("Nombre de menos de 3 caracteres");
                    ev.preventDefault();
                }
                else {
                    if (!patronNombre.test(nombre)) {
                        alert("El nombre no es válido. Debe contener al menos 3 caracteres y empezar por letra mayúscula");
                        ev.preventDefault();   
                    }
                    else {
                        if (apellidos == "") {
                            alert("apellidos vacío");
                            ev.preventDefault();
                        }
                        else {
                            if (apellidos.length < 3) {
                                alert("Apellidos de menos de 3 caracteres");
                                ev.preventDefault();
                            }
                            else {
                                if (!patronNombre.test(apellidos)) {
                                    alert("Los apellidos no son válidos. Deben contener al menos 3 caracteres y empezar por letra mayúscula");
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
                    }
                }
            }
        }
    }
}
});