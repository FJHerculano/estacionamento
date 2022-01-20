<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mensalidades extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		
		//Verifica se esta logado e redireciona 
		if(!$this->ion_auth->logged_in()){
			redirect('login');
		}

        // model para fazer join com precificação e mensalistas
        $this->load->model('mensalidades_model');
	}
	
	// Metodo index que carrega a view e ja lista todos 
	public function index(){

		$data = array(
			// titulo e subtitulo das paginas da aplicação 
			'titulo' => 'Mensalidades Cadastradas',
			'sub_titulo' => 'Listando todas as mensalidades cadastradas',
			'icone_view' => 'fas fa-hand-holding-usd',

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
			'mensalidades' => $this->mensalidades_model->get_all(),
		);

		// Para ver o que a biblioteca ion_auth traz de opções para nosso 
		// autenticação
		// echo '<pre>';
		// print_r($data['mensalidades']);
		// exit();

		$this->load->view('layout/header', $data);
		$this->load->view('mensalidades/index');
		$this->load->view('layout/footer');
        
	}

    public function core($mensalidade_id = NULL){

        if(!$mensalidade_id){
            //Cadastrando

        }else{
            //Editando

            if(!$this->core_model->get_by_id('mensalidades', array('mensalidade_id' => $mensalidade_id))){
                $this->session->set_flashdata('error', 'Mensalidade não encontrada');
                redirect($this->router->fetch_class());
            }else{

                $this->form_validation->set_rules('mensalidade_precificacao_id', 'Categoria','required' );

                if($this->form_validation->run()){

                    $data = elements(
                        array(
                            'mensalidade_precificacao_id',
                            'mensalidade_valor_mensalidade',
                            'mensalidade_mensalista_dia_vencimento',
                            'mensalidade_status',
                        ), $this->input->post()
                    );

                    $data['mensalidade_mensalista_id'] = $this->input->post('mensalidade_mensalista_hidden_id');
                    $data['mensalidade_precificacao_id'] = $this->input->post('mensalidade_precificacao_hidden_id');

                    if($data['mensalidade_status'] == 1){

                        $data['mensalidade_data_pagamento'] = date('Y-m-d H:i:s');
                    }
                    
                    $data = html_escape($data);

                    $this->core_model->update('mensalidades', $data, array('mensalidade_id' => $mensalidade_id));
                    redirect($this->router->fetch_class());

                }else{
                    //Error de validação
                    $data = array(
                        // titulo e subtitulo das paginas da aplicação 
                        'titulo' => 'Editar Mensalidades',
                        'sub_titulo' => 'Editando uma mensalidade cadastrada',
                        'icone_view' => 'fas fa-hand-holding-usd',
                        'texto_modal' => 'Os dados estão corretos? </br></br> Depois de salva só sera possivel alterar a "categoria" e a "Situação"!',
    
                        // estilos da aplicação sendo carregados, usando Bootstrap 4
                        'styles' => array (
                            'plugins/select2/dist/css/select2.min.css',
                        ),
    
                        'scripts' => array(
                            'plugins/mask/jquery.mask.min.js',
                            'plugins/mask/custom.js',
                            'plugins/select2/dist/js/select2.min.js',
                            'js/mensalidades/mensalidades.js',
                        ),
    
                        'precificacoes' => $this->core_model->get_all('precificacoes', array('precificacao_ativa' => 1)),
                        'mensalistas' => $this->core_model->get_all('mensalistas', array('mensalista_ativo' => 1)),
    
                        // listagem usando a biblioteca ion_auth
                        'mensalidade' => $this->core_model->get_by_id('mensalidades', array('mensalidade_id' => $mensalidade_id)),
                    );
    
                    $this->load->view('layout/header', $data);
                    $this->load->view('mensalidades/core');
                    $this->load->view('layout/footer');

                }
            }

        }
        
	}
}
