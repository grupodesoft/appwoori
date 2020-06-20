<modal v-if="addModal" @close="clearAll()">
   <h3 slot="head" >Agregar Cobro -  C. </h3>
   <div slot="body">
      <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <label style="color: red" v-html="formValidate.msgerror"></label>
            </div>
        </div>
        <div class="row">
     <div class="col-md-12 col-sm-12 col-xs-12 ">
          <input type="hidden" name="" v-model="chooseSolicitud.idamortizacion" > 
         <div class="form-group">
           <label><font color="red">*</font> Total a pagar</label>
              <input type="text" v-model="chooseSolicitud.descuento" class="form-control"  :class="{'is-invalid': formValidate.descuento}" name="po" disabled=""> 
         </div>
         <div class="form-group">
          <label><font color="red">*</font> Forma de Pago</label>
          <select v-model="newCobro.idformapago"  :class="{'is-invalid': formValidate.idperiodo}" class="form-control">
                   <option value="">--Seleccione Forma Pago--</option>
                   <option   v-for="option in formaspago" v-bind:value="option.idformapago">
                        {{ option.nombretipopago }} 
                  </option>
         </select>
           <div class="text-danger" v-html="formValidate.idformapago"></div>
         </div>
          <div class="form-group">
            <label>Número Autorización</label>
             <input type="text" v-model="newCobro.autorizacion" class="form-control"  :class="{'is-invalid': formValidate.autorizacion}" name="po"> 
              <div class="text-danger" v-html="formValidate.autorizacion"></div>
         </div> 
      </div>
     </div>
   </div>
   <div slot="foot"> 
      <div class="row">
        <div  class="col-md-6 col-sm-12 col-xs-12 " align="center" >
           <div v-if="cargando">
               <img  style="width: 50px;" src="<?php echo base_url() . '/assets/loader/pagos.gif' ?>" alt=""> <strong>Procesando...</strong>
           </div>
           <div v-if="error"  align="left">
               <label class="text-danger">*Corrija los errores en el formulario.</label>
           </div>
        </div>
         <div class="col-md-6 col-sm-12 col-xs-12 "  align="right"  >
    <button type="button" class="btn btn-danger waves-effect waves-black"  @click="clearAll"> <i class="fa fa-times"></i> Cancelar</button>
      <button class="btn btn-primary waves-effect waves-black" @click="addCobro" ><i class="fa fa-check-circle"></i> Cobrar</button>
   </div>
      </div>
   </div>
</modal>


<modal v-if="addPagoModal" @close="clearAll()">
   <h3 slot="head" >Agregar Cobro -  | I. ${{ve.total_que_debe_pagar_inscripcion}} | R. ${{ve.total_que_debe_pagar_reinscripcion}}|</h3>
   <div slot="body">
         <div style=" height: 300px; overflow-x: hidden; overflow-y: scroll;">
      <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <label style="color: red" v-html="formValidate.msgerror"></label>
            </div>
        </div>
        <div class="row"> 
          <div class="col-md-6 col-sm-12 col-xs-12 "> 
          <div class="form-group">
          <label><font color="red">*</font> Tipo de Pago</label>
          <select v-model="newCobroInicio.idtipopagocol"  :class="{'is-invalid': formValidate.idtipopagocol}" class="form-control">
                   <option value="">-- SELECCIONAR --</option>
                   <option   v-for="option in tipospago" v-bind:value="option.idtipopagocol">
                        {{ option.concepto }} 
                  </option>
         </select>
           <div class="text-danger" v-html="formValidate.idtipopagocol"></div>
         </div>
        </div>
      </div>

              <div class="row" v-if="mostar_error_formapago">
                 <div class="col-md-12 col-sm-12 col-xs-12 ">
                         <label class="text-danger">{{error_formapago}}</label>
                 </div>
         </div>
         <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-12 ">
                
               <div class="form-group">
                  <label><font color="red">*</font> Forma de Pago</label>
                  <select v-model="array_formapago"  :class="{'is-invalid': formValidate.idperiodo}" class="form-control">
                     <option value="">-- SELECCIONAR --</option>
                     <option   v-for="option in formaspago" v-bind:value="option.idformapago">
                        {{ option.nombretipopago }} 
                     </option>
                  </select>
                  <div class="text-danger" v-html="formValidate.idformapago"></div>
               </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12 ">
               <div class="form-group">
                  <label><font color="red">*</font> Total a pagar</label>
                  <input type="text" v-model="array_descuento" class="form-control"  :class="{'is-invalid': formValidate.descuento}" name="po" > 
                  <small>Ejemplo: 300.00, 500.50, etc.</small>
                  <div class="text-danger" v-html="formValidate.descuento"></div>
               </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12 ">
               <div class="form-group">
                  <label>Número Autorización</label>
                  <input type="text" v-model="array_autorizacion" class="form-control"  :class="{'is-invalid': formValidate.autorizacion}" name="po"> 
                  <div class="text-danger" v-html="formValidate.autorizacion"></div>
               </div>
            </div>
              <div class="col-md-2 col-sm-2 col-xs-12 ">
               <div class="form-group">
                   <button @click="agregar_forma_pago_colegiatura()" style="margin-top: 25px;"  class="btn btn-info"> <i class="fa fa-plus" aria-hidden="true"></i> Agregar</button>
               </div>
              </div>
         </div>
         <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <table class="table">
                     <caption align="center" > <center><strong>Detalle de Forma de Pago</strong></center></caption>
                    <thead>
                        <th>Forma de Pago</th>
                        <th>Descuento</th>
                        <th>Número de Autorización</th>
                        <th></th>
                    </thead>
                    <tbody>
                        <tr v-for="(row, index) in array_pago_colegiatura">
                            <td>
                                <label  v-if="row.idformapago === '1'" class="text-success" for="">EFECTIVO</label>
                                <label v-else-if="row.idformapago === '2'" class="text-info" for="">TARJETA</label>
                                <label v-else for="" class=" text-dark">NO DEFINIDO</label>
                            </td>
                            <td >{{ row.descuento | currency }}</td>
                            <td >{{row.autorizacion}}</td>
                            <td><button  @click="deleteItem(index)" class="btn btn-danger">Quitar</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
         </div>
   </div>
   </div>
   <div slot="foot"> 
      <div class="row">
        <div  class="col-md-6 col-sm-12 col-xs-12 " align="center" >
           <div v-if="cargando">
               <img  style="width: 50px;" src="<?php echo base_url() . '/assets/loader/pagos.gif' ?>" alt=""> <strong>Procesando...</strong>
           </div>
           <div v-if="error"  align="left">
               <label class="text-danger">*Corrija los errores en el formulario.</label>
           </div>
               <div v-if="error_pago"  align="left">
               <label class="text-danger">*Agregar detalle de Forma de Pago.</label>
            </div>
        </div>
         <div class="col-md-6 col-sm-12 col-xs-12 "  align="right"  >
    <button type="button" class="btn btn-danger waves-effect waves-black"  @click="clearAll"> <i class="fa fa-times"></i> Cancelar</button>
      <button class="btn btn-primary waves-effect waves-black" @click="addCobroInicio" ><i class="fa fa-check-circle"></i> Cobrar</button>
   </div>
      </div>
   </div>
</modal>

<modal v-if="addPagoColegiaturaModal" @close="clearAll()">
   <h3 slot="head" >Agregar Cobro | C. ${{ve.total_que_debe_pagar_colegiatura}}</h3>
   <div slot="body">
      <div style=" height: 300px; overflow-x: hidden; overflow-y: scroll;">
         <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
               <label style="color: red" v-html="formValidate.msgerror"></label>
            </div>
         </div>
         <div class="row"> 
            <div class="col-md-6 col-sm-6 col-xs-12 ">
               <div class="form-group">
                  <label><font color="red">*</font> Mes a pagar</label>
                  <select v-model="newCobroColegiatura.idmes"  :class="{'is-invalid': formValidate.idmes}" class="form-control">
                     <option value="">-- SELECCIONAR --</option>
                     <option   v-for="option in meses" v-bind:value="option.idmes">
                        {{ option.nombremes }} 
                     </option>
                  </select>
                  <div class="text-danger" v-html="formValidate.idmes"></div>
               </div>
            </div>
         </div>  
         <div class="row" v-if="mostar_error_formapago">
                 <div class="col-md-12 col-sm-12 col-xs-12 ">
                         <label class="text-danger">{{error_formapago}}</label>
                 </div>
         </div>
         <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-12 ">
                
               <div class="form-group">
                  <label><font color="red">*</font> Forma de Pago</label>
                  <select v-model="array_formapago"  :class="{'is-invalid': formValidate.idperiodo}" class="form-control">
                     <option value="">-- SELECCIONAR --</option>
                     <option   v-for="option in formaspago" v-bind:value="option.idformapago">
                        {{ option.nombretipopago }} 
                     </option>
                  </select>
                  <div class="text-danger" v-html="formValidate.idformapago"></div>
               </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12 ">
               <div class="form-group">
                  <label><font color="red">*</font> Total a pagar</label>
                  <input type="text" v-model="array_descuento" class="form-control"  :class="{'is-invalid': formValidate.descuento}" name="po" > 
                  <small>Ejemplo: 300.00, 500.50, etc.</small>
                  <div class="text-danger" v-html="formValidate.descuento"></div>
               </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12 ">
               <div class="form-group">
                  <label>Número Autorización</label>
                  <input type="text" v-model="array_autorizacion" class="form-control"  :class="{'is-invalid': formValidate.autorizacion}" name="po"> 
                  <div class="text-danger" v-html="formValidate.autorizacion"></div>
               </div>
            </div>
              <div class="col-md-2 col-sm-2 col-xs-12 ">
               <div class="form-group">
                   <button @click="agregar_forma_pago_colegiatura()" style="margin-top: 25px;"  class="btn btn-info"> <i class="fa fa-plus" aria-hidden="true"></i> Agregar</button>
               </div>
              </div>
         </div>
         <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <table class="table">
                     <caption align="center" > <center><strong>Detalle de Forma de Pago</strong></center></caption>
                    <thead>
                        <th>Forma de Pago</th>
                        <th>Descuento</th>
                        <th>Número de Autorización</th>
                        <th></th>
                    </thead>
                    <tbody>
                        <tr v-for="(row, index) in array_pago_colegiatura">
                            <td>
                                <label  v-if="row.idformapago === '1'" class="text-success" for="">EFECTIVO</label>
                                <label v-else-if="row.idformapago === '2'" class="text-info" for="">TARJETA</label>
                                <label v-else for="" class=" text-dark">NO DEFINIDO</label>
                            </td>
                            <td >{{ row.descuento | currency }}</td>
                            <td >{{row.autorizacion}}</td>
                            <td><button  @click="deleteItem(index)" class="btn btn-danger">Quitar</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
         </div>
      </div>
   </div>
   <div slot="foot">
      <div class="row">
         <div  class="col-md-6 col-sm-12 col-xs-12 " align="center" >
            <div v-if="cargando">
               <img  style="width: 50px;" src="<?php echo base_url() . '/assets/loader/pagos.gif' ?>" alt=""> <strong>Procesando...</strong>
            </div>
            <div v-if="error"  align="left">
               <label class="text-danger">*Corrija los errores en el formulario.</label>
            </div>
            <div v-if="error_pago"  align="left">
               <label class="text-danger">*Agregar detalle de Forma de Pago.</label>
            </div>
         </div>
         <div class="col-md-6 col-sm-12 col-xs-12 "  align="right"  >
            <button type="button" class="btn btn-danger waves-effect waves-black"  @click="clearAll"> <i class="fa fa-times"></i> Cancelar</button>
            <button class="btn btn-primary waves-effect waves-black" @click="addCobroColegiatura" ><i class="fa fa-check-circle"></i> Cobrar</button>
         </div>
      </div>
   </div>
