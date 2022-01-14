<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller{

    public function index(){
        
        $data = array(
            'titulo' => 'Login',
        );

        $this->load->view('layout/header', $data);
        $this->load->view('login/index');
        $this->load->view('layout/footer');
   
    }
    
    // usando a biblioteca ion_auth
    public function auth(){

        $identity = html_escape($this->input->post('email'));
        $password = html_escape($this->input->post('password'));
        $remember = FALSE; // REMEMBER THE USER

        if($this->ion_auth->login($identity, $password, $remember)){

            $usuario = $this->core_model->get_by_id('users', array('email' => $identity));

            $this->session->set_flashdata('sucesso', 'Sejá muito bem vindo(a)!'. '' .$usuario->first_name);
            redirect('/');

        }else{

            $this->session->set_flashdata('error', 'Verifique seu e-mail ou senha!');
            redirect($this->router->fetch_class());

        }
    }

    public function logout(){
        $this->ion_auth->logout();
        redirect($this->router->fetch_class());
    }
}