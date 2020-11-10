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

    // GET : SELECT
    function index_get(){
        $this->response($this->DAO->getUsers(),200);
    } 

    // POST : INSERT
    function index_post(){
        $this->DAO->insertUsers($this->post());
        $this->response($this->post(),201);
    }

    // PUT : UPDATE
    function index_put(){
        $this->DAO->updateUsers($this->post(),$this->put('email_user'));
        $this->response($this->put(),200);
    }

    // DELETE : DELETE/ UPDATE DELET LOGIC
    function index_delete(){
        $this->DAO->deleteUsers($this->delete('email_user'));
        $this->response($this->delete(),200);
    }
}