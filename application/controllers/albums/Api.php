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

    function albums_get(){
        if ($this->get('pid')) {
            $result = $this->DAO->selectEntity('albums_view',array('album_id'=>$this->get('pid')),TRUE);
        }else{
            $result = $this->DAO->selectEntity('albums_view');
        }
        $response = array(
            "status" => 200,
            "status_text" => "success",
            "api" => "albums/api/albums",
            "method" => "GET",
            "message" => "Listado de albums",
            "data" => $result
        );
        $this->response($response,200);
    }

    function albums_post(){
        $this->form_validation->set_data($this->post());

        $this->form_validation->set_rules('pName','Nombre','required|min_length[3]|max_length[120]');
        $this->form_validation->set_rules('pDate','Fecha de nacimiento','required');
        $this->form_validation->set_rules('pTime','Hora de lanzamiento','required');
        $this->form_validation->set_rules('pArtists','Clave del artista','required|callback_valid_artist');
        $this->form_validation->set_rules('pGenre','Clave del genero','required|callback_valid_genre');
        if ($this->form_validation->run()) {
            $data = array(
                'album_name' => $this->post('pName'),
                'album_date_released' => $this->post('pDate'),
                'album_time_released' => $this->post('pTime'),
                'artist_fk' => $this->post('pArtists'),
                'genre_fk' => $this->post('pGenre')
            );
            $this->DAO->saveOrUpdate('albums',$data);
            $response = array(
                "status" => 200,
                "status_text" => "succes",
                "api" => "albums/api/albums",
                "method" => "POST",
                "message" => "Registro correcto",
                "data" => null
            );

        }else{
            $response = array(
                "status" => 500,
                "status_text" => "error",
                "api" => "albums/api/albums",
                "method" => "POST",
                "message" => "Error al registrar el album",
                "errors" => $this->form_validation->error_array(),
                "data" => null
            );
        }
        $this->response($response,200);
    }

    function valid_artist($value){
        if ($value) {
            $artist_exists = $this->DAO->selectEntity('artists',array('artist_id'=>$value),true);
            if ($artist_exists) {
                return true;
            }else{
                $this->form_validation->set_message('valid_artist','La clave del campo {field} no es correcto');
                return false;
            }
        }else{
            $this->form_validation->set_message('valid_artist','El campo {field} es requerido');
            return false;
        }
    }

    function valid_genre($value){
        if ($value) {
            $genre_exists = $this->DAO->selectEntity('genre',array('genre_id'=>$value),true);
            if ($genre_exists) {
                return true;
            }else{
                $this->form_validation->set_message('valid_genre','La clave del campo {field} no es correcto');
                return false;
            }
        }else{
            $this->form_validation->set_message('valid_genre','El campo {field} es requerido');
            return false;
        }
    }

}