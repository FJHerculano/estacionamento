<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mensalistas extends CI_Controller {
	
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

		$data = array(
			// titulo e subtitulo das paginas da aplicação 
			'titulo' => 'Mensalistas Cadastrados',
			'sub_titulo' => 'Listando todos os mensalistas cadastrados',
			'icone_view' => 'fas fa-users',

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
			'mensalistas' => $this->core_model->get_all('mensalistas'),
		);

		// Para ver o que a biblioteca ion_auth traz de opções para nosso 
		// autenticação
		// echo '<pre>';
		// print_r($data['mensalistas']);
		// exit();

		$this->load->view('layout/header', $data);
		$this->load->view('mensalistas/index');
		$this->load->view('layout/footer');
        
	}

	//Metodo para editar e cadastrar novos mensalistas 
	public function core($mensalista_id = NULL)
	{

		if(!$mensalista_id){
			// cadastrando

			$this->form_validation->set_rules('mensalista_nome','Nome','trim|required|min_length[3]|max_length[20]');
			$this->form_validation->set_rules('mensalista_sobrenome','sobrenome','trim|required|min_length[3]|max_length[150]');
			$this->form_validation->set_rules('mensalista_data_nascimento','Data nascimento','required');
			$this->form_validation->set_rules('mensalista_cpf','CPF','trim|required|exact_length[14]|is_unique[mensalistas.mensalista_cpf]|callback_valida_cpf');
			$this->form_validation->set_rules('mensalista_rg','RG','trim|required|min_length[12]|max_length[20]|is_unique[mensalistas.mensalista_rg]');   
			$this->form_validation->set_rules('mensalista_email','Email','trim|required|valid_email|max_length[50]|is_unique[mensalistas.mensalista_email]');
			
			// Se o campo for input vazio não verifica se ja existe
			$mensalista_telefone_fixo = $this->input->post('mensalista_telefone_fixo');
			if(!empty($mensalidade_telefone_fixo)){
				$this->form_validation->set_rules('mensalista_telefone_fixo','Telefone','trim|exact_length[14]|callback_check_telefone_fixo|is_unique[mensalistas.mensalista_telefone_fixo]');
			}
			if(!empty($mensalidade_telefone_movel)){
				$this->form_validation->set_rules('mensalista_telefone_movel','Celular','trim|min_length[14]|max_length[15]|callback_check_telefone_movel|is_unique[mensalistas.mensalista_telefone_movel]');
			}
		
			$this->form_validation->set_rules('mensalista_cep','cep','trim|required|exact_length[9]');
			$this->form_validation->set_rules('mensalista_endereco','Endereço','trim|required|min_length[4]|max_length[150]');
			$this->form_validation->set_rules('mensalista_numero_endereco','Numero','trim|required|max_length[20]');
			$this->form_validation->set_rules('mensalista_bairro','Bairro','trim|required|min_length[4]|max_length[45]');
			$this->form_validation->set_rules('mensalista_cidade','Cidade','trim|required|min_length[3]|max_length[80]');
			$this->form_validation->set_rules('mensalista_estado','Estado','trim|required|exact_length[2]');
			$this->form_validation->set_rules('mensalista_complemento','Complemento','trim|max_length[145]');
			$this->form_validation->set_rules('mensalista_dia_vencimento','Dia vencimento','trim|integer|greater_than[0]|less_than[28],');
			$this->form_validation->set_rules('mensalista_observacao','Observação','trim|max_length[500]');

			if($this->form_validation->run()){
				
				$data = elements(

					array(

						'mensalista_nome',
						'mensalista_sobrenome',
						'mensalista_data_nascimento',
						'mensalista_cpf',
						'mensalista_rg',
						'mensalista_email',
						'mensalista_telefone_fixo',
						'mensalista_telefone_movel',
						'mensalista_cep',
						'mensalista_endereco',
						'mensalista_numero_endereco',
						'mensalista_bairro',
						'mensalista_cidade',
						'mensalista_estado',
						'mensalista_ativo',
						'mensalista_complemento',
						'mensalista_dia_vencimento',
						'mensalista_observacao',

					), $this->input->post()
				);

				// sempre estado terá letras maisculas
				$data['mensalista_estado'] = strtoupper($this->input->post('mensalista_estado'));

				$data = html_escape($data);

				$this->core_model->insert('mensalistas', $data);
				redirect($this->router->fetch_class());

			}else{
				//Error de validação
				$data = array(
					// titulo e subtitulo das paginas da aplicação 
					'titulo' => 'Cadastrar Mensalista',
					'sub_titulo' => 'cadastrando um novo mensalista',
					'icone_view' => 'fas fa-users',
		
					'scripts' => array(
						'plugins/mask/jquery.mask.min.js',
						'plugins/mask/custom.js',
					),
		
					// listagem de usuarios usando a biblioteca ion_auth
					'mensalista' => $this->core_model->get_by_id('mensalistas', array('mensalista_id' => $mensalista_id)),
				);
		
				// Para ver o que a biblioteca ion_auth traz de opções para nosso 
				// autenticação
				// echo '<pre>';
				// print_r($data['mensalista']);
				// exit();
		
				$this->load->view('layout/header', $data);
				$this->load->view('mensalistas/core');
				$this->load->view('layout/footer');
		   
			}
			
		}else{
			//Editando
			if(!$this->core_model->get_by_id('mensalistas', array('mensalista_id' => $mensalista_id))){
				$this->session->set_flashdata('error', 'mensalista não encontrado');
				redirect($this->router->fetch_class());
			}else{

				$this->form_validation->set_rules('mensalista_nome','Nome','trim|required|min_length[3]|max_length[20]');
				$this->form_validation->set_rules('mensalista_sobrenome','sobrenome','trim|required|min_length[3]|max_length[150]');
				$this->form_validation->set_rules('mensalista_data_nascimento','Data nascimento','required');
				$this->form_validation->set_rules('mensalista_cpf','CPF','trim|required|exact_length[14]|callback_valida_cpf');
				$this->form_validation->set_rules('mensalista_rg','RG','trim|required|min_length[12]|max_length[20]|callback_check_rg');   
				$this->form_validation->set_rules('mensalista_email','Email','trim|required|valid_email|max_length[50]|callback_check_email');
				
				// Se o campo for input vazio não verifica se ja existe
				$mensalista_telefone_fixo = $this->input->post('mensalista_telefone_fixo');
				if(!empty($mensalidade_telefone_fixo)){
					$this->form_validation->set_rules('mensalista_telefone_fixo','Telefone','trim|exact_length[14]|callback_check_telefone_fixo');
				}
				if(!empty($mensalidade_telefone_movel)){
					$this->form_validation->set_rules('mensalista_telefone_movel','Celular','trim|min_length[14]|max_length[15]|callback_check_telefone_movel');
				}
			
				$this->form_validation->set_rules('mensalista_cep','cep','trim|required|exact_length[9]');
				$this->form_validation->set_rules('mensalista_endereco','Endereço','trim|required|min_length[4]|max_length[150]');
				$this->form_validation->set_rules('mensalista_numero_endereco','Numero','trim|required|max_length[20]');
				$this->form_validation->set_rules('mensalista_bairro','Bairro','trim|required|min_length[4]|max_length[45]');
				$this->form_validation->set_rules('mensalista_cidade','Cidade','trim|required|min_length[3]|max_length[80]');
				$this->form_validation->set_rules('mensalista_estado','Estado','trim|required|exact_length[2]');
				$this->form_validation->set_rules('mensalista_complemento','Complemento','trim|max_length[145]');
				$this->form_validation->set_rules('mensalista_dia_vencimento','Dia vencimento','trim|integer|greater_than[0]|less_than[28],');
				$this->form_validation->set_rules('mensalista_observacao','Observação','trim|max_length[500]');

				if($this->form_validation->run()){

				// recupera o valor atual da mensalista, e verifica se tem algum 
				// caso tenha não podera ser desativada 
				$mensalista_ativo = $this->input->post('mensalista_ativo');

				if($mensalista_ativo == 0 ){

				   if($this->db->table_exists('mensalidades')){

					   if($this->core_model->get_by_id('mensalidades', array('mensalidade_mensalista_id' => $mensalista_id, 'mensalidade_status' => 0 ))){
						   $this->session->set_flashdata('error', 'Mensalista com debito pedente em <i class="fas fa-users"></i>&nbsp;mensalidades não poderá ser desativado'); 
						   redirect($this->router->fetch_class());
					   }

				   }

				}
					
					$data = elements(

						array(

							'mensalista_nome',
							'mensalista_sobrenome',
							'mensalista_data_nascimento',
							'mensalista_cpf',
							'mensalista_rg',
							'mensalista_email',
							'mensalista_telefone_fixo',
							'mensalista_telefone_movel',
							'mensalista_cep',
							'mensalista_endereco',
							'mensalista_numero_endereco',
							'mensalista_bairro',
							'mensalista_cidade',
							'mensalista_estado',
							'mensalista_ativo',
							'mensalista_complemento',
							'mensalista_dia_vencimento',
							'mensalista_observacao',

						), $this->input->post()
					);


					// sempre estado terá letras maisculas
					$data['mensalista_estado'] = strtoupper($this->input->post('mensalista_estado'));


					$data = html_escape($data);

					$this->core_model->update('mensalistas', $data, array('mensalista_id' => $mensalista_id));
					redirect($this->router->fetch_class());

				}else{
					//Error de validação
					$data = array(
						// titulo e subtitulo das paginas da aplicação 
						'titulo' => 'Editando Mensalista',
						'sub_titulo' => 'editando o  mensalista cadastrado',
						'icone_view' => 'fas fa-users',
			
						'scripts' => array(
							'plugins/mask/jquery.mask.min.js',
							'plugins/mask/custom.js',
						),
			
						// listagem de usuarios usando a biblioteca ion_auth
						'mensalista' => $this->core_model->get_by_id('mensalistas', array('mensalista_id' => $mensalista_id)),
					);
			
					// Para ver o que a biblioteca ion_auth traz de opções para nosso 
					// autenticação
					// echo '<pre>';
					// print_r($data['mensalista']);
					// exit();
			
					$this->load->view('layout/header', $data);
					$this->load->view('mensalistas/core');
					$this->load->view('layout/footer');
			   
				}
			}
		}

		     
	}

	// Pouco alterado, função em si é code da internet
	public function valida_cpf($cpf) {

        if ($this->input->post('mensalista_id')) {

            $mensalista_id = $this->input->post('mensalista_id');

            if ($this->core_model->get_by_id('mensalistas', array('mensalista_id !=' => $mensalista_id, 'mensalista_cpf' => $cpf))) {
                $this->form_validation->set_message('valida_cpf', 'O campo {field} já existe, ele deve ser único');
                return FALSE;
            }
        }

        $cpf = str_pad(preg_replace('/[^0-9]/', '', $cpf), 11, '0', STR_PAD_LEFT);
        // Verifica se nenhuma das sequências abaixo foi digitada, caso seja, retorna falso
        if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999') {

            $this->form_validation->set_message('valida_cpf', 'Por favor digite um CPF válido');
            return FALSE;
        } else {
            // Calcula os números para verificar se o CPF é verdadeiro
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) { 
                    $d += $cpf[$c] * (($t + 1) - $c); // se a versão do php for inferior ao 7.4 alterar trecho  $cpf[$c] para $cpf($c)
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf[$c] != $d) {  // se a versão do php for inferior ao 7.4 alterar trecho  $cpf[$c] para $cpf($c)
                    $this->form_validation->set_message('valida_cpf', 'Por favor digite um CPF válido');
                    return FALSE;
                }
            }
            return TRUE;
        }
    }

	// Verifica se o rg ja existe
	public function check_rg($mensalista_rg){
		$mensalista_id = $this->input->post('mensalista_id');

		if ($this->core_model->get_by_id('mensalistas', array('mensalista_id !=' => $mensalista_id, 'mensalista_rg' => $mensalista_rg))) {
			$this->form_validation->set_message('check_rg', 'O campo {field} já existe, ele deve ser único');
			return FALSE;
		}else{
			return TRUE;
		}

	}

	// Verifica se o email ja existe
	public function check_email($mensalista_email){
		$mensalista_id = $this->input->post('mensalista_id');

		if ($this->core_model->get_by_id('mensalistas', array('mensalista_id !=' => $mensalista_id, 'mensalista_email' => $mensalista_email))) {
			$this->form_validation->set_message('check_email', 'O campo {field} já existe, ele deve ser único');
			return FALSE;
		}else{
			return TRUE;
		}

	}

	// Verifica se o telefone ja existe
	public function check_telefone_fixo($mensalista_telefone_fixo){
		$mensalista_id = $this->input->post('mensalista_id');

		if ($this->core_model->get_by_id('mensalistas', array('mensalista_id !=' => $mensalista_id, 'mensalista_telefone_fixo' => $mensalista_telefone_fixo))) {
			$this->form_validation->set_message('check_telefone_fixo', 'O campo {field} já existe, ele deve ser único');
			return FALSE;
		}else{
			return TRUE;
		}

	}

	// Verifica se o celular ja existe
	public function check_telefone_movel($mensalista_telefone_movel){
		$mensalista_id = $this->input->post('mensalista_id');

		if ($this->core_model->get_by_id('mensalistas', array('mensalista_id !=' => $mensalista_id, 'mensalista_telefone_movel' => $mensalista_telefone_movel))) {
			$this->form_validation->set_message('check_telefone_movel', 'O campo {field} já existe, ele deve ser único');
			return FALSE;
		}else{
			return TRUE;
		}

	}

	public function del($mensalista_id = NULL){

		if(!$mensalista_id || !$this->core_model->get_by_id('mensalistas', array('mensalista_id' => $mensalista_id))){
			$this->session->set_flashdata('error', 'mensalista não encontrado');
			redirect($this->router->fetch_class());
		}

		if($this->core_model->get_by_id('mensalistas', array('mensalista_id' => $mensalista_id, 'mensalista_ativo' => 1 ))){
			$this->session->set_flashdata('error', 'Não é possivel excluir mensalista ativo');
			redirect($this->router->fetch_class());
		}

		$this->core_model->delete('mensalistas', array('mensalista_id' => $mensalista_id));
		redirect($this->router->fetch_class());

	}
}