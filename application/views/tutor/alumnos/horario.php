  <!-- page content -->
  <style>
ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
}
  </style>
  <div class="right_col" role="main">

      <div class="">

          <div class="row">
              <div class="col-md-12">
                  <div class="x_panel">
                      <div class="x_title">
                          <div class="col-md-6 col-sm-12 col-xs-12 ">
                              <h2><strong> <i class="fa fa-clock-o"></i> HORARIO ESCOLAR</strong></h2>
                          </div>
                          <div class="col-md-6 col-sm-12 col-xs-12 " align="right">
                              <?php  if(isset($tabla) && !empty($tabla)){?>
                              <a target="_blank"
                                  href="<?php echo site_url('Tutores/descargar/'.$controller->encode($idhorario).'/'.$controller->encode($idalumno)) ?>"
                                  class="btn btn-primary">IMPRIMIR HORARIO</a>
                              <?php } ?>
                          </div>
                          <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                          <?php
                        if (isset($materias_repetir) && !empty($materias_repetir)) {
                            echo '  <div class="row" > 
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <h5>Materias para recuperar.</h5>
                        ';
                            foreach ($materias_repetir as $row) {
                                echo '<label>*' . $row->nombreclase . '</label> - <small>' . $row->nombre . ' ' . $row->apellidop . ' ' . $row->apellidom . '</small> || ';
                            }
                            echo '   <div class="clearfix"></div>    
                    </div>
                    </div>
                    ';
                        }
                        ?>
                          <div class="row" align="center">
                              <?php
             if(isset($tabla) && !empty($tabla)){
              echo $tabla;
            }else{
              echo '<label align="center">No tiene registrado Horario de Clases.</label>';
            }
              ?>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>

      <!-- footer content -->
      <footer>
          <div class="copyright-info">
              <p class="pull-right">SICE - Sistema Integral para el Control Escolar</a>
              </p>
          </div>
          <div class="clearfix"></div>
      </footer>
      <!-- /footer content -->

  </div>
  <!-- /page content -->
  </div>

  </div>

  <div id="custom_notifications" class="custom-notifications dsp_none">
      <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
      </ul>
      <div class="clearfix"></div>
      <div id="notif-group" class="tabbed_notifications"></div>
  </div>
  <script data-my_var_1="<?php echo base_url() ?>" data-my_var_2="<?php echo $idhorario; ?>"
      src="<?php echo base_url(); ?>/assets/vue/appvue/apphorariodetalle.js"></script>