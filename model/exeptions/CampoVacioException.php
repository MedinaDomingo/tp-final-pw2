<?php

class CampoVacioException extends Exception
{
    private $campo;
    public function __construct($mensaje, $campo)
    {
        parent::__construct($mensaje);
        $this->campo = $campo;
    }
    public function getCampo()
    {
        return $this->campo;
    }
}