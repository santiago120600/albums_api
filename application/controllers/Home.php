<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;
require APPPATH.'libraries/REST_Controller.php';
require APPPATH.'libraries/Format.php';

class Home extends REST_Controller{

    function __construct(){
        parent::__construct();
    }

    function index_get(){
        $message = array(
            "api_name " => "Albums",
            "api_desc" => "Api de comunicación del sitema de albums"
        );
        $this->response($message,200);
    }

}