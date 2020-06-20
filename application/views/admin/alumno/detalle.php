  <!-- page content -->
      <div class="right_col" role="main">

        <div class=""> 

          <div class="row">
            <div class="col-md-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><strong>DETALLES DEL ALUMNO</strong></h2> 
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  

                            <div class="col-md-3 col-sm-3 col-xs-12 profile_left">

                    <div class="profile_img">

                      <!-- end of image cropping -->
                      <div id="crop-avatar">
                        <!-- Current avatar -->
                        <div class="avatar-view" title="Dar clic para cambiar la Foto.">
                          <?php if(isset($detalle->foto) && (!empty($detalle->foto) || $detalle->foto != null) ){ ?>
                          <img src="<?php echo base_url(); ?>/assets/alumnos/<?php echo $detalle->foto ?>" alt="Avatar">
                        <?php } else { ?>
                           <img src="<?php echo base_url(); ?>/assets/images/images.png" alt="Avatar">
                        <?php } ?>
                        </div>

                        <!-- Cropping modal -->
                        <div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <form class="avatar-form" action="<?php echo base_url('alumno/actualizarFoto')?>" enctype="multipart/form-data" method="post">
                                <div class="modal-header">
                                  <button class="close" data-dismiss="modal" type="button">&times;</button>
                                  <h4 class="modal-title" id="avatar-modal-label">Cambiar foto</h4>
                                </div>
                                <div class="modal-body">
                                  <div class="avatar-body">

                                    <!-- Upload image and data -->
                                    <div class="avatar-upload">
                                      <input class="avatar-src" name="avatar_src" type="hidden">
                                      <input class="avatar-data" name="avatar_data" type="hidden">
                                      <label for="avatarInput">Cargar imagen</label>
                                      <input class="avatar-input" id="avatarInput" name="avatar_file" type="file">
                                      <input type="hidden" name="idalumno" value="<?php echo $id;?>">
                                    </div>

                                    <!-- Crop and preview -->
                                    <div class="row">
                                      <div class="col-md-9">
                                        <div class="avatar-wrapper"></div>
                                      </div>
                                      <div class="col-md-3">
                                        <div class="avatar-preview preview-lg"></div>
                                        <div class="avatar-preview preview-md"></div>
                                        <div class="avatar-preview preview-sm"></div>
                                      </div>
                                    </div>

                                    <div class="row avatar-btns">
                                      <div class="col-md-9">
                                        <div class="btn-group">
                                          <button class="btn btn-primary" data-method="rotate" data-option="-90" type="button" title="Rotate -90 degrees">R. izquierda</button>
                                          <button class="btn btn-primary" data-method="rotate" data-option="-15" type="button">-15deg</button>
                                          <button class="btn btn-primary" data-method="rotate" data-option="-30" type="button">-30deg</button>
                                          <button class="btn btn-primary" data-method="rotate" data-option="-45" type="button">-45deg</button>
                                        </div>
                                        <div class="btn-group">
                                          <button class="btn btn-primary" data-method="rotate" data-option="90" type="button" title="Rotate 90 degrees">R. derecha</button>
                                          <button class="btn btn-primary" data-method="rotate" data-option="15" type="button">15deg</button>
                                          <button class="btn btn-primary" data-method="rotate" data-option="30" type="button">30deg</button>
                                          <button class="btn btn-primary" data-method="rotate" data-option="45" type="button">45deg</button>
                                        </div>
                                      </div>
                                      <div class="col-md-3">
                                        <button class="btn btn-primary btn-block avatar-save" type="submit">Subir</button>
                                        <button onclick="javascript:window.location.reload()" class="btn btn-danger btn-block">Cerrar</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- <div class="modal-footer">
                                                  <button class="btn btn-default" data-dismiss="modal" type="button">Close</button>
                                                </div> -->
                              </form>
                            </div>
                          </div>
                        </div>
                        <!-- /.modal -->

                        <!-- Loading state -->
                        <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
                      </div>
                      <!-- end of image cropping -->

                    </div>
                    <h3><?php echo $detalle->nombre." ".$detalle->apellidop." ".$detalle->apellidom ?></h3>

                    <ul class="list-unstyled user_data">
                      <li><i class="fa fa-key user-profile-icon" ></i> <label>Matricula:  <?php echo $detalle->matricula ?></label></li>

                      <li>
                        <i class="fa fa-home user-profile-icon" ></i> <label><?php if(isset($grupoactual) && empty($grupoactual)) { echo "Grupo no asignado";}else{ echo $grupoactual; } ?></label>
                      </li>
                      <li>
                        <i class="fa fa-check-circle" ></i> <label>Promedio Gral. <?php if(isset($promediogeneral) && !empty($promediogeneral)) {  echo number_format($promediogeneral,2);}else{ echo " --- "; } ?></label>
                      </li>
                      <li>
                        <i class="fa fa-check-circle "></i> <label><?php echo $detalle->nombreespecialidad ?></label>
                      </li>
                      <li>
                        <i class="fa fa-check-circle "></i> <label>Beca: <?php 
                        if(isset($becaalumno) && !empty($becaalumno)) {echo $becaalumno."%"; }else{ echo "0%";} 
                        ?></label>
                        <?php
                          if(isset($validargrupo) && !empty($validargrupo)) {
                            echo ' <i class="fa fa-pencil" title="Dar clic para modificar la Beca." data-toggle="modal" data-target=".bs-beca-modal-sm" ></i>'; 
                          }
                        ?>
                       
                      </li>


                     <!-- <li class="m-top-xs">
                        <i class="fa fa-external-link user-profile-icon"></i>
                        <a href="http://www.kimlabs.com/profile/" target="_blank">www.kimlabs.com</a>
                      </li>-->
                    </ul>

                   <div class="row">
                         <div class="col-md-12 col-sm-12 col-xs-12 " align="left">
                            <div class="form-group">
                                 <?php if(isset($validargrupo) && empty($validargrupo)){ ?>
                                 <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target=".bs-example-modal-sm">Asignar grupo</button>
                               <?php } ?>
                                <!--  <?php// if(isset($validargrupo) && !empty($validargrupo)){ ?>
                                 <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target=".bs-example-cambiar-modal-sm">Cambiar de grupo</button>
                                   <?php// } ?>-->
                            </div>
                        </div>   
                  </div> 
                    <br />

                    

                  </div>
                  <div class="col-md-9 col-sm-9 col-xs-12">
 

                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-bookmark"></i> <label>Kardex / Horario</label></a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-users"></i> <label>Tutor(es)</label></a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false"><i class="fa fa-money"></i> <label>Estado Cuenta</label></a>
                        </li>
                          <li role="presentation" class=""><a href="#tab_content4" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false"><i class="fa fa-user"></i> <label>D. Alumno(a)</label></a>
                        </li>
                      </ul>
                      <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
    <table class="table">
                    <thead>
                      <tr> 
                        <th>Periodo</th>
                        <th>Año</th>
                        <th>Grupo</th> 
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                          if(isset($kardex) && !empty($kardex)){
                            foreach($kardex as $row){
                           ?>
                              <tr> 
                                <td>
                                <?php 
                                    echo "<label>".$row->mesinicio." ".$row->yearinicio." - ".$row->mesfin." ".$row->yearfin."</label>";
                                 ?> 
                                </td> 
                                <td>
                                  <?php
                                    echo $row->nombrenivel;
                                  ?>
                                </td>
                                 <td>
                                  <?php
                                    echo $row->nombregrupo;
                                  ?>
                                </td>
                                <td align="right">
                                     <div class="btn-group" role="group">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-primary waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                             Opciones
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu"> 
                                            <li><a href="<?php echo site_url('Alumno/historial/'.$row->idhorario.'/'.$id) ?>"><i class="fa fa-list-alt" aria-hidden="true"></i> Boleta</a></li> 
                                            <li><a href="<?php echo site_url('Alumno/horario/'.$row->idhorario.'/'.$id) ?>"><i class="fa fa-clock-o"></i> Horario</a></li> 
                                           <!-- <li><a href="<?php //echo site_url('alumno/asistencia/'.$row->idhorario.'/'.$id) ?>"> <i class="fa fa-check"></i> Asistencia</a></li>  -->
                                           
                                          
                                        </ul>
                                    </div>
                                </div>
 

                                </td>
                             </tr>
                       <?php } } else{ echo "<tr><td colspan='4'>No existe Kardex del alumno.</td></tr>"; }?>
                    </tbody>
                  </table>

                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab"> 

                             <div id="app">
                            <div class="container">
                                <div class="row">
                                    <transition
                                        enter-active-class="animated fadeInLeft"
                                        leave-active-class="animated fadeOutRight">
                                        <div class="notification is-success text-center px-5 top-middle" v-if="successMSG" @click="successMSG = false">{{successMSG}}</div>
                                    </transition>
                                    <div class="col-md-12">
 
                                        <div class="row">
                                            <div class="col-md-6">
                                               <button class="btn btn-round btn-primary waves-effect waves-black" @click="addModal= true"><i class='fa fa-plus'></i> Asignar Tutor</button> 
                                            </div>
                                            <div class="col-md-6">
                                                <input placeholder="Buscar" type="search" class="form-control" v-model="search.text" @keyup="searchTutor" name="search">
                                            </div>
                                        </div>
                                        <br>
                                        <table class="table ">
                                            <thead class="" >

                                            <th class="text-white" v-column-sortable:nombre>Nombre </th>
                                            <th class="text-white" v-column-sortable:apellidop>A. Paterno </th>
                                            <th class="text-white" v-column-sortable:apellidom>A. Materno </th>
                                             <th class="text-center text-white">Opción </th>
                                            </thead>
                                            <tbody class="table-light">
                                                <tr v-for="tutor in tutores" class="table-default">

                                                    <td>{{tutor.nombre}}</td>
                                                    <td>{{tutor.apellidop}}</td>
                                                    <td>{{tutor.apellidom}}</td> 
                                                    <td align="right">


                                                        <button type="button" class="btn btn-icons btn-danger btn-sm waves-effect waves-black" @click="deleteTutor(tutor.idtutoralumno)"> <i class="fa fa-trash" aria-hidden="true"></i>
                                                          Quitar
                                                        </button> 

                                                    </td>
                                                </tr>
                                                <tr v-if="emptyResult">
                                                    <td colspan="4" class="text-center">No existe Tutor</td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="4" align="right">
                                            <pagination
                                                :current_page="currentPage"
                                                :row_count_page="rowCountPage"
                                                @page-update="pageUpdate"
                                                :total_users="totalTutores"
                                                :page_range="pageRange"
                                                >
                                            </pagination>
                                            </td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div> 
                            </div>
                            <?php include 'modaltutor.php'; ?>
                        </div>

                        </div>


                      <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">  
                            <div id="appestadocuenta">
                                <div class="container">
                                  <div class="row">
                                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                                        <div class="form-group"> 

                                             <select v-model="newBuscarCiclo.idperiodo"  ref="idperiodo" :class="{'is-invalid': formValidate.idperiodo}"class="form-control">
                                              <option value="">-- CICLO ESCOLAR --</option>
                                                <option   v-for="option in ciclos" v-bind:value="option.idperiodo">
                                                {{ option.mesinicio }}  {{ option.yearinicio }} - {{option.mesfin}}  {{ option.yearfin }}
                                              </option>
                                            </select>
                                            <span v-if="mostrar_error" style="color:red;">Ciclo Escolar requerido</span>
                                        </div>
                                    </div>  
                                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                                  
                                        <div class="form-group" > 
                                        <div v-if="btnbuscar">    
                                        <button   class="btn btn-primary waves-effect waves-black"  @click.prevent="searchSolicitud()" style="margin-top: 0"><i class="fa fa-search"></i> Buscar</button>
                                        </div>     
                                           
                                            <div v-if="loaging_buscar"  >
                                                <img  style="width: 50px;" src="<?php echo base_url() . '/assets/loader/pagos.gif' ?>" alt=""> <strong>Buscando...</strong>
                                            </div>
                                             </div>
                                              
                                    </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-12 col-sm-12 col-xs-12 ">
                                  <div v-if="mostrar">
                                      <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12" align="left"> 
                                      <button v-if="btnpagar"   @click="addPagoModal = true;" class="btn btn-default waves-effect waves-black"> <i class="fa fa-plus-circle"></i> Agregar Pago</button>
                                    </div>
                                  </div>  
                                  <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12" align="center">
                                      <small style="font-weight: bold;text-decoration: underline red; ">Pagos de Inscripcion o Reinscripcion</small>
                                    </div>
                                     </div>  
                                   
                                     <table class="table table-hover">
                                          <thead style="background-color: #e3e3df;">
                                            <tr>
                                              <th>Descuento</th> 
                                              <th>Forma de Pago</th>
                                              <th>Estatus</th>
                                              <th>Fecha</th> 
                                               <th></th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <tr v-for="pago in pagos" class="table-default">  
                                               <td><label style="font-weight: bold;">{{pago.descuento | currency}}</label></td> 
                                               <td align="left">
                                                <label v-if="pago.idtipopago == 1" class="label label-primary">{{pago.nombretipopago}}</label>
                                                <label  v-else class="label label-default">{{pago.nombretipopago}}</label>
                                               </td> 
                                                <td align="left">
                                                <label v-if="pago.pagado == 1" class="label label-success">PAGADO</label>
                                                <label  v-else class="label label-warning">EN PROCESO</label>
                                               </td> 
                                               <td>{{pago.fechapago}}</td> 
                                               
                                               <td align="left">
                                                    <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-info waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                 Opciones
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu">   
                                                <li><a v-if="pago.pagado==1" ref="#"  @click="eliminarModalP = true; selectPrimerPago(pago)"> <i class="fa fa-trash" style="color: red;"></i> Eliminar</a></li>  
                                                <li v-if="pago.pagado==1"><a  target="_blank" ref="#"  v-bind:href="'../../EstadoCuenta/imprimir/'+ pago.idpago+'/'+idperiodobuscado+'/'+idalumno+'/0'" ><i class="fa fa-print" style="color:blue;"></i> Imprimir</a></li>  
                                             </ul>
                                        </div>
                                               </td> 
                                            </tr> 
                                            <tr v-if="noresultadoinicio">
                                              <td colspan="4" align="center">
                                                No abonado Incripción/Reincripción
                                              </td>
                                            </tr>
                                          </tbody> 
                                        </table>
                                        <div class="row" v-if="btnpagarcolegiatura">
                                          <div class="col-md-12 col-sm-12 col-xs-12">
                                            <button class="btn btn-info waves-effect waves-black"  @click="addPagoColegiaturaModal = true;"> <i class="fa fa-plus-circle"></i> Agregar Pago</button>
                                          </div>
                                        </div>
                                  <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12" align="center">

                                      <small style="font-weight: bold;text-decoration: underline red;  ">Pagos de Colegiaturas</small>
                                    </div>
                                  </div> 
                                       <table class="table table-hover">
                                          <thead style="background-color: #68c5ea">
                                            <tr>
                                             
                                              <th>Mes</th> 
                                              <th>Descuento</th>
                                              <th>Pagado</th>
                                              <th>Fecha</th>
                                               <th></th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <tr v-for="solicitud in solicitudes" class="table-default">
                                               
                                               
                                               <td>{{solicitud.mes}}</td> 
                                               <td><strong>{{solicitud.descuento | currency}}</strong></td>
                                               <td>
                                                   <span v-if="solicitud.pagado==1" class="label label-success">PAGADO</span>
                                                   <span v-else class="label label-warning">EN PROCESO</span>
                                               </td>
                                               <td>{{solicitud.fecha}}</td>
                                               <td>
                                                 
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-info waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                 Opciones
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu"> 
                                                <!--<li v-if="solicitud.pagado==0"  @click="addModal = true; selectPeriodo(solicitud)"><a href="#" ><i class="fa fa-money" aria-hidden="true"></i> Pagar</a></li> -->
                                               
                                                <li  v-if="solicitud.pagado==1"><a  ref="#" @click="eliminarModalC = true; selectPeriodo(solicitud)"> <i class="fa fa-trash" style="color: red;"></i> Eliminar</a></li>  
                                                  <li v-if="solicitud.pagado==1"><a  target="_blank" ref="#"  v-bind:href="'../../EstadoCuenta/imprimir/'+ solicitud.idpago+'/'+idperiodobuscado+'/'+idalumno+'/1'" ><i class="fa fa-print" style="color:blue;"></i> Imprimir</a></li>  
                                              
                                            </ul>
                                        </div>
                                     

                                               </td>
                                            </tr> 
                                            <tr v-if="noresultado">
                                              <td colspan="5" align="center">Sin estado de cuenta</td>
                                            </tr>
                                          </tbody> 
                                        </table>
                  
                                  </div>
                            </div>
                                </div>
                            </div>
                            <?php include 'modal_estadocuenta.php' ?>
                        </div>
                     </div>
                                

                       <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="profile-tab">
                              <div class="row">
                                   <div class="col-md-6 col-sm-12 col-xs-12 ">
                                        <h5 align="center">Datos del Alumno(a)</h5>
                                         <div>
                                           <ul>
                                          <li>  CURP: <label for=""><?php echo $detalle->curp; ?></label> </li>
                                          <li><i class="fa fa-phone"></i> Núm Celular:  <label for=""><?php echo $detalle->telefono; ?></label></li>
                                          <li><i class="fa fa-phone"></i> Núm Emergencia: <label for=""> <?php echo $detalle->telefonoemergencia; ?></label></li>
                                          <li>L. Nacimiento: <label for=""><?php echo $detalle->lugarnacimiento; ?></label></li>
                                          <li>Nacionalidad: <label for=""><?php echo $detalle->nacionalidad; ?></label> </li>
                                          <li>Servicio Medico: <label for=""><?php echo $detalle->serviciomedico; ?></label></li>
                                          <li>Alergia o Padecimiento: <label for=""><?php echo $detalle->alergiaopadecimiento; ?></label></li>
                                           <li>T. Sanguineo: <label for=""><?php echo $detalle->tiposanguineo; ?></label></li>
                                           <li>Peso: <label for=""><?php echo $detalle->peso; ?></label></li>
                                           <li>Estatura: <label for=""><?php echo $detalle->estatura; ?></label></li>
                                           <li>Núm Folio: <label for=""><?php echo $detalle->numfolio; ?></label></li>
                                           <li>Núm Acta: <label for=""><?php echo $detalle->numacta; ?></label></li>
                                           <li>Núm Libro: <label for=""><?php echo $detalle->numlibro; ?></label></li>
                                           <li>F. Nacimiento: <label for=""><?php echo $detalle->fechanacimiento; ?></label></li>
                                           <li>Sexo: <label for=""><?php 
                                                if($detalle->sexo == 1){
                                                  echo "HOMBRE";
                                                }else{
                                                  echo "MUJER";
                                                }
                                           ?></label></li>
                                           <li>Correo: <label for=""><?php echo $detalle->correo; ?></label></li>
                                            <li>Domicilio: <label for=""><?php echo $detalle->domicilio; ?></label></li>
                                      </ul>
                                        </div>
                                   </div>
                                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                                        <h5 align="center">Datos del Tutor</h5>
                                        <?php if(isset($tutores) && !empty($tutores)){
                                          foreach($tutores as $value){
                                          ?>
                                        <ul>
                                          <li>Nombre: <label for=""><?php echo $value->nombre." ".$value->apellidop." ".$value->apellidom ?></label></li>
                                          <li>Escolaridad: <label for=""><?php echo $value->escolaridad; ?></label></li>
                                          <li>Ocupación: <label for=""><?php echo $value->ocupacion; ?></label></li>
                                          <li>Donde Trabaja: <label for=""><?php echo $value->dondetrabaja; ?></label></li>
                                          <li>Telefono: <label for=""><?php echo $value->telefono; ?></label></li>
                                          <li>Correo: <label for=""><?php echo $value->correo; ?></label></li>
                                          <li>Domicilio: <label for=""><?php echo $value->direccion; ?></label></li>
                                        </ul>
                                        <hr>
                                        <?php } } ?>
                                   </div>
                              </div>
                       </div>

                      </div>
                    </div>
                  </div>

                 <!-- MODAL ASIGNAR/MODIFICAR BEVA -->
                  <div class="modal fade bs-beca-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-sm">
                    <div class="modal-content">

                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel2">ASIGNAR BECA</h4>
                      </div>
                        <form method="post" id="frmasignarbeca" action="">
                      <div class="modal-body">
                       
                          <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 ">
                               <div class="alert alert-danger print-error-msg" style="display:none"></div>
                               <div class="alert alert-success print-success-msg" style="display:none"></div>
                                <div class="form-group">
                                    <label><font color="red">*</font> Beca</label>
                                   
                                        <select name="idbeca" required=""  class="form-control" >
                                            <option value="">-- SELECCIONAR --</option>
                                              <?php if(isset($becas) && !empty($becas)){ 
                                                foreach($becas as $row){
                                                ?>
                                                <option value="<?php echo $row->idbeca ?>"><?php echo $row->descuento.'%'; ?></option>
                                             
                                              <?php  }  } ?>
                                        </select>
                                   
                                </div> 
                            </div>  
                        </div>
                      
                      </div>
                      <div class="modal-footer">
                         <input type="hidden" name="idalumnobeca" value="<?php echo $id ?>">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class='fa fa-ban'></i>  Cerrar</button>
                        <button type="button" id="btnasignarbeca" class="btn btn-primary"> <i class='fa fa-floppy-o'></i> Aceptar</button>
                      </div>
                        </form>

                    </div>
                  </div>
                </div>
                <!-- FIN MODAL ASIGNAR/MODIFICAR BECA -->
                 <!-- MODAL ASIGNAR GRUPO -->
                  <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-sm">
                    <div class="modal-content">

                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel2">ASIGNAR GRUPO</h4>
                      </div>
                        <form method="post" id="frmasignargrupo" action="">
                      <div class="modal-body">
                       
                          <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 ">
                               <div class="alert alert-danger print-error-msg" style="display:none"></div>
                               <div class="alert alert-success print-success-msg" style="display:none"></div>
                                <div class="form-group">
                                    <label><font color="red">*</font> Ciclo Escolar</label>
                                   
                                        <select name="idcicloescolar" required=""  class="form-control" >
                                            <option value="">-- SELECCIONAR --</option>
                                              <?php if(isset($cicloescolar) && !empty($cicloescolar)){ 
                                                foreach($cicloescolar as $row){
                                                ?>
                                                <option value="<?php echo $row->idperiodo ?>"><?php echo $row->mesinicio." - ".$row->mesfin." ".$row->yearfin ?></option>
                                             
                                              <?php  }  } ?>
                                        </select>
                                   
                                </div>
                                <div class="form-group">
                                    <label><font color="red">*</font> Grupo</label>
                                   
                                        <select name="idgrupo" required=""  class="form-control" >
                                            <option value="">-- SELECCIONAR --</option>
                                              <?php if(isset($grupos) && !empty($grupos)){ 
                                                foreach($grupos as $row){
                                                ?>
                                                <option value="<?php echo $row->idgrupo ?>"><?php echo $row->nombrenivel." - ".$row->nombregrupo ?></option>
                                             
                                              <?php  }  } ?>
                                        </select>
                                   
                                </div>
                            </div>  
                        </div>
                      
                      </div>
                      <div class="modal-footer">
                         <input type="hidden" name="idalumno" value="<?php echo $id ?>">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class='fa fa-ban'></i>  Cerrar</button>
                        <button type="button" id="btnasignargrupo" class="btn btn-primary"> <i class='fa fa-floppy-o'></i> Aceptar</button>
                      </div>
                        </form>

                    </div>
                  </div>
                </div>
                <!-- FIN MODAL ASIGNAR GRUPO -->

