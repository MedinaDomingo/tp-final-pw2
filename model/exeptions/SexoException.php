<?php

class SexoExeption extends Exception
{

    public function __construct($mensaje)
    {
        parent::__construct($mensaje);
    }
}