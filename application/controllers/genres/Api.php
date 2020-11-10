<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;
require APPPATH.'libraries/REST_Controller.php';
require APPPATH.'libraries/Format.php';

class Api extends REST_Controller{

    function __construct(){
        parent::__construct();
        $this->load->model('DAO');
    }

    // http://localhost/codeigniter_api/index.php/genres/api/genres
    function genres_get(){
        if ($this->get('pid')) {
            $result = $this->DAO->selectEntity('genre',array('genre_id'=>$this->get('pid')),TRUE);
        }else{
            $result = $this->DAO->selectEntity('genre');
        }
        $response = array(
            "status" => 200,
            "status_text" => "success",
            "api" => "genres/api/genres",
            "method" => "GET",
            "message" => "Listado de generos",
            "data" => $result
        );
        $this->response($response,200);
    }

    function genres_post(){

        $this->form_validation->set_data($this->post());
        $this->form_validation->set_rules('pGenre','Genero','required|is_unique[genre.genre_name]');
        if ($this->form_validation->run()) {
            // guardar
            $data = array(
                "genre_name" => $this->post('pGenre')
            );
            $this->DAO->saveOrUpdate('genre',$data);

            $response = array(
                "status" => 200,
                "status_text" => "succes",
                "api" => "genres/api/genres",
                "method" => "POST",
                "message" => "Registro correcto",
                "data" => null
            );
        }else{
            // error
            $response = array(
                "status" => 500,
                "status_text" => "error",
                "api" => "genres/api/genres",
                "method" => "POST",
                "message" => "Error al registrar el genero",
                "errors" => $this->form_validation->error_array(),
                "data" => null
            );
        }
        $this->response($response,200);
    }

}