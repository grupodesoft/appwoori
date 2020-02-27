<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tutor_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function __destruct() {
        $this->db->close();
    }

  
    public function showAll($idplantel = '') {
        $this->db->select('t.*');
        $this->db->from('tbltutor t'); 
         if (isset($idplantel) && !empty($idplantel)) {
        $this->db->where('t.idplantel',$idplantel); 
        }  
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    } 
      public function showAllAlumnos($idplantel = '') {
        $this->db->select('a.*');
        $this->db->from('tblalumno a'); 
         if (isset($idplantel) && !empty($idplantel)) {
        $this->db->where('a.idplantel',$idplantel); 
        }  
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    } 
          public function validarAddTutor($correo = '', $idplantel = '') {
        $this->db->select('t.*');
        $this->db->from('tbltutor t'); 
         if (isset($idplantel) && !empty($idplantel)) {
        $this->db->where('t.idplantel',$idplantel); 
        }  
        $this->db->where('t.correo',$correo);
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    } 
              public function validarUpdateTutor($idtutor = '', $correo = '', $idplantel = '') {
        $this->db->select('t.*');
        $this->db->from('tbltutor t'); 
         if (isset($idplantel) && !empty($idplantel)) {
        $this->db->where('t.idplantel',$idplantel); 
        }  
        $this->db->where('t.correo',$correo);
        $this->db->where('t.idtutor !=',$idtutor);
         $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    } 


    public function showAllTutorAlumnos($idtutor,$idplantel = '')
    {
        $this->db->select('t.idtutoralumno, a.nombre, a.apellidop, a.apellidom');    
        $this->db->from('tbltutoralumno t');
        $this->db->join('tblalumno a', 'a.idalumno = t.idalumno');
        $this->db->where('t.idtutor', $idtutor); 
        if (isset($idplantel) && !empty($idplantel)) { 
             $this->db->where('t.idplantel', $idplantel); 
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

 public function deleteAlumno($id)
    {
        $this->db->where('idtutoralumno', $id);
        $this->db->delete('tbltutoralumno');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
        
    }

        public function searchTutor($match,$idplantel = '') {
        $field = array(
                 't.nombre',
                 't.apellidop',
                 't.apellidom'
        );
         $this->db->select('t.*');
        $this->db->from('tbltutor t'); 
        if (isset($idplantel) && !empty($idplantel)) {
            $this->db->where('t.idplantel',$idplantel); 
        }
        
        $this->db->like('concat(' . implode(',', $field) . ')', $match);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
   
     public function addTutor($data)
    {
        $this->db->insert('tbltutor', $data);
        $insert_id = $this->db->insert_id(); 
        return  $insert_id;
    }
     public function addTutorAlumno($data)
    {
        $this->db->insert('tbltutoralumno', $data);
        $insert_id = $this->db->insert_id(); 
        return  $insert_id;
    }
    
       public function detalleTutor($idtutor)
    {
        $this->db->select('t.*');
        $this->db->from('tbltutor t'); 
        $this->db->where('t.idtutor', $idtutor);
        $query = $this->db->get();

        return $query->first_row();
    }
    
    public function updateTutor($id, $field)
    {
        $this->db->where('idtutor', $id);
        $this->db->update('tbltutor', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
        
    }

    public function deleteTutor($idtutor)
{
    # code...
     $this->db->where('idtutor', $idtutor);
        $this->db->delete('tbltutor');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
}

      

}