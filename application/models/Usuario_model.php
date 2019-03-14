<!-- 
    AUTOR: Jhony Lara
    DATA: 13/03/2019
    https://www.linkedin.com/in/jhonylara/
    "Sempre achei que o tempo não passava, hoje me arrependo de o tempo ter passado." 
-->
<?php
    class Usuario_model extends CI_Model {
       
    public function __construct(){

        $this->load->database();

    }
    
    //Retorna se existe usuario
    public function getUsuarioPorID($id){  
        $this->db->select('id, email, username , nome, data_criacao');
        $this->db->from('Usuario');
        $this->db->where('id',$id);
        $query = $this->db->get();

        if($query->num_rows() == 1){
            return $query->result_array();
        }
        else{
            return 0;
        }
    }

    //Retorna se existe usuario
    public function autenticacao($username, $senha){  

        $this->db->select('username, nome');
        $this->db->from('Usuario');
        $this->db->where('username',$username);
        $this->db->where('senha',$senha);
        $query = $this->db->get();

        if($query->num_rows() == 1){
            return $query->row();
        }
        else{
            return 0;
        }
    }
    
    //Retorna todos usuarios
    public function getTodosUsuarios(){   
        $this->db->select('id, email, username , nome, data_criacao');
        $this->db->from('Usuario');
        $this->db->order_by("id", "desc"); 
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }
        else{
            return 0;
        }
    }

    //Retorna todos usuarios
    public function getUsuarioPorNomeOuID($username, $id){   
        $this->db->select('id, email, username , nome, data_criacao');
        $this->db->from('Usuario');
        $this->db->like('username',$username);
        $this->db->or_like('id',$id);
        $this->db->order_by("id", "desc"); 
        $query = $this->db->get();

        if($query->num_rows() > 0){
            return $query->result_array();
        }
        else{
            return 0;
        }
    }
   
   //Adiciona um novo usuario
    public function adicionar($dados){
        if($this->db->insert('Usuario', $dados)){
            return true;
        }
        else{
            return false;
        }
    }
    
    //Alterar um usuario
    public function alterar($id, $dados){
        $this->db->where('id', $id);
        if($this->db->update('Usuario', $dados)){
            return true;
        }
        else{
            return false;
        }
    }

   //Deletar por id
    public function deletar($id){
        $this->db->where('id', $id);
        if($this->db->delete('Usuario')){
            return true;
        }
        else{
            return false;
        }
   }
}