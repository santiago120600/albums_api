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

    function artists_get(){
        if ($this->get('pid')) {
            $result = $this->DAO->selectEntity('artists',array('artist_id'=>$this->get('pid')),TRUE);
        }else{
            $result = $this->DAO->selectEntity('artists');
        }
        $response = array(
            "status" => 200,
            "status_text" => "success",
            "api" => "artists/api/artists",
            "method" => "GET",
            "message" => "Listado de generos",
            "data" => $result
        );
        $this->response($response,200);
    }

    function artists_post(){

        $this->form_validation->set_data($this->post());
        $this->form_validation->set_rules('pName','Nombre','required');
        if ($this->form_validation->run()) {
            // guardar
            $data = array(
                "artist_name" => $this->post('pName')
            );
            $this->DAO->saveOrUpdate('artists',$data);

            $response = array(
                "status" => 200,
                "status_text" => "succes",
                "api" => "artists/api/artists",
                "method" => "POST",
                "message" => "Registro correcto",
                "data" => null
            );
        }else{
            // error
            $response = array(
                "status" => 500,
                "status_text" => "error",
                "api" => "artists/api/artists",
                "method" => "POST",
                "message" => "Error al registrar el artista",
                "errors" => $this->form_validation->error_array(),
                "data" => null
            );
        }
        $this->response($response,200);
    }

}