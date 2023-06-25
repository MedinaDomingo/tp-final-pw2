<?php
include_once('fpdf/fpdf.php');

class AdministradorController
{
    private $model;
    private $renderer;

    public function __construct($model, $renderer)
    {
        $this->renderer = $renderer;
        $this->model = $model;
    }

    public function administrador()
    {
        if (!$_SESSION['valid'] || !$_SESSION['user_data']['descripción'] == 'administrador') {
            header('Location:/');
            exit();
        }
        $this->renderer->render('perfiladm', $_SESSION["user_data"]);
    }

    public function estadistica()
    {
        $cantidadClientes = $this->model->traerCantidadClientes();
        $cantidadPreguntas = $this->model->cantidadPreguntasEnJuego();
        $cantidadPreguntasCreadas = $this->model->cantidadPreguntasCreadas();
        $cantidadUsuarioPorSexo = $this->model->cantidadUsuariosPorSexo($_POST['fechaInicial'] ?? null, $_POST['fechaFinal'] ?? null);
        $cantidadUsuarioPorPais = $this->model->cantidadUsuariosPorPais($_POST['fechaInicial'] ?? null, $_POST['fechaFinal'] ?? null);
        $cantidadUsuariosRangoEtario = $this->model->cantidadUsuariosRangoEtario($_POST['fechaInicial'] ?? null, $_POST['fechaFinal'] ?? null);

        $data = array(
            "cantidad_clientes" => $cantidadClientes['cantidad_clientes'],
            "cantidad_preguntas" => $cantidadPreguntas['cantidad_preguntas'],
            "cantidad_preguntas_creadas" => $cantidadPreguntasCreadas['cantidad_preguntas_creadas'],
            "cantidad_usuarios_masculino" => $cantidadUsuarioPorSexo[1][1] ?? 0,
            "cantidad_usuarios_femenino" => $cantidadUsuarioPorSexo[0][1] ?? 0,
            "paises" => $cantidadUsuarioPorPais,
            "edades" => $cantidadUsuariosRangoEtario

        );

        echo json_encode($data);
    }

    public function generarPDF()
    {
        $chartDivImage = $_POST['chartDivImage'];

        file_put_contents('public/pdf/grafico1.jpg', base64_decode(explode(',', $chartDivImage)[1]));

        // Crear una instancia del PDF
        $pdf = new PDF();

        // Agregar una nueva página al documento
        $pdf->AddPage();

        // Generar el contenido del documento con los datos de los gráficos
        $pdf->Content(array(
            'chart_div' => 'public/pdf/grafico1.jpg',
        ));

        // Guardar el archivo PDF
        $pdf->Output('public/pdf/reporte.pdf', 'F');

        $pdfUrl = $_SERVER['HTTP_HOST'] .'/public/pdf/reporte.pdf';

        // Devolver la URL del archivo PDF como respuesta
        echo json_encode(['pdfUrl' => $pdfUrl]);
    }

}


class PDF extends FPDF
{
    function Header()
    {
        // Configurar el encabezado del PDF
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, utf8_decode('Reporte pdf'), 0, 1, 'C');
    }

    function Content($chartsData)
    {

        $this->SetFont('Arial', 'B', 10);
        /*        $this->Cell(0, 10, utf8_decode('Gráfico de Barras'), 0, 1);*/
        $this->Image($chartsData['chart_div'], 10, 20, 0, 260);

    }
}

