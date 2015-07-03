<?php

require_once(APPPATH . 'libraries/fpdf.php');

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Generar extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('modelo');
        $this->load->library('fpdf');
    }

    public function index() {

    }

    public function individual() {

        $datos = $this->modelo->obtenerDatosPDFIndividual("001783359");
        $nombre = $datos['nombre'];
        $talleres = $datos['talleres'];

        $pdf = new PDF();
        $pdf->SetMargins(20, 10);
        $pdf->AliasNbPages();
        $pdf->AddPage();

        $pdf->SetFont('Arial', '', 15);
        $pdf->Cell(0, 0, utf8_decode($nombre), 0, 0, 'C');
        $pdf->Ln("10");

//ITERAR ESTA VAINA 4 VECES
        for ($i = 0; $i < 4; $i++) {

            $nombreTaller = $talleres[$i]['nombres'];
            $tallerista = $talleres[$i]['tallerista'];
            $lugar = $talleres[$i]['ubicacion'];

            $horario = "";
            switch ($i) {
                case 0:
                    $horario = "Primer horario";
                    break;
                case 1:
                    $horario = "Segundo horario";
                    break;
                case 2:
                    $horario = "Tercer horario";
                    break;
                case 3:
                    $horario = "Cuarto horario";
                    break;
            }
            $pdf->imprimirTalleres($nombreTaller, $tallerista, $horario, $lugar);
        }

        $pdf->Output();
    }

}

class PDF extends FPDF {

// Cabecera de página
    function Header() {

        // Logo
        $this->Ln(35);
        $size = "25";
        $absx = (210 - $size) / 2;
        $this->Image('http://vidaestudiantil.com/So1o/wp-content/uploads/2014/10/logo2@-e1414024238391.png', $absx, 5, $size);

        // Arial bold 15
        $this->SetFont('Arial', 'B', 24);
        // Movernos a la derecha
        $this->Cell(80);
        // Título
        $this->Cell(30, 10, 'Lista de talleres inscritos', 0, 0, 'C');
        // Salto de línea
        $this->Ln(20);
    }

    // Tabla simple
    function imprimirTalleres($taller, $tallerista, $horario, $lugar) {
        // Anchuras de las columnas
        $w = array(40, 250);

        $this->SetFont('Arial', 'B', 10);
        $this->Cell($w[0], 6, "Taller/Workshop", 0, 'LR');

        $this->SetFont('Arial', '', 10);
        $this->Cell($w[1], 6, utf8_decode($taller[0]), 0, 'LR');
        $this->Ln();
        $this->Cell($w[0], 6, "", 0, 'LR');
        $this->Cell($w[1], 6, utf8_decode($taller[1]), 0, 'LR');
        $this->Ln();
        $this->Cell($w[0], 6, "", 0, 'LR');
        $this->Cell($w[1], 6, utf8_decode($taller[2]), 0, 'LR');
        $this->Ln();

        $this->SetFont('Arial', 'B', 10);
        $this->Cell($w[0], 6, "Tallerista/Facilitator", 0, 'LR');

        $this->SetFont('Arial', '', 10);
        $this->Cell($w[1], 6, utf8_decode($tallerista), 0, 'LR');
        $this->Ln();

        $this->SetFont('Arial', 'B', 10);
        $this->Cell($w[0], 6, "Horario/Schedule", 0, 'LR');

        $this->SetFont('Arial', '', 10);
        $this->Cell($w[1], 6, utf8_decode($horario), 0, 'LR');
        $this->Ln();

        $this->SetFont('Arial', 'B', 10);
        $this->Cell($w[0], 6, "Lugar/Place", 0, 'LR');

        $this->SetFont('Arial', '', 10);
        $this->Cell($w[1], 6, utf8_decode($lugar), 0, 'LR');
        $this->Ln(19);
    }

}
