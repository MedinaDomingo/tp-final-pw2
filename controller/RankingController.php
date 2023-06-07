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
        if(!$_SESSION['valid']){
            header('Location:/');
        }
        $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;

        $users_ranking = $this->model->obtenerRankingDeUsuarios($currentPage);
        $this->renderer->render('ranking', $users_ranking);
    }
}