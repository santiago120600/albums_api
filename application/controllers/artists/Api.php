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

    public function artists_get()
    {
        if ($this->get('pid')) {
            $result = $this->DAO->selectEntity('artists', array('artist_id' => $this->get('pid')), true);
        } else {
            $result = $this->DAO->selectEntity('artists');
        }
        $response = array(
            "status" => 200,
            "status_text" => "success",
            "api" => "artists/api/artists",
            "method" => "GET",
            "message" => "Listado de generos",
            "data" => $result,
        );
        $this->response($response, 200);
    }

    public function artists_post()
    {

        $this->form_validation->set_data($this->post());
        $this->form_validation->set_rules('pName', 'Nombre', 'required');
        if ($this->form_validation->run()) {
            // guardar
            $data = array(
                "artist_name" => $this->post('pName'),
            );
            $this->DAO->saveOrUpdate('artists', $data);

            $response = array(
                "status" => 200,
                "status_text" => "succes",
                "api" => "artists/api/artists",
                "method" => "POST",
                "message" => "Registro correcto",
                "data" => null,
            );
        } else {
            // error
            $response = array(
                "status" => 500,
                "status_text" => "error",
                "api" => "artists/api/artists",
                "method" => "POST",
                "message" => "Error al registrar el artista",
                "errors" => $this->form_validation->error_array(),
                "data" => null,
            );
        }
        $this->response($response, 200);
    }

    public function artists_put()
    {
        if ($this->get('pid')) {
            $artist_exists = $this->DAO->selectEntity('artists', array('artist_id' => $this->get('pid')), true);
            if ($artist_exists) {
                $this->form_validation->set_data($this->put());
                $this->form_validation->set_rules('pName', 'Nombre', 'required');
                if ($this->form_validation->run()) {
                    $data = array(
                        "artist_name" => $this->post('pName'),
                    );
                    $this->DAO->saveOrUpdate('artists', $data, array('artist_id' => $this->post('pid')));

                    $response = array(
                        "status" => 200,
                        "status_text" => "succes",
                        "api" => "artists/api/artists",
                        "method" => "PUT",
                        "message" => "artista actualizado correctamente",
                        "data" => null,
                    );
                } else {
                    $response = array(
                        "status" => 500,
                        "status_text" => "error",
                        "api" => "artists/api/artists",
                        "method" => "PUT",
                        "message" => "Error al actualizar el artista",
                        "errors" => $this->form_validation->error_array(),
                        "data" => null,
                    );
                }

            } else {
                $response = array(
                    "status" => 404,
                    "status_text" => "error",
                    "api" => "artists/api/artists",
                    "method" => "PUT",
                    "message" => "Artista no localizado",
                    "errors" => array(),
                    "data" => null,
                );
            }
        } else {
            $response = array(
                "status" => 404,
                "status_text" => "error",
                "api" => "artists/api/artists",
                "method" => "PUT",
                "message" => "Identificador no localizado, La clave de artista no fue enviada",
                "errors" => array(),
                "data" => null,
            );
        }
        $this->response($response, 200);
    }

    public function artists_delete()
    {
        if ($this->get('pid')) {
            $artist_exists = $this->DAO->selectEntity('artists', array('artist_id' => $this->get('pid')), true);
            if ($artist_exists) {
                $this->DAO->deleteItemEntity('artists', array('artist_id' => $this->get('pid')));
            } else {
                $response = array(
                    "status" => 404,
                    "status_text" => "error",
                    "api" => "artists/api/artists",
                    "method" => "DELETE",
                    "message" => "Artista no localizado",
                    "errors" => array(),
                    "data" => null,
                );
                $response = array(
                    "status" => 200,
                    "status_text" => "succes",
                    "api" => "artists/api/artists",
                    "method" => "DELETE",
                    "message" => "Artista borrado correctamente",
                    "data" => null,
                );
            }
        } else {
            $response = array(
                "status" => 404,
                "status_text" => "error",
                "api" => "artists/api/artists",
                "method" => "DELETE",
                "message" => "Identificador no localizado, La clave de artista no fue enviada",
                "errors" => array(),
                "data" => null,
            );
        }
    }

}
