<!-- 
    AUTOR: Jhony Lara
    DATA: 13/03/2019
    https://www.linkedin.com/in/jhonylara/
    "Sempre achei que o tempo não passava, hoje me arrependo de o tempo ter passado." 
-->
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH.'libraries/REST_Controller.php');
use Restserver\Libraries\REST_Controller;
require APPPATH . 'libraries/Format.php';

class Api extends REST_Controller{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('usuario_model');
    }
    
    //Retorna todos os usuarios
    //Usei post para passar a chave
    function autenticacao_post(){

        if($this->post('chave') != 'jhony12ed21d1t14'){
            $this->response('Sem permissão', 401); 
        } 
        
        $usuario = $this->usuario_model->autenticacao($this->post('username'), md5($this->post('senha')));

        if($usuario){
            $this->response($usuario, 200); 
        } 
        else{
            $this->response("erroauth", 200);
        }
    }

    //Retorna todos os usuarios
    //Usei post para passar a chave
    function usuarios_post(){

        if($this->post('chave') != 'jhony12ed21d1t14'){
            $this->response('Sem permissão', 401); 
        } 
        
        $usuarios = $this->usuario_model->getTodosUsuarios();

        //Ocultar dados se não for usuario ou admin
        $oculto;
        if($this->post('logado') != 'user' && $this->post('logado') != 'admin'){
            foreach($usuarios as $chave => $usuario){
                $oculto[$chave]['email'] = preg_replace("/(?<=.).(?=.*@)/", "*", $usuario['email']);
                $oculto[$chave]['nome'] = preg_replace("/(?!^).(?!$)/", "*", $usuario['nome']);
                $oculto[$chave]['username'] = preg_replace("/(?!^).(?!$)/", "*", $usuario['username']);
                $oculto[$chave]['data_criacao'] = preg_replace("/(?!^).(?!$)/", "*", $usuario['data_criacao']);
            }
            $usuarios = $oculto;
        }
        if($usuarios){
            $this->response($usuarios, 200); 
        } 
        else{
            $this->response("Nenhum usuario cadastrado", 404);
        }
    }

    //Retorna usuarios por nome
    //Usei post para passar a chave
    function buscaUsuarios_post(){

        if($this->post('chave') != 'jhony12ed21d1t14'){
            $this->response('Sem permissão', 401); 
        } 

        //Ocultar dados se não for usuario ou admin
        $usuarios = $this->usuario_model->getUsuarioPorNomeOuID($this->post('pesquisa'), $this->post('pesquisa'));
        $oculto;
        if($this->post('logado') != 'user' && $this->post('logado') != 'admin'){
            foreach($usuarios as $chave => $usuario){
                $oculto[$chave]['id'] = $usuario['id'];
                $oculto[$chave]['email'] = preg_replace("/(?<=.).(?=.*@)/", "*", $usuario['email']);
                $oculto[$chave]['nome'] = preg_replace("/(?!^).(?!$)/", "*", $usuario['nome']);
                $oculto[$chave]['username'] = preg_replace("/(?!^).(?!$)/", "*", $usuario['username']);
                $oculto[$chave]['data_criacao'] = preg_replace("/(?!^).(?!$)/", "*", $usuario['data_criacao']);
            }
            $usuarios = $oculto;
        }
        if($usuarios){
            $this->response($usuarios, 200); 
        } 
        else{
            $this->response("Nenhum usuario cadastrado", 404);
        }
    }
     
    //Criar usuario
    function adicionarUsuario_post(){
        if($this->post('chave') != 'jhony12ed21d1t14'){
            $this->response('Sem permissão', 401); 
        } 

        $email = $this->post('email');
        $username = $this->post('username');
        $nome = $this->post('nome');
        $senha = md5($this->post('senha'));
        $data_criacao = date('Y-m-d H:i:s');
        if(!$email || !$username || !$nome || !$senha || !$data_criacao){
                $this->response("Preencha todos os campos", 400);
        }else{
            $usuario = $this->usuario_model->adicionar(array("email"=>$email, "username"=>$username, "nome"=>$nome, "senha"=>$senha, "data_criacao"=>$data_criacao));
            if($usuario === 0){
                $this->response("O usuario informado não pode ser cadastrado", 404);
            }else{
                $this->response("Sucesso", 200);  
           
            }
        }
    }
    
    //Alterar usuario
    //Usei post porque o axios não funcionou com put
    function alterarUsuario_post(){
        if($this->post('chave') != 'jhony12ed21d1t14'){
            $this->response('Sem permissão', 401); 
        } 

        $id = $this->post('id');
        $email = $this->post('email');
        $username = $this->post('username');
        $nome = $this->post('nome');
        $senha = md5($this->post('senha'));
        $data_criacao = date('Y-m-d H:i:s');
        if(!$id || !$email || !$username || !$nome || !$senha){
            $this->response("Preencha todos os campos", 400);
        }else{
            $usuario = $this->usuario_model->alterar($id, array("email"=>$email, "username"=>$username, "nome"=>$nome, "senha"=>$senha));
            if($usuario === 0){
                $this->response("O usuario informado não pode ser alterado", 404);
            }else{
                $this->response("Sucesso", 200);  
            }
        }
    }
    //Deletar usuario
    //Usei post porque o axios não funcionou com delete
    function deletarUsuario_post(){
        if($this->post('chave') != 'jhony12ed21d1t14'){
            $this->response('Sem permissão', 401); 
        } 

        $id = $this->post('id');
        if(!$id){
            $this->response("Falta um id", 404);
        }
         
        if($this->usuario_model->deletar($id)){
            $this->response("Sucesso", 200);
        } 
        else{
            $this->response("Erro", 400);
        }
    }
}