<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");

class EstadoCuenta extends CI_Controller {

    function __construct() {
        parent::__construct();

        if (!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('welcome');
        }
        $this->load->helper('url');
        $this->load->model('data_model');
        $this->load->model('EstadoCuenta_model', 'estadocuenta');
        $this->load->model('Alumno_model', 'alumno');
        $this->load->model('user_model', 'usuario');
        $this->load->library('permission');
        $this->load->library('session');
        $this->load->helper('numeroatexto_helper');
        $this->load->model('configuracion_model', 'configuracion');
    }

    /* $cantidad = trim($this->input->post('cantidad'));

      if (empty($cantidad)) {
      echo json_encode(array('leyenda' => 'Debe introducir una cantidad.'));

      return;
      }

      # verificar si el número no tiene caracteres no númericos, con excepción
      # del punto decimal
      $xcantidad = str_replace('.', '', $cantidad);

      if (FALSE === ctype_digit($xcantidad)){
      echo json_encode(array('leyenda' => 'La cantidad introducida no es válida.'));

      return;
      }

      # procedemos a covertir la cantidad en letras
      $this->load->helper('numeros');
      $response = array(
      'leyenda' => num_to_letras($cantidad)
      , 'cantidad' => $cantidad
      );
      echo json_encode($response);
      } */

    public function imprimir($idpago = '', $idperiodo = '', $idalumno = '', $tipo = '') {
        Permission::grant(uri_string());
        $concepto = "";
        if ($tipo == 1) {
            $detalle = $this->estadocuenta->detalleAlumnoRecibo($idpago);
            $concepto .= "MENSUALIDAD DE " . $detalle->nombremes;
        } else {
            $detalle = $this->estadocuenta->detalleAlumnoPrimerRecibo($idpago);
            $concepto .= $detalle->concepto;
        }
        $detalle_periodo = $this->estadocuenta->detallePeriodo($idperiodo);
        $detalle_grupo = $this->estadocuenta->grupoAlumno($idalumno, $idperiodo);
        $grupo = $detalle_grupo->nombrenivel . ' ' . $detalle_grupo->nombregrupo;
        $ciclo_escolar = $detalle_periodo->mesiniciol . ' A ' . $detalle_periodo->mesfinl . ' DE ' . $detalle_periodo->yearfin;
        $descuento = $detalle->descuento;
        $logo = base_url() . '/assets/images/escuelas/' . $detalle->logoplantel;
        $xcantidad = str_replace('.', '', $descuento);
        if (FALSE === ctype_digit($xcantidad)) {
            echo json_encode(array('leyenda' => 'La cantidad introducida no es válida.'));

            return;
        }
        $response = array(
            'leyenda' => num_to_letras($descuento)
            , 'cantidad' => $descuento
        ); 
        $this->load->library('tcpdf'); 
        $fechaactual = date('d/m/Y');
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetTitle('Recibo de Pago.');
        $pdf->SetHeaderMargin(30);
        $pdf->SetTopMargin(10);
        $pdf->setFooterMargin(20);
        $pdf->SetAutoPageBreak(true);
        $pdf->SetAuthor('Sistema Integral para el Control Escolar');
        $pdf->SetDisplayMode('real', 'default');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->AddPage();

        $tbl = ' 
        <style>
          .txtgeneral{
            font-size:10px;
          }
          .txtdireccion{
             font-size:7px;
             cell-spacing:0;
          }
          .imgtitle{
        width:55px; 
    }
    .txtusuario{
       font-size:8px;
    }
    .txtcliclo{
      font-size:8px;
    }
    .txtplantel{
      font-size:11px;
      font-weight:bold;
    }
        </style>
        <table width="575" border="0">
  <tr>
    <td colspan="2" rowspan="3" nowrap="nowrap" width="94" valing="top" aling="center"><img    class="imgtitle" src="' . $logo . '" /></td>
    <td width="304" rowspan="3" nowrap="nowrap" align="center" valign="center">
    <label class="txtplantel">' . $detalle->nombreplantel . '</label><br>
    <label class="txtdireccion">' . $detalle->direccion . '</label><br>
    <label class="txtdireccion"> TELEFONO: ' . $detalle->telefono . '</label><br>
     <label class="txtdireccion"> CLAVE: ' . $detalle->clave . '</label>
 
    
    </td>
    <td width="70" nowrap="nowrap" class="txtgeneral"><strong>Fecha:</strong></td>
    <td width="73" nowrap="nowrap" class="txtgeneral">' . $detalle->fechapago . '</td>
  </tr>
  <tr>
    <td nowrap="nowrap" class="txtgeneral"><strong>Recibo:</strong></td>
    <td nowrap="nowrap" class="txtgeneral"><font color="red"><strong>' . $detalle->folio . '</strong></font></td>
  </tr>
  <tr>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" nowrap="nowrap" width="94">&nbsp;</td>
    <td colspan="2" align="center" nowrap="nowrap" width="304">&nbsp;</td>
    <td align="center" nowrap="nowrap" width="70" class="txtcliclo">GRUPO:</td>
    <td align="center" nowrap="nowrap" width="73" align="left" class="txtcliclo">&nbsp;' . $grupo . '</td>
  </tr>
    <tr>
    <td colspan="3" align="left" nowrap="nowrap" width="399" class="txtgeneral"><strong>Alumno(a):</strong> ' . $detalle->apellidop . ' ' . $detalle->apellidom . ' ' . $detalle->nombre . '</td>
    <td colspan="2" align="center" nowrap="nowrap" width="143" class="txtcliclo">' . $ciclo_escolar . '</td>
  </tr>
     <tr>
    <td align="center" nowrap="nowrap" width="94">&nbsp;</td>
    <td colspan="2" align="center" nowrap="nowrap" width="304">&nbsp;</td>
    <td align="center" nowrap="nowrap" width="70">&nbsp;</td>
    <td align="center" nowrap="nowrap" width="73">&nbsp;</td>
  </tr>
  <tr>
    <td width="94" align="center" nowrap="nowrap" class="txtgeneral" ><strong>Can</strong></td>
    <td colspan="2" align="left" nowrap="nowrap" width="304" class="txtgeneral"><strong>Concepto</strong></td>
    <td align="center" nowrap="nowrap" width="70" class="txtgeneral"><strong>Cantidad</strong></td>
    <td align="center" nowrap="nowrap" width="73" class="txtgeneral">&nbsp;</td>
  </tr>
  <tr>
    <td nowrap="nowrap" class="txtgeneral" align="center"style="border-top:solid 1px black;border-bottom:solid 1px black;">&nbsp;1</td>
    <td colspan="2" nowrap="nowrap" class="txtgeneral" style="border-top:solid 1px black;border-bottom:solid 1px black;">' . $concepto . '</td>
    <td nowrap="nowrap" class="txtgeneral" align="center" style="border-top:solid 1px black;border-bottom:solid 1px black;">$' . number_format($detalle->descuento, 2) . '</td>
    <td nowrap="nowrap" class="txtgeneral" align="center" style="border-top:solid 1px black;border-bottom:solid 1px black;">&nbsp;</td>
  </tr>
  <tr>
    <td nowrap="nowrap">&nbsp;</td>
    <td colspan="2" nowrap="nowrap" class="txtgeneral"></td>
    <td nowrap="nowrap" class="txtgeneral" align="center"></td>
    <td nowrap="nowrap">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" nowrap="nowrap" class="txtgeneral"><strong>Forma de Pago:</strong> ' . $detalle->nombretipopago . '</td>
    <td nowrap="nowrap"  class="txtgeneral">Subtotal:</td>
    <td nowrap="nowrap" class="txtgeneral">$' . number_format($detalle->descuento, 2) . '</td>
  </tr>
  <tr>
    <td nowrap="nowrap">&nbsp;</td>
    <td colspan="2" nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap"  class="txtgeneral">Total:</td>
    <td nowrap="nowrap" class="txtgeneral"><strong>$' . number_format($detalle->descuento, 2) . '</strong></td>
  </tr>
  <tr>
    <td colspan="3" nowrap="nowrap" class="txtgeneral"><strong>Cantidad con letra:</strong> ' . num_to_letras($descuento) . ' </td>
    <td nowrap="nowrap"  class="txtgeneral"></td>
    <td nowrap="nowrap">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="right" nowrap="nowrap" class="txtgeneral">Lo atendio: <label class="txtusuario">' . $this->session->nombre . ' ' . $this->session->apellidop . ' ' . $this->session->apellidom . '</label></td>
    
  </tr>
</table>';

        $pdf->writeHTML($tbl, true, false, false, false, '');
        ob_end_clean();
        $pdf->Output('Kardex de Calificaciones', 'I');
    }

