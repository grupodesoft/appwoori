<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Load libruary for API
class Rol extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		if(!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('welcome');
        }
        $this->load->helper('url');
		$this->load->model('data_model');
		$this->load->model('rol_model','rol'); 
		$this->load->library('permission'); 
         $this->load->library('session');
	}

	public function index()
	{
           Permission::grant(uri_string());
		   $this->load->view('admin/header');
           $this->load->view('admin/rol/index');
           $this->load->view('admin/footer');
	}

	    public function showAll()
    {
         // Permission::grant(uri_string());
        $query = $this->rol->showAll();
        if ($query) {
            $result['roles'] = $this->rol->showAll();
        }
       if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
    }

     public function todosRoles()
    {
        $idplantel = $this->session->idplantel;
        $idrol = $this->session->idrol;
          //Permission::grant(uri_string());
        $query = $this->rol->showAll($idrol,$idplantel); 
        echo json_encode($query);
    }

      public function addRol()
    {
         // Permission::grant(uri_string());
        $config = array( 
            array(
                'field' => 'rol',
                'label' => 'Rol',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ) 
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg']   = array(
                'rol' => form_error('rol') 
            );
            
        } else {
            
            $data     = array(
                'rol' => $this->input->post('rol')
                
            );
            if ($this->rol->addRol($data)) {
                $result['error'] = false;
                $result['msg']   = 'User added successfully';
            }
            
        }
        echo json_encode($result);
    }
	 public function updateRol()
    {
        //  Permission::grant(uri_string());
        $config = array(
           
            array(
                'field' => 'rol',
                'label' => 'Rol',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg']   = array(
                'rol' => form_error('rol')
            );
            
        } else {
            $id   = $this->input->post('id');
            $data = array(
                'rol' => $this->input->post('rol') 
            );
            if ($this->rol->updateRol($id, $data)) {
                $result['error']   = false;
                $result['success'] = 'User updated successfully';
            }
            
        }
        if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
    }
     public function searchRol()
    {
        //  Permission::grant(uri_string());
        $value = $this->input->post('text');
        $idrol = $this->session->idrol;
        $query = $this->rol->searchRol($value,$idrol);
        if ($query) {
            $result['roles'] = $query;
        }
        
       if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
    }
     public function rolpermisos($id)
    { 
        //  Permission::grant(uri_string());
           //$data['permisos']  = $this->rol_model->rolpermisos($id); 
           $arraypermisos = array();
           $permisos= $this->rol->permisos(); 
           //var_dump($permisos);
            $i = 0;
           foreach ($permisos as  $value) {
                 $idpermiso=$value->id;
               
                 $permisodetalle= $this->rol->permisoid($idpermiso,$id); 
                
                 if(empty($permisodetalle)){
                        $arraypermisos[$i] = array();
                        $arraypermisos[$i]['id'] = $value->id;
                        $arraypermisos[$i]['uri'] = $value->uri;
                        $arraypermisos[$i]['description'] = $value->description;
                        $arraypermisos[$i]['status'] = "0";
                         $arraypermisos[$i]['rol'] = $id;

                 }else{
                        $arraypermisos[$i] = array();
                        $arraypermisos[$i]['id'] = $value->id;
                        $arraypermisos[$i]['uri'] = $value->uri;
                        $arraypermisos[$i]['description'] = $value->description;
                        $arraypermisos[$i]['status'] ="1";
                        $arraypermisos[$i]['rol'] = $id;

                 }
            $i++ ;
           }

          // print_r($arraypermisos);
           $data['permisos']=$arraypermisos;
           $this->load->view('admin/header');
           $this->load->view('admin/rol/rolpermisos', $data);
           $this->load->view('admin/footer');
         
    }
    public function agregarrolpermiso()
    {
         // Permission::grant(uri_string());
        # code...
        $idrol=$this->input->post('rol');
        $this->rol->eliminarPermisosRol($idrol);
        $check=$this->input->post('permiso');
        for ($i=0; $i <sizeof($check) ; $i++) { 
            # code...
             $data  = array(
                'permission_id' => $check[$i],
                 'rol_id' => $this->input->post('rol')
                
            );
            if ($this->rol->addRolPermiso($data)) {
                $result['error'] = false;
                $result['msg']   = 'User added successfully';
            }
        }
        $this->session->set_flashdata('exito', 'Exito!.');
        redirect('rol/rolpermisos/'.$idrol);
    }
}
