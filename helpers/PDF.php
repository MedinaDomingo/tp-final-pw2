<?php
include_once('fpdf/fpdf.php');
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