<?php

class EmailException extends Exception
{

    public function __construct($mensaje)
    {
        parent::__construct($mensaje);
    }
}