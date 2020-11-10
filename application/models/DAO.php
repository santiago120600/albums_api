<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class DAO extends CI_Model{

    function __construct(){
        parent::__construct();
    }

    function getUsers(){
        $query = $this->db->get('tb_users');
        return $query->result();
    }

    function insertUsers($data){
        $query = $this->db->insert('tb_users',$data);
    }

    function updateUsers($data,$email){
        $this->db->where('email_users',$email);
        $query = $this->db->update('tb_users',$data);
    }

    function deleteUsers($email){
        $this->db->where('email_users',$email);
        $query = $this->db->delete('tb_users');
    }

    

}