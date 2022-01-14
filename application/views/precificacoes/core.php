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
                        <div class="card-header"><?php echo(isset($precificacao) ? '<i class="ik ik-calendar ik-2 x"></i> &nbsp; Data da ultima alteração:&nbsp; ' .formata_data_banco_com_hora( $precificacao->precificacao_data_alteracao) : ''); ?></div>
                        <div class="card-body">
                        <form class="forms-sample" name="form_core" method="POST">
                                    
                                    <!-- Primeira linha do form user -->
                                    <div class="form-group row">
                                        <div class="col-md-4 mb-20">
                                            <label >Categoria</label>
                                            <input type="text" class="form-control" name="precificacao_categoria" value="<?php echo(isset($precificacao) ? $precificacao->precificacao_categoria : set_value('precificacao_categoria')); ?>" >
                                            <?php echo form_error('precificacao_categoria', '<div class="text-danger">', '</div>') ?>
                                        </div>

                                        <div class="col-md-2 mb-20">
                                            <label >Valor hora</label>
                                            <input type="text" class="form-control money" name="precificacao_valor_hora" value="<?php echo(isset($precificacao) ? $precificacao->precificacao_valor_hora : set_value('precificacao_valor_hora')); ?>" >
                                            <?php echo form_error('precificacao_valor_hora', '<div class="text-danger">', '</div>') ?>
                                        </div>                                        
                                        
                                        <div class="col-md-2 mb-20">
                                            <label >Valor Mensalidade</label>
                                            <input type="text" class="form-control money" name="precificacao_valor_mensalidade" value="<?php echo(isset($precificacao) ? $precificacao->precificacao_valor_mensalidade : set_value('precificacao_valor_mensalidade')); ?>" >
                                            <?php echo form_error('precificacao_valor_mensalidade', '<div class="text-danger">', '</div>') ?>
                                        </div>

                                        <div class="col-md-2 mb-20">
                                            <label >Numero de Vagas</label>
                                            <input type="number" class="form-control" name="precificacao_numero_vagas" value="<?php echo(isset($precificacao) ? $precificacao->precificacao_numero_vagas : set_value('precificacao_numero_vagas')); ?>" >
                                            <?php echo form_error('precificacao_numero_vagas', '<div class="text-danger">', '</div>') ?>
                                        </div>

                                        <div class="col-md-2 mb-20">
                                            <label >Ativa</label>
                                            <select class="form-control" name="precificacao_ativa">
                                                
                                                <?php if(isset($precificacao)): ?>

                                                    <option value="0" <?php echo ($precificacao->precificacao_ativa == 0 ? 'selected' : '')?>>Não</option>
                                                    <option value="1" <?php echo ($precificacao->precificacao_ativa == 1 ? 'selected' : '')?>>Sim</option>
                                                
                                                <?php else: ?>

                                                    <option value="0" >Não</option>
                                                    <option value="1" >Sim</option>

                                                <?php endif; ?>

                                            </select>

                                        </div>

                                    </div>

                                    <!-- Quinta linha do form user -->
                                    <?php if(isset($precificacao)) : ?>
                                        <div class="form-group row">
                                            <div class="col-md-12 mb-20">
                                                <input type="hidden" class="form-control" name="precificaco_id" value="<?php echo $precificacao->precificacao_id; ?>" >
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