<!--MODAL PARA MOFIFICAR GRUPO-->
                  <div class="modal fade bs-example-cambiar-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-sm">
                    <div class="modal-content">

                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel2">GRUPO</h4>
                      </div>
                       <form method="post" id="frmcambiargrupo" action="">
                      <div class="modal-body">
                       
                          <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 ">
                              <div class="alert alert-success print-success-msg" style="display:none"></div>
                              <div class="alert alert-danger print-error-msg" style="display:none"></div>
                                <div class="form-group">
                                    <label><font color="red">*</font> Grupo</label>
                                   
                                        <select name="idgrupo" required=""  class="form-control" >
                                            <option value="">-- SELECCIONAR --</option>
                                              <?php if(isset($grupos) && !empty($grupos)){ 
                                                foreach($grupos as $row){
                                                ?>
                                                <option value="<?php echo $row->idgrupo ?>"><?php echo $row->nombrenivel." - ".$row->nombregrupo ?></option>
                                             
                                              <?php  }  } ?>
                                        </select>
                                   
                                </div>
                            </div>  
                        </div>
                      
                      </div>
                      <div class="modal-footer">
                        <input type="hidden" name="idalumno" value="<?php echo $id ?>">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="btncambiargrupo">Guardar</button>
                      </div>
                        </form>
                    </div>
                  </div>
                </div>
 <!--FIN DEL MODAL PARA MODIFICAR GRUPO-->

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
  <script src="<?php echo base_url(); ?>/assets/vue/vue2-filters.min.js"></script>
  <script data-my_var_1="<?php echo base_url() ?>" data-my_var_2="<?php echo $id ?>" src="<?php echo base_url(); ?>/assets/vue/appvue/appalumnotutor.js"></script> 
  <script data-my_var_1="<?php echo base_url() ?>" data-my_var_2="<?php echo $id ?>" src="<?php echo base_url(); ?>/assets/vue/appvue/appestadocuenta.js"></script> 

