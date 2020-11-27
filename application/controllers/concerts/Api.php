<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Api extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('DAO');
    }

    public function concerts_get()
    {
        if ($this->get('pid')) {
            $result = $this->DAO->selectEntity('concerts_view', array('concert_id' => $this->get('pid')), true);
        } else {
            $result = $this->DAO->selectEntity('concerts_view');
        }
        $response = array(
            "status" => 200,
            "status_text" => "success",
            "api" => "concerts/api/concerts",
            "method" => "GET",
            "message" => "Listado de conciertos",
            "data" => $result,
        );
        $this->response($response, 200);
    }

    public function concerts_post()
    {
        $this->form_validation->set_data($this->post());

        $this->form_validation->set_rules('pTitle', 'Titulo del concierto', 'required|max_length[180]');
        $this->form_validation->set_rules('pPlace', 'Lugar del concierto', 'required|max_length[60]');
        $this->form_validation->set_rules('pDate', 'Fecha del concierto', 'required');
        $this->form_validation->set_rules('pArtists', 'Clave del artista', 'required|callback_valid_artist');
        if ($this->form_validation->run()) {
            $data = array(
                'concert_place' => $this->post('pPlace'),
                'concert_date' => $this->post('pDate'),
                'artist_fk' => $this->post('pArtists'),
                'concert_title' => $this->post('pTitle')
            );
            $this->DAO->saveOrUpdate('concerts', $data);
            $response = array(
                "status" => 200,
                "status_text" => "success",
                "api" => "concerts/api/concerts",
                "method" => "POST",
                "message" => "Registro correcto",
                "data" => null,
            );

        } else {
            $response = array(
                "status" => 500,
                "status_text" => "error",
                "api" => "concerts/api/concerts",
                "method" => "POST",
                "message" => "Error al registrar el concierto",
                "errors" => $this->form_validation->error_array(),
                "data" => null,
            );
        }
        $this->response($response, 200);
    }

    public function valid_artist($value)
    {
        if ($value) {
            $artist_exists = $this->DAO->selectEntity('artists', array('artist_id' => $value), true);
            if ($artist_exists) {
                return true;
            } else {
                $this->form_validation->set_message('valid_artist', 'La clave del campo {field} no es correcto');
                return false;
            }
        } else {
            $this->form_validation->set_message('valid_artist', 'El campo {field} es requerido');
            return false;
        }
    }


}
