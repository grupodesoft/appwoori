<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mensaje_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function __destruct() {
        $this->db->close();
    }

 
        public function showAllMensaje($idhorariodetalle = '') {
        $this->db->select('m.*');
        $this->db->from('tblmensaje m'); 
        if(isset($idhorariodetalle) && !empty($idhorariodetalle)){
        $this->db->where('m.idhorariodetalle',$idhorariodetalle);
        }
        $this->db->where('m.eliminado',0);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    } 
    public function showAllMensajeAlumno($idhorario = '') {
        $this->db->select("m.idmensaje, ma.nombreclase,LEFT(m.mensaje, 90) as mensaje, DATE_FORMAT(m.fecharegistro,'%d/%m/%Y') as fecha");
        $this->db->from('tblmensaje m'); 
        $this->db->join('tblhorario_detalle hd','hd.idhorariodetalle = m.idhorariodetalle');
        $this->db->join('tblprofesor_materia pm','hd.idmateria = pm.idprofesormateria');
        $this->db->join('tblmateria ma','pm.idmateria = ma.idmateria');
        if(isset($idhorario) && !empty($idhorario)){
        $this->db->where('m.idhorario',$idhorario);
        } 
        $this->db->where('m.eliminado',0);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    } 
        public function detalleTarea($idtarea = '') {
        $this->db->select("ma.nombreclase,t.tarea, DATE_FORMAT(t.fechaentrega,'%d/%m/%Y') as fecha");
        $this->db->from('tbltarea t'); 
        $this->db->join('tblhorario_detalle hd','hd.idhorariodetalle = t.idhorariodetalle');
        $this->db->join('tblprofesor_materia pm','hd.idmateria = pm.idprofesormateria');
        $this->db->join('tblmateria ma','pm.idmateria = ma.idmateria');
        if(isset($idtarea) && !empty($idtarea)){
        $this->db->where('t.idtarea',$idtarea);
        }  
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    } 
            public function detalleMensaje($idmensaje = '') {
        $this->db->select("ma.nombreclase,t.mensaje, DATE_FORMAT(t.fecharegistro,'%d/%m/%Y') as fecha");
        $this->db->from('tblmensaje t'); 
        $this->db->join('tblhorario_detalle hd','hd.idhorariodetalle = t.idhorariodetalle');
        $this->db->join('tblprofesor_materia pm','hd.idmateria = pm.idprofesormateria');
        $this->db->join('tblmateria ma','pm.idmateria = ma.idmateria');
        if(isset($idmensaje) && !empty($idmensaje)){
        $this->db->where('t.idmensaje',$idmensaje);
        }  
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    } 
          public function addMensaje($data)
    {
        $this->db->insert('tblmensaje', $data);
        $insert_id = $this->db->insert_id(); 
        return  $insert_id;
    }

        public function updateMensaje($id, $field)
    {
        $this->db->where('idmensaje', $id);
        $this->db->update('tblmensaje', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
      

    }

}