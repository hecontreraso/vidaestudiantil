<?php

require_once(APPPATH . 'libraries/fpdf.php');

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Generar extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('modelo');
        $this->load->library('fpdf');
        $this->load->helper('url');
    }

    public function index() {

    }

    public function generarPDF($pasaporte, $pdf){

        $datos = $this->modelo->obtenerDatosPDFIndividual($pasaporte);
        if($datos == false){
            return false;
        }

        $nombre = $datos['nombre'];
        $talleres = $datos['talleres'];
        $pais = $datos['pais'];

        $pdf->SetMargins(20, 10);
        $pdf->AliasNbPages();
        $pdf->AddPage();

        $pdf->SetFont('Arial', '', 15);
        $pdf->Cell(0, 0, utf8_decode($nombre . ' - ' .  $pais), 0, 0, 'C');
        $pdf->Ln("10");

        //ITERAR ESTA VAINA 4 VECES
        for ($i = 0; $i < 4; $i++) {

            $horario = "";
            switch ($i) {
                case 0:
                    $horario = "Primer horario: MIÉRCOLES 3:00 PM";
                    break;
                case 1:
                    $horario = "Segundo horario: MIÉRCOLES 4:15 PM";
                    break;
                case 2:
                    $horario = "Tercer horario: DOMINGO 10:00 AM";
                    break;
                case 3:
                    $horario = "Cuarto horario: DOMINGO 11:15 AM";
                    break;
            }

            $nombreTaller = $talleres[$i]['nombres'];
            $tallerista = $talleres[$i]['tallerista'];
            $lugar = $talleres[$i]['ubicacion'];

            $pdf->imprimirTalleres($nombreTaller, $tallerista, $horario, $lugar);
        }

        return $pdf;
    }

    public function individual($error='') {
        if ($this->input->server('REQUEST_METHOD') == "GET") {

            $header = $this->input->server('HTTP_ACCEPT_LANGUAGE');
            $lang = substr($header, 0, 2); //es, en, pt
            $idiomaExiste = in_array($lang, array("es", "en", "pt"));
            $lang = ($idiomaExiste ? $lang : "es");
            $this->lang->load($lang, $lang);

            if($error == 'noexiste'){
                $data['error'] = "El pasaporte ingresado no existe";
                $this->load->view('generador-individual', $data);
            }
            else{
                $this->load->view('generador-individual');
            }
        }
        
        else if ($this->input->server('REQUEST_METHOD') == "POST") {
            
            $pasaporte = $this->input->post('pasaporte');

            $pdf = new PDF();
            $pdf = $this->generarPDF($pasaporte, $pdf);

            if($pdf == false){
                redirect('/generar/individual/noexiste');
            }
            else{
                $pdf->Output();
            }
        }
    }

    public function todos() {
        $pasaportes = $this->modelo->obtenerTodosLosPasaportes();
        $pdf = new PDF();
        foreach ($pasaportes as $pasaporte)
        {
            $pdf = $this->generarPDF($pasaporte, $pdf);
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
        $this->Cell(20, 10, 'Lista de talleres inscritos', 0, 0, 'C');
        // Salto de línea
        $this->Ln(20);
    }

    // Tabla simple
    function imprimirTalleres($taller, $tallerista, $horario, $lugar) {
        // Anchuras de las columnas
        $w = array(40, 250);

        $this->SetFont('Arial', 'B', 14);
        $this->Cell($w[1], 6, utf8_decode($horario), 0, 'LR');
        $this->Ln();

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
        $this->Cell($w[0], 6, "Lugar/Place", 0, 'LR');

        $this->SetFont('Arial', '', 10);
        $this->Cell($w[1], 6, utf8_decode($lugar), 0, 'LR');
        $this->Ln(19);
        
        $this-> Line(20, $this->GetY()-8, 180, $this->GetY()-8);
    }

}