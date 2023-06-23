
$(document).ready(function () {
    var urlParams = new URLSearchParams(window.location.search);
    var estado = urlParams.get('estado');
    function loadPreguntas(page) {
        var url = '/GestionPreguntas/listarPreguntas?page=' + page;
        if (estado !== null) {
            $('#alta').empty();
            $('#alta').removeClass();

            url += '&estado=' + estado;
        }
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'text',
            success: function (response) {
                let data = JSON.parse(response);
                let tbody = $('#tablaPreguntas tbody');
                let preguntas = data.preguntas;
                tbody.empty(); // Vaciar la tabla antes de agregar las nuevas filas

                for (var i = 0; i < preguntas.length; i++) {
                    var pregunta = preguntas[i];
                    let row = $('<tr>');
                    row.append($('<td>').text(pregunta.pregunta));
                    row.append($('<td>').text(pregunta.categoria));
                    row.append($('<td>').text(pregunta.correcta));
                    row.append($('<td>').text(pregunta.opcion_b));
                    row.append($('<td>').text(pregunta.opcion_c));
                    row.append($('<td>').text(pregunta.opcion_d));
                    row.append($('<td>').text(pregunta.estado));

                    row.append(`<td><a id="btn-modificar" href="/GestionPreguntas/modificar" class="settings" title="Modificar" data-toggle="tooltip"><i class="material-icons">&#xE8B8;</i></a> 
                                <a id="btn-eliminar" class="delete" title="Eliminar" data-toggle="tooltip"><i class="material-icons text-danger">&#xE5C9;</i></a> </td>`);
                    tbody.append(row);
                }

                if (data.prevPage) {
                    $('#prevPageLink').attr('data-page', data.prevPage).show();
                } else {
                    $('#prevPageLink').hide();
                }

                if (data.nextPage) {
                    $('#nextPageLink').attr('data-page', data.nextPage).show();
                } else {
                    $('#nextPageLink').hide();
                }

                $('#currentPageText').text('Pagina ' + data.currentPage + '/' + data.totalPages);
            },
            error: function (xhr, status, error) {
                console.log('Error: ' + error);
            }
        });
    }

    // Esto cargaria la  preguntas y paginación en la página inicial
    loadPreguntas(1);

    // Capturar el evento de clic en el enlace de página anterior
    $('#prevPageLink').on('click', function (event) {
        event.preventDefault();
        var page = $(this).attr('data-page');
        loadPreguntas(page);
    });

    // Capturar el evento de clic en el enlace de página siguiente
    $('#nextPageLink').on('click', function (event) {
        event.preventDefault();
        var page = $(this).attr('data-page');
        loadPreguntas(page);
    });
});
