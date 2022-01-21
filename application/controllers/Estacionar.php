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

}