$(document).ready(function () {
    $.ajax({
        url: '/GestionPreguntas/listarPreguntas',
        type: 'POST',
        dataType: 'text',
        success: function (response) {
            var data = JSON.parse(response);
            let table = $('#tablaPreguntas');
            for (var i = 0; i < data.length; i++) {
                var pregunta = data[i];
                /*console.log('Pregunta:', pregunta.pregunta);
                console.log('Categoria:', pregunta.categoria);
                console.log('correcta:', pregunta.correcta);
                console.log('incorrecta a:', pregunta.incorrecta_a);
                console.log('incorrecta b:', pregunta.incorrecta_b);
                console.log('incorrecta c:', pregunta.incorrecta_c);*/

                let row = $('<tr>');
                row.append($('<td>').text(pregunta.pregunta));
                row.append($('<td>').text(pregunta.categoria));
                row.append($('<td>').text(pregunta.correcta));
                row.append($('<td>').text(pregunta.incorrecta_a));
                row.append($('<td>').text(pregunta.incorrecta_b));
                row.append($('<td>').text(pregunta.incorrecta_c));

                if(pregunta.estado == "Alta"){
                    row.append($('<td>').append('<span class="status text-success fs-1">&bull;</span>'));
                }else{
                    row.append($('<td>').append('<span class="status text-danger fs-1">&bull;</span>'));
                }

                row.append(`<td><a id="btn-modificar" href="/GestionPreguntas/modificar" class="settings" title="Modificar" data-toggle="tooltip"><i class="material-icons">&#xE8B8;</i></a> 
                                <a id="btn-eliminar" class="delete" title="Eliminar" data-toggle="tooltip"><i class="material-icons text-danger">&#xE5C9;</i></a> </td>`)
                table.append(row);
            }
        },
        error: function (xhr, status, error) {
            console.log('Error: ' + error);
        }
    });
});

