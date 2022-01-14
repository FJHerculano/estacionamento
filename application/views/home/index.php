        
    <?php $this->load->view('layout/navbar')?>;
  
            <div class="page-wrap">

            <?php $this->load->view('layout/sidebar')?>;

                <div class="main-content">
                    <div class="container-fluid">

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

                    </div>
                </div>
          
                <footer class="footer">
                    <div class="w-100 clearfix">
                        <span class="text-center text-sm-left d-md-inline-block">Copyright © <?php echo date('Y') ?> ThemeKit v2.0. All Rights Reserved.</span>
                        <span class="float-none float-sm-right mt-1 mt-sm-0 text-center">Customizado <i class="fas fa-code text-danger"></i> by <a href="javascript:void" class="text-dark" >HSoftware</a></span>
                    </div>
                </footer>
                
            </div>

        