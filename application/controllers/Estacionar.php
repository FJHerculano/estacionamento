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
                'dist/css/estacionar.css'
			),

			// scripts usados na aplicação
			'scripts' => array(
				'plugins/datatables.net/js/jquery.dataTables.min.js',
				'plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js',
				'plugins/datatables.net/js/estacionamento.js',
			),

			// listagem usando a biblioteca ion_auth
			'estacionados' => $this->estacionar_model->get_all(),

            //Inicio numero vagas por categoria
            'numero_vagas_pequeno' => $this->estacionar_model->get_numero_vagas(1),
            'vagas_ocupadas_pequeno' => $this->core_model->get_all('estacionar', array('estacionar_status' => 0, 'estacionar_precificacao_id' => 1)),

            'numero_vagas_medio' => $this->estacionar_model->get_numero_vagas(2),
            'vagas_ocupadas_medio' => $this->core_model->get_all('estacionar', array('estacionar_status' => 0, 'estacionar_precificacao_id' => 2)),

            'numero_vagas_grande' => $this->estacionar_model->get_numero_vagas(3),
            'vagas_ocupadas_grande' => $this->core_model->get_all('estacionar', array('estacionar_status' => 0, 'estacionar_precificacao_id' => 3)),

            'numero_vagas_moto' => $this->estacionar_model->get_numero_vagas(4),
            'vagas_ocupadas_moto' => $this->core_model->get_all('estacionar', array('estacionar_status' => 0, 'estacionar_precificacao_id' => 4)),

		);

		// Para ver o que a biblioteca ion_auth traz de opções para nosso 
		// autenticação
		// echo '<pre>';
		// print_r($data['numero_vagas_pequeno']);
		// exit();

		$this->load->view('layout/header', $data);
		$this->load->view('estacionar/index');
		$this->load->view('layout/footer');
        
	}

    public function core($estacionar_id = NULL){

        if(!$estacionar_id){
            //cadastrando

            $this->form_validation->set_rules('estacionar_precificacao_id', 'Categoria', 'required');
            $this->form_validation->set_rules('estacionar_numero_vaga', 'Número da vaga', 'required|integer|greater_than[0]|callback_check_vaga_ocupada|callback_check_range_vagas_categoria');
            $this->form_validation->set_rules('estacionar_placa_veiculo', 'Placa veículo', 'required|exact_length[8]|callback_check_placa_status_aberta');
            $this->form_validation->set_rules('estacionar_marca_veiculo', 'Marca do veículo', 'required|min_length[2]|max_length[30]');
            $this->form_validation->set_rules('estacionar_modelo_veiculo', 'Modelo do veículo', 'required|min_length[2]|max_length[20]');



            if($this->form_validation->run()){


                $data = elements(
                    array(
                        'estacionar_valor_hora',
                        'estacionar_numero_vaga',
                        'estacionar_placa_veiculo',
                        'estacionar_marca_veiculo',
                        'estacionar_modelo_veiculo',
                    ),$this->input->post()
                );

                $data['estacionar_precificacao_id'] = intval(substr($this->input->post('estacionar_precificacao_id'), 0, 1));


                $data['estacionar_status'] = 0; // Ao cadastrar  um ticket  o status fica com zero

                $data = html_escape($data);

                $this->core_model->insert('estacionar', $data, TRUE);

                $estacionar_id = $this->session->userdata('last_id');

                redirect($this->router->fetch_class().'/acoes/'.$estacionar_id);

                // Criar função de imprimir 

            }else{

                // Error de validação  

                $data = array(
                    // titulo e subtitulo das paginas da aplicação 
                    'titulo' => 'Cadastrar o ticket',
                    'sub_titulo' => 'Chegou a hora de Cadastrar um novo ticket ',
                    'icone_view' => 'fas fa-parking',
                    'texto_modal'=> 'Tem certeza que deseja salvar esse ticket, não será possível alterá-lo',
                    
                    'scripts' => array(
                        'plugins/mask/jquery.mask.min.js',
                        'plugins/mask/custom.js',
                        'js/estacionar/estacionar.js'
                    ),

                    // listagem usando a biblioteca ion_auth
                    'precificacoes' => $this->core_model->get_all('precificacoes', array('precificacao_ativa' => 1 )),

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

        }else{
                  // ENCERRANDO UM TICKET (UM UPDATE)     
            //Verificação de existencia 
            if(!$this->core_model->get_by_id('estacionar', array('estacionar_id' => $estacionar_id))){
            
                $this->session->set_flashdata('error', 'Ticket não encontrado para encerramento');
                redirect($this->router->fetch_class());
            
            }else{
            // Encerramento de um ticket 

            // Se o tempo decorrido for maior que 15 minuto campo pagar se torna obrigatorio 
                $estacionar_tempo_decorrido = str_replace('.', '', $this->input->post('estacionar_tempo_decorrido') );

                if($estacionar_tempo_decorrido > '015'){
                    $this->form_validation->set_rules('estacionar_forma_pagamento_id', 'Forma de pagamento', 'required');
                }else{
                    // O form precisa validar alguma coisa para a regra dos 15 minuto funcionar
                    $this->form_validation->set_rules('estacionar_forma_pagamento_id', 'Forma de pagamento', 'trim');
                }

                if($this->form_validation->run()){

                    $data = elements(
                        array(
                            'estacionar_valor_devido',
                            'estacionar_forma_pagamento_id',
                            'estacionar_tempo_decorrido',
                        ),$this->input->post()
                    );
                    
                    // Não está funcionando
                    if($estacionar_tempo_decorrido <= '015'){
                        $data['estacionar_forma_pagamento_id'] = 5; // id referente ao id da forma de pagamento GRATIS 
                    }

                    $data['estacionar_data_saida'] = date('Y-m-d H:i:s');
                    $data['estacionar_status'] = 1; // encerrando um ticket 

                    $data = html_escape($data);

                    $this->core_model->update('estacionar', $data, array('estacionar_id' => $estacionar_id));
                    redirect($this->router->fetch_class().'/acoes/'.$estacionar_id);

                   
                    // Criar função de imprimir 

                }else{

                    // Error de validação  

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

    public function check_range_vagas_categoria($numero_vaga) {

        $precificacao_id = intval(substr($this->input->post('estacionar_precificacao_id'), 0, 1));

        if ($precificacao_id) {

            $precificacao = $this->core_model->get_by_id('precificacoes', array('precificacao_id' => $precificacao_id));

            if ($precificacao->precificacao_numero_vagas < $numero_vaga) {

                $this->form_validation->set_message('check_range_vagas_categoria', 'A vaga deve estar entre 1 e ' . $precificacao->precificacao_numero_vagas);

                return FALSE;
            } else {

                return TRUE;
            }
        } else {
            $this->form_validation->set_message('check_range_vagas_categoria', 'Escolha uma categoria');
            return FALSE;
        }
    }

    public function check_vaga_ocupada($estacionar_numero_vaga) {

        $estacionar_precificacao_id = intval(substr($this->input->post('estacionar_precificacao_id'), 0, 1));

        if ($this->core_model->get_by_id('estacionar', array('estacionar_numero_vaga' => $estacionar_numero_vaga, 'estacionar_status' => 0, 'estacionar_precificacao_id' => $estacionar_precificacao_id))) {

            $this->form_validation->set_message('check_vaga_ocupada', 'Essa vaga já está ocupada para essa categoria');

            return FALSE;
        } else {

            return TRUE;
        }
    }

    public function check_placa_status_aberta($estacionar_placa_veiculo) {

        $estacionar_placa_veiculo = strtoupper($estacionar_placa_veiculo);

        if ($this->core_model->get_by_id('estacionar', array('estacionar_placa_veiculo' => $estacionar_placa_veiculo, 'estacionar_status' => 0))) {

            $this->form_validation->set_message('check_placa_status_aberta', 'Existe uma ticket aberto para essa placa');

            return FALSE;
        } else {

            return TRUE;
        }
    }

    public function acoes($estacionar_id = NULL){
        if(!$this->core_model->get_by_id('estacionar', array('estacionar_id' => $estacionar_id))){
            
            $this->session->set_flashdata('error', 'Ticket não encontrado');
            redirect($this->router->fetch_class());
        
        }else{
            $data = array(
                // titulo e subtitulo das paginas da aplicação 
                'titulo' => 'O que você gostaria de fazer',
                'sub_titulo' => 'Escolha uma das opções a seguir',
                'icone_view' => 'fas fa-question',

                // listagem usando a biblioteca ion_auth
                'estacionado' => $this->core_model->get_by_id('estacionar', array('estacionar_id' => $estacionar_id)),
                
            );

            // Para ver o que a biblioteca ion_auth traz de opções para nosso 
            // autenticação
            // echo '<pre>';
            // print_r($data['estacionados']);
            // exit();

            $this->load->view('layout/header', $data);
            $this->load->view('estacionar/acoes');
            $this->load->view('layout/footer');
       
        }
    }


    public function pdf($estacionar_id = NULL){

        if(!$estacionar_id || !$this->core_model->get_by_id('estacionar', array('estacionar_id' => $estacionar_id))){
            
            $this->session->set_flashdata('error', 'Ticket não encontrado para a impressão');
            redirect($this->router->fetch_class());
        
        }else{

            $this->load->library('pdf');
            $this->load->model('estacionar_model');

            // carregando os dados da empresa e do ticket para passar ao cliente
            $empresa = $this->core_model->get_by_id('sistema', array('sistema_id' => 1));
            $ticket = $this->estacionar_model->get_by_id($estacionar_id);


            $file_name = 'Ticket - placa' . $ticket->estacionar_placa_veiculo;

            $html = '<html style="font-size:10px;">';

            $html .=  '<head>';

            $html .=  '<title>'.$empresa->sistema_razao_social.'</title>';
            
            $html .=  '</head>';

            $html .=  '<body >';
            
            // Dados da empresa
            $html .=  '<h5 align="center"  style="font-size:10px;">
                '.$empresa->sistema_nome_fantasia.'<br/>
                CNPJ: '.$empresa->sistema_cnpj.'<br/>
                Endereço: '.$empresa->sistema_endereco.' - '.$empresa->sistema_numero.'<br/>
                CEP: '.$empresa->sistema_cep.'<br/>
                Cidade: '.$empresa->sistema_cidade.'<br/>
                Telefone: '.$empresa->sistema_telefone_fixo.' - '.$empresa->sistema_telefone_movel.'<br/>
                E-mail: '.$empresa->sistema_email.'<br/>

            </h5>';
            
            $html .= '<hr>';

            $dados_saida = '';

            if($ticket->estacionar_status == 1 ){

                $dados_saida .= '<strong>Data saída: &nbsp;</strong>'. formata_data_banco_com_hora($ticket->estacionar_data_saida). '<br/>'
                .'<strong>Tempo decorrido (HR:MIN): &nbsp;</strong>' . $ticket->estacionar_tempo_decorrido . '<br/>'
                .'<strong>Valor pago: &nbsp; </strong>' . 'R$&nbsp;' . $ticket->estacionar_valor_devido. '<br/>'
                .'<strong>Forma de pagamento: &nbsp;</strong>' . $ticket->forma_pagamento_nome . '<br/>';

            }
            
            // Dados do ticket
            $html .= '<p align="right" >Ticket Nº: '.$ticket->estacionar_id.'</p>'.'<br/>';
            
            $html .= '<p>'
            .'<strong>Placa veiculo: &nbsp;</strong>' . $ticket->estacionar_placa_veiculo . '<br/>'
            .'<strong>Marca veiculo: &nbsp;</strong>' . $ticket->estacionar_marca_veiculo . '<br/>'
            .'<strong>Modelo veiculo: &nbsp;</strong>' . $ticket->estacionar_modelo_veiculo . '<br/>'
            .'<strong>Categoria veiculo: &nbsp;</strong>' . $ticket->precificacao_categoria . '<br/>'
            .'<strong>Numero da vaga: &nbsp;</strong>' . $ticket->estacionar_numero_vaga . '<br/>'
            .'<strong>Data entrada: &nbsp;</strong>' . formata_data_banco_com_hora($ticket->estacionar_data_entrada). '<br/>'
            .$dados_saida
            .'</p>';

            $html .= '<br/>';

            $html .= '<hr/>';

             // Dados da empresa
             $html .=  '<h5 align="center"  style="font-size:11px;">
             '.$empresa->sistema_texto_ticket.'<br/>
            Data: '.date('d/m/Y H:i:s').'<br/>


            </h5>';

                
            /*
                False abre no navegador 
                True Faz download
            */

            $this->pdf->createPDF($html, $file_name, false);

           

            $html .=  '</html>';

            $html .=  '</body>';
        }
    }

    public function del($estacionar_id = NULL){
        if(!$estacionar_id || !$this->core_model->get_by_id('estacionar', array('estacionar_id' => $estacionar_id))){
            $this->session->set_flashdata('error', 'Ticket não encontrado para exclusão');
            redirect($this->router->fetch_class());
        }

        if($this->core_model->get_by_id('estacionar', array('estacionar_id' => $estacionar_id, 'estacionar_status' => 0  ))){
            $this->session->set_flashdata('error', 'Ticket não pode ser excluido, pois ainda esta em aberto');
            redirect($this->router->fetch_class());
        }

        $this->core_model->delete('estacionar', array('estacionar_id' => $estacionar_id));
        redirect($this->router->fetch_class());

    }

}