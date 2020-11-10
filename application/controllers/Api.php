<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;
require APPPATH.'libraries/REST_Controller.php';
require APPPATH.'libraries/Format.php';

class Api extends REST_Controller{

    function __construct(){
        parent::__construct();
    }

    public function demo_get(){
        $users = array(
            array(
                "nombre" =>"Pedro",
                "carrera" =>"sw"
            ),
            array(
                "nombre" =>"Luisa",
                "carrera" =>"sw"
            )
        );
        $this->response($users,200);
    }
    
    public function demo_post(){
        $this->response($this->post(),200);
    }
    
    public function demo_put(){
        $this->response($this->post(),200);
    }
    
    public function demo_delete(){
        $this->response($this->get(),200);
    }
}

