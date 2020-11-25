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

    // http://localhost/codeigniter_api/index.php/genres/api/genres
    public function genres_get()
    {
        if ($this->get('pid')) {
            $result = $this->DAO->selectEntity('genre', array('genre_id' => $this->get('pid')), true);
        } else {
            $result = $this->DAO->selectEntity('genre');
        }
        $response = array(
            "status" => 200,
            "status_text" => "success",
            "api" => "genres/api/genres",
            "method" => "GET",
            "message" => "Listado de generos",
            "data" => $result,
        );
        $this->response($response, 200);
    }

    public function genres_post()
    {

        $this->form_validation->set_data($this->post());
        $this->form_validation->set_rules('pGenre', 'Genero', 'required|is_unique[genre.genre_name]');
        if ($this->form_validation->run()) {
            // guardar
            $data = array(
                "genre_name" => $this->post('pGenre'),
            );
            $this->DAO->saveOrUpdate('genre', $data);

            $response = array(
                "status" => 200,
                "status_text" => "succes",
                "api" => "genres/api/genres",
                "method" => "POST",
                "message" => "Registro correcto",
                "data" => null,
            );
        } else {
            // error
            $response = array(
                "status" => 500,
                "status_text" => "error",
                "api" => "genres/api/genres",
                "method" => "POST",
                "message" => "Error al registrar el genero",
                "errors" => $this->form_validation->error_array(),
                "data" => null,
            );
        }
        $this->response($response, 200);
    }

    // end point http://localhost/codeigniter_api/index.php/genres/api/genres/pid/1
    public function genres_put()
    {
        if ($this->get('pid')) {
            $genre_exists = $this->DAO->selectEntity('genre', array('genre_id' => $this->get('pid')), true);
            if ($genre_exists) {
                $this->form_validation->set_data($this->put());
                $this->form_validation->set_rules('pGenre', 'Genero', 'required|is_unique[genre.genre_name]');
                if ($this->form_validation->run()) {
                    // si valida
                    $data = array(
                        "genre_name" => $this->put('pGenre'),
                    );
                    $this->DAO->saveOrUpdate('genre', $data, array('genre_id' => $this->get('pid')));

                    $response = array(
                        "status" => 200,
                        "status_text" => "succes",
                        "api" => "genres/api/genres",
                        "method" => "PUT",
                        "message" => "Genero actualizado correctamente",
                        "data" => null,
                    );
                } else {
                    $response = array(
                        "status" => 500,
                        "status_text" => "error",
                        "api" => "genres/api/genres",
                        "method" => "PUT",
                        "message" => "Error al actualizar el genero",
                        "errors" => $this->form_validation->error_array(),
                        "data" => null,
                    );
                }

            } else {
                // si no existe
                $response = array(
                    "status" => 404,
                    "status_text" => "error",
                    "api" => "genres/api/genres",
                    "method" => "PUT",
                    "message" => "Genero no localizado",
                    "errors" => array(),
                    "data" => null,
                );
            }
        } else {
            // si no se manda el id
            $response = array(
                "status" => 404,
                "status_text" => "error",
                "api" => "genres/api/genres",
                "method" => "PUT",
                "message" => "Identificador no localizado, La clave de genero no fue enviada",
                "errors" => array(),
                "data" => null,
            );
        }
        $this->response($response, 200);
    }

    public function genres_delete()
    {
        if ($this->get('pid')) {
            $genre_exists = $this->DAO->selectEntity('genre', array('genre_id' => $this->get('pid')), true);
            if ($genre_exists) {
                $this->DAO->deleteItemEntity('genre',array('genre_id' => $this->get('pid')));
                $response = array(
                    "status" => 200,
                    "status_text" => "succes",
                    "api" => "genres/api/genres",
                    "method" => "DELETE",
                    "message" => "Genero borrado correctamente",
                    "data" => null,
                );
            }else{
                $response = array(
                    "status" => 404,
                    "status_text" => "error",
                    "api" => "genres/api/genres",
                    "method" => "DELETE",
                    "message" => "Genero no localizado",
                    "errors" => array(),
                    "data" => null,
                );
            }
        } else {
            $response = array(
                "status" => 404,
                "status_text" => "error",
                "api" => "genres/api/genres",
                "method" => "DELETE",
                "message" => "Identificador no localizado, La clave de genero no fue enviada",
                "errors" => array(),
                "data" => null,
            );
        }
        $this->response($response, 200);
    }

}
