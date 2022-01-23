        
    <?php $this->load->view('layout/navbar')?>;
  
            <div class="page-wrap">

            <?php $this->load->view('layout/sidebar')?>;

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
                            
                        </div>
                    </div>                    

                      <!-- um disparo de sucesso caso funcione -->
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

                        <div class="row">

                            <!-- Dashboard tickets -->

                            <!-- ticket 1 -->
                            <div class="col-xl-3 col-md-12">
                                <div class="card proj-t-card">
                                    <div class="card-body  text-navy">
                                        <div class="row align-items-center mb-30">
                                            <div class="col-auto">
                                                <i class="fas fa-warehouse f-40"></i>
                                            </div>
                                            <div class="col pl-0">
                                                <h6 class="mb-5">Total vagas</h6>
                                                <h6 class="mb-5 font-weight-bold"><?php echo $numero_total_vagas->precificacao_numero_vagas; ?></h6>
                                            </div>
                                        </div>
                                        <div class="row align-items-center text-center">
                                            <div class="col">
                                                <span>Livre</span>
                                                <h6 class="mb-0 badge badge-pill badge-navy text-white"><?php echo $numero_total_vagas->precificacao_numero_vagas - $total_estacionados_agora;; ?></h6></div>
                                            <div class="col"><i class="fas fa-exchange-alt  f-18"></i></div>
                                            <div class="col">
                                                <span>Ocupadas</span>
                                                <h6 class="mb-0 badge badge-pill badge-navy text-white"><?php echo $total_estacionados_agora; ?></h6></div>
                                            
                                        </div>
                                        <h6 class="pt-badge bg-navy small">FastPark</h6>
                                    </div>
                                </div>
                            </div>
                            <!-- ticket 2 -->
                            <div class="col-xl-3 col-md-12">
                                <div class="card proj-t-card">
                                    <div class="card-body  text-blue">
                                        <div class="row align-items-center mb-30">
                                            <div class="col-auto">
                                                <i class="fas fa-hand-holding-usd f-40"></i>
                                            </div>
                                            <div class="col pl-0">
                                                <h6 class="mb-5">Mensais</h6>
                                                <h6 class="mb-5 font-weight-bold"><?php echo 'R$ &nbsp;'. $total_mensalidades->total_mensalidades; ?></h6>
                                            </div>
                                        </div>
                                        <div class="row align-items-center text-center">
                                            <div class="col">
                                                <span>Pagas</span>
                                                <h6 class="mb-0 badge badge-pill badge-blue text-white"><?php echo $total_mensalidades_pagas; ?></h6></div>
                                            <div class="col"><i class="fas fa-exchange-alt  f-18"></i></div>
                                            <div class="col">
                                                <span>Abertas</span>
                                                <h6 class="mb-0 badge badge-pill badge-blue text-white"><?php echo $total_mensalidades_abertas;?></h6></div>
                                            
                                        </div>
                                        <h6 class="pt-badge bg-blue small">FastPark</h6>
                                    </div>
                                </div>
                            </div>
                            <!-- ticket 3 -->
                            <div class="col-xl-3 col-md-12">
                                <div class="card proj-t-card">
                                    <div class="card-body  text-yellow">
                                        <div class="row align-items-center mb-30">
                                            <div class="col-auto">
                                                <i class="fas fa-money-bill-alt f-40"></i>
                                            </div>
                                            <div class="col pl-0">
                                                <h6 class="mb-5">Avulsos</h6>
                                                <h6 class="mb-5 font-weight-bold"> <?php echo 'R$ &nbsp;'.$total_avulsos->total_avulsos; ?></h6>
                                            </div>
                                        </div>
                                        <div class="row align-items-center text-center">
                                            <div class="col">
                                                <span>Pagas</span>
                                                <h6 class="mb-0 badge badge-pill badge-yellow text-dark"><?php echo $total_avulsos_pagos; ?></h6></div>
                                            <div class="col"><i class="fas fa-exchange-alt  f-18"></i></div>
                                            <div class="col">
                                                <span>Abertas</span>
                                                <h6 class="mb-0 badge badge-pill badge-yellow text-dark"><?php echo $total_avulsos_abertos?></h6></div>
                                            
                                        </div>
                                        <h6 class="pt-badge bg-yellow small text-dark">FastPark</h6>
                                    </div>
                                </div>
                            </div>
                            <!-- ticket 4 -->
                            <div class="col-xl-3 col-md-12">
                                <div class="card proj-t-card">
                                    <div class="card-body  text-success">
                                        <div class="row align-items-center mb-30">
                                            <div class="col-auto">
                                                <i class="fas fa-users f-40"></i>
                                            </div>
                                            <div class="col pl-0">
                                                <h6 class="mb-5">Mensalistas</h6>
                                                <h6 class="mb-5 font-weight-bold"><?php echo $total_mensalistas; ?></h6>
                                            </div>
                                        </div>
                                        <div class="row align-items-center text-center">
                                            <div class="col">
                                                <span>Ativos</span>
                                                <h6 class="mb-0 badge badge-pill badge-success text-white"><?php echo $total_mensalistas_ativos; ?></h6></div>
                                            <div class="col"><i class="fas fa-exchange-alt  f-18"></i></div>
                                            <div class="col">
                                                <span>Inativos</span>
                                                <h6 class="mb-0 badge badge-pill badge-success text-white"><?php echo $total_mensalistas_inativos; ?></h6></div>
                                            
                                        </div>
                                        <h6 class="pt-badge bg-success small text-white">FastPark</h6>
                                    </div>
                                </div>
                            </div>
                         
                            <!-- Final-tickets  -->
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
          
                <footer class="footer">
                    <div class="w-100 clearfix">
                        <span class="text-center text-sm-left d-md-inline-block">Copyright © <?php echo date('Y') ?> ThemeKit v2.0. All Rights Reserved.</span>
                        <span class="float-none float-sm-right mt-1 mt-sm-0 text-center">Customizado <i class="fas fa-code text-danger"></i> by <a href="javascript:void" class="text-dark" >HSoftware</a></span>
                    </div>
                </footer>
                
            </div>

        