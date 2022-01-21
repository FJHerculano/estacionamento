<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estacionar extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		
		//Verifica se esta logado e redireciona 
		if(!$this->ion_auth->logged_in()){
			redirect('login');
		}

        // model para fazer join com precificação e mensalistas
        $this->load->model('estacionar_model');
	}
	
	// Metodo index que carrega a view e ja lista todos 
	public function index(){

		$data = array(
			// titulo e subtitulo das paginas da aplicação 
			'titulo' => 'Tickets de estacionamento cadastrados ',
			'sub_titulo' => 'Listando todos os tickets cadastrados',
			'icone_view' => 'fas fa-parking',

			// estilos da aplicação sendo carregados, usando Bootstrap 4
			'styles' => array (
				'plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css',
			),

			// scripts usados na aplicação
			'scripts' => array(
				'plugins/datatables.net/js/jquery.dataTables.min.js',
				'plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js',
				'plugins/datatables.net/js/estacionamento.js',
			),

			// listagem usando a biblioteca ion_auth
			'estacionados' => $this->estacionar_model->get_all(),
		);

		// Para ver o que a biblioteca ion_auth traz de opções para nosso 
		// autenticação
		// echo '<pre>';
		// print_r($data['estacionados']);
		// exit();

		$this->load->view('layout/header', $data);
		$this->load->view('estacionar/index');
		$this->load->view('layout/footer');
        
	}

    public function core($estacionar_id = NULL){

        if(!$estacionar_id){
            //cadastrando
        }else{
            //Encerrando um ticket
            
            //Verificação de existencia 
            if(!$this->core_model->get_by_id('estacionar', array('estacionar_id' => $estacionar_id))){
            
                $this->session->set_flashdata('error', 'Ticket não encontrado para encerramento');
                redirect($this->router->fetch_class());
            
            }else{
            // Encerramento de um ticket 


                $data = array(
                    // titulo e subtitulo das paginas da aplicação 
                    'titulo' => 'Encerrando o ticket',
                    'sub_titulo' => 'Chegou a hora de encerrar um ticket cadastrado',
                    'icone_view' => 'fas fa-parking',
                    'texto_modal'=> 'Tem certeza que deseja encerrar esse ticket',
                    
                    'scripts' => array(
                        'plugins/mask/jquery.mask.min.js',
                        'plugins/mask/custom.js',
                        'js/estacionar/estacionar.js'
                    ),

                    // listagem usando a biblioteca ion_auth
                    'estacionado' => $this->core_model->get_by_id('estacionar', array('estacionar_id' => $estacionar_id)),
                    'precificacoes' => $this->core_model->get_all('precificacoes', array('precificacao_ativa' => 1 )),
                    'formas_pagamentos' => $this->core_model->get_all('formas_pagamentos', array('forma_pagamento_ativa' => 1 )),

                );

                // Para ver o que a biblioteca ion_auth traz de opções para nosso 
                // autenticação
                // echo '<pre>';
                // print_r($data['estacionados']);
                // exit();

                $this->load->view('layout/header', $data);
                $this->load->view('estacionar/core');
                $this->load->view('layout/footer');

            }
        }

        
	}

}