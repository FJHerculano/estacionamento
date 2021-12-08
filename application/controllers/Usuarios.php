$this->load->view('layout/footer');
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {
	// Metodo index que carrega na view usuarios a pagina e ja lista 
	// todos os users 
	public function index()
	{

		$data = array(
			// titulo e subtitulo das paginas da aplicação 
			'titulo' => 'Usuários Cadastrados',
			'sub_titulo' => 'Listando todos os usuários cadastrados',

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
			'usuarios' => $this->ion_auth->users()->result(),
		);

		// Para ver o que a biblioteca ion_auth traz de opções para nosso 
		// autenticação
		// echo '<pre>';
		// print_r($data['usuarios']);
		// exit();

		$this->load->view('layout/header', $data);
		$this->load->view('usuarios/index');
		$this->load->view('layout/footer');
        
	}

	// Cadastrando e Editando usuarios  
	public function core( $usuario_id = NULL ){

		if(!$usuario_id){
			// se usuario não existe cadastra um usuario
			exit('pode cadastrar um novo usuario');
		}else{
			// Edita o usuario 
			// verifica se o user existe (usando o ion_auth)
			if (!$this->ion_auth->user($usuario_id)->row()){
				exit('Usuario não existe');
			} else {
				// Se entrou no else, é por que existe e vai ser editado

				// Validação de campos                                
				$this->form_validation->set_rules('first_name','Nome','trim|required|min_length[5]|max_length[20]');
				$this->form_validation->set_rules('last_name','Sobrenome','trim|required|min_length[5]|max_length[20]');
				$this->form_validation->set_rules('username','Usuario','trim|required|min_length[5]|max_length[30]|callback_username_check');
				$this->form_validation->set_rules('email','E-mail','trim|valid_email|required|min_length[5]|max_length[200]|callback_email_check');
				$this->form_validation->set_rules('password', 'Senha','trim|min_length[8]');
				$this->form_validation->set_rules('confirmacao','Confirmação','trim|matches[password]');


				if($this->form_validation->run()){

					echo '<pre>';
					print_r($this->input->post());
					exit();
				
				}else{
					// Erro de validação
					$data = array(
						// titulo e subtitulo das paginas da aplicação 
						'titulo' => 'Editar Usuario',
						'sub_titulo' => 'Chegou a hora de ditar o usuário',
						'icone_view' => 'ik ik-user',
						// listagem de usuarios usando a biblioteca ion_auth
						'usuario' => $this->ion_auth->user($usuario_id)->row(),
						//
						'perfil_usuario' => $this->ion_auth->get_users_groups($usuario_id)->row()
					);
	
					//Para ver o que a biblioteca ion_auth traz de opções para nosso 
					//autenticação
					// echo '<pre>';
					// print_r($data['perfil_usuario']);
					// exit();
	
					$this->load->view('layout/header', $data);
					$this->load->view('usuarios/core');
					$this->load->view('layout/footer');
			
				}
				
			}
		}

	}

	// Função de verificação de username unico, para poder fazer edição e 
	// a regra de verificar se é unico no banco ser apenas para o cadastro
	public function username_check($username){

		$usuario_id = $this->input->post('usuario_id');
		
		// O meu "se" pega dois parametros que é requisitado na função get_by_id
		// no arquivo core_model, e eles são 1° a tabela a ser alterada, 2° o array 
		// de elementos que será trabalhada nesta função em especifico
		// IMPORTANTE, o array verifica se o campo 'username' e o campo 'id' são iguais para poder dar certo
		if($this->core_model->get_by_id('users', array('username' => $username, 'id !=' => $usuario_id))){
			 $this->form_validation->set_message('username_check', 'Esse usuario ja existe');
			return FALSE;
		}else{
			return TRUE;
		}

	}


	// Função de verificação de username unico, para poder fazer edição e 
	// a regra de verificar se é unico no banco ser apenas para o cadastro
	public function email_check($email){

		$usuario_id = $this->input->post('usuario_id');
		
		// O meu "se" pega dois parametros que é requisitado na função get_by_id
		// no arquivo core_model, e eles são 1° a tabela a ser alterada, 2° o array 
		// de elementos que será trabalhada nesta função em especifico
		// IMPORTANTE, o array verifica se o campo 'username' e o campo 'id' são iguais para poder dar certo
		if($this->core_model->get_by_id('users', array('email' => $email, 'id !=' => $usuario_id))){
			 $this->form_validation->set_message('email_check', 'Esse E-mail ja existe');
			return FALSE;
		}else{
			return TRUE;
		}

	}
}
