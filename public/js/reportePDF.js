$(document).ready(function() {
    $('#btnImprimir').click(function() {
        generarPDF();
    });
});

async function generarPDF() {
    let report = await getImageDataUrl($('#reports')[0]);
    $.ajax({
        url: '/Administrador/generarPDF',
        method: 'POST',
        dataType: 'json',
        data: {
            chartDivImage: report,
        },
        success: function(response) {
            mostrarPDF(response.pdfUrl);
        },
        error: function(xhr, status, error) {
            console.log(error);
        }
    });
}

function getImageDataUrl(element) {
    return new Promise(function(resolve) {
        html2canvas(element).then(function(canvas) {
            var imgDataUrl = canvas.toDataURL('image/jpeg');
            resolve(imgDataUrl);
        });
    });
}

function mostrarPDF(pdfUrl) {
    window.open('http://'+pdfUrl);


}

