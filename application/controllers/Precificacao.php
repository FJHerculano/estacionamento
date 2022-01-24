<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Precificacao extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		
		//Verifica se esta logado e redireciona 
		if(!$this->ion_auth->logged_in()){
			redirect('login');
		}

		if(!$this->ion_auth->is_admin()){
			$this->session->set_flashdata('info', 'Você não tem permissão para acessar esse Menu');
			redirect('/');
		}
	}
	
	// Metodo index que carrega na view usuarios a pagina e ja lista 
	// todos os users 
	public function index()
	{

		$data = array(
			// titulo e subtitulo das paginas da aplicação 
			'titulo' => 'Precificações cadastradas',
			'sub_titulo' => 'Listando todos as precificações',
            'icone_view' => 'fas fa-dollar-sign',


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

			// listagem de usuarios usando a biblioteca ion_auth
			'precificacoes' => $this->core_model->get_all('precificacoes'),
		);

		// Para ver o que a biblioteca ion_auth traz de opções para nosso 
		// autenticação
		// echo '<pre>';
		// print_r($data['precificacoes']);
		// exit();

		$this->load->view('layout/header', $data);
		$this->load->view('precificacoes/index');
		$this->load->view('layout/footer');
        
	}


	// Editando precificações, e criando
	public function core($precificacao_id = NULL)
	{
		// Verifica se não existe
		if(!$precificacao_id){
			// Cadastrando

			// Validação de campos input
			$this->form_validation->set_rules('precificacao_categoria', 'Categoria','trim|required|min_length[5]|max_length[30]|is_unique[precificacoes.precificacao_categoria]');
			$this->form_validation->set_rules('precificacao_valor_hora','Valor da hora','trim|required|max_length[50]');
			$this->form_validation->set_rules('precificacao_valor_mensalidade','Valor da mensalidade','trim|required|max_length[50]');
			$this->form_validation->set_rules('precificacao_numero_vagas','Numero de vagas','trim|required|integer|greater_than[0]');

			if($this->form_validation->run()){
			
			//sanitizando o html5
			$data = elements(
				array(
					'precificacao_categoria',
					'precificacao_valor_hora',
					'precificacao_valor_mensalidade',
					'precificacao_numero_vagas',
					'precificacao_ativa',
				), $this->input->post()
			);

			$data = html_escape($data);

			$this->core_model->insert('precificacoes', $data);
			redirect($this->router->fetch_class());

			}else{
				// Error de validação
				// se não existir mete bala
				$data = array(
					// titulo e subtitulo das paginas da aplicação 
					'titulo' => 'Cadastrar Precificação',
					'sub_titulo' => 'Cadastrando a precificações',
					'icone_view' => 'fas fa-dollar-sign',
		
					// scripts usados na aplicação
					'scripts' => array(
						'plugins/mask/jquery.mask.min.js',
						'plugins/mask/custom.js',
					),
				);
		
				$this->load->view('layout/header', $data);
				$this->load->view('precificacoes/core');
				$this->load->view('layout/footer');
			}



		}else{ 
			//Atualizando
			//verifica se existe
			if(!$this->core_model->get_by_id('precificacoes', array('precificacao_id' => $precificacao_id))){
				$this->session->set_flashdata('error', 'precificação não encontrada');
				redirect($this->router->fetch_class());
			}else{

			// Validação de campos input
			$this->form_validation->set_rules('precificacao_categoria', 'Categoria','trim|required|min_length[5]|max_length[30]|callback_check_categoria');
			$this->form_validation->set_rules('precificacao_valor_hora','Valor da hora','trim|required|max_length[50]');
			$this->form_validation->set_rules('precificacao_valor_mensalidade','Valor da mensalidade','trim|required|max_length[50]');
			$this->form_validation->set_rules('precificacao_numero_vagas','Numero de vagas','trim|required|integer|greater_than[0]');

			if($this->form_validation->run()){
				// recupera o valor atual da precificação, e verifica se tem algum automovel  estacionado
				// caso tenha não podera ser desativada 
				 $precificacao_ativa = $this->input->post('precificacao_ativa');
				// para verificação de estacionamento
				 if($precificacao_ativa == 0 ){

					if($this->db->table_exists('estacionar')){

						if($this->core_model->get_by_id('estacionar', array('estacionar_precificacao_id' => $precificacao_id, 'estacionar_status' => 0 ))){
							$this->session->set_flashdata('error', 'Esta categoria está sendo utilizada em <i class="fas fa-parking"></i> &nbsp;Estacionar'); 
							redirect($this->router->fetch_class());
						}

					}

				 }

				 // para verificação de mensalidade, e uma possivel desativação da mesma
				 if($precificacao_ativa == 0 ){

					if($this->db->table_exists('mensalidades')){

						if($this->core_model->get_by_id('mensalidades', array('mensalidade_precificacao_id' => $precificacao_id, 'mensalidade_status' => 0 ))){
							$this->session->set_flashdata('error', 'Esta categoria está sendo utilizada em <i class="fas fa-hand-holding-usd"></i> &nbsp; mensalidades '); 
							redirect($this->router->fetch_class());
						}

					}

				 }

			//sanitizando o html5
			$data = elements(
				array(
					'precificacao_categoria',
					'precificacao_valor_hora',
					'precificacao_valor_mensalidade',
					'precificacao_numero_vagas',
					'precificacao_ativa',
				), $this->input->post()
			);

			$data = html_escape($data);

			$this->core_model->update('precificacoes', $data, array('precificacao_id' => $precificacao_id));
			redirect($this->router->fetch_class());

			}else{
				// Error de validação
				// se não existir mete bala
				$data = array(
					// titulo e subtitulo das paginas da aplicação 
					'titulo' => 'Editar Precificação',
					'sub_titulo' => 'Editando a precificações',
					'icone_view' => 'fas fa-dollar-sign',
		
					// scripts usados na aplicação
					'scripts' => array(
						'plugins/mask/jquery.mask.min.js',
						'plugins/mask/custom.js',
					),
		
					'precificacao' => $this->core_model->get_by_id('precificacoes', array('precificacao_id' => $precificacao_id)),
				);
		
				$this->load->view('layout/header', $data);
				$this->load->view('precificacoes/core');
				$this->load->view('layout/footer');
			}

				
			}
		}
	}
	 
	public function check_categoria($precificacao_categoria){

		$precificacao_id = $this->input->post('precificacao_id');

		// No momento só imprime se o nome que for passado no input for diferente do que ja está presente,  obrigando o usuario a mudar o nome sempre que 
		// solicita uma atualização
		if($this->core_model->get_by_id('precificacoes', array('precificacao_categoria' => $precificacao_categoria, 'precificacao_id !=' => $precificacao_id ))){
			
			$this->form_validation->set_message('check_categoria', 'Esta categoria ja existe');

			return FALSE;

		}else{
			return TRUE;
		}

	}

	public function del($precificacao_id = NULL){
		
		if(!$this->core_model->get_by_id('precificacoes', array('precificacao_id' => $precificacao_id))){
			$this->session->set_flashdata('error', 'precificação não encontrada');
			redirect($this->router->fetch_class());
		}

		if($this->core_model->get_by_id('precificacoes', array('precificacao_id' => $precificacao_id, 'precificacao_ativa' => 1))){
			$this->session->set_flashdata('error', 'precificação atia não pode ser deletada');
			redirect($this->router->fetch_class());
		}

		$this->core_model->delete('precificacoes', array('precificacao_id' => $precificacao_id));
		redirect($this->router->fetch_class());

	}
}
