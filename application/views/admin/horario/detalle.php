  <!-- page content -->
  <style>
[data-title]:hover:after{
    opacity:1;
    transition:all 0.1s ease 0.5s;
    visibility:visible;
}
[data-title]:after{
    content:attr(data-title);
    backgroud-color:#333;
    color:#fff;
    font-size:14px;
    font-family:Raleway;
    position:absolute;
    padding:3px 20px;
    bottom:-1.6em;
    left:100%;
    white-space:nowrap;
    box-shadow:1px 1px 3px #222222;
    opacity:0;
    border:1px 1px 3px #111111;
    z-index:99999;
    visibility:hidden;
    border-radius:6px;
    
}
[data-title]{
position:relative;
}
</style>
  <div class="right_col" role="main">

    <div class="">

      <div class="row">
        <div class="col-md-12  col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
                <h2><strong>DETALLES DEL HORARIO: <?php if(isset($detalle_horario) && !empty($detalle_horario)){ echo $detalle_horario->nombrenivel." - ".$detalle_horario->nombregrupo; } ?></strong></h2>

              <div class="clearfix"></div>
            </div>
            <div class="x_content">



              <div id="appd">
                <div class="row">
                  <div class="col-md-12  col-sm-12 col-xs-12">
                    <?php if ($activo_horario == 1 && $activo_ciclo_escolar == 1) { ?>
                      <button class="btn btn-round btn-primary waves-effect waves-black" @click="modelAgregarMateria()"><i class='fa fa-plus'></i> Agregar Asignatura/Curso</button>

                      <button class="btn btn-round btn-primary waves-effect waves-black" @click="modelAgregarRecreo()"><i class='fa fa-plus'></i> Agregar Receso</button>

                      <button class="btn btn-round btn-primary waves-effect waves-black" @click="modelAgregarHoraSinClase()"><i class='fa fa-plus'></i> Agregar Receso por Dia</button>
                    <?php } ?>
                    <a target="_blank" class="btn btn-round btn-info waves-effect waves-black" href="<?php echo base_url(); ?>Horario/descargar/<?php echo $id ?>" class="btn btn-primary"><i class="fa fa-print"></i> IMPRIMIR HORARIO</a>
                  </div>
                </div>

                <div class="row">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>LUNES</th>
                        <th>MARTES</th>
                        <th>MIERCOLES</th>
                        <th>JUEVES</th>
                        <th>VIERNES</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          <div v-for="row in lunes">
                            <ul class="nav navbar-right panel_toolbox" style="border: 2px solid #ccc; border-radius: 4px; margin-bottom: 4px">
                                <li style="padding: 0 0 0 10px;"><a class="collapse-link " style="color: #000; text-decoration: none; ">
                                  <div v-if="row.opcion == 'NORMAL'">
                                    <strong   :title="row.nombreclase" >{{row.nombreclaserecortado}} </strong> ({{row.horainicial}}-{{row.horafinal}})<br>
                                     <small>{{row.nombre}} {{row.apellidop}} {{row.apellidom}}</small><br/>
                                    
                                     <small v-if="row.urlvideoconferencia" ><a target='_blank' v-bind:href="row.urlvideoconferencia"> <i class="fa fa-external-link"></i> {{row.urlvideoconferenciarecortado}}</a></small>
                                  </div>
                                  <div v-else>
                                    <strong>{{row.nombreclase}} </strong> ({{row.horainicial}}-{{row.horafinal}})
                                  </div>
                                </a>
                                  
                              </li>
                              <?php if ($activo_horario == 1 && $activo_ciclo_escolar == 1) { ?>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench" style="color: #1495ef;"></i></a>
                                  <ul class="dropdown-menu" role="menu">
                                      <li v-if="row.opcion == 'NORMAL'"><a @click="modelEditMateria(); selectHorario(row)" href="#"><i class="fa fa-pencil" style="color: #04b04d;"></i>  Editar</a>
                                    </li>

                                    <li v-if="row.opcion == 'DESCANSO'"><a @click=" modelEditRecreo();  selectHorario(row)" href="#"><i class="fa fa-pencil" style="color: #04b04d;"></i>  Editar</a>
                                    </li>
                                    <li v-if="row.opcion == 'SIN CLASES'"><a @click="modelEditHoraSinClase(); selectHorario(row)" href="#"><i class="fa fa-pencil" style="color: #04b04d;"></i> Editar</a>
                                    </li>

                                    <li v-if="row.opcion == 'NORMAL'"><a href="#" @click="deleteHorario(row.idhorariodetalle); selectHorario(row);"><i class="fa fa-trash" style="color: red;"></i> Eliminar</a>
                                    </li>

                                    <li v-if="row.opcion == 'DESCANSO'"><a href="#" @click="deleteReceso(row.idhorariodetalle); selectHorario(row);"><i class="fa fa-trash" style="color: red;"></i> Eliminar</a>
                                    </li>
                                    <li v-if="row.opcion == 'SIN CLASES'"><a href="#" @click="deleteSinClases(row.idhorariodetalle); selectHorario(row);"><i class="fa fa-trash" style="color: red;"></i> Eliminar</a>
                                    </li>
                                  </ul>
                                </li>
                              <?php } ?>
                            </ul>
                          </div>
                        </td>
                        <td>
                          <div v-for="row in martes">
                            <ul class="nav navbar-right panel_toolbox" style="border: 2px solid #ccc; border-radius: 4px; margin-bottom: 4px">
                              <li  style="padding: 0 0 0 10px;"><a class="collapse-link " style="color: #000;  text-decoration: none;">
                                  <div v-if="row.opcion == 'NORMAL'">
                                    <strong  :title="row.nombreclase">{{row.nombreclaserecortado}} </strong> ({{row.horainicial}}-{{row.horafinal}})<br>
                                    <small>{{row.nombre}} {{row.apellidop}} {{row.apellidom}}</small><br/>
                                     <small v-if="row.urlvideoconferencia" ><a target='_blank' v-bind:href="row.urlvideoconferencia"> <i class="fa fa-external-link"></i> {{row.urlvideoconferenciarecortado}}</a></small>
                                  </div>
                                  <div v-else>
                                    <strong>{{row.nombreclase}} </strong> ({{row.horainicial}}-{{row.horafinal}})
                                  </div>
                                </a>
                              </li>
                              <?php if ($activo_horario == 1 && $activo_ciclo_escolar == 1) { ?>
                                <li class="dropdown">
                                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"  style="color: #1495ef;"></i></a>
                                  <ul class="dropdown-menu" role="menu">
                                    <li v-if="row.opcion == 'NORMAL'"><a @click="modelEditMateria(); selectHorario(row)" href="#"><i class="fa fa-pencil" style="color: #04b04d;"></i> Editar</a>
                                    </li>

                                    <li v-if="row.opcion == 'DESCANSO'"><a @click=" modelEditRecreo(); selectHorario(row)" href="#"><i class="fa fa-pencil" style="color: #04b04d;"></i> Editar</a>
                                    </li>
                                    <li v-if="row.opcion == 'SIN CLASES'"><a @click="modelEditHoraSinClase(); selectHorario(row)" href="#"><i class="fa fa-pencil" style="color: #04b04d;"></i> Editar</a>
                                    </li>

                                    <li v-if="row.opcion == 'NORMAL'"><a href="#" @click="deleteHorario(row.idhorariodetalle); selectHorario(row);"><i class="fa fa-trash" style="color: red;"></i> Eliminar</a>
                                    </li>

                                    <li v-if="row.opcion == 'DESCANSO'"><a href="#" @click="deleteReceso(row.idhorariodetalle); selectHorario(row);"><i class="fa fa-trash" style="color: red;"></i> Eliminar</a>
                                    </li>
                                    <li v-if="row.opcion == 'SIN CLASES'"><a href="#" @click="deleteSinClases(row.idhorariodetalle); selectHorario(row);"><i class="fa fa-trash" style="color: red;"></i> Eliminar</a>
                                    </li>
                                  </ul>
                                </li>
                              <?php } ?>
                            </ul>
                          </div>
                        </td>
                        <td>
                          <div v-for="row in miercoles">
                            <ul class="nav navbar-right panel_toolbox" style="border: 2px solid #ccc; border-radius: 4px; margin-bottom: 4px">
                              <li  style="padding: 0 0 0 10px;"><a class="collapse-link " style="color: #000;  text-decoration: none;">
                                  <div v-if="row.opcion == 'NORMAL'">
                                    <strong  :title="row.nombreclase">{{row.nombreclaserecortado}} </strong> ({{row.horainicial}}-{{row.horafinal}})<br>
                                    <small>{{row.nombre}} {{row.apellidop}} {{row.apellidom}}</small><br/>
                                     <small  v-if="row.urlvideoconferencia" ><a target='_blank' v-bind:href="row.urlvideoconferencia"> <i class="fa fa-external-link"></i> {{row.urlvideoconferenciarecortado}}</a></small>
                                  </div>
                                  <div v-else>
                                    <strong>{{row.nombreclase}} </strong> ({{row.horainicial}}-{{row.horafinal}})
                                  </div>
                                </a>
                              </li>
                              <?php if ($activo_horario == 1 && $activo_ciclo_escolar == 1) { ?>
                                <li class="dropdown">
                                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"  style="color: #1495ef;"></i></a>
                                  <ul class="dropdown-menu" role="menu">
                                    <li v-if="row.opcion == 'NORMAL'"><a @click="modelEditMateria();  selectHorario(row)" href="#"><i class="fa fa-pencil" style="color: #04b04d;"></i> Editar</a>
                                    </li>

                                    <li v-if="row.opcion == 'DESCANSO'"><a @click="modelEditRecreo();  selectHorario(row)" href="#"><i class="fa fa-pencil" style="color: #04b04d;"></i> Editar</a>
                                    </li>
                                    <li v-if="row.opcion == 'SIN CLASES'"><a @click="modelEditHoraSinClase(); selectHorario(row)" href="#"><i class="fa fa-pencil" style="color: #04b04d;"></i> Editar</a>
                                    </li>

                                    <li v-if="row.opcion == 'NORMAL'"><a href="#" @click="deleteHorario(row.idhorariodetalle); selectHorario(row);"><i class="fa fa-trash" style="color: red;"></i> Eliminar</a>
                                    </li>

                                    <li v-if="row.opcion == 'DESCANSO'"><a href="#" @click="deleteReceso(row.idhorariodetalle); selectHorario(row);"><i class="fa fa-trash" style="color: red;"></i> Eliminar</a>
                                    </li>
                                    <li v-if="row.opcion == 'SIN CLASES'"><a href="#" @click="deleteSinClases(row.idhorariodetalle); selectHorario(row);"><i class="fa fa-trash" style="color: red;"></i> Eliminar</a>
                                    </li>
                                  </ul>
                                </li>
                              <?php } ?>
                            </ul>
                          </div>
                        </td>
                        <td>
                          <div v-for="row in jueves">
                            <ul class="nav navbar-right panel_toolbox" style="border: 2px solid #ccc; border-radius: 4px; margin-bottom: 4px">
                              <li  style="padding: 0 0 0 10px;"><a class="collapse-link " style="color: #000;  text-decoration: none;">
                                  <div v-if="row.opcion == 'NORMAL'">
                                    <strong  :title="row.nombreclase">{{row.nombreclaserecortado}} </strong> ({{row.horainicial}}-{{row.horafinal}})<br>
                                    <small>{{row.nombre}} {{row.apellidop}} {{row.apellidom}}</small><br/>
                                     <small v-if="row.urlvideoconferencia" ><a target='_blank' v-bind:href="row.urlvideoconferencia"> <i class="fa fa-external-link"></i> {{row.urlvideoconferenciarecortado}}</a></small>
                                  </div>
                                  <div v-else>
                                    <strong>{{row.nombreclase}} </strong> ({{row.horainicial}}-{{row.horafinal}})
                                  </div>
                                </a>
                              </li>
                              <?php if ($activo_horario == 1 && $activo_ciclo_escolar == 1) { ?>
                                <li class="dropdown">
                                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"  style="color: #1495ef;"></i></a>
                                  <ul class="dropdown-menu" role="menu">
                                    <li v-if="row.opcion == 'NORMAL'"><a @click="modelEditMateria();  selectHorario(row)" href="#"><i class="fa fa-pencil" style="color: #04b04d;"></i> Editar</a>
                                    </li>

                                    <li v-if="row.opcion == 'DESCANSO'"><a @click="modelEditRecreo();  selectHorario(row)" href="#"><i class="fa fa-pencil" style="color: #04b04d;"></i> Editar</a>
                                    </li>
                                    <li v-if="row.opcion == 'SIN CLASES'"><a @click="modelEditHoraSinClase(); selectHorario(row)" href="#"><i class="fa fa-pencil" style="color: #04b04d;"></i> Editar</a>
                                    </li>

                                    <li v-if="row.opcion == 'NORMAL'"><a href="#" @click="deleteHorario(row.idhorariodetalle); selectHorario(row);"><i class="fa fa-trash" style="color: red;"></i> Eliminar</a>
                                    </li>

                                    <li v-if="row.opcion == 'DESCANSO'"><a href="#" @click="deleteReceso(row.idhorariodetalle); selectHorario(row);"><i class="fa fa-trash" style="color: red;"></i> Eliminar</a>
                                    </li>
                                    <li v-if="row.opcion == 'SIN CLASES'"><a href="#" @click="deleteSinClases(row.idhorariodetalle); selectHorario(row);"><i class="fa fa-trash" style="color: red;"></i> Eliminar</a>
                                    </li>
                                  </ul>
                                </li>
                              <?php } ?>
                            </ul>
                          </div>
                        </td>
                        <td>
                          <div v-for="row in viernes">
                            <ul class="nav navbar-right panel_toolbox" style="border: 2px solid #ccc; border-radius: 4px; margin-bottom: 4px">
                              <li  style="padding: 0 0 0 10px;"><a class="collapse-link " style="color: #000; text-decoration: none;">
                                  <div v-if="row.opcion == 'NORMAL'">
                                    <strong  :title="row.nombreclase">{{row.nombreclaserecortado}} </strong> ({{row.horainicial}}-{{row.horafinal}})<br>
                                    <small>{{row.nombre}} {{row.apellidop}} {{row.apellidom}}</small><br/>
                                       <smalL v-if="row.urlvideoconferencia"><a target='_blank' v-bind:href="row.urlvideoconferencia"> <i class="fa fa-external-link"></i> {{row.urlvideoconferenciarecortado}}</a></small>
                                  </div>
                                  <div v-else>
                                    <strong>{{row.nombreclase}} </strong> ({{row.horainicial}}-{{row.horafinal}})
                                  </div>
                                </a>
                              </li>
                              <?php if ($activo_horario == 1 && $activo_ciclo_escolar == 1) { ?>
                                <li class="dropdown">
                                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"  style="color: #1495ef;"></i></a>
                                  <ul class="dropdown-menu" role="menu">
                                      <li v-if="row.opcion == 'NORMAL'"><a @click="modelEditMateria();  selectHorario(row)" href="#"><i class="fa fa-pencil" style="color: #04b04d;"></i> Editar</a>
                                    </li>

                                    <li v-if="row.opcion == 'DESCANSO'"><a @click=" modelEditRecreo(); selectHorario(row)" href="#"><i class="fa fa-pencil" style="color: #04b04d;"></i> Editar</a>
                                    </li>
                                    <li v-if="row.opcion == 'SIN CLASES'"><a @click="modelEditHoraSinClase(); selectHorario(row)" href="#"><i class="fa fa-pencil" style="color: #04b04d;"></i> Editar</a>
                                    </li>

                                    <li v-if="row.opcion == 'NORMAL'"><a href="#" @click="deleteHorario(row.idhorariodetalle); selectHorario(row);"><i class="fa fa-trash" style="color: red;"></i> Eliminar</a>
                                    </li>

                                    <li v-if="row.opcion == 'DESCANSO'"><a href="#" @click="deleteReceso(row.idhorariodetalle); selectHorario(row);"><i class="fa fa-trash" style="color: red;"></i> Eliminar</a>
                                    </li>
                                    <li v-if="row.opcion == 'SIN CLASES'"><a href="#" @click="deleteSinClases(row.idhorariodetalle); selectHorario(row);"><i class="fa fa-trash" style="color: red;"></i> Eliminar</a>
                                    </li>
                                  </ul>
                                </li>
                              <?php } ?>
                            </ul>
                          </div>
                        </td>
                      </tr>

                    </tbody>
                  </table>
                  <?php include 'modaldet.php'; ?>


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

 

  </div>
 

  <div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
  </div>
  <script data-my_var_1="<?php echo base_url() ?>" data-my_var_2="<?php echo $id; ?>" src="<?php echo base_url(); ?>/assets/vue/appvue/apphorariodetalle.js"></script>