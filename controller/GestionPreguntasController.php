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
        }

        $this->renderer->render('gestionpreguntas');
        if (isset($_GET['mensaje'])) {
            // Obtener el mensaje de la URL
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
        }

        $result =$this->model->guardarPregunta(
            $_POST['pregunta'],
            $_POST['categoria'],
            $_POST['respuesta-correcta'],
            $_POST['respuesta-incorrecta-a'],
            $_POST['respuesta-incorrecta-b'],
            $_POST['respuesta-incorrecta-c']);

        echo json_encode($result);
        /*if(!array_key_exists("categoria", $result)){
            header('location: /GestionPreguntas/gestion?mensaje=guardado');
            exit();
        }*/


    }
}