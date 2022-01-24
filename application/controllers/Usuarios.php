<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		
		//Verifica se esta logado e redireciona 
		if(!$this->ion_auth->logged_in()){
			redirect('login');
		}
	}
	
	// Metodo index que carrega na view usuarios a pagina e ja lista 
	// todos os users 
	public function index()
	{


		if(!$this->ion_auth->is_admin()){
			$this->session->set_flashdata('info', 'Você não tem permissão para acessar esse Menu');
			redirect('/');
		}

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

			// esse if refere-se ao controle de usuarios
			if(!$this->ion_auth->is_admin()) {
				$this->session->set_flashdata('info', 'Você não tem permissão para acessar esse menu');
				redirect('/');
			}
			
			// Validação de campos                                
			$this->form_validation->set_rules('first_name','Nome','trim|required|min_length[3]|max_length[20]');
			$this->form_validation->set_rules('last_name','Sobrenome','trim|required|min_length[3]|max_length[20]');
			$this->form_validation->set_rules('username','Usuario','trim|required|min_length[4]|max_length[30]|is_unique[users.username]');
			$this->form_validation->set_rules('email','E-mail','trim|valid_email|required|min_length[5]|max_length[200]|is_unique[users.email]');
			$this->form_validation->set_rules('password', 'Senha','trim|required|min_length[8]');
			$this->form_validation->set_rules('confirmacao','Confirmação','trim|required|matches[password]');

			if($this->form_validation->run()){

				// HTML_escape para sanitizar 
				$username = html_escape($this->input->post('username'));
				$password =  html_escape($this->input->post('password'));
				$email =  html_escape($this->input->post('email'));

				$aditional_data = array(
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'active' => $this->input->post('active'),
				);

				$group = array($this->input->post('perfil')); 

				// sanitiza array 
				$aditional_data = html_escape($aditional_data);

				if($this->ion_auth->register($username, $password, $email, $aditional_data, $group)){
					$this->session->set_flashdata('sucesso', 'Dados salvos com sucesso!');
				}else{
					$this->session->set_flashdata('error', 'Erro ao salvar os dados!');
				}

				redirect($this->router->fetch_class());

			}else{

				//Erro de validação
				$data = array(
					// titulo e subtitulo das paginas da aplicação 
					'titulo' => 'Cadastrar Usuario',
					'sub_titulo' => 'Chegou a hora de cadastrar um novo usuário',
					'icone_view' => 'ik ik-user',
					//
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

		}else{
			// Edita o usuario 
			// verifica se o user existe (usando o ion_auth)
			if (!$this->ion_auth->user($usuario_id)->row()){
				exit('Usuario não existe');
			} else {
				// Se entrou no else, é por que existe e vai ser editado

				// esse if refere-se ao controle de usuarios
				if($this->session->userdata('user_id') != $usuario_id && !$this->ion_auth->is_admin()) {
					$this->session->set_flashdata('error', 'Você não tem permissão para editar um usuario cadastrado');
					redirect('/');
				}

				$perfil_atual = $this->ion_auth->get_users_groups($usuario_id)->row();

				// Validação de campos                                
				$this->form_validation->set_rules('first_name','Nome','trim|required|min_length[3]|max_length[20]');
				$this->form_validation->set_rules('last_name','Sobrenome','trim|required|min_length[3]|max_length[20]');
				$this->form_validation->set_rules('username','Usuario','trim|required|min_length[4]|max_length[30]|callback_username_check');
				$this->form_validation->set_rules('email','E-mail','trim|valid_email|required|min_length[5]|max_length[200]|callback_email_check');
				$this->form_validation->set_rules('password', 'Senha','trim|min_length[8]');
				$this->form_validation->set_rules('confirmacao','Confirmação','trim|matches[password]');


				if($this->form_validation->run()){

				// array com dados do meu user
				$data = elements(
					array(
						'first_name',
						'last_name',
						'username',
						'email',
						'password',
						'active',
					), $this->input->post()
				);


				// esse if refere-se ao controle de usuarios
				if(!$this->ion_auth->is_admin()) {
					unset($data['active']);
				}

				$password = $this->input->post('password');

				// não atualiza a senha 
				if(!$password){
					unset($data['password']);
				}

				
				// Sanitizar array

				$data = html_escape($data);
				
				/*
				echo '<pre>'
				print_r($perfil_atual);
				exit();
				*/

				if($this->ion_auth->update($usuario_id, $data)){

					$perfil_post = $this->input->post('perfil');

					//se foi passado o 'perfil',então éadmin
					if($perfil_post){

						//se for diferente atualiza o grupo
						if($perfil_atual->id != $perfil_post){

							$this->ion_auth->remove_from_group($perfil_atual->id, $usuario_id);
							$this->ion_auth->add_to_group($perfil_post, $usuario_id); 

						}

					}
					 
					$this->session->set_flashdata('sucesso', 'Dados atualizados com sucesso');

				}else{

					$this->session->set_flashdata('error', 'Não foi possivel atualizar os dados');

				}

				if(!$this->ion_auth->is_admin()){
					redirect('/');
				}else{
					redirect($this->router->fetch_class());
				}


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

	public function del($usuario_id = NULL){
		
		// esse if refere-se ao controle de usuarios
		if(!$this->ion_auth->is_admin()) {
			$this->session->set_flashdata('error', 'Você não tem permissão para excluir um usuario cadastrado');
			redirect('/');
		}

		// Verificando se o id do usuario existe 
		if(!$usuario_id || !$this->core_model->get_by_id('users', array('id' => $usuario_id))){

			$this->session->set_flashdata('error', 'Usuario não encontrado');
			redirect($this->router->fetch_class());
			
		}else {
			// Evitando a exclusão de Administrador

			if($this->ion_auth->is_admin($usuario_id)){
				
				$this->session->set_flashdata('error', 'Administrador não pode ser DELETADO!');
				redirect($this->router->fetch_class());
			
			}

			if($this->ion_auth->delete_user($usuario_id)){
				$this->session->set_flashdata('sucesso', 'Usuario foi deletado');
			}else{
				$this->session->set_flashdata('error', 'Não foi possivel concluir a exclusão');
			}

			redirect($this->router->fetch_class());

		}
	}
}
