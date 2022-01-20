i  <!-- caminho Navbar -->      
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
                                    <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Home" href="<?php echo base_url('/') ?>"><i class="ik ik-home"></i></a>
                                </li>

                                <li class="breadcrumb-item">
                                    <a 
                                        data-bs-toggle="tooltip" 
                                        data-bs-placement="bottom" 
                                        title="Listar <?php echo $this->router->fetch_class(); ?>" 
                                        href="<?php echo base_url($this->router->fetch_class()); ?>"
                                    >
                                        Listar &nbsp; <?php echo($this->router->fetch_class()); ?>
                                    </a>
                                </li>

                                <li class="breadcrumb-item "><?php echo $titulo; ?></li>
                                
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header"><?php echo(isset($forma) ? '<i class="ik ik-calendar ik-2 x"></i> &nbsp; Data da ultima alteração:&nbsp; ' .formata_data_banco_com_hora( $forma->forma_pagamento_data_alteracao) : ''); ?></div>
                        <div class="card-body">
                        <form class="forms-sample" name="form_core" method="POST">
                                    
                                    <!-- Primeira linha do form user -->
                                    <div class="form-group row">
                                        <div class="col-md-8 mb-20">
                                            <label >Nome da forma de pagamento </label>
                                            <input type="text" class="form-control" name="forma_pagamento_nome" value="<?php echo(isset($forma) ? $forma->forma_pagamento_nome : set_value('forma_pagamento_nome')); ?>" >
                                            <?php echo form_error('forma_pagamento_nome', '<div class="text-danger">', '</div>') ?>
                                        </div>

                                        <div class="col-md-4 mb-20">
                                            <label >Ativa</label>
                                            <select class="form-control" name="forma_pagamento_ativa">
                                                
                                                <?php if(isset($forma)): ?>

                                                    <option value="0" <?php echo ($forma->forma_pagamento_ativa == 0 ? 'selected' : '')?>>Não</option>
                                                    <option value="1" <?php echo ($forma->forma_pagamento_ativa == 1 ? 'selected' : '')?>>Sim</option>
                                                
                                                <?php else: ?>

                                                    <option value="0" >Não</option>
                                                    <option value="1" >Sim</option>

                                                <?php endif; ?>

                                            </select>

                                        </div>

                                    </div>

                                    <!-- Quinta linha do form user -->
                                    <?php if(isset($forma)) : ?>
                                        <div class="form-group row">
                                            <div class="col-md-12 mb-20">
                                                <input type="hidden" class="form-control" name="forma_pagamento_id" value="<?php echo $forma->forma_pagamento_id; ?>" >
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <button type="submit" class="btn btn-primary mr-2">Salvar</button>
                                    <button class="btn btn-info" href="<?php echo base_url($this->router->fetch_class()); ?>" >Voltar</button>
                                    </form>
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

