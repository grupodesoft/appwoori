<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("America/Mexico_City");

class Pprofesor extends CI_Controller {

    function __construct() {
        parent::__construct();

        if (!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('welcome');
        }
        $this->load->helper('url');
        $this->load->library('permission');
        $this->load->library('session');
        $this->load->model('grupo_model', 'grupo');
         $this->load->model('profesor_model', 'profesor');
         $this->load->model('planificacion_model', 'planificacion');
        $this->load->library('encryption');
    }

    public function index() {

        Permission::grant(uri_string());
        //  echo $_SESSION['user_id'];
        $this->load->view('docente/header');
        $this->load->view('docente/index');
        $this->load->view('docente/footer');
    }

    function encode($string) {
        $encrypted = $this->encryption->encrypt($string);
        if (!empty($string)) {
            $encrypted = strtr($encrypted, array('/' => '~'));
        }
        return $encrypted;
    }

    function decode($string) {
        $string = strtr($string, array('~' => '/'));
        return $this->encryption->decrypt($string);
    }

    public function planeacion() {
        # code...
        Permission::grant(uri_string());
        $idprofesor = $this->session->idprofesor;
        $result = $this->grupo->showAllGruposProfesor($idprofesor);
        $unidades = $this->grupo->unidades($this->session->idplantel);
        $detalle = $this->profesor->detalleProfesor($idprofesor);
        /*
          if ($detalle->idniveleducativo == 1) {
          //PRIMARIA
          $data = array(
          'datos' => $result,
          'unidades' => $unidades,
          'controller' => $this
          );
          $this->load->view('docente/header');
          $this->load->view('docente/planeacion/primaria/planificacion_primaria', $data);
          $this->load->view('docente/footer');
          } elseif ($detalle->idniveleducativo == 2) {
          //SECUNDARIA
          $data = array(
          'datos' => $result,
          'unidades' => $unidades,
          'controller' => $this
          );
          $this->load->view('docente/header');
          $this->load->view('docente/planeacion/licenciatura/index', $data);
          $this->load->view('docente/footer');
          } elseif ($detalle->idniveleducativo == 3) {
          //PREPA
          }elseif ($detalle->idniveleducativo == 4) {
          //PREESCOLAR
          }elseif ($detalle->idniveleducativo == 5) {
          //LICENCIATURA
          $data = array(
          'datos' => $result,
          'unidades' => $unidades,
          'controller' => $this
          );
          $this->load->view('docente/header');
          $this->load->view('docente/planeacion/licenciatura/index', $data);
          $this->load->view('docente/footer');
          } */
        $data = array(
            'datos' => $result,
            'unidades' => $unidades,
            'controller' => $this
        );
        $this->load->view('docente/header');
        $this->load->view('docente/planeacion/licenciatura/index', $data);
        $this->load->view('docente/footer');
    }

    public function saberDia($nombredia = '') {
        # code...
        Permission::grant(uri_string());
        $dias = array('Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo');
        $fecha = $dias[date('N', strtotime($nombredia))];
        return $fecha;
    }