    public function showAllCicloEscolar() {
        $idplantel = $this->session->idplantel;
        $query = $this->estadocuenta->showAllCicloEscolar($idplantel);
        if ($query) {
            $result['ciclos'] = $this->estadocuenta->showAllCicloEscolar($idplantel);
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function showAllFormasPago() {
        $query = $this->estadocuenta->showAllFormasPago();
        if ($query) {
            $result['formaspago'] = $this->estadocuenta->showAllFormasPago();
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function showAllTipoPago() {
        $query = $this->estadocuenta->showAllTipoPago();
        if ($query) {
            $result['tipospago'] = $this->estadocuenta->showAllTipoPago();
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }
    
    public function costoPagoInicio() {
        $idplantel = $this->session->idplantel;
        $idalumno = $this->input->get('idalumno');
        $idperiodo = $this->input->get('idperiodo');
        $idconcepto = $this->input->get('idconcepto');
        $cobro_colegiatura = 0;
          $detalle_niveleducativo = $this->alumno->detalleAlumnoNivelEducativo($idalumno,$idperiodo);
                if($detalle_niveleducativo){
                      $idniveleducativo = $detalle_niveleducativo->idnivelestudio;
                     $detalle_descuento = $this->estadocuenta->descuentoPagosInicio($idalumno, $idperiodo, $idconcepto,$idplantel,$idniveleducativo);
                    if($detalle_descuento){
                        if ($detalle_descuento[0]->descuento > 0) {
                            $cobro_colegiatura = $detalle_descuento[0]->descuento;
                        } else {
                            $cobro_colegiatura = 0;
                        }
                        
                    }else{
                        $cobro_colegiatura = 0;
                    }
                    }else{
                        $cobro_colegiatura = 0;
                    }

          $result['cobro_inicio'] =  $cobro_colegiatura;
        
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }

    }
    public function agregarCostoColegiatura()
    {
        $idplantel = $this->session->idplantel;
        $idalumno = $this->input->get('idalumno');
        $idperiodo = $this->input->get('idperiodo');
        $idmes = $this->input->get('idmes');
        $costo_colegiatura = 0;
         $detalle_niveleducativo = $this->alumno->detalleAlumnoNivelEducativo($idalumno,$idperiodo);
                if($detalle_niveleducativo){
                      $idniveleducativo = $detalle_niveleducativo->idnivelestudio;
                      $detalle_descuento = $this->estadocuenta->descuentoPagosInicio($idalumno, $idperiodo, 3,$idplantel, $idniveleducativo);
                        $detalle_alumno = $this->alumno->detalleAlumno($idalumno); 
                      $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel,$detalle_alumno->idniveleducativo);  
                      $recargo = 0;

                            if ($detalle_descuento[0]->idniveleducativo == 1) {
                                //PRIMARIA 
                               
                                    $dia_actual = date('Y-m-d');
                                    $year_actual = date('Y');
                                    $dia_pago = date('Y-m-d', strtotime($detalle_configuracion[0]->diaultimorecargo . "-" . $idmes . "-" . $year_actual));
                                    if ($dia_actual > $dia_pago) {
                                        $recargo += $detalle_configuracion[0]->totalrecargo;
                                    } else {
                                        $recargo += 0;
                                    }
                                
                            } elseif ($detalle_descuento[0]->idniveleducativo == 2) {
                                //SECUNDARIA 
                               
                                    $dia_actual = date('Y-m-d');
                                    $year_actual = date('Y');
                                    $dia_pago = date('Y-m-d', strtotime($detalle_configuracion[0]->diaultimorecargo . "-" . $idmes . "-" . $year_actual));
                                    if ($dia_actual > $dia_pago) {
                                        $recargo += $detalle_configuracion[0]->totalrecargo;
                                    } else {
                                        $recargo += 0;
                                    }
                                
                            } elseif ($detalle_descuento[0]->idniveleducativo == 3) {
                                //PREPA 
                                 
                                    $dia_actual = date('Y-m-d');
                                    $year_actual = date('Y');
                                    $dia_pago = date('Y-m-d', strtotime($detalle_configuracion[0]->diaultimorecargo . "-" . $idmes . "-" . $year_actual));
                                    if ($dia_actual > $dia_pago) {
                                        $recargo += $detalle_configuracion[0]->totalrecargo;
                                    } else {
                                        $recargo += 0;
                                    }
                               
                            } else {
                                $recargo = 0;
                            }
                             $descuento_correcto = (($detalle_descuento[0]->descuento - ($detalle_descuento[0]->descuentobeca / 100 * $detalle_descuento[0]->descuento)) * 1) + $recargo;
                            $costo_colegiatura = $descuento_correcto;
                            }else{
                    $costo_colegiatura = 0;
                }
        $result['cobro_colegiatura'] =  $costo_colegiatura;
        
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function showAllMeses() {
        $idalumno = $this->input->get('idalumno');
        $idperiodo = $this->input->get('idperiodo');
        $detalle = $this->estadocuenta->detalleAlumno($idalumno);
        $detalle_periodo = $this->estadocuenta->detallePeriodo($idperiodo);

        if ($detalle->idniveleducativo == 1) {
            if ($this->session->idrol == 13 || $this->session->idrol == 14) {
                $query = $this->estadocuenta->showAllMeses($idperiodo, $idalumno);
            } else {
                $query = $this->estadocuenta->showAllMeses($idperiodo, $idalumno);
//CODIGO SIGUIENTE PARA MOSTRAR SOLO UN MES PARA SER COBRADO                 
//$query = $this->estadocuenta->showAllMesesSiguiente($idperiodo, $idalumno);
            }
        } else {
            $mesinicio = $detalle_periodo->mesinicio;
            $mesfin = $detalle_periodo->mesfin;
            if ($this->session->idrol == 13 || $this->session->idrol == 14) {
                $query = $this->estadocuenta->showAllMesPeriodo($idperiodo, $idalumno, $mesinicio, $mesfin);
            } else {
                $query = $this->estadocuenta->showAllMesPeriodo($idperiodo, $idalumno, $mesinicio, $mesfin);
//CODIGO SIGUIENTE PARA MOSTRAR SOLO UN MES PARA SER COBRADO                       
//$query = $this->estadocuenta->showAllSiguienteMesPeriodo($idperiodo, $idalumno, $mesinicio, $mesfin);
            }
        }

        if ($query) {
            $result['meses'] = $query;
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function pagosInicio() {
        $idalumno = $this->input->get('idalumno');
        $idperiodo = $this->input->get('idperiodo');
        //$idalumno = 1;
        //$idperiodo = 1;
        $query = $this->estadocuenta->showAllPagosInicio($idalumno, $idperiodo);
        if ($query) {
            $result['pagos'] = $this->estadocuenta->showAllPagosInicio($idalumno, $idperiodo);
        }
        //if(isset($result)){
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function descuentoPagoInicioInscripcion() {
        $idalumno = $this->input->get('idalumno');
        $idperiodo = $this->input->get('idperiodo');
        $idplantel = $this->session->idplantel;
         $detalle_niveleducativo = $this->alumno->detalleAlumnoNivelEducativo($idalumno,$idperiodo);
                if($detalle_niveleducativo){
                      $idniveleducativo = $detalle_niveleducativo->idnivelestudio;
        $resultado = $this->estadocuenta->descuentoPagosInicio($idalumno, $idperiodo, 1,$idplantel,$idniveleducativo);
        if ($resultado) {
            $result['pagoinscripcion'] = number_format($resultado[0]->beca, 2);
        }
    }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function descuentoPagoInicioReinscripcion() {
        $idalumno = $this->input->get('idalumno');
        $idperiodo = $this->input->get('idperiodo');
        $idplantel = $this->session->idplantel;
          $detalle_niveleducativo = $this->alumno->detalleAlumnoNivelEducativo($idalumno,$idperiodo);
                if($detalle_niveleducativo){
                      $idniveleducativo = $detalle_niveleducativo->idnivelestudio;
        $resultado = $this->estadocuenta->descuentoPagosInicio($idalumno, $idperiodo, 2,$idplantel,$idniveleducativo);
        //var_dump($resultado);
        if ($resultado) {
            $result['pagoreinscripcion'] = number_format($resultado[0]->beca, 2);
        }
    }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function descuentoPagoColegiatura() {
        $idalumno = $this->input->get('idalumno');
        $idperiodo = $this->input->get('idperiodo');
        $idplantel = $this->session->idplantel;
          $detalle_niveleducativo = $this->alumno->detalleAlumnoNivelEducativo($idalumno,$idperiodo);
                if($detalle_niveleducativo){
                      $idniveleducativo = $detalle_niveleducativo->idnivelestudio;
        $resultado = $this->estadocuenta->descuentoPagosInicio($idalumno, $idperiodo, 3,$idplantel,$idniveleducativo);
        if ($resultado) {
            $result['pagocolegiatura'] = number_format($resultado[0]->beca, 2);
        }
    }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function eliminarColegiatura() {
        $config = array(
            array(
                'field' => 'usuario',
                'label' => 'Forma de Pago',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'password',
                'label' => 'Forma de Pago',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            )
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'usuario' => form_error('usuario'),
                'password' => form_error('password')
            );
        } else {
            $idpago = $this->input->post('idpago');
            $usuario = $this->input->post('usuario');
            $password = $this->input->post('password');
            $detalle_usuario = $this->usuario->validarUsuarioEliminar($usuario, $this->session->idplantel);
            if ($detalle_usuario) {
                if (password_verify($password, $detalle_usuario[0]->password)) {

                    $data = array(
                        'eliminado' => 1
                    );
                    $this->estadocuenta->updateEstadoCuenta($idpago, $data);
                } else {
                    $result['error'] = true;
                    $result['msg'] = array(
                        'msgerror' => 'El Usuario o Contraseña no son validos.'
                    );
                }
            } else {
                $result['error'] = true;
                $result['msg'] = array(
                    'msgerror' => 'El Usuario o Contraseña no son validos.'
                );
            }
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function eliminarPrimerCobro() {
        $config = array(
            array(
                'field' => 'usuario',
                'label' => 'Forma de Pago',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'password',
                'label' => 'Forma de Pago',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            )
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'usuario' => form_error('usuario'),
                'password' => form_error('password')
            );
        } else {
            $idpago = $this->input->post('idpago');
            $usuario = $this->input->post('usuario');
            $password = $this->input->post('password');
            $detalle_usuario = $this->usuario->validarUsuarioEliminar($usuario, $this->session->idplantel);
            if ($detalle_usuario) {
                if (password_verify($password, $detalle_usuario[0]->password)) {

                    $data = array(
                        'eliminado' => 1
                    );
                    $this->estadocuenta->updatePagoInicio($idpago, $data);
                } else {
                    $result['error'] = true;
                    $result['msg'] = array(
                        'msgerror' => 'El Usuario o Contraseña no son validos.'
                    );
                }
            } else {
                $result['error'] = true;
                $result['msg'] = array(
                    'msgerror' => 'El Usuario o Contraseña no son validos.'
                );
            }
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function estadoCuenta() {
        # code...
        $idalumno = $this->input->get('idalumno');
        $idperiodo = $this->input->get('idperiodo');
        //$idalumno = 1;
        //$idperiodo = 11;
        $estadocuentap = array();
        $i = 0;
        /*
          $tabla_amoritzacion = $this->estadocuenta->showAllTableAmotizacion($idperiodo,$idalumno);
          //var_dump($tabla_amoritzacion);
          if($tabla_amoritzacion != false){
          foreach ($tabla_amoritzacion as $value) {
          $estadocuenta_veri = $this->estadocuenta->showAllEstadoCuenta($idperiodo,$idalumno,$value->idamortizacion);
          if($estadocuenta_veri != false){
          //PAGADO
          foreach ($estadocuenta_veri as $value2) {
          $estadocuentap[$i]                = array();
          $estadocuentap[$i]['idamortizacion'] = $value2->idamortizacion;
          $estadocuentap[$i]['idpago'] = $value2->idestadocuenta;
          $estadocuentap[$i]['idperiodo'] = $value2->idperiodo;
          $estadocuentap[$i]['mes'] = $value2->mes;
          $estadocuentap[$i]['descuento']     = $value2->descuento;
          $estadocuentap[$i]['numeromes']   = $value2->numeromes;
          $estadocuentap[$i]['pagado']       = $value2->pagado;
          $estadocuentap[$i]['fecha']       = $value2->fechapago;
          $i++;
          }
          } else{
          //NO PAGADO
          $estadocuentap[$i]                = array();
          $estadocuentap[$i]['idamortizacion'] = $value->idamortizacion;
          $estadocuentap[$i]['idpago'] = 0;
          $estadocuentap[$i]['idperiodo'] = $value->idperiodo;
          $estadocuentap[$i]['mes'] = $value->mes;
          $estadocuentap[$i]['descuento']     = $value->descuento;
          $estadocuentap[$i]['numeromes']   = $value->numeromes;
          $estadocuentap[$i]['descuento']       = $value->descuento;
          $estadocuentap[$i]['pagado']       = $value->pagado;
          $estadocuentap[$i]['fecha']       = "---";
          $i++;
          }
          }
          }
          else{
          //PURO ESTADO DE CUENTA
         */
        $vali = $this->estadocuenta->showAllEstadoCuentaTodos($idperiodo, $idalumno);
        if ($vali != false) {
            foreach ($vali as $value2) {
                $estadocuentap[$i] = array();
                $estadocuentap[$i]['idamortizacion'] = 0;
                $estadocuentap[$i]['idpago'] = $value2->idestadocuenta;
                $estadocuentap[$i]['idperiodo'] = $value2->idperiodo;
                $estadocuentap[$i]['mes'] = $value2->mes;
                //$estadocuentap[$i]['year']     = $value2->yearp;
                $estadocuentap[$i]['descuento'] = $value2->descuento;
                //$estadocuentap[$i]['numeromes']   = $value2->numeromes;
                $estadocuentap[$i]['pagado'] = $value2->pagado;
                $estadocuentap[$i]['fecha'] = $value2->fechapago;
                $i++;
            }
        }

//}


        function compare_lastname($a, $b) {
            return strnatcmp($a['idpago'], $b['idpago']);
        }

        usort($estadocuentap, 'compare_lastname');
        //var_dump($estadocuenta);
        echo json_encode($estadocuentap);
    }

    public function addCobroColegiatura() {
        if (Permission::grantValidar(uri_string()) == 1) {
            $config = array(
                array(
                    'field' => 'idperiodo',
                    'label' => 'Forma de Pago',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
                array(
                    'field' => 'coleccionMeses',
                    'label' => 'Forma de Pago',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Marque los meses a pagar.'
                    )
                ),
            );

            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() == FALSE) {
                $result['error'] = true;
                $result['msg'] = array(
                    //'idformapago' => form_error('idformapago'),
                    'idmes' => form_error('coleccionMeses'),
                    //'descuento' => form_error('descuento'),
                    'msgerror' => form_error('idperiodo')
                );
            } else {
                $idplantel = $this->session->idplantel;
                $idalumno = trim($this->input->post('idalumno'));
                $detalle_alumno = $this->alumno->detalleAlumno($idalumno);
                $detalle_configuracion = $this->configuracion->showAllConfiguracion($this->session->idplantel,$detalle_alumno->idniveleducativo);
                $array_formapago = json_decode($this->input->post('formapago'));
                $array_meses_a_pagar = json_decode($this->input->post('meseapagar'));
                $idperiodo = trim($this->input->post('idperiodo'));
                $detalle_niveleducativo = $this->alumno->detalleAlumnoNivelEducativo($idalumno,$idperiodo);
                if($detalle_niveleducativo){
                      $idniveleducativo = $detalle_niveleducativo->idnivelestudio;
                if (($this->input->post('condonar')) && ($this->session->idrol == 13 || $this->session->idrol == 14)) {
                  

                    $folio = generateRandomString();
                    $total_meses = 0;
                    foreach ($array_meses_a_pagar as $row) {
                        $total_meses = 1 + $total_meses;
                    }
                    $descuento_enviado = 0;
                    $total_formapago = 0;
                    foreach ($array_formapago as $row) {
                        $descuento_enviado += $row->descuento;
                        $total_formapago += $total_formapago;
                    }

                    $detalle_descuento = $this->estadocuenta->descuentoPagosInicio($idalumno, $idperiodo, 3,$idplantel,$idniveleducativo);
                    if ($detalle_descuento && $detalle_descuento[0]->descuento > 0) {
                        $descuento_correcto = $detalle_descuento[0]->descuento - ($detalle_descuento[0]->descuentobeca / 100 * $detalle_descuento[0]->descuento);


                        //1.- OBTENER DATOS DE LA TABLA AMORTIZACION Y PONER COMO PAGADO
                        /* $data_add_amortizacion = array(
                          'idalumno'=>$idalumno,
                          'idperiodo'=>$idperiodo,
                          'idperiodopago'=>$idmes,
                          'descuento'=>$descuento_enviado,
                          'pagado'=>1,
                          'idusuario' => $this->session->user_id,
                          'fecharegistro' => date('Y-m-d H:i:s')
                          );
                          $idamortizacion = $this->estadocuenta->addAmortizacion($data_add_amortizacion); */
                        if ($total_formapago == 0 && $descuento_enviado == 0) {
                            $data_estadocuenta = array(
                                'folio' => $folio,
                                'idperiodo' => $idperiodo,
                                'idalumno' => $idalumno,
                                'descuento' => $descuento_enviado,
                                'totalrecargo' => 0,
                                'recargo' => 0,
                                'condonar' => 1,
                                'idopenpay' => '',
                                'idorden' => '',
                                'online' => 0,
                                'pagado' => 1,
                                'fechapago' => date('Y-m-d H:i:s'),
                                'eliminado' => 0,
                                'idusuario' => $this->session->user_id,
                                'fecharegistro' => date('Y-m-d H:i:s')
                            );

                            $idestadocuenta = $this->estadocuenta->addEstadoCuenta($data_estadocuenta);
                            foreach ($array_formapago as $row) {

                                $idformapago = $row->idformapago;
                                $autorizacion = $row->autorizacion;
                                $abono = $row->descuento;
                                if ($idformapago == 1) {
                                    //FORMA DE PAGO EN EFECTIVO 

                                    $data_detallepago = array(
                                        'idestadocuenta' => $idestadocuenta,
                                        'idformapago' => $idformapago,
                                        'descuento' => $abono,
                                        'autorizacion' => '',
                                        'fechapago' => date('Y-m-d H:i:s'),
                                        'idusuario' => $this->session->user_id,
                                        'fecharegistro' => date('Y-m-d H:i:s')
                                    );
                                    $this->estadocuenta->addDetalleEstadoCuenta($data_detallepago);
                                } elseif ($idformapago == 2 && !empty($autorizacion)) {
                                    //FORMA DE PAGO EN TARJETA   
                                    $data_detallepago = array(
                                        'idestadocuenta' => $idestadocuenta,
                                        'idmes' => $row,
                                        'idformapago' => $idformapago,
                                        'descuento' => $abono,
                                        'autorizacion' => $autorizacion,
                                        'fechapago' => date('Y-m-d H:i:s'),
                                        'idusuario' => $this->session->user_id,
                                        'fecharegistro' => date('Y-m-d H:i:s')
                                    );
                                    $this->estadocuenta->addDetalleEstadoCuenta($data_detallepago);
                                } else {
                                    $result['error'] = true;
                                    $result['msg'] = array(
                                        'msgerror' => 'Es necesario registrar el Número Autorización.'
                                    );
                                }
                            }

                            foreach ($array_meses_a_pagar as $row) {
                                //AGREGAR A DETALLE ESTADO CUENTA
                                $data = array(
                                    'idestadocuenta' => $idestadocuenta,
                                    'idmes' => $row,
                                    'idusuario' => $this->session->user_id,
                                    'fecharegistro' => date('Y-m-d H:i:s')
                                );
                                $this->estadocuenta->addEstadoCuentaDetalle($data);
                            }
                        } else {
                            $result['error'] = true;
                            $result['msg'] = array(
                                'msgerror' => 'Debe de ser solo una forma de pago y el total a pagar igual 0.'
                            );
                        }
                    } else {
                        $result['error'] = true;
                        $result['msg'] = array(
                            'msgerror' => 'No esta registrado el costo para cobrar.'
                        );
                    }
                } else {

                    //PAGOS NORMALES

                    $total_meses = 0;
                    foreach ($array_meses_a_pagar as $row) {
                        $total_meses = 1 + $total_meses;
                    }

                    // $validar = $this->estadocuenta->validarAddColegiatura($idalumno,$idperiodo,$idmes);
                    $folio = generateRandomString();
                    if ($total_meses > 0) {
                        $descuento_enviado = 0;
                        foreach ($array_formapago as $row) {
                            $descuento_enviado += $row->descuento;
                        }

                        $detalle_descuento = $this->estadocuenta->descuentoPagosInicio($idalumno, $idperiodo, 3,$idplantel, $idniveleducativo);
                       
                      
                                if ($detalle_descuento && $detalle_descuento[0]->descuento > 0) {
                            $recargo = 0;

                            if ($detalle_descuento[0]->idniveleducativo == 1) {
                                //PRIMARIA 
                                foreach ($array_meses_a_pagar as $row) {
                                    $dia_actual = date('Y-m-d');
                                    $year_actual = date('Y');
                                    $dia_pago = date('Y-m-d', strtotime($detalle_configuracion[0]->diaultimorecargo . "-" . $row . "-" . $year_actual));
                                    if ($dia_actual > $dia_pago) {
                                        $recargo += $detalle_configuracion[0]->totalrecargo;
                                    } else {
                                        $recargo += 0;
                                    }
                                }
                            } elseif ($detalle_descuento[0]->idniveleducativo == 2) {
                                //SECUNDARIA 
                                foreach ($array_meses_a_pagar as $row) {
                                    $dia_actual = date('Y-m-d');
                                    $year_actual = date('Y');
                                    $dia_pago = date('Y-m-d', strtotime($detalle_configuracion[0]->diaultimorecargo . "-" . $row . "-" . $year_actual));
                                    if ($dia_actual > $dia_pago) {
                                        $recargo += $detalle_configuracion[0]->totalrecargo;
                                    } else {
                                        $recargo += 0;
                                    }
                                }
                            } elseif ($detalle_descuento[0]->idniveleducativo == 3) {
                                //PREPA 
                                foreach ($array_meses_a_pagar as $row) {
                                    $dia_actual = date('Y-m-d');
                                    $year_actual = date('Y');
                                    $dia_pago = date('Y-m-d', strtotime($detalle_configuracion[0]->diaultimorecargo . "-" . $row . "-" . $year_actual));
                                    if ($dia_actual > $dia_pago) {
                                        $recargo += $detalle_configuracion[0]->totalrecargo;
                                    } else {
                                        $recargo += 0;
                                    }
                                }
                            } else {
                                $recargo = 0;
                            }
// (co.descuento - (b.descuento / 100 * co.descuento)) AS beca
                          
                            $descuento_correcto = (($detalle_descuento[0]->descuento - ($detalle_descuento[0]->descuentobeca / 100 * $detalle_descuento[0]->descuento)) * $total_meses) + $recargo;
                            if ($descuento_enviado == $descuento_correcto) {

                                //1.- OBTENER DATOS DE LA TABLA AMORTIZACION Y PONER COMO PAGADO
                                /* $data_add_amortizacion = array(
                                  'idalumno'=>$idalumno,
                                  'idperiodo'=>$idperiodo,
                                  'idperiodopago'=>$idmes,
                                  'descuento'=>$descuento_enviado,
                                  'pagado'=>1,
                                  'idusuario' => $this->session->user_id,
                                  'fecharegistro' => date('Y-m-d H:i:s')
                                  );
                                  $idamortizacion = $this->estadocuenta->addAmortizacion($data_add_amortizacion); */

                                $si_recargo = 0;
                                if ($recargo > 0) {
                                    $si_recargo += 1;
                                }
                                $data_estadocuenta = array(
                                    'folio' => $folio,
                                    'idperiodo' => $idperiodo,
                                    'idalumno' => $idalumno,
                                    'descuento' => $descuento_enviado,
                                    'totalrecargo' => $recargo,
                                    'recargo' => $si_recargo,
                                    'condonar' => 0,
                                    'idopenpay' => '',
                                    'idorden' => '',
                                    'online' => 0,
                                    'pagado' => 1,
                                    'fechapago' => date('Y-m-d H:i:s'),
                                    'eliminado' => 0,
                                    'idusuario' => $this->session->user_id,
                                    'fecharegistro' => date('Y-m-d H:i:s')
                                );

                                $idestadocuenta = $this->estadocuenta->addEstadoCuenta($data_estadocuenta);
                                foreach ($array_formapago as $row) {

                                    $idformapago = $row->idformapago;
                                    $autorizacion = $row->autorizacion;
                                    $abono = $row->descuento;
                                    if ($idformapago == 1) {
                                        //FORMA DE PAGO EN EFECTIVO 

                                        $data_detallepago = array(
                                            'idestadocuenta' => $idestadocuenta,
                                            'idformapago' => $idformapago,
                                            'descuento' => $abono,
                                            'autorizacion' => '',
                                            'fechapago' => date('Y-m-d H:i:s'),
                                            'idusuario' => $this->session->user_id,
                                            'fecharegistro' => date('Y-m-d H:i:s')
                                        );
                                        $this->estadocuenta->addDetalleEstadoCuenta($data_detallepago);
                                    } elseif ($idformapago == 2 && !empty($autorizacion)) {
                                        //FORMA DE PAGO EN TARJETA  

                                        $data_detallepago = array(
                                            'idestadocuenta' => $idestadocuenta,
                                            'idformapago' => $idformapago,
                                            'descuento' => $abono,
                                            'autorizacion' => $autorizacion,
                                            'fechapago' => date('Y-m-d H:i:s'),
                                            'idusuario' => $this->session->user_id,
                                            'fecharegistro' => date('Y-m-d H:i:s')
                                        );
                                        $this->estadocuenta->addDetalleEstadoCuenta($data_detallepago);
                                    } else {
                                        $result['error'] = true;
                                        $result['msg'] = array(
                                            'msgerror' => 'Es necesario registrar el Número Autorización.'
                                        );
                                    }
                                }
                                foreach ($array_meses_a_pagar as $row) {
                                    //AGREGAR A DETALLE ESTADO CUENTA
                                    $data = array(
                                        'idestadocuenta' => $idestadocuenta,
                                        'idmes' => $row,
                                        'idusuario' => $this->session->user_id,
                                        'fecharegistro' => date('Y-m-d H:i:s')
                                    );
                                    $this->estadocuenta->addEstadoCuentaDetalle($data);
                                }
                            } else {
                                $result['error'] = true;
                                $result['msg'] = array(
                                    'msgerror' => 'El pago debe de ser de: ' . number_format($descuento_correcto, 2)
                                );
                            }
                        } else {
                            $result['error'] = true;
                            $result['msg'] = array(
                                'msgerror' => 'No esta registrado el costo para cobrar.'
                            );
                        }
                    } else {
                        $result['error'] = true;
                        $result['msg'] = array(
                            'msgerror' => 'Solo debe de marcar un Mes.'
                        );
                    }
                }

                 } else {
                        $result['error'] = true;
                        $result['msg'] = array(
                            'msgerror' => 'No esta registrado el costo para cobrar.'
                        );
                    }

            }
        } else {
            $result['error'] = true;
            $result['msg'] = array(
                'msgerror' => 'NO TIENE PERMISO PARA REALIZAR ESTA ACCION.'
            );
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function addCobro() {
        $config = array(
            array(
                'field' => 'idformapago',
                'label' => 'Forma de Pago',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'idformapago' => form_error('idformapago')
            );
        } else {

            $idformapago = trim($this->input->post('idformapago'));
            $autorizacion = trim($this->input->post('autorizacion'));
            $idamortizacion = trim($this->input->post('idamortizacion'));
            $idalumno = trim($this->input->post('idalumno'));
            $abono = trim($this->input->post('abono'));
            if ($idformapago == 1) {

                //1.- OBTENER DATOS DE LA TABLA AMORTIZACION Y PONER COMO PAGADO
                $data_amortizacion = $this->estadocuenta->datosTablaAmortizacion($idamortizacion);
                $idperiodo = $data_amortizacion->idperiodo;
                $data_update_amortizacion = array(
                    'pagado' => 1
                );
                $result_update_amortizacion = $this->estadocuenta->updateTablaAmortizacion($idamortizacion, $data_update_amortizacion);
                if ($result_update_amortizacion == true) {
                    //Se modifico el estatus de pagado
                    $data_estadocuenta = array(
                        'idamortizacion' => $idamortizacion,
                        'idperiodo' => $idperiodo,
                        'idalumno' => $idalumno,
                        'descuento' => $abono,
                        'fechapago' => date('Y-m-d H:i:s'),
                        'idusuario' => $this->session->user_id,
                        'fecharegistro' => date('Y-m-d H:i:s')
                    );

                    $idestadocuenta = $this->estadocuenta->addEstadoCuenta($data_estadocuenta);

                    $data_detallepago = array(
                        'idestadocuenta' => $idestadocuenta,
                        'idformapago' => $idformapago,
                        'descuento' => $abono,
                        'autorizacion' => '',
                        'fechapago' => date('Y-m-d H:i:s'),
                        'idusuario' => $this->session->user_id,
                        'fecharegistro' => date('Y-m-d H:i:s')
                    );
                    $this->estadocuenta->addDetalleEstadoCuenta($data_detallepago);
                } else {
                    //No se pudo modificar el estatus de pagado de la tabla amortizacion
                    $result['error'] = true;
                    $result['msg'] = array(
                        'msgerror' => 'Error intente mas tarde.'
                    );
                }
            } elseif ($idformapago == 2 && !empty($autorizacion)) {
                //1.- OBTENER DATOS DE LA TABLA AMORTIZACION Y PONER COMO PAGADO
                $data_amortizacion = $this->estadocuenta->datosTablaAmortizacion($idamortizacion);
                $idperiodo = $data_amortizacion->idperiodo;
                $data_update_amortizacion = array(
                    'pagado' => 1
                );
                $result_update_amortizacion = $this->estadocuenta->updateTablaAmortizacion($idamortizacion, $data_update_amortizacion);
                if ($result_update_amortizacion == true) {
                    //Se modifico el estatus de pagado
                    $data_estadocuenta = array(
                        'idamortizacion' => $idamortizacion,
                        'idperiodo' => $idperiodo,
                        'idalumno' => $idalumno,
                        'descuento' => $abono,
                        'fechapago' => date('Y-m-d H:i:s'),
                        'idusuario' => $this->session->user_id,
                        'fecharegistro' => date('Y-m-d H:i:s')
                    );

                    $idestadocuenta = $this->estadocuenta->addEstadoCuenta($data_estadocuenta);

                    $data_detallepago = array(
                        'idestadocuenta' => $idestadocuenta,
                        'idformapago' => $idformapago,
                        'descuento' => $abono,
                        'autorizacion' => $autorizacion,
                        'fechapago' => date('Y-m-d H:i:s'),
                        'idusuario' => $this->session->user_id,
                        'fecharegistro' => date('Y-m-d H:i:s')
                    );
                    $this->estadocuenta->addDetalleEstadoCuenta($data_detallepago);
                } else {
                    //No se pudo modificar el estatus de pagado de la tabla amortizacion
                    $result['error'] = true;
                    $result['msg'] = array(
                        'msgerror' => 'Error intente mas tarde.'
                    );
                }
            } else {
                $result['error'] = true;
                $result['msg'] = array(
                    'msgerror' => 'Es necesario registrar el Número Autorización.'
                );
            }
        }

        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

    public function addCobroInicio() {
        if (Permission::grantValidar(uri_string()) == 1) {
            $config = array(
                array(
                    'field' => 'idperiodobuscado',
                    'label' => 'Periodo',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                ),
                array(
                    'field' => 'idtipopagocol',
                    'label' => 'Periodo',
                    'rules' => 'trim|required',
                    'errors' => array(
                        'required' => 'Campo obligatorio.'
                    )
                )
            );

            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() == FALSE) {
                $result['error'] = true;
                $result['msg'] = array(
                    'idperiodobuscado' => form_error('idperiodobuscado'),
                    'idtipopagocol' => form_error('idtipopagocol')
                );
            } else {
                    $idplantel = $this->session->idplantel;
                     $idperiodo = trim($this->input->post('idperiodobuscado'));
                    $idalumno = trim($this->input->post('idalumno'));
                    $idtipopagocol = trim($this->input->post('idtipopagocol'));
                $detalle_niveleducativo = $this->alumno->detalleAlumnoNivelEducativo($idalumno,$idperiodo);
                if($detalle_niveleducativo){
                      $idniveleducativo = $detalle_niveleducativo->idnivelestudio;
                
                if (($this->input->post('condonar')) && ($this->session->idrol == 13 || $this->session->idrol == 14)) {

                    //CONDONAR
                    $array_formapago = json_decode($this->input->post('formapago'));
                    $descuento_enviado = 0;
                    $total_formapago = 0;
                    foreach ($array_formapago as $row) {
                        $descuento_enviado += $row->descuento;
                        $total_formapago += $total_formapago;
                    }
                   
                    $detalle_descuento = $this->estadocuenta->descuentoPagosInicio($idalumno, $idperiodo, $idtipopagocol,$idplantel,$idniveleducativo);
                    if ($detalle_descuento && $detalle_descuento[0]->descuento > 0) {
                        // $descuento_correcto = $detalle_descuento[0]->descuento - ($detalle_descuento[0]->descuentobeca / 100 * $detalle_descuento[0]->descuento);
                        if ($total_formapago == 0 && $descuento_enviado == 0) {
                            $folio = generateRandomString();
                            $data_estadocuenta = array(
                                'folio' => $folio,
                                'idperiodo' => $idperiodo,
                                'idalumno' => $idalumno,
                                //'idformapago'=>$idformapago,
                                'idtipopagocol' => $idtipopagocol,
                                'descuento' => $descuento_enviado,
                                'totalrecargo' => 0,
                                'recargo' => 0,
                                'condonar' => 1,
                                //'autorizacion'=>'',
                                'online' => 0,
                                'pagado' => 1,
                                'fechapago' => date('Y-m-d H:i:s'),
                                'idusuario' => $this->session->user_id,
                                'fecharegistro' => date('Y-m-d H:i:s')
                            );

                            $idestadocuenta = $this->estadocuenta->addPagoInicio($data_estadocuenta);

                            foreach ($array_formapago as $row) {
                                $idformapago = $row->idformapago;
                                $autorizacion = $row->autorizacion;
                                $descuento = $row->descuento;
                                if ($idformapago == 1) {
                                    //EFECTIVO FORMA PAGO  

                                    $data_detalle = array(
                                        'idpago' => $idestadocuenta,
                                        'idformapago' => $idformapago,
                                        'autorizacion' => '',
                                        'descuento' => $descuento,
                                        'idusuario' => $this->session->user_id,
                                        'fecharegistro' => date('Y-m-d H:i:s')
                                    );
                                    $this->estadocuenta->addDetallePagoInicio($data_detalle);
                                } elseif ($idformapago == 2 && !empty($autorizacion)) {
                                    //TARJETA 

                                    $data_detalle = array(
                                        'idpago' => $idestadocuenta,
                                        'idformapago' => $idformapago,
                                        'autorizacion' => $autorizacion,
                                        'descuento' => $descuento,
                                        'idusuario' => $this->session->user_id,
                                        'fecharegistro' => date('Y-m-d H:i:s')
                                    );
                                    $this->estadocuenta->addDetallePagoInicio($data_detalle);
                                } else {
                                    $result['error'] = true;
                                    $result['msg'] = array(
                                        'msgerror' => 'Es necesario registrar el Número Autorización.'
                                    );
                                }
                            }
                        } else {
                            $result['error'] = true;
                            $result['msg'] = array(
                                'msgerror' => 'Debe de ser solo una forma de pago y el total a pagar igual 0.'
                            );
                        }
                    } else {
                        $result['error'] = true;
                        $result['msg'] = array(
                            'msgerror' => 'No esta registrado el costo para cobrar.'
                        );
                    }
                } else {
                    //COBRO NORMAL
                    $array_formapago = json_decode($this->input->post('formapago'));
                    $descuento_enviado = 0;
                    foreach ($array_formapago as $row) {
                        $descuento_enviado += $row->descuento;
                    }
                    $detalle_descuento = $this->estadocuenta->descuentoPagosInicio($idalumno, $idperiodo, $idtipopagocol,$idplantel,$idniveleducativo);
                    if ($detalle_descuento && $detalle_descuento[0]->descuento > 0) {
                        $descuento_correcto = $detalle_descuento[0]->descuento - ($detalle_descuento[0]->descuentobeca / 100 * $detalle_descuento[0]->descuento);
                        if ($descuento_enviado == $descuento_correcto) {
                            $folio = generateRandomString();
                            $data_estadocuenta = array(
                                'folio' => $folio,
                                'idperiodo' => $idperiodo,
                                'idalumno' => $idalumno,
                                //'idformapago'=>$idformapago,
                                'idtipopagocol' => $idtipopagocol,
                                'descuento' => $descuento_enviado,
                                //'autorizacion'=>'',
                                'online' => 0,
                                'pagado' => 1,
                                'fechapago' => date('Y-m-d H:i:s'),
                                'idusuario' => $this->session->user_id,
                                'fecharegistro' => date('Y-m-d H:i:s')
                            );

                            $idestadocuenta = $this->estadocuenta->addPagoInicio($data_estadocuenta);

                            foreach ($array_formapago as $row) {
                                $idformapago = $row->idformapago;
                                $autorizacion = $row->autorizacion;
                                $descuento = $row->descuento;
                                if ($idformapago == 1) {
                                    //EFECTIVO FORMA PAGO  

                                    $data_detalle = array(
                                        'idpago' => $idestadocuenta,
                                        'idformapago' => $idformapago,
                                        'autorizacion' => '',
                                        'descuento' => $descuento,
                                        'idusuario' => $this->session->user_id,
                                        'fecharegistro' => date('Y-m-d H:i:s')
                                    );
                                    $this->estadocuenta->addDetallePagoInicio($data_detalle);
                                } elseif ($idformapago == 2 && !empty($autorizacion)) {
                                    //TARJETA 

                                    $data_detalle = array(
                                        'idpago' => $idestadocuenta,
                                        'idformapago' => $idformapago,
                                        'autorizacion' => $autorizacion,
                                        'descuento' => $descuento,
                                        'idusuario' => $this->session->user_id,
                                        'fecharegistro' => date('Y-m-d H:i:s')
                                    );
                                    $this->estadocuenta->addDetallePagoInicio($data_detalle);
                                } else {
                                    $result['error'] = true;
                                    $result['msg'] = array(
                                        'msgerror' => 'Es necesario registrar el Número Autorización.'
                                    );
                                }
                            }
                        } else {
                            $result['error'] = true;
                            $result['msg'] = array(
                                'msgerror' => 'El pago debe de ser de: ' . number_format($descuento_correcto, 2)
                            );
                        }
                    } else {
                        $result['error'] = true;
                        $result['msg'] = array(
                            'msgerror' => 'No esta registrado el costo para cobrar.'
                        );
                    }
                }
                } else {
                        $result['error'] = true;
                        $result['msg'] = array(
                            'msgerror' => 'No esta registrado el costo para cobrar.'
                        );
                    }

            }
        } else {
            $result['error'] = true;
            $result['msg'] = array(
                'msgerror' => 'NO TIENE PERMISO PARA REALIZAR ESTA ACCIÓN.'
            );
        }
        if (isset($result) && !empty($result)) {
            echo json_encode($result);
        }
    }

}