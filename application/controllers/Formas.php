<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Formas extends CI_Controller {

	public function __construct(){
		parent::__construct();
		
		//Verifica se esta logado e redireciona 
		if(!$this->ion_auth->logged_in()){
			redirect('login');
		}
	}

	public function index()
	{

        $data = array(
			// titulo e subtitulo das paginas da aplicação 
			'titulo' => 'Formas de pagamento cadastradas ',
			'sub_titulo' => 'Listando todas as formas de pagamento',
            'icone_view' => 'fas fa-comment-dollar',


			// listagem de usuarios usando a biblioteca ion_auth
			'formas' => $this->core_model->get_all('formas_pagamentos'),
		);

		// Para ver o que a biblioteca ion_auth traz de opções para nosso 
		// autenticação
		// echo '<pre>';
		// print_r($data['precificacoes']);
		// exit();

		$this->load->view('layout/header', $data);
		$this->load->view('formas/index');
		$this->load->view('layout/footer');
	}

    public function core($forma_pagamento_id = NULL)
	{

        if(!$this->ion_auth->is_admin()){
			$this->session->set_flashdata('info', 'Você não tem permissão para editar ou criar forma de pagamento ');
			redirect($this->router->fetch_class());
		}

        if(!$forma_pagamento_id){
            //cadastrando

            // Validação de campos input
            $this->form_validation->set_rules('forma_pagamento_nome', 'nome da forma de pagamento','trim|required|min_length[3]|max_length[30]|is_unique[formas_pagamentos.forma_pagamento_nome]');


			if($this->form_validation->run()){
			
			//sanitizando o html5
			$data = elements(
				array(
                    'forma_pagamento_nome',
                    'forma_pagamento_ativa',
				), $this->input->post()
			);

			$data = html_escape($data);

			$this->core_model->insert('formas_pagamentos', $data);
			redirect($this->router->fetch_class());

			}else{
				// Error de validação
				$data = array(
					// titulo e subtitulo das paginas da aplicação 
					'titulo' => 'Editar Precificação',
					'sub_titulo' => 'Editando a precificações',
					'icone_view' => 'fas fa-dollar-sign',
		
				);
		
				$this->load->view('layout/header', $data);
				$this->load->view('formas/core');
				$this->load->view('layout/footer');
			}




        }else{
            //Verifica se o id existe para editar 
            if(!$this->core_model->get_by_id('formas_pagamentos', array('forma_pagamento_id' => $forma_pagamento_id))){
                $this->session->set_flashdata('error', 'Forma de pagamento não encontrada');
                redirect($this->router->fetch_class());
            }else{
                // Editando

                // validações nos campos input
                $this->form_validation->set_rules('forma_pagamento_nome', 'nome','trim|required|min_length[3]|max_length[30]|callback_check_pagamento_nome');

                if($this->form_validation->run()){

                    $data = elements(
                        array(
                            'forma_pagamento_nome',
                            'forma_pagamento_ativa',
                        ), $this->input->post() 
                    );

                    //sanitizando o formulario 
                    $data = html_escape($data);

                    $this->core_model->update('formas_pagamentos', $data, array("forma_pagamento_id" => $forma_pagamento_id));
                    redirect($this->router->fetch_class());


                }else{

                    // Erro de validação 
                    $data = array(
                        // titulo e subtitulo das paginas da aplicação 
                        'titulo' => 'Editar Formas de pagamento',
                        'sub_titulo' => 'Editando formas de pagamento',
                        'icone_view' => 'fas fa-comment-dollar',


                        // listagem de usuarios usando a biblioteca ion_auth
                        'forma' => $this->core_model->get_by_id('formas_pagamentos', array('forma_pagamento_id' => $forma_pagamento_id)),
                    );

                    // Para ver o que a biblioteca ion_auth traz de opções para nosso 
                    // autenticação
                    // echo '<pre>';
                    // print_r($data['forma']);
                    // exit();

                    $this->load->view('layout/header', $data);
                    $this->load->view('formas/core');
                    $this->load->view('layout/footer');

                }
            }

        }

	}

    public function check_pagamento_nome($forma_pagamento_nome){

        $forma_pagamento_id = $this->input->post('forma_pagamento_id');

        if($this->core_model->get_by_id('formas_pagamentos', array('forma_pagamento_nome' => $forma_pagamento_nome, 'forma_pagamento_id !=' => $forma_pagamento_id ))){

            $this->form_validation->set_message('check_pagamento_nome', 'Forma de pagamento já existe');
            return FALSE;
        }else{
            return TRUE;
        }
    }


    public function del($forma_pagamento_id = NULL){

        if(!$this->ion_auth->is_admin()){
			$this->session->set_flashdata('info', 'Você não tem permissão para excluir ');
			redirect($this->router->fetch_class());
		}

        //Verifica se o id existe para editar 
        if(!$this->core_model->get_by_id('formas_pagamentos', array('forma_pagamento_id' => $forma_pagamento_id))){
            $this->session->set_flashdata('error', 'Forma de pagamento não encontrada');
            redirect($this->router->fetch_class());
        }else{
            $this->core_model->delete('formas_pagamentos', array('forma_pagamento_id ' => $forma_pagamento_id ));
            redirect($this->router->fetch_class());
        }
    }

}
