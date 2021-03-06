<?php

defined('BASEPATH') or exit('No direct script access allowed');

class CicloEscolar_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function __destruct()
    {
        $this->db->close();
    }


    public function showAll($idplantel = '')
    {
        $this->db->select('p.*,m.nombremes as mesinicio,m2.nombremes as mesfin,y.nombreyear as yearinicio,y2.nombreyear as yearfin');
        $this->db->from('tblperiodo p');
        $this->db->join('tblmes m ', ' p.idmesinicio = m.idmes');
        $this->db->join('tblmes m2 ', ' p.idmesfin = m2.idmes');
        $this->db->join('tblyear y ', ' p.idyearinicio = y.idyear');
        $this->db->join('tblyear y2 ', ' p.idyearfin = y2.idyear');
        if (isset($idplantel) && !empty($idplantel)) {
            $this->db->where('p.idplantel', $idplantel);
        }
        $this->db->order_by('p.idperiodo DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function detalleCicloEscolar($idperiodo)
    {
        $this->db->select('m.nombremes as mesinicio,m2.nombremes as mesfin,y.nombreyear as yearinicio,y2.nombreyear as yearfin,p.descripcion');
        $this->db->from('tblperiodo p');
        $this->db->join('tblmes m ', ' p.idmesinicio = m.idmes');
        $this->db->join('tblmes m2 ', ' p.idmesfin = m2.idmes');
        $this->db->join('tblyear y ', ' p.idyearinicio = y.idyear');
        $this->db->join('tblyear y2 ', ' p.idyearfin = y2.idyear');
        $this->db->where('p.idperiodo', $idperiodo);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }
    public function showAllCicloEscolar($idplantel = '')
    {
        $this->db->select('p.*,m.nombremes as mesinicio,m2.nombremes as mesfin,y.nombreyear as yearinicio,y2.nombreyear as yearfin');
        $this->db->from('tblperiodo p');
        $this->db->join('tblmes m ', ' p.idmesinicio = m.idmes');
        $this->db->join('tblmes m2 ', ' p.idmesfin = m2.idmes');
        $this->db->join('tblyear y ', ' p.idyearinicio = y.idyear');
        $this->db->join('tblyear y2 ', ' p.idyearfin = y2.idyear');
        if (isset($idplantel) && !empty($idplantel)) {
            $this->db->where('p.idplantel', $idplantel);
        }
        $this->db->order_by('p.idperiodo DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function detalleGrupo($idhorario = '')
    {
        $this->db->select('g.nombregrupo,ne.primaria');
        $this->db->from('tblhorario h');
        $this->db->join('tblgrupo g ', ' h.idgrupo = g.idgrupo');
        $this->db->join('tblnivelestudio ne ', ' ne.idnivelestudio = g.idnivelestudio');
        $this->db->where('h.idhorario', $idhorario);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }
    public function detalleCicloEscolarHorario($idhorario = '')
    {
        $this->db->select('m.nombremes as mesinicio,m2.nombremes as mesfin,y.nombreyear as yearinicio,y2.nombreyear as yearfin');
        $this->db->from('tblperiodo p');
        $this->db->join('tblmes m ', ' p.idmesinicio = m.idmes');
        $this->db->join('tblmes m2 ', ' p.idmesfin = m2.idmes');
        $this->db->join('tblyear y ', ' p.idyearinicio = y.idyear');
        $this->db->join('tblyear y2 ', ' p.idyearfin = y2.idyear');
        $this->db->join('tblhorario h', ' p.idperiodo = h.idperiodo');
        $this->db->where('h.idhorario', $idhorario);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }
    public function showAllPrimerTrimestre()
    {
        $this->db->select('m.idmes');
        $this->db->from('tblmes m');
        $this->db->where('m.numero >= 9');
        $this->db->where('m.numero <= 11');
        $this->db->order_by('m.enumeracion ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function showAllSegundoTrimestre()
    {
        $in = array(12, 1, 2, 3);
        $this->db->select('m.idmes');
        $this->db->from('tblmes m');
        $this->db->where_in('m.idmes', $in);
        $this->db->order_by('m.enumeracion ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function showAllTercerTrimestre()
    {
        $in = array(4, 5, 6);
        $this->db->select('m.idmes');
        $this->db->from('tblmes m');
        $this->db->where_in('m.idmes', $in);
        $this->db->order_by('m.enumeracion ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function calificacionXMes($idprofesormateria = '', $idalumno = '', $idmes, $idhorario)
    {
        $this->db->select('dc.calificacion');
        $this->db->from('tblcalificacion c');
        $this->db->join('tbldetalle_calificacion dc', 'c.idcalificacion = dc.idcalificacion');
        $this->db->join('tblhorario_detalle hd ', 'hd.idhorariodetalle = c.idhorariodetalle');
        $this->db->join('tblmes m ', 'm.idmes = dc.idmes');
        $this->db->where('hd.idhorario', $idhorario);
        $this->db->where('c.idalumno', $idalumno);
        $this->db->where('hd.idmateria', $idprofesormateria);
        $this->db->where('dc.idmes', $idmes);
        $this->db->order_by('m.enumeracion ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }


    public function showAllCicloEscolarActivo($idplantel = '')
    {
        $this->db->select('p.*,m.nombremes as mesinicio,m2.nombremes as mesfin,y.nombreyear as yearinicio,y2.nombreyear as yearfin');
        $this->db->from('tblperiodo p');
        $this->db->join('tblmes m ', ' p.idmesinicio = m.idmes');
        $this->db->join('tblmes m2 ', ' p.idmesfin = m2.idmes');
        $this->db->join('tblyear y ', ' p.idyearinicio = y.idyear');
        $this->db->join('tblyear y2 ', ' p.idyearfin = y2.idyear');
        if (isset($idplantel) && !empty($idplantel)) {
            $this->db->where('p.idplantel', $idplantel);
        }
        $this->db->where('p.activo', 1);
        $this->db->order_by('p.idperiodo DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function showAllMeses()
    {
        $this->db->select('m.*');
        $this->db->from('tblmes m');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function showAllYears()
    {
        $this->db->select('m.*');
        $this->db->from('tblyear m');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function validarAddCiclo($mesinicio = '', $yearinicio = '', $mesfin = '', $yearfin = '', $idplantel = '')
    {
        $this->db->select('p.*');
        $this->db->from('tblperiodo p');
        $this->db->where('p.idmesinicio', $mesinicio);
        $this->db->where('p.idyearinicio', $yearinicio);
        $this->db->where('p.idmesfin', $mesfin);
        $this->db->where('p.idyearfin', $yearfin);
        if (isset($idplantel) && !empty($idplantel)) {
            $this->db->where('p.idplantel', $idplantel);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function validarUpdateCiclo($mesinicio = '', $yearinicio = '', $mesfin = '', $yearfin = '', $idperiodo = '', $idplantel = '')
    {
        $this->db->select('p.*');
        $this->db->from('tblperiodo p');
        $this->db->where('p.idmesinicio', $mesinicio);
        $this->db->where('p.idyearinicio', $yearinicio);
        $this->db->where('p.idmesfin', $mesfin);
        $this->db->where('p.idyearfin', $yearfin);
        $this->db->where('p.idperiodo !=', $idperiodo);
        if (isset($idplantel) && !empty($idplantel)) {
            $this->db->where('p.idplantel', $idplantel);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function datosCiclo($idperiodo = '')
    {
        $this->db->select('p.*');
        $this->db->from('tblperiodo p');
        $this->db->where('p.idperiodo', $idperiodo);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }


    public function addCiclo($data)
    {
        $this->db->insert('tblperiodo', $data);
        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }

    public function deleteCicloEscolar($idciclo = '')
    {
        # code...
        $this->db->where('idperiodo', $idciclo);
        $this->db->delete('tblperiodo');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function searchCiclo($match, $idplantel = '')
    {
        $field = array(
            'm.nombremes',
            'm2.nombremes',
            'y.nombreyear',
            'y2.nombreyear',
            'p.descripcion'
        );
        $this->db->select('p.*,m.nombremes as mesinicio,m2.nombremes as mesfin,y.nombreyear as yearinicio,y2.nombreyear as yearfin');
        $this->db->from('tblperiodo p');
        $this->db->join('tblmes m ', ' p.idmesinicio = m.idmes');
        $this->db->join('tblmes m2 ', ' p.idmesfin = m2.idmes');
        $this->db->join('tblyear y ', ' p.idyearinicio = y.idyear');
        $this->db->join('tblyear y2 ', ' p.idyearfin = y2.idyear');
        if (isset($idplantel) && !empty($idplantel)) {
            $this->db->where('p.idplantel', $idplantel);
        }
        $this->db->like('concat(' . implode(',', $field) . ')', $match);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }



    public function updatePeriodo($id, $field)
    {
        $this->db->where('idperiodo', $id);
        $this->db->update('tblperiodo', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function updateHorario($id, $field)
    {
        $this->db->where('idperiodo', $id);
        $this->db->update('tblhorario', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function desactivarHorario($field, $idplantel)
    {
        $this->db->where('idplantel', $idplantel);
        $this->db->update('tblhorario', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function desactivaCiclo($field, $idplantel)
    {
        $this->db->where('idplantel', $idplantel);
        $this->db->update('tblperiodo', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
