google.charts.load('current', { 'packages': ['corechart'] });
google.charts.setOnLoadCallback(drawChart);

$(document).ready(function() {
    $('#generateReports').click(function() {
        generateReports();
    });
});
function generateReports() {
    let fechaInicial = $('#fecha-inicial').val();
    let fechaFinal = $('#fecha-final').val();

    $.ajax({
        url: '/Administrador/estadistica',
        method: 'POST',
        dataType: 'json',
        data: {
            fechaInicial: fechaInicial,
            fechaFinal: fechaFinal
        },
        success: function(response) {
            // Generar los informes utilizando los datos de respuesta
            console.log(response)
            $('#chart_div').empty();
            $('#tortachart_sexo').empty();
            $('#tortachart_pais').empty();
            $('#chart_div_edades').empty();

            drawBarChart(response);
            drawPieChartSexo(response);
            drawPieChartByPais(response);
            drawColumnChartEdades(response);
        },
        error: function(xhr, status, error) {
            // Manejo del error de la solicitud
            console.error(error,xhr, status);
        }
    });
}
function drawChart() {
    $.ajax({
        url: '/Administrador/estadistica',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            drawBarChart(response);
            drawPieChartSexo(response);
            drawPieChartByPais(response);
            drawColumnChartEdades(response)
        },
        error: function(xhr, status, error) {
            // Manejo del error de la solicitud
            console.error(error);
        }
    });
}

function drawBarChart(response) {
    let data = google.visualization.arrayToDataTable([
        ['Categoría', 'Cantidad'],
        ['Jugadores', parseInt(response.cantidad_clientes)],
        ['Partidas Jugadas', parseInt(response.cantidad_partidas_jugadas)],
        ['Preguntas en el Juego', parseInt(response.cantidad_preguntas)],
        ['Preguntas Creadas', parseInt(response.cantidad_preguntas_creadas)]
    ]);

    let options = {
        title: 'Algo',
        bar: { groupWidth: '50%' },
        height: 500,
        legend: { position: 'none' },
        chartArea: { width: '80%', height: '70%' },
        responsive: true
    };

    let chart = new google.visualization.BarChart($('#chart_div')[0]);

        chart.draw(data, options);

}

function drawPieChartSexo(response) {
    let data = google.visualization.arrayToDataTable([
        ['Categoría', 'Cantidad'],
        ['Masculino', parseInt(response.cantidad_usuarios_masculino)],
        ['Femenino',  parseInt(response.cantidad_usuarios_femenino)],
    ]);

    let options = {
        title: 'Usuarios por sexo',
        height: 500,
        chartArea: { width: '80%', height: '70%' },
        responsive: true
    };

    let chart = new google.visualization.PieChart($('#tortachart_sexo')[0]);

        chart.draw(data, options);

}

function drawPieChartByPais(response) {
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'País');
    data.addColumn('number', 'Cantidad');

    var paises = JSON.parse(response.paises);

    for (var i = 0; i < paises.length; i++) {
        var pais = paises[i];
        data.addRow([pais.pais, parseInt(pais.cantidad)]);
    }

    var options = {
        title: 'Usuarios por país',
        height: 500,
        chartArea: { width: '80%', height: '70%' },
        responsive: true
    };

    var chart = new google.visualization.PieChart($('#tortachart_pais')[0]);

        chart.draw(data, options);


}

function drawColumnChartEdades(response) {
    let edades = JSON.parse(response.edades);
    let cantidadJubilados = edades.find(obj => obj.grupo_edad === "jubilados")?.cantidad ?? 0;
    let cantidadMedio = edades.find(obj => obj.grupo_edad === "medio")?.cantidad ?? 0;
    let cantidadMenores = edades.find(obj => obj.grupo_edad === "menores")?.cantidad ?? 0;

    let data = google.visualization.arrayToDataTable([
        ['Categoría', 'Cantidad'],
        ['Menores', parseInt(cantidadMenores)],
        ['Medio', parseInt(cantidadMedio)],
        ['Jubilados', parseInt(cantidadJubilados)],
    ]);

    let options = {
        title: 'Cantidad de usuarios por rango etario',
        height: 500,
        legend: { position: 'none' },
        chartArea: { width: '80%', height: '70%' },
        responsive: true
    };

    let chart = new google.visualization.ColumnChart($('#chart_div_edades')[0]);

        chart.draw(data, options);
}

$(window).resize(function() {
    drawChart();
});



