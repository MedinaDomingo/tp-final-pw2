<?php

class GestionPreguntasController
{
    private $model;
    private $renderer;
    public function __construct($model, $renderer)
    {
        $this->renderer = $renderer;
        $this->model = $model;
    }

    public function gestion()
    {
        if(!$_SESSION['valid'] || !$_SESSION['user_data']['descripción'] =='editor'){
            header('Location:/');
            exit();
        }

        $this->renderer->render('gestionpreguntas');
        if (isset($_GET['mensaje'])) {
            $mensaje = $_GET['mensaje'];
            // Mostrar la notificación utilizando SweetAlert2
            echo '<script>
        Swal.fire({
            icon: "success",
            title: "¡Éxito!",
            text: "La operación se realizó correctamente."
        });
     </script>';
        }
    }

    public function guardarPregunta()
    {
        if(!$_SESSION['valid'] || !$_SESSION['user_data']['descripción'] =='editor'){
            header('Location:/');
            exit();
        }

        $result =$this->model->guardarPregunta(
            $_POST['pregunta']??"",
            $_POST['categoria']??"",
            $_POST['otra_categoria']??"",
            $_POST['check-otra-categoria']??"",
            $_POST['respuesta-correcta']??"",
            $_POST['respuesta-incorrecta-a']??"",
            $_POST['respuesta-incorrecta-b']??"",
            $_POST['respuesta-incorrecta-c']??"");

        echo json_encode($result);
    }

    public function listarPreguntas()
    {
        $ELEMENTOS_POR_PAGINA = 3;
        if(!$_SESSION['valid'] || !$_SESSION['user_data']['descripción'] =='editor'){
            header('Location:/');
            exit();
        }
        $paginaActual = $_GET['page'] ?? 1;

        $offset = ($paginaActual - 1) * $ELEMENTOS_POR_PAGINA;
        $result = $this->model->traerTodasLasPreguntas($_GET['estado']??"");
        $elementos = count($result);

        $preguntas["preguntas"] = array_slice($result, $offset, $ELEMENTOS_POR_PAGINA);

        $preguntas["totalPages"] = ceil($elementos/$ELEMENTOS_POR_PAGINA);
        $preguntas["currentPage"] = $paginaActual;

        if($paginaActual != 1){
            $preguntas["prevPage"] = $paginaActual - 1;
        }

        if($elementos > $paginaActual * $ELEMENTOS_POR_PAGINA){
            $preguntas["nextPage"] = $paginaActual + 1;
        }

        echo json_encode($preguntas);
    }

    public function listarCategorias()
    {
        if(!empty($_GET["paginacion"] )){
            if($_GET["paginacion"] == "no"){
                $categorias = $this->model->traerTodasLasCategorias(2);
                echo json_encode($categorias);
                exit();
            }
        }
        $ELEMENTOS_POR_PAGINA = 3;
        if(!$_SESSION['valid'] || !$_SESSION['user_data']['descripción'] =='editor'){
            header('Location:/');
            exit();
        }
        $paginaActual = $_GET['page'] ?? 1;

        $offset = ($paginaActual - 1) * $ELEMENTOS_POR_PAGINA;
        $result = $this->model->traerTodasLasCategorias();
        $elementos = count($result);

        $categorias["categorias"] = array_slice($result, $offset, $ELEMENTOS_POR_PAGINA);

        $categorias["totalPages"] = ceil($elementos/$ELEMENTOS_POR_PAGINA);
        $categorias["currentPage"] = $paginaActual;

        if($paginaActual != 1){
            $categorias["prevPage"] = $paginaActual - 1;
        }

        if($elementos > $paginaActual * $ELEMENTOS_POR_PAGINA){
            $categorias["nextPage"] = $paginaActual + 1;
        }

        echo json_encode($categorias);
    }

    public function eliminarPreguntaRespuestas()
    {
        if(!$_SESSION['valid'] || !$_SESSION['user_data']['descripción'] =='editor'){
            header('Location:/');
            exit();
        }

        $result = $this->model->eliminarPreguntaRespuestas($_POST['pregunta']);

        echo json_encode($result);
    }

    public function modificar()
    {
        if(!$_SESSION['valid'] || !$_SESSION['user_data']['descripción'] =='editor'){
            header('Location:/');
            exit();
        }

        $pregunta =  $this->model->buscarPregunta($_POST["pregunta"]);
        $pregunta[0]['revision'] = $pregunta[0]['estado'] == 'en_revision' ? true : false;
        $pregunta[0]['pendiente'] = $pregunta[0]['estado'] == 'pendiente_aprobacion' ? true : false;
        $pregunta[0]['aprobada'] = $pregunta[0]['estado'] == 'aprobada' ? true : false;
        $this->renderer->render('modificar', $pregunta[0]);
    }

    public function modificarPregunta()
    {
        if(!$_SESSION['valid'] || !$_SESSION['user_data']['descripción'] =='editor'){
            header('Location:/');
            exit();
        }

        $result =  $this->model->modificarPregunta(
            $_POST['preguntacod']??"",
            $_POST['pregunta']??"",
            $_POST['categoria']??"",
            $_POST['estado']??"",
            $_POST['otra_categoria']??"",
            $_POST['check-otra-categoria']??"",
            $_POST['respuesta-correcta']??"",
            $_POST['respuesta-incorrecta-a']??"",
            $_POST['respuesta-incorrecta-b']??"",
            $_POST['respuesta-incorrecta-c']??"");

        echo json_encode($result);
    }

    public function categorias()
    {
        if(!$_SESSION['valid'] || !$_SESSION['user_data']['descripción'] =='editor'){
            header('Location:/');
            exit();
        }

        $this->renderer->render('gestionCategorias');
        if (isset($_GET['mensaje'])) {
            $mensaje = $_GET['mensaje'];
            // Mostrar la notificación utilizando SweetAlert2
            echo '<script>
        Swal.fire({
            icon: "success",
            title: "¡Éxito!",
            text: "La operación se realizó correctamente."
        });
     </script>';
        }
    }

    public function guardarCategoria()
    {
        $result = $this->model->guardarCategoria($_POST['categoria']);

        echo json_encode($result);
    }
    public function eliminarCategoria()
    {
        if(!$_SESSION['valid'] || !$_SESSION['user_data']['descripción'] =='editor'){
            header('Location:/');
            exit();
        }

        $result = $this->model->eliminarCategoria($_POST['categoria']);

        echo json_encode($result);
    }

    public function formModificarCategoria()
    {
        if(!$_SESSION['valid'] || !$_SESSION['user_data']['descripción'] == 'editor'){
            header('Location:/');
            exit();
        }

        $pregunta =  $this->model->buscarCategoria($_POST["categoria"]);
        $pregunta[0]['revision'] = $pregunta[0]['estado'] == 'en_revision' ? true : false;
        $pregunta[0]['pendiente'] = $pregunta[0]['estado'] == 'pendiente_aprobacion' ? true : false;
        $pregunta[0]['aprobada'] = $pregunta[0]['estado'] == 'aprobada' ? true : false;
        $this->renderer->render('modificarCategoria', $pregunta[0]);
    }

    public function modificarCategoria()
    {
        if (!$_SESSION['valid'] || !$_SESSION['user_data']['descripción'] == 'editor') {
            header('Location:/');
            exit();
        }

        $result = $this->model->modificarCategoria($_POST['categoriacod'], $_POST['categoria'], $_POST['estado']);
        echo json_encode($result);
    }
}