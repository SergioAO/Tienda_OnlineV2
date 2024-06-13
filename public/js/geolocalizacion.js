document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("localizacion").addEventListener("click", visualizar_Mapa, false);

    function visualizar_Mapa() {
        var latitud = "40.5071739"; // Latitud fija
        var longitud = "-3.8965226"; // Longitud fija

        // Crear una nueva ventana
        var nuevaVentana = window.open("", "_blank");

        // Crear una página completa en una cadena de texto
        var pagina = '<html><head><title>¿Donde nos encontramos?</title></head><body>';
        pagina += '<h2> Electro Gamer. AVDA Europa, Parcela 24-45 y 26-66. Polígono industrial Las Rozas, 25840, Las Rozas, Madrid. ESPAÑA. </h2>';
        pagina += '<iframe src="https://maps.google.com/?ll=' + latitud + ',' + longitud + '&z=14&t=m&output=embed" width="70%" height="70%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>';
        pagina += '</body></html>';

        // Abrir la página en la nueva ventana
        nuevaVentana.document.write(pagina);
        nuevaVentana.document.close();
    }
});