<script type="text/javascript">
    $(document).ready(function() {

        var myform;
        var disabled;
        var serialized;

        $("#btncambiargrupo").click(function(){
 
            myform = $('#frmcambiargrupo'); 
            serialized = myform.serialize();
            $.ajax({
             method: "POST",
             url: "<?php echo site_url('Alumno/cambiarGrupo'); ?>",
             data: serialized,
             beforeSend: function( xhr ) { 
            }
          }).done(function(data) {
              console.log(data);
              var msg = $.parseJSON(data);
                      console.log(msg.error);
                      if((typeof msg.error === "undefined")){ 
                      $(".print-error-msg").css('display','none'); 
                      // window.location.href = "<?php //echo site_url('hold/index'); ?>";
                      }else{ 
                      $(".print-error-msg").css('display','block'); 
                      $(".print-error-msg").html(msg.error);

                      } 
                      }); 
                      
                  });

           $("#btnasignargrupo").click(function(){ 
                myform = $('#frmasignargrupo'); 
            serialized = myform.serialize();
            $.ajax({
             method: "POST",
             url: "<?php echo site_url('Alumno/asignarGrupo'); ?>",
             data: serialized,
             beforeSend: function( xhr ) {
                //xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
                console.log(xhr);
            }
        }).done(function(data) { 
                      var val = $.parseJSON(data); 
                        if((val.success === "Ok")){ 
                          $(".print-success-msg").css('display','block'); 
                          $(".print-success-msg").html("Fue asignado al Grupo.");
                          setTimeout(function() {
                            $('.print-error-msg').fadeOut('fast');
                            location.reload(); 
                          }, 3000);

                        }else{ 
                          $(".print-error-msg").css('display','block'); 
                          $(".print-error-msg").html(val.error);
                          setTimeout(function() {$('.print-error-msg').fadeOut('fast');}, 6000);
                        } 
                     }); 
                    
                });
        $("#btnasignarbeca").click(function(){ 
                myform = $('#frmasignarbeca'); 
            serialized = myform.serialize();
            $.ajax({
             method: "POST",
             url: "<?php echo site_url('Alumno/asignarBeca'); ?>",
             data: serialized,
             beforeSend: function( xhr ) {
                //xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
                console.log(xhr);
            }
        }).done(function(data) { 
                      var val = $.parseJSON(data); 
                        if((val.success === "Ok")){ 
                          $(".print-success-msg").css('display','block'); 
                          $(".print-success-msg").html("La beca fue registrada.");
                          setTimeout(function() {
                            $('.print-error-msg').fadeOut('fast');
                            location.reload(); 
                          }, 3000);

                        }else{ 
                          $(".print-error-msg").css('display','block'); 
                          $(".print-error-msg").html(val.error);
                          setTimeout(function() {$('.print-error-msg').fadeOut('fast');}, 6000);
                        } 
                     }); 
                    
                }); 
    });

</script>