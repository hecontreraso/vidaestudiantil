<?php

class Modelo extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function obtenerTalleresDisponibles($idioma) {
        $talleres = array();
        for ($i = 1; $i <= 4; $i++) {
            $this->db->select('*')->from('talleresform')->where(array('horario' => $i, 'idioma' => $idioma, 'disponibles >' => 0))->order_by("tallerhorario_id", "asc");
            $query = $this->db->get();
            $talleres[$i] = $query->result_array();
        }
        return $talleres;
    }

    function obtenerPaises() {
        $query = $this->db->select('*')->from('pais')->get();
        return $query->result_array();
    }

    function guardarInscripcion($pasaporte, $pais, $nombre, $apellidos, $correo, $talleres) {
        $this->db->trans_start(); //Comenzar transacción

        $talleresID = array();
        foreach ($talleres as $taller) {
            $talleresID[] = $this->db->select('tallerId')->from('tallerhorario')->where('tallerhorario_id', $taller)->get()->row()->tallerId;
        }

        if (($talleresID[0] == $talleresID[1]) || ($talleresID[2] == $talleresID[3])) {
            return "repetido";
        }

        $data = array(
            'pasaporte' => $this->pasarMayusculas($pasaporte),
            'nombre' => $this->pasarMayusculas($nombre),
            'apellido' => $this->pasarMayusculas($apellidos),
            'paisId' => $pais,
            'correo' => $this->pasarMayusculas($correo)
        );
        $this->db->insert('persona', $data);

        foreach ($talleres as $taller) {
            $this->db->insert('talleresinscritos', array('pasaporte' => $this->pasarMayusculas($pasaporte), 'tallerhorario_id' => $taller));
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {//Guardar error en el log
            log_message('ERROR', 'EL ERROR EN LA BD ES: ' . $this->db->_error_message());
            log_message('ERROR', 'pasaporte = ' . $pasaporte);
            log_message('ERROR', 'nombre = ' . $nombre);
            log_message('ERROR', 'apellidos= ' . $apellidos);
            log_message('ERROR', 'pais= ' . $pais);
            log_message('ERROR', 'taller1= ' . $talleres[0]);
            log_message('ERROR', 'taller2= ' . $talleres[1]);
            log_message('ERROR', 'taller3= ' . $talleres[2]);
            log_message('ERROR', 'taller4= ' . $talleres[3]);

//            show_error('Error al guardar el registro. Por favor, contacte al administrador a hecontreraso@gmail.com e informe del error');
            return "yainscrito";
        } else {
            return "exito";
        }
    }

    function pasarMayusculas($cadena) {
        $cadena = strtoupper($cadena);
        $cadena = str_replace("á", "Á", $cadena);
        $cadena = str_replace("é", "É", $cadena);
        $cadena = str_replace("í", "Í", $cadena);
        $cadena = str_replace("ó", "Ó", $cadena);
        $cadena = str_replace("ú", "Ú", $cadena);
        $cadena = str_replace("ñ", "Ñ", $cadena);
        return ($cadena);
    }

    function obtenerDatosPDFIndividual($pasaporte) {

        $datos = array();

        $query = $this->db->select('nombre, apellido, pais')->from('inscripciones')->where(array('pasaporte' => $pasaporte))->get();
        $row = $query->result_array();
        
        if(count($row) == 0){
            return false;
        }


        $nombre = $row[0]['nombre'];
        $nombre = $nombre . " " . $row[0]['apellido'];
        $pais = $row[0]['pais'];
        $datos['nombre'] = $nombre;
        $datos['pais'] = $pais;

        $talleres = array();

        for ($horario = 1; $horario <= 4; $horario++) {
            $tallerActual = array();

            $query = $this->db->select('taller')->from('inscripciones')->where(array('pasaporte' => $pasaporte, 'horario' => $horario))->get();
            $row = $query->result_array();
            $tallerId = $row[0]['Taller'];

            $query = $this->db->select('nombre')->from('taller_nombre')->where(array('tallerID' => $tallerId))->get();
            $nombres = array();
            foreach ($query->result() as $row) {
                array_push($nombres, $row->nombre);
            }
            $tallerActual['nombres'] = $nombres;

            $query = $this->db->select('tallerista, ubicacion')->from('taller')->where(array('tallerID' => $tallerId))->get();
            $row = $query->row_array();
            $tallerActual['tallerista'] = $row['tallerista'];
            $tallerActual['ubicacion'] = $row['ubicacion'];

            array_push($talleres, $tallerActual);
        }

        $datos['talleres'] = $talleres;

        return $datos;
    }

    function obtenerTodosLosPasaportes() {
        $query = $this->db->select('pasaporte')->from('persona')->order_by("pasaporte", "asc")->get();
        $pasaportes = array();
        foreach ($query->result() as $row)
        {
            $pasaportes[] = $row->pasaporte;
        }
        return $pasaportes;
    }

}
