<?php

class RankingController
{
    private $model;
    private $renderer;
    public function __construct($model, $renderer)
    {
        $this->renderer = $renderer;
        $this->model = $model;
    }

    public function ranking(){
        $ELEMENTOS_POR_PAGINA = 2;
        if(!$_SESSION['valid']){
            header('Location:/');
        }

        $paginaActual = $_GET['page'] ?? 1;
        $offset = ($paginaActual - 1) * $ELEMENTOS_POR_PAGINA;

        $users_ranking = $this->model->obtenerRankingDeUsuarios();
        $elementos = count($users_ranking["users"]);

        $rankingData["users"] = array_slice($users_ranking["users"], $offset, $ELEMENTOS_POR_PAGINA);

        $rankingData["totalPages"] = ceil($elementos/$ELEMENTOS_POR_PAGINA);
        $rankingData["currentPage"] = $paginaActual;

        if($paginaActual != 1){
            $rankingData["prevPage"] = $paginaActual - 1;
        }

        if(ceil(count($rankingData)/$ELEMENTOS_POR_PAGINA) >=  $paginaActual){
            $rankingData["nextPage"] = $paginaActual + 1;
        }

        $this->renderer->render('ranking', $rankingData);
    }
}