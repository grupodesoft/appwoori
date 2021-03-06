<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Load libruary for API
class Permiso extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		if(!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('welcome');
        }
        $this->load->helper('url');
		$this->load->model('data_model');
		$this->load->model('permiso_model','permiso');
		$this->load->library('permission'); 
                $this->load->library('session');
	}

	public function index()
	{
        Permission::grant(uri_string());
		 $this->load->view('admin/header');
           $this->load->view('admin/permiso/index');
           $this->load->view('admin/footer');
	}

	    public function showAll()
    {
       //Permission::grant(uri_string());
        $query = $this->permiso->showAll();
        if ($query) {
            $result['permisos'] = $this->permiso->showAll();
        }
       if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
    }
      public function addPermiso()
    {
        //Permission::grant(uri_string());
        $config = array( 
            array(
                'field' => 'uri',
                'label' => 'Permiso',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'description',
                'label' => 'Descripción',
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
                'uri' => form_error('uri'),
                'description' => form_error('description') 
            );
            
        } else {
            
            $data     = array(
                'uri' => $this->input->post('uri'),
                'description' => $this->input->post('description')
                
            );
            if ($this->permiso->addPermiso($data)) {
                $result['error'] = false;
                $result['msg']   = 'User added successfully';
            }
            
        }
        if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
    }
	 public function updatePermiso()
    {
        //Permission::grant(uri_string());
        $config = array(
            array(
                'field' => 'uri',
                'label' => 'Permiso',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'description',
                'label' => 'Descripción',
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
                'uri' => form_error('uri'),
                'description' => form_error('description') 
            );
            
        } else {
            $id   = $this->input->post('id');
            $data = array(
                'uri' => $this->input->post('uri'),
                'description' => $this->input->post('description')
            );
            if ($this->permiso->updatePermiso($id, $data)) {
                $result['error']   = false;
                $result['success'] = 'User updated successfully';
            }
            
        }
      if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
    }
     public function searchPermiso()
    {
        //Permission::grant(uri_string());
        $value = $this->input->post('text');
        $query = $this->permiso->searchPermiso($value);
        if ($query) {
            $result['permisos'] = $query;
        }
        
       if(isset($result) && !empty($result)){
         echo json_encode($result);
        }
        
    }
   
}