</modal>


<modal v-if="eliminarModalP" @close="clearAll()">
    <h3 slot="head" >Eliminar Cobro</h3>
    <div slot="body">
         <div style=" height: 100px;overflow-x: hidden; overflow-y: scroll;">
         <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <label class="text-danger" v-html="formValidate.msgerror"></label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Usuario</label>
                    <input type="password" v-model="eliminarPrimerCobro.usuario" class="form-control"  :class="{'is-invalid': formValidate.usuario}" name="po"> 
                           <div class="text-danger" v-html="formValidate.usuario"></div>
                </div>
            </div> 
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Contraseña</label>
                    <input type="password" v-model="eliminarPrimerCobro.password" class="form-control"  :class="{'is-invalid': formValidate.password}" name="po"> 
                           <div class="text-danger" v-html="formValidate.password"></div>
                </div>
            </div> 
        </div>  
 
</div>
    </div>
    <div slot="foot">
       <div class="row">
        <div  class="col-md-6 col-sm-12 col-xs-12 " align="center" >
           <div v-if="cargando">
               <img  style="width: 50px;" src="<?php echo base_url() . '/assets/loader/pagos.gif' ?>" alt=""> <strong>Procesando...</strong>
           </div>
           <div v-if="error"  align="left">
               <label class="text-danger">*Corrija los errores en el formulario.</label>
           </div>
        </div>
         <div class="col-md-6 col-sm-12 col-xs-12 "  align="right"  >
        <button class="btn btn-danger waves-effect waves-black" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>
        <button class="btn btn-primary waves-effect waves-black" @click="eliminarPagoInicio"><i class='fa fa-edit'></i> Eliminar</button>
    </div>
       </div>
    </div>
</modal>

<modal v-if="eliminarModalC" @close="clearAll()">
    <h3 slot="head" >Eliminar Cobro</h3>
    <div slot="body">
         <div style=" height: 100px;overflow-x: hidden; overflow-y: scroll;">
         <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <label class="text-danger" v-html="formValidate.msgerror"></label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Usuario</label>
                    <input type="password" v-model="eliminarColegiatura.usuario" class="form-control"  :class="{'is-invalid': formValidate.usuario}" name="po"> 
                           <div class="text-danger" v-html="formValidate.usuario"></div>
                </div>
            </div> 
            <div class="col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group">
                    <label><font color="red">*</font> Contraseña</label>
                    <input type="password" v-model="eliminarColegiatura.password" class="form-control"  :class="{'is-invalid': formValidate.password}" name="po"> 
                           <div class="text-danger" v-html="formValidate.password"></div>
                </div>
            </div> 
        </div>  
 
</div>
    </div>
    <div slot="foot">
       <div class="row">
        <div  class="col-md-6 col-sm-12 col-xs-12 " align="center" >
           <div v-if="cargando">
               <img  style="width: 50px;" src="<?php echo base_url() . '/assets/loader/pagos.gif' ?>" alt=""> <strong>Procesando...</strong>
           </div>
           <div v-if="error"  align="left">
               <label class="text-danger">*Corrija los errores en el formulario.</label>
           </div>
        </div>
         <div class="col-md-6 col-sm-12 col-xs-12 "  align="right"  >
        <button class="btn btn-danger waves-effect waves-black" @click="clearAll"><i class='fa fa-ban'></i> Cancelar</button>
        <button class="btn btn-primary waves-effect waves-black" @click="eliminarPagoColegiatura"><i class='fa fa-edit'></i> Eliminar</button>
    </div>
       </div>
    </div>
</modal>
