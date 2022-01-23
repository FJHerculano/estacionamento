  <!-- caminho Navbar -->      
  <?php $this->load->view('layout/navbar')?>;
  
  <div class="page-wrap">
  
  <!-- caminho Sidebar -->      
  <?php $this->load->view('layout/sidebar')?>;

        <!-- Conteudo de tabelas -->  

        <div class="main-content">
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <i class="<?php echo $icone_view; ?> bg-blue"></i>
                                <div class="d-inline">
                                    <h5><?php echo $titulo; ?></h5>
                                    <span><?php echo $sub_titulo; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <nav class="breadcrumb-container" aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a title="Home" href="<?php echo base_url('/') ?>"><i class="ik ik-home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page"><?php echo $titulo; ?></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                
                <?php if($message = $this->session->flashdata('sucesso')): ?>
                    <div class="row">
                    <div class="col-md-12">
                        <div class="alert bg-success alert-success text-white  alert-dismissible fade show" role="alert">
                            <strong><i class=" fas fa-smile" ></i>&nbsp;<?php echo $message  ?></strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="ik ik-x"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <?php if($message = $this->session->flashdata('error')): ?>
                    <div class="row">
                    <div class="col-md-12">
                        <div class="alert bg-danger alert-danger text-white  alert-dismissible fade show" role="alert">
                            <strong><i class=" fas fa-smile" ></i>&nbsp;<?php echo $message  ?></strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="ik ik-x"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- ROW com tabela listagem estacionados -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-block">
                                <h3><a 
                                    data-bs-toggle="tooltip" 
                                    data-bs-placement="right" 
                                    title="Cadastrar <?php echo $this->router->fetch_class(); ?>" 
                                    class="btn bg-blue float-right text-white " href="<?php echo base_url($this->router->fetch_class().'/core/'); ?>">+ Novo</a>
                                </h3>
                            </div>
                            
                            <div class="card-body">
                                <table  class="table data-table">
                                    <thead>
                                        <tr>

                                            <th>#</th>
                                            <th>Categoria</th>
                                            <th>Valor hora</th>
                                            <th>Placa</th>
                                            <th>Forma pagamento</th>
                                            <th>status</th>
                                            <th class="nosort text-right pr-25 ">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($estacionados as $estacionado): ?>
                                        <tr>
                                            <td><?php echo $estacionado->estacionar_id; ?></td>
                                            <td><?php echo $estacionado->precificacao_categoria; ?></td>
                                            <td><?php echo "R$&nbsp;".$estacionado->precificacao_valor_hora; ?></td>
                                            <td><?php echo $estacionado->estacionar_placa_veiculo; ?></td>
                                            <td><?php echo ($estacionado-> estacionar_status == 1 ? $estacionado->forma_pagamento_nome : 'Em aberto'); ?></td>

                                            <td>
                                                <?php echo ($estacionado-> estacionar_status == 1 ? 
                                                '<span class="badge badge-pill badge-success mb-1">   Paga</span>' 
                                                : '<span class="badge badge-pill badge-warning mb-1"> Divida </span>'); ?>
                                                
                                            </td>
                                            <td class="text-right" >
                                                <a  target="_blank" 
                                                    data-bs-toggle="tooltip" 
                                                    data-bs-placement="bottom" 
                                                    title="Imprimir ticket" 
                                                    href="<?php echo base_url($this->router->fetch_class(). '/pdf/'. $estacionado->estacionar_id ); ?>"
                                                    class="btn btn-icon bg-dark text-white " 
                                                >
                                                    <i class="fas fa-print  "></i>
                                                </a>
                                                <a 
                                                    data-bs-toggle="tooltip" 
                                                    data-bs-placement="bottom" 
                                                    title="<?php echo ($estacionado->estacionar_status == 1 ? 'Visualizar' : 'Encerrar')?> ticket" 
                                                    href="<?php echo base_url($this->router->fetch_class().'/core/'. $estacionado->estacionar_id); ?>" 
                                                    class="btn btn-icon btn-primary"
                                                >
                                                    <i class="<?php echo($estacionado->estacionar_status == 1 ? 'ik ik-eye' : 'ik ik-edit-2') ?>"></i>
                                                </a>

                                                <button  
                                                    type="button"
                                                    title="Excluir ticket" 
                                                    class="btn btn-icon btn-danger"
                                                    data-toggle="modal" 
                                                    data-target="#estacionado-<?php echo $estacionado->estacionar_id; ?>"
                                                >
                                                    <i class="ik ik-trash"></i>
                                                </button> 
                                            </td>                                                    
                                        </tr>

                                            <div class="modal fade" id="estacionado-<?php echo $estacionado->estacionar_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalCenterLabel"><i class="fas fa-exclamation-triangle text-danger" ></i>&nbsp;Você tem certeza que deseja excluir este usuario?</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        </div>
                                                        
                                                        <div class="modal-footer">
                                                            <button 
                                                                data-toggle="tooltip"
                                                                data-bs-placement="bottom" 
                                                                title="Cancelar exclusão"
                                                                type="button" 
                                                                class="btn btn-secondary" 
                                                                data-dismiss="modal"
                                                                >Não, voltar a pagina</button>                                                                    
                                                            <a 
                                                                data-bs-toggle="tooltip" 
                                                                data-bs-placement="bottom" 
                                                                title="Excluir <?php echo $this->router->fetch_class(); ?>" 
                                                                href="<?php echo base_url($this->router->fetch_class().'/del/'. $estacionado->estacionar_id); ?>" 
                                                                class="btn  btn-danger"
                                                            >
                                                            Sim, EXCLUIR
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- cards de vagas disponiveis   -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-block text-center">SITUAÇÃO VAGAS</div>
                            
                            <div class="card-body">

                            <div class="row">
                                <!-- Primeiro card da view estacionar em vagas disponiveis-->
                                <div class="col-lg-3 col-md-4 col-6">
                                    <p class="text-center text-uppercase">Veículo pequeno <?php echo ($numero_vagas_pequeno->precificacao_ativa == 0 ? '<span class="text-danger font-weight-bold text-center small">&nbsp;<i class="fas fa-ban"></i>&nbsp;Desativado</span>' : ''); ?></p>
                                    <div class="widget social-widget">
                                        
                                        <div class="widget-body text-center">
                                            <div class="content">
                                                <i class="fas fa-car fa-3x text-primary" ></i>
                                            </div>
                                        </div>
 
                                        <div>
                                            <ul class="list-inline mt-15 text-center">

                                                <?php 

                                                    $ocupadas = array(); // armazena as vagas
                                                    $placas = array();   // armazena as placas 

                                                    foreach($vagas_ocupadas_pequeno as $vaga){

                                                        $ocupadas[] = $vaga->estacionar_numero_vaga;
                                                        $placas[$vaga->estacionar_numero_vaga] = $vaga->estacionar_placa_veiculo;

                                                    }
                                                
                                                ?>

                                                <?php for($i=1; $i <= $numero_vagas_pequeno->vagas; $i++ ): ?>
                                                    <li class="list-inline-item" >

                                                        <?php if(in_array($i, $ocupadas)): ?>
                                                            <div class="widget social-widget bg-warning vaga">
                                                                <div class="widget-body">
                                                                    <div class="content" data-toggle="tooltip" data-placement="bottom" title="Placa&nbsp;<?php echo $placas[$i] ?>">
                                                                        <i class="fas fa-car fa-lg"></i>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        
                                                        <?php else: ?>
                                                            <div class="widget social-widget <?php echo ($numero_vagas_pequeno->precificacao_ativa == 0 ? 'bg-google' : 'bg-success' ); ?> vaga">
                                                                <div class="widget-body">
                                                                    <div class="content" data-toggle="tooltip" data-placement="bottom" title="<?php echo ($numero_vagas_pequeno->precificacao_ativa == 0 ? 'Desativado' : 'Livre' ); ?>">
                                                                        <div class="number"><?php echo ($numero_vagas_pequeno->precificacao_ativa == 0 ? '<i class="fas fa-ban"></i>' : $i ); ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>

                                                    </li>

                                                <?php endfor; ?>
                                            </ul>
                                        </div>

                                    </div>
                                </div>

                                <!-- Segundo card da view estacionar em vagas disponiveis-->
                                <div class="col-lg-3 col-md-4 col-6">
                                <p class="text-center text-uppercase">Veículo médio <?php echo ($numero_vagas_medio->precificacao_ativa == 0 ? '<span class="text-danger font-weight-bold text-center small">&nbsp;<i class="fas fa-ban"></i>&nbsp; Desativado</span>' : ''); ?></p>
                                    <div class="widget social-widget">
                                        
                                        <div class="widget-body text-center">
                                            <div class="content">
                                                <i class="fas fa-truck-pickup fa-3x text-primary" ></i>
                                            </div>
                                        </div>
 
                                        <div>
                                            <ul class="list-inline mt-15 text-center">

                                            <?php 

                                                $ocupadas = array(); // armazena as vagas
                                                $placas = array();   // armazena as placas 

                                                foreach($vagas_ocupadas_medio as $vaga){

                                                    $ocupadas[] = $vaga->estacionar_numero_vaga;
                                                    $placas[$vaga->estacionar_numero_vaga] = $vaga->estacionar_placa_veiculo;

                                                }

                                            ?>

                                                <?php for($i=1; $i <= $numero_vagas_medio->vagas; $i++ ): ?>

                                                    <li class="list-inline-item" >

                                                    <?php if(in_array($i, $ocupadas)): ?>
                                                            <div class="widget social-widget bg-warning vaga">
                                                                <div class="widget-body">
                                                                    <div class="content" data-toggle="tooltip" data-placement="bottom" title="Placa&nbsp;<?php echo $placas[$i] ?>">
                                                                        <i class="fas fa-truck-pickup fa-lg"></i>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        
                                                        <?php else: ?>
                                                            <div class="widget social-widget <?php echo ($numero_vagas_medio->precificacao_ativa == 0 ? 'bg-google' : 'bg-success' ); ?> vaga">
                                                                <div class="widget-body">
                                                                    <div class="content" data-toggle="tooltip" data-placement="bottom" title="<?php echo ($numero_vagas_medio->precificacao_ativa == 0 ? 'Desativado' : 'Livre' ); ?>">
                                                                        <div class="number"><?php echo ($numero_vagas_medio->precificacao_ativa == 0 ? '<i class="fas fa-ban"></i>' : $i ); ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                    </li>

                                                <?php endfor; ?>
                                            </ul>
                                        </div>

                                    </div>
                                </div>

                                <!-- terceiro card da view estacionar em vagas disponiveis-->
                                <div class="col-lg-3 col-md-4 col-6">
                                <p class="text-center text-uppercase">Veículo grande <?php echo ($numero_vagas_grande->precificacao_ativa == 0 ? '<span class="text-danger font-weight-bold text-center small">&nbsp;<i class="fas fa-ban"></i>&nbsp; Desativado</span>' : ''); ?></p>
                                    <div class="widget social-widget">
                                        <div class="widget-body text-center">
                                            <div class="content">
                                                <i class="fas fa-truck fa-3x text-primary" ></i>
                                            </div>
                                        </div>
 
                                        <div>
                                            <ul class="list-inline mt-15 text-center">
                                                <?php 

                                                    $ocupadas = array(); // armazena as vagas
                                                    $placas = array();   // armazena as placas 

                                                    foreach($vagas_ocupadas_grande as $vaga){

                                                        $ocupadas[] = $vaga->estacionar_numero_vaga;
                                                        $placas[$vaga->estacionar_numero_vaga] = $vaga->estacionar_placa_veiculo;

                                                    }

                                                ?>

                                                <?php for($i=1; $i <= $numero_vagas_grande->vagas; $i++ ): ?>
                                                    <li class="list-inline-item" >

                                                        <?php if(in_array($i, $ocupadas)): ?>
                                                            <div class="widget social-widget bg-warning vaga">
                                                                <div class="widget-body">
                                                                    <div class="content" data-toggle="tooltip" data-placement="bottom" title="Placa&nbsp;<?php echo $placas[$i] ?>">
                                                                        <i class="fas fa-truck fa-lg"></i>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        
                                                        <?php else: ?>
                                                            <div class="widget social-widget <?php echo ($numero_vagas_grande->precificacao_ativa == 0 ? 'bg-google' : 'bg-success' ); ?> vaga">
                                                                <div class="widget-body">
                                                                    <div class="content" data-toggle="tooltip" data-placement="bottom" title="<?php echo ($numero_vagas_grande->precificacao_ativa == 0 ? 'Desativado' : 'Livre' ); ?>">
                                                                        <div class="number"><?php echo ($numero_vagas_grande->precificacao_ativa == 0 ? '<i class="fas fa-ban"></i>' : $i ); ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                    </li>

                                                <?php endfor; ?>
                                            </ul>
                                        </div>

                                    </div>
                                </div>

                                <!-- quarto card da view estacionar em vagas disponiveis-->
                                <div class="col-lg-3 col-md-4 col-6">
                                <p class="text-center text-uppercase">Veículo moto <?php echo ($numero_vagas_moto->precificacao_ativa == 0 ? '<span class="text-danger font-weight-bold text-center small ">&nbsp;<i class="fas fa-ban"></i>&nbsp; Desativado</span>' : ''); ?></p>
                                    <div class="widget social-widget">
                                        <div class="widget-body text-center">
                                            <div class="content">
                                                <i class="fas fa-motorcycle fa-3x text-primary" ></i>
                                            </div>
                                        </div>
 
                                        <div>
                                            <ul class="list-inline mt-15 text-center">
                                            <?php 
                                                $ocupadas = array(); // armazena as vagas
                                                $placas = array();   // armazena as placas 

                                                foreach($vagas_ocupadas_moto as $vaga){

                                                    $ocupadas[] = $vaga->estacionar_numero_vaga;
                                                    $placas[$vaga->estacionar_numero_vaga] = $vaga->estacionar_placa_veiculo;

                                                }
                                            ?>
                                                <?php for($i=1; $i <= $numero_vagas_moto->vagas; $i++ ): ?>

                                                    <li class="list-inline-item" >
                                                    <?php if(in_array($i, $ocupadas)): ?>
                                                            <div class="widget social-widget bg-warning vaga">
                                                                <div class="widget-body">
                                                                    <div class="content" data-toggle="tooltip" data-placement="bottom" title="Placa&nbsp;<?php echo $placas[$i] ?>">
                                                                        <i class="fas fa-motorcycle fa-lg"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        
                                                        <?php else: ?>
                                                            <div class="widget social-widget <?php echo ($numero_vagas_moto->precificacao_ativa == 0 ? 'bg-google' : 'bg-success' ); ?> vaga">
                                                                <div class="widget-body">
                                                                    <div class="content" data-toggle="tooltip" data-placement="bottom" title="<?php echo ($numero_vagas_moto->precificacao_ativa == 0 ? 'Desativado' : 'Livre' ); ?>">
                                                                        <div class="number"><?php echo ($numero_vagas_moto->precificacao_ativa == 0 ? '<i class="fas fa-ban"></i>' : $i ); ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                    </li>
                                                <?php endfor; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                               
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- final footer, copyright -->
        <footer class="footer">
            <div class="w-100 clearfix">
                <span class="text-center text-sm-left d-md-inline-block">Copyright © <?php echo date('Y') ?> ThemeKit v2.0. All Rights Reserved.</span>
                <span class="float-none float-sm-right mt-1 mt-sm-0 text-center">Customizado <i class="fas fa-code text-danger"></i> by <a href="javascript:void" class="text-dark" >HSoftware</a></span>
            </div>
        </footer>
      
  </div>

