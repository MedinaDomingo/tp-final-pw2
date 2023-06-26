<?php
include_once ('helpers/PDF.php');

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
        if (!$_SESSION['valid'] || !$_SESSION['user_data']['descripción'] == 'administrador') {
            header('Location:/');
            exit();
        }
        $cantidadPartidas = $this->model->traerCantidadPartidas($_POST['fechaInicial'] ?? null, $_POST['fechaFinal'] ?? null);
        $cantidadClientes = $this->model->traerCantidadClientes($_POST['fechaInicial'] ?? null, $_POST['fechaFinal'] ?? null);
        $cantidadPreguntas = $this->model->cantidadPreguntasEnJuego($_POST['fechaInicial'] ?? null, $_POST['fechaFinal'] ?? null);
        $cantidadPreguntasCreadas = $this->model->cantidadPreguntasCreadas($_POST['fechaInicial'] ?? null, $_POST['fechaFinal'] ?? null);
        $cantidadUsuarioPorSexo = $this->model->cantidadUsuariosPorSexo($_POST['fechaInicial'] ?? null, $_POST['fechaFinal'] ?? null);
        $cantidadUsuarioPorPais = $this->model->cantidadUsuariosPorPais($_POST['fechaInicial'] ?? null, $_POST['fechaFinal'] ?? null);
        $cantidadUsuariosRangoEtario = $this->model->cantidadUsuariosRangoEtario($_POST['fechaInicial'] ?? null, $_POST['fechaFinal'] ?? null);

        $data = array(
            "cantidad_partidas_jugadas" => $cantidadPartidas['cantidad_partidas'],
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
        if (!$_SESSION['valid'] || !$_SESSION['user_data']['descripción'] == 'administrador') {
            header('Location:/');
            exit();
        }
        $chartDivImage = $_POST['chartDivImage'];

        file_put_contents('public/pdf/grafico1.jpg', base64_decode(explode(',', $chartDivImage)[1]));

        $pdf = new PDF();

        $pdf->AddPage();

        $pdf->Content(array(
            'chart_div' => 'public/pdf/grafico1.jpg',
        ));

        $pdf->Output('public/pdf/reporte.pdf', 'F');

        $pdfUrl = $_SERVER['HTTP_HOST'] .'/public/pdf/reporte.pdf';

        echo json_encode(['pdfUrl' => $pdfUrl]);
    }

}