    public function planear($idunidad = '', $id = '') {
        Permission::grant(uri_string());
        date_default_timezone_set('UTC');

        $idunidad = $this->decode($idunidad);
        $id = $this->decode($id);
        if ((isset($idunidad) && !empty($idunidad)) && (isset($id) && !empty($id))) {

            //RETROCEDER 6 MESES PARA ATRAS
            for ($i = 1; $i < 150; $i++) {
                # code... $fecha_actual = '';
                $fecha = date("Y-m-d");
                $fecha_actual = date("Y-m-d", strtotime($fecha . "- " . $i . " days"));
                $numerodia = date('N', strtotime($fecha_actual));
                $result_dia = $this->grupo->dia($id);
                $dia = $result_dia->iddia;
                if ($numerodia == $dia) {
                    $datosinicial[$i] = array();
                    $datosinicial[$i]['fechainicial'] = $fecha_actual . " " . $result_dia->horainicial;
                    $datosinicial[$i]['fechafinal'] = $fecha_actual . " " . $result_dia->horafinal;
                    //echo "SI";
                } else {
                    // echo "NO";
                }
            }
            // var_dump($datosinicial);
            //FIN DEL RETROCESO
            //ADELANTO 6 MESES PARA ATRAS
            for ($i = 1; $i < 150; $i++) {
                # code... $fecha_actual = '';
                $fecha = date("Y-m-d");
                $fecha_actual = date("Y-m-d", strtotime($fecha . "+ " . $i . " days"));
                $numerodia = date('N', strtotime($fecha_actual));
                $result_dia = $this->grupo->dia($id);
                $dia = $result_dia->iddia;
                if ($numerodia == $dia) {
                    //echo "SI";
                    $datosfinal[$i] = array();
                    $datosfinal[$i]['fechainicial'] = $fecha_actual . " " . $result_dia->horainicial;
                    $datosfinal[$i]['fechafinal'] = $fecha_actual . " " . $result_dia->horafinal;
                } else {
                    // echo "NO";
                }
            }
            //var_dump($datosfinal);
            //FIN DEL ADELANTO
//Lista de Planeacion agregadas

            $lista_planeacion = $this->grupo->listaPlaneacion($idunidad, $id);
//Fin de la lista de planeacion agregadas

            $data = array(
                'atras' => $datosinicial,
                'idunidad' => $idunidad,
                'iddetallehorario' => $id,
                'listaplaneacion' => $lista_planeacion,
                'controller' => $this
            );


            # code...
            $this->load->view('docente/header');
            $this->load->view('docente/planeacion/planear', $data);
            $this->load->view('docente/footer');
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Error intente mas tarde.'
            );
            $this->load->view('errors/html/error_general', $data);
        }
    }

    public function addPlaneacion() {
        Permission::grant(uri_string());
        # code...
        // Permission::grant(uri_string()); 
        $config = array(
            array(
                'field' => 'planeacion',
                'label' => 'planeacion',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'La Actividad es requerido.'
                )
            ),
            array(
                'field' => 'lugar',
                'label' => 'Modelo',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'El Lugar de desarrollo es requerido.'
                )
            ),
            array(
                'field' => 'finicio',
                'label' => 'Modelo',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'La Fecha inicio es requerido.'
                )
            ),
            array(
                'field' => 'ffin',
                'label' => 'Modelo',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'La Fecha fin es requerido.'
                )
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            echo json_encode(['error' => $errors]);
        } else {
            $planeacion = $this->input->post('planeacion');
            $lugar = strtoupper($this->input->post('lugar'));
            $finicio = $this->input->post('finicio');
            $ffin = $this->input->post('ffin');
            $idunidad = $this->input->post('unidad');
            $iddatallehorario = $this->input->post('horario');
            $data = array(
                'idunidad' => $idunidad,
                'iddetallehorario' => $iddatallehorario,
                'planeacion' => $planeacion,
                'lugar' => $lugar,
                'fechainicio' => $finicio,
                'fechafin' => $ffin,
                'idusuario' => $this->session->user_id,
                'fecharegistro' => date('Y-m-d H:i:s')
            );
            $value = $this->grupo->addPlaneacion($data);
            if ($value) {
                echo json_encode(['success' => 'Ok']);
            } else {
                echo json_encode(['error' => 'Error... Intente mas tarde.']);
            }
        }
        // echo json_encode($result);
    }

    public function updatePlaneacion() {
        Permission::grant(uri_string());
        $config = array(
            array(
                'field' => 'planeacion',
                'label' => 'planeacion',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Debe de redactar la Actividad.'
                )
            ),
            array(
                'field' => 'lugar',
                'label' => 'Modelo',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'De de escribir Lugar.'
                )
            ),
            array(
                'field' => 'finicio',
                'label' => 'Modelo',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Fecha inicio.'
                )
            ),
            array(
                'field' => 'ffin',
                'label' => 'Modelo',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Fecha fin.'
                )
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            echo json_encode(['error' => $errors]);
        } else {
            $planeacion = $this->input->post('planeacion');
            $lugar = strtoupper($this->input->post('lugar'));
            $finicio = $this->input->post('finicio');
            $ffin = $this->input->post('ffin');
            $idplaneacion = $this->input->post('idplaneacion');
            //$idunidad = $this->input->post('unidad'); 
            //$iddatallehorario = $this->input->post('horario');  
            $data = array(
                'planeacion' => $planeacion,
                'lugar' => $lugar,
                'fechainicio' => $finicio,
                'fechafin' => $ffin,
                'idusuario' => $this->session->user_id,
                'fecharegistro' => date('Y-m-d H:i:s')
            );
            //echo json_encode($data);
            $value_update = $this->grupo->updatePlaneacion($idplaneacion, $data);

            echo json_encode(['success' => 'Ok']);
        }
    }

    public function eliminar($idunidad = '', $iddetallehorario = '', $idplaneacion = '') {
        # code...
        Permission::grant(uri_string());
        $idunidad = $this->decode($idunidad);
        $iddetallehorario = $this->decode($iddetallehorario);
        $idplaneacion = $this->decode($idplaneacion);

        if ((isset($idunidad) && !empty($idunidad)) && (isset($iddetallehorario) && !empty($iddetallehorario)) && (isset($idplaneacion) && !empty($idplaneacion))) {
            $result = $this->grupo->eliminarPlaneacion($idplaneacion);
            redirect('pProfesor/planear/' . $this->encode($idunidad) . '/' . $this->encode($iddetallehorario));
        } else {
            $data = array(
                'heading' => 'Error',
                'message' => 'Error intente mas tarde.'
            );
            $this->load->view('errors/html/error_general', $data);
        }
    }

}
