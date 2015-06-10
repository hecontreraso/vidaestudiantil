<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Formulario extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('modelo');
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function index($lang = '') {
        if ($this->input->server('REQUEST_METHOD') == "POST") {
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');

            $this->form_validation->set_rules('pasaporte', 'Pasaporte', 'trim|required');
            $this->form_validation->set_rules('pais', 'País', 'trim|required');
            $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required');
            $this->form_validation->set_rules('apellidos', 'Apellidos', 'trim|required');

            $pasaporte = $this->input->post('pasaporte');
            $pais = $this->input->post('pais');
            $nombre = $this->input->post('nombre');
            $apellidos = $this->input->post('apellidos');
            $correo = $this->input->post('correo');
            $correo2 = $this->input->post('correo2');

            $taller1 = $this->input->post('taller1');
            $taller2 = $this->input->post('taller2');
            $taller3 = $this->input->post('taller3');
            $taller4 = $this->input->post('taller4');

            $exito = $this->modelo->guardarInscripcion($pasaporte, $pais, $nombre, $apellidos, $correo, array($taller1, $taller2, $taller3, $taller4));
            if ($correo !== $correo2) {
                $exito = 'correo';
            }
            if ($exito == "exito") {
                $this->load->view('exito');
                $this->session->sess_destroy();
                return;
            } else {
                $lang = $this->session->userdata('lang');
                $error = $exito;
            }
        }

        if ($lang == '') {
            $header = $this->input->server('HTTP_ACCEPT_LANGUAGE');
            $lang = substr($header, 0, 2); //es, en, pt
            $idiomaExiste = in_array($lang, array("es", "en", "pt"));
            $lang = ($idiomaExiste ? $lang : "es");
        }
        $this->lang->load($lang, $lang);

        $data['paises'] = $this->modelo->obtenerPaises();
        $data['talleres'] = $this->modelo->obtenerTalleresDisponibles($lang);
        if (!isset($error)) {
            $data['error'] = "";
        } else {
            $data['error'] = $error;
        }
        if (!isset($pasaporte)) {
            $data['pasaporte'] = "";
        } else {
            $data['pasaporte'] = $pasaporte;
        }
        if (!isset($nombre)) {
            $data['nombre'] = "";
        } else {
            $data['nombre'] = $nombre;
        }
        if (!isset($apellidos)) {
            $data['apellidos'] = "";
        } else {
            $data['apellidos'] = $nombre;
        }
            if (!isset($correo)) {
            $data['correo'] = "";
        } else {
            $data['correo'] = $correo;
        }
        if (!isset($correo2)) {
            $data['correo2'] = "";
        } else {
            $data['correo2'] = $correo2;
        }
        $this->load->view('formulario', $data);
        $this->session->set_userdata('lang', $lang);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
