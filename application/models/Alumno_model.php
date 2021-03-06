<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Alumno_model extends CI_Model
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
        $this->db->select("t.idalumno, t.nombre, t.apellidop, t.apellidom,t.idplantel, t.idespecialidad,"
            . "t.matricula, t.curp,t.lugarnacimiento, t.nacionalidad, t.domicilio, t.telefono,t.telefonoemergencia,"
            . "t.serviciomedico,t.idtiposanguineo,t.alergiaopadecimiento, t.peso, t.estatura,t.numfolio, t.numacta,numlibro,"
            . "t.foto, t.sexo, t.correo,t.password,t.idalumnoestatus, DATE_FORMAT(t.fechanacimiento,'%d/%m/%Y') as fechanacimiento,n.nombreniveleducativo,ae.idestatusalumno, ae.nombreestatus");
        $this->db->from('tblalumno t');
        $this->db->join('tblplantel p', 't.idplantel = p.idplantel');
        $this->db->join('tblniveleducativo n', 'n.idniveleducativo = p.idniveleducativo');
        $this->db->join('tblalumno_estatus ae', 'ae.idestatusalumno = t.idalumnoestatus');
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

    public function showAllEstatusAlumno()
    {
        $this->db->select('ae.*');
        $this->db->from('tblalumno_estatus ae');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function logo($idplantel = '')
    {
        $this->db->select('p.*');
        $this->db->from('tblplantel p');
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

    public function buscarAlumno($matricula = '')
    {
        $this->db->select('a.idalumno, a.nombre, a.apellidop, a.apellidom');
        $this->db->from('tblalumno a');
        $this->db->where('a.matricula', $matricula);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }


    public function becaAlumno($idalumno = '')
    {
        $this->db->select('ag.idalumnogrupo, b.descuento,b.descripcion');
        $this->db->from('tblbeca b');
        $this->db->join('tblalumno_grupo ag', 'ag.idbeca = b.idbeca');
        $this->db->where('ag.idalumno', $idalumno);
        $this->db->where('ag.activo', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public function estatusAlumno($idalumno = '')
    {
        $this->db->select('a.idalumno,ae.idestatusalumno,ae.nombreestatus');
        $this->db->from('tblalumno a');
        $this->db->join('tblalumno_estatus ae', 'a.idalumnoestatus = ae.idestatusalumno');
        $this->db->where('a.idalumno', $idalumno);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }


    public function showAllBecas()
    {
        $this->db->select('b.idbeca, b.descuento,b.descripcion');
        $this->db->from('tblbeca b');
        $this->db->where('b.activo', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllAlumnosTutor($idtutor = '')
    {
        $this->db->select('a.idalumno,a.nombre, a.apellidop, a.apellidom');
        $this->db->from('tbltutoralumno ta');
        $this->db->join('tblalumno a', 'a.idalumno = ta.idalumno');
        $this->db->where('ta.idtutor', $idtutor);
        $this->db->order_by('a.apellidop ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllTiposSanguineos()
    {
        $this->db->select('ts.*');
        $this->db->from('tbltiposanguineo ts');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function materiasTallerHorario($idhorario)
    {
        $this->db->select('hd.idhorario,pm.idprofesormateria, pm.idmateria, m.nombreclase, p.nombre, p.apellidop, p.apellidom');
        $this->db->from('tblhorario_detalle hd');
        $this->db->join('tblprofesor_materia pm', 'pm.idprofesormateria = hd.idmateria');
        $this->db->join('tblmateria m', 'm.idmateria = pm.idmateria');
        $this->db->join('tblprofesor p', 'p.idprofesor = pm.idprofesor');
        $this->db->where('hd.idhorario', $idhorario);
        $this->db->where('m.idclasificacionmateria', 3);
        $this->db->group_by('hd.idmateria');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function materiaTallerSeleccionada($idhorario, $idalumno)
    {
        $this->db->select('hd.idhorario,pm.idprofesormateria, pm.idmateria');
        $this->db->from('tblhorario_detalle hd');
        $this->db->join('tblprofesor_materia pm', 'pm.idprofesormateria = hd.idmateria');
        $this->db->join('tblmateria m', 'm.idmateria = pm.idmateria');
        $this->db->join('tblhorario_detalle_cursos hdc', 'hdc.idhorario = hd.idhorario');
        $this->db->where('hd.idhorario', $idhorario);
        $this->db->where('hdc.idalumno', $idalumno);
        $this->db->where('hdc.idprofesormateria = pm.idprofesormateria');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public function showAllAlumnosTutorActivos($idtutor = '')
    {
        $this->db->select("a.idalumno, h.idhorario, a.nombre, a.apellidop, a.apellidom,ne.nombrenivel, ne.idnivelestudio, g.nombregrupo, g.idgrupo, ag.idperiodo, p.idniveleducativo, CASE niv.idniveleducativo 
        WHEN 3 THEN ne.numeroromano
        WHEN 5 THEN ne.numeroromano
        WHEN 1 THEN ne.numeroordinaria
        WHEN 2 THEN ne.numeroordinaria
        WHEN 4 THEN ne.numeroordinaria
        ELSE ''
    END AS nivelgrupo");
        $this->db->from('tblalumno a');
        $this->db->join('tbltutoralumno ta', 'a.idalumno=ta.idalumno');
        $this->db->join('tblalumno_grupo ag', 'ag.idalumno=a.idalumno');
        $this->db->join('tblgrupo g', 'g.idgrupo=ag.idgrupo');
        $this->db->join('tblnivelestudio ne', 'g.idnivelestudio=ne.idnivelestudio');
        $this->db->join('tblhorario h', 'h.idperiodo = ag.idperiodo');
        $this->db->join('tblplantel p', 'a.idplantel = p.idplantel');
        $this->db->join('tblniveleducativo niv', 'p.idniveleducativo = niv.idniveleducativo');
        $this->db->where('h.idgrupo = ag.idgrupo');
        $this->db->where('ta.idtutor', $idtutor);
        $this->db->where('ag.activo', 1);
        $this->db->where('h.activo', 1);
        $this->db->order_by('a.apellidop ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllMateriasAlumno($idalumno = '', $activo = '')
    {
        $this->db->select('pe.idperiodo, hd.idhorariodetalle,ma.nombreclase,p.nombre, p.apellidop, p.apellidom, g.nombregrupo,ne.nombrenivel, g.idgrupo, h.idhorario,m.nombremes as mesinicio,m2.nombremes as mesfin,y.nombreyear as yearinicio,y2.nombreyear as yearfin, pla.nombreplantel,pla.asociado, pla.direccion, pla.telefono, a.matricula, h.idhorario,ma.unidades');
        $this->db->from('tblhorario_detalle hd');
        $this->db->join('tblprofesor_materia pm', 'pm.idprofesormateria = hd.idmateria');
        $this->db->join('tblprofesor p', 'p.idprofesor = pm.idprofesor');
        $this->db->join('tblmateria ma', 'ma.idmateria = pm.idmateria');
        $this->db->join('tblhorario h', 'hd.idhorario = h.idhorario');
        $this->db->join('tblplantel pla', 'pla.idplantel = h.idplantel');
        $this->db->join('tblgrupo g', 'g.idgrupo = h.idgrupo');
        $this->db->join('tblnivelestudio ne', 'ne.idnivelestudio = g.idnivelestudio');
        $this->db->join('tblperiodo pe', 'pe.idperiodo = h.idperiodo');
        $this->db->join('tblmes m ', ' pe.idmesinicio = m.idmes');
        $this->db->join('tblmes m2 ', ' pe.idmesfin = m2.idmes');
        $this->db->join('tblyear y ', ' pe.idyearinicio = y.idyear');
        $this->db->join('tblyear y2 ', ' pe.idyearfin = y2.idyear');
        $this->db->join('tblalumno_grupo ag', 'ag.idgrupo = g.idgrupo');
        $this->db->join('tblalumno a', 'a.idalumno = ag.idalumno');
        $this->db->where('a.idalumno', $idalumno);
        if (isset($activo) && empty($activo)) {
            $this->db->where('pe.activo', 1);
            $this->db->where('h.activo', 1);
        }
        $this->db->where('(pe.idperiodo = ag.idperiodo)');
        $this->db->group_by('ma.idmateria');
        $this->db->group_by('h.idgrupo');
        $this->db->order_by('ne.nombrenivel asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllPagoInscripcion($idalumno = '', $idperiodo = '')
    {
        $this->db->select("tp2.concepto,( SELECT
         GROUP_CONCAT(CONCAT_WS(' ', tp.nombretipopago)
                    SEPARATOR ', ') ) AS nombretipopago, tp.nombretipopago, DATE_FORMAT(pi.fecharegistro,'%d/%m/%Y') as fecharegistro, dpi.idformapago, pi.online, pi.pagado");
        $this->db->from('tblpago_inicio pi');
        $this->db->join('tbltipopagocol tp2', 'tp2.idtipopagocol = pi.idtipopagocol');
        $this->db->join('tbldetalle_pago_inicio dpi', 'pi.idpago = dpi.idpago');
        $this->db->join('tbltipo_pago tp', 'tp.idtipopago = dpi.idformapago');
        //$this->db->join('tblperiodo p', 'p.idperiodo = pi.idperiodo');
        $this->db->where('pi.idalumno', $idalumno);
        $this->db->where('pi.idperiodo', $idperiodo);
        //$this->db->where('p.activo',1);
        $this->db->where('pi.eliminado', 0);
        $this->db->group_by('dpi.idpago');
        $this->db->select_sum('dpi.descuento');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllPagoColegiaturas($idalumno = '', $idperiodo = '')
    {
        $query = $this->db->query("SELECT
    ec.idestadocuenta,
    SUM(dp.descuento) AS descuento,
    ec.pagado,
    ec.idperiodo,
    (SELECT
            GROUP_CONCAT(CONCAT_WS(' ', tp.nombretipopago)
                    SEPARATOR ', ')
        ) AS nombretipopago,
    DATE_FORMAT(ec.fechapago, '%d/%m/%Y') AS fechapago,
    (SELECT
    (SELECT
            GROUP_CONCAT(CONCAT_WS(' ', m.nombremes)
                    SEPARATOR ', ')
        )  FROM  tbldetalle_estadocuenta det
        INNER JOIN
    tblmes m ON m.idmes = det.idmes WHERE det.idestadocuenta = ec.idestadocuenta )AS mes,
    ec.online
FROM
    tblestado_cuenta ec
        INNER JOIN
    tbldetalle_pago dp ON ec.idestadocuenta = dp.idestadocuenta
        INNER JOIN
    tbltipo_pago tp ON tp.idtipopago = dp.idformapago
    WHERE ec.idperiodo = $idperiodo AND ec.idalumno = $idalumno
    AND ec.eliminado = 0
    GROUP BY ec.idestadocuenta");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showColonias($cp)
    {
        $this->db->select('c.*');
        $this->db->from('tblcolonia c');
        $this->db->where('c.cp', $cp);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showMunicipio($cp)
    {
        $this->db->select('m.*');
        $this->db->from('tblcolonia c');
        $this->db->join('tblmunicipio m ', 'c.idmunicipio = m.idmunicipio');
        $this->db->where('c.cp', $cp);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showEstado($cp)
    {
        $this->db->select('e.*');
        $this->db->from('tblcolonia c');
        $this->db->join('tblmunicipio m ', 'c.idmunicipio = m.idmunicipio');
        $this->db->join('tblestado e ', 'e.idestado = m.idestado');
        $this->db->where('c.cp', $cp);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllUnidades($idplantel = '')
    {
        $this->db->select('u.*');
        $this->db->from('tblunidad u');
        if (isset($idplantel) && !empty($idplantel)) {
            $this->db->where('u.idplantel', $idplantel);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllEspecialidades($idplantel = '')
    {
        $this->db->select('e.*');
        $this->db->from('tblespecialidad e');
        if (isset($idplantel) && !empty($idplantel)) {
            $this->db->where('e.idplantel', $idplantel);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllDias()
    {
        $this->db->select('d.*');
        $this->db->from('tbldia d');
        $this->db->where('d.iddia NOT IN (6,7)');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllGrupos($idplantel = '')
    {
        $this->db->select('g.idgrupo,n.nombrenivel,g.nombregrupo,t.nombreturno, e.nombreespecialidad');
        $this->db->from('tblgrupo g');
        $this->db->join('tblnivelestudio n', 'n.idnivelestudio = g.idnivelestudio');
        $this->db->join('tblespecialidad e', 'e.idespecialidad = g.idespecialidad');
        $this->db->join('tblturno t', 'g.idturno = t.idturno');
        if (isset($idplantel) && !empty($idplantel)) {
            $this->db->where('g.idplantel', $idplantel);
        }
        $this->db->order_by('n.nombrenivel ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllTipoAsistencia()
    {
        $this->db->select('a.*');
        $this->db->from('tblmotivo_asistencia a');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllTutorAlumno($idalumno = '')
    {
        $this->db->select('t.nombre,t.apellidop,t.apellidom,t.escolaridad,t.ocupacion,t.dondetrabaja, t.fnacimiento,direccion,telefono,correo');
        $this->db->from('tbltutor t');
        $this->db->join('tbltutoralumno ta', 'ta.idtutor= t.idtutor');
        $this->db->where('ta.idalumno', $idalumno);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function validarAddAlumnoGrupo($idcicloescolar = '', $idalumno = '', $idgrupo = '', $idplantel = '')
    {
        $this->db->select('ag.*');
        $this->db->from('tblalumno_grupo ag');
        $this->db->join('tblalumno a', 'a.idalumno = ag.idalumno');
        $this->db->where('ag.idperiodo', $idcicloescolar);
        $this->db->where('ag.idalumno', $idalumno);
        $this->db->where('ag.idgrupo', $idgrupo);
        if (isset($idplantel) && !empty($idplantel)) {
            $this->db->where('a.idplantel', $idplantel);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function validarMatricula($matricula = '', $idalumno = '', $idplantel = '')
    {
        $this->db->select('a.*');
        $this->db->from('tblalumno a');
        $this->db->where('a.matricula', $matricula);
        if (!empty($idalumno)) {
            $this->db->where('a.idalumno !=', $idalumno);
        }
        if (isset($idplantel) && !empty($idplantel)) {
            $this->db->where('a.idplantel', $idplantel);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function validarAsignarTutor($idalumno = '', $idtutor = '', $idplantel = '')
    {
        $this->db->select('a.*');
        $this->db->from('tblalumno a');
        $this->db->join('tbltutoralumno ta', 'a.idalumno = ta.idalumno');
        $this->db->where('ta.idtutor', $idtutor);
        $this->db->where('ta.idalumno', $idalumno);
        if (isset($idplantel) && !empty($idplantel)) {
            $this->db->where('a.idplantel', $idplantel);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function showAllMateriasTareas($idhorario, $reprobadas = '', $idalumno = '')
    {
        $sql = 'select
    idprofesormateri,
    idhorariodetalle,
    idhorario,
    horainicial,
    horafinal,
    nombreclase,
    nombre,
    apellidop,
    apellidom,
    idmateria,
    unidades,
    opcion,
totaltareacontestada,
totaltareaenviada,
mensajesnovistos
FROM
    (select
        hd.idmateria AS idprofesormateri,
            hd.idhorariodetalle,
            hd.idhorario,
            hd.horainicial,
            hd.horafinal,
            m.nombreclase,
            p.nombre,
            p.apellidop,
            p.apellidom,
            m.idmateria,
            m.unidades,
            1 as opcion,COALESCE((SELECT
			COUNT(t2.idtarea)
		FROM
			tbltareav2 tv2
		INNER JOIN tblhorario_detalle hd2 ON
			tv2.idhorariodetalle = hd2.idhorariodetalle
		LEFT JOIN tbldetalle_tarea t2
			ON tv2.idtarea = t2.idtarea
		WHERE
			hd.idmateria = hd2.idmateria
			AND tv2.eliminado = 0
			AND t2.idalumno  = ' . $idalumno . '
			AND tv2.idhorario = hd.idhorario
			),
		0) AS totaltareacontestada,
			    
COALESCE((SELECT
							 COUNT(tv2.idtarea)
                        FROM
                            tbltareav2 tv2
                        INNER JOIN tblhorario_detalle hd2 ON tv2.idhorariodetalle = hd2.idhorariodetalle
                        WHERE
                            hd.idmateria = hd2.idmateria
AND tv2.eliminado = 0
                                AND tv2.idhorario = hd.idhorario),0) AS totaltareaenviada,

                               COALESCE((
		SELECT
			COUNT(m.idmensaje)
		FROM
			tblmensaje m
		INNER JOIN tblhorario_detalle hd2 ON
			m.idhorariodetalle = hd2.idhorariodetalle
		WHERE
			hd.idmateria = hd2.idmateria
			AND m.eliminado = 0
			AND m.idhorario = hd.idhorario
			AND m.idnotificacionalumno = 1),
		0) AS mensajesnovistos

    FROM
        tblhorario_detalle hd
    JOIN tblprofesor_materia pm ON hd.idmateria = pm.idprofesormateria
    JOIN tblmateria m ON m.idmateria = pm.idmateria
    JOIN tblprofesor p ON p.idprofesor = pm.idprofesor
    WHERE hd.idhorario = ' . $idhorario . ' ';
        if (isset($reprobadas) && !empty($reprobadas)) {
            $sql .= " and m.idmateria NOT IN ($reprobadas)";
        }
        $sql .= " and m.idclasificacionmateria NOT IN (3) ";

        $sql .= ' UNION ALL select
    hd.idmateria AS idprofesormateri,
        hd.idhorariodetalle,
        hd.idhorario,
        hd.horainicial,
        hd.horafinal,
        m.nombreclase,
        p.nombre,
        p.apellidop,
        p.apellidom,
        m.idmateria,
        m.unidades,
        1 as opcion,COALESCE((SELECT
        COUNT(t2.idtarea)
    FROM
        tbltareav2 tv2
    INNER JOIN tblhorario_detalle hd2 ON
        tv2.idhorariodetalle = hd2.idhorariodetalle
    LEFT JOIN tbldetalle_tarea t2
        ON tv2.idtarea = t2.idtarea
    WHERE
        hd.idmateria = hd2.idmateria
        AND tv2.eliminado = 0
        AND t2.idalumno  = ' . $idalumno . '
        AND tv2.idhorario = hd.idhorario
        ),
    0) AS totaltareacontestada,
            
COALESCE((SELECT
                         COUNT(tv2.idtarea)
                    FROM
                        tbltareav2 tv2
                    INNER JOIN tblhorario_detalle hd2 ON tv2.idhorariodetalle = hd2.idhorariodetalle
                    WHERE
                        hd.idmateria = hd2.idmateria
AND tv2.eliminado = 0
                            AND tv2.idhorario = hd.idhorario),0) AS totaltareaenviada,
                             COALESCE((
                                SELECT
                                    COUNT(m.idmensaje)
                                FROM
                                    tblmensaje m
                                INNER JOIN tblhorario_detalle hd2 ON
                                    m.idhorariodetalle = hd2.idhorariodetalle
                                WHERE
                                    hd.idmateria = hd2.idmateria
                                    AND m.eliminado = 0
                                    AND m.idhorario = hd.idhorario
                                    AND m.idnotificacionalumno = 1),
                                0) AS mensajesnovistos
FROM
    tblhorario_detalle hd
JOIN tblprofesor_materia pm ON hd.idmateria = pm.idprofesormateria
JOIN tblmateria m ON m.idmateria = pm.idmateria
JOIN tblprofesor p ON p.idprofesor = pm.idprofesor
JOIN tblhorario_detalle_cursos hdc ON hdc.idhorario = hd.idhorario
WHERE hd.idhorario = ' . $idhorario . ' ';
        $sql .= " and hdc.idalumno = $idalumno and hdc.idprofesormateria = hd.idmateria ";

        $sql .= ' UNION ALL
        SELECT
        hd.idmateria AS idprofesormateri,
            hd.idhorariodetalle,
            hd.idhorario,
            hd.horainicial,
            hd.horafinal,
            m.nombreclase,
            p.nombre,
            p.apellidop,
            p.apellidom,
            m.idmateria,
            m.unidades,
            0 as opcion,COALESCE((SELECT
			COUNT(t2.idtarea)
		FROM
			tbltareav2 tv2
		INNER JOIN tblhorario_detalle hd2 ON
			tv2.idhorariodetalle = hd2.idhorariodetalle
		LEFT JOIN tbldetalle_tarea t2
			ON tv2.idtarea = t2.idtarea
		WHERE
			hd.idmateria = hd2.idmateria
			AND tv2.eliminado = 0
			AND t2.idalumno  = ' . $idalumno . '
			AND tv2.idhorario = hd.idhorario
			),
		0) AS totaltareacontestada,
			    
(SELECT
							 COUNT(tv2.idtarea)
                        FROM
                            tbltareav2 tv2
                        INNER JOIN tblhorario_detalle hd2 ON tv2.idhorariodetalle = hd2.idhorariodetalle
                        WHERE
                            hd.idmateria = hd2.idmateria
                                AND tv2.idhorario = hd.idhorario) AS totaltareaenviada,
                                 COALESCE((
                                    SELECT
                                        COUNT(m.idmensaje)
                                    FROM
                                        tblmensaje m
                                    INNER JOIN tblhorario_detalle hd2 ON
                                        m.idhorariodetalle = hd2.idhorariodetalle
                                    WHERE
                                        hd.idmateria = hd2.idmateria
                                        AND m.eliminado = 0
                                        AND m.idhorario = hd.idhorario
                                        AND m.idnotificacionalumno = 1),
                                    0) AS mensajesnovistos
                                
    FROM
        tblmateria_reprobada mr
    INNER JOIN tbldetalle_reprobada dr ON mr.idreprobada = dr.idreprobada
    INNER JOIN tblhorario_detalle hd ON dr.idprofesormateria = hd.idmateria
    INNER JOIN tblhorario h ON h.idhorario = hd.idhorario
    INNER JOIN tblperiodo pe ON h.idperiodo = pe.idperiodo
    JOIN tblprofesor_materia pm ON hd.idmateria = pm.idprofesormateria
    JOIN tblmateria m ON m.idmateria = pm.idmateria
    JOIN tblprofesor p ON p.idprofesor = pm.idprofesor
    WHERE (pe.activo = 1 OR h.activo =1) AND mr.estatus = 1) materias
GROUP BY idmateria ORDER BY nombreclase ASC';

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function showAllMaterias($idhorario, $reprobadas = '', $idalumno = '')
    {
        $sql = 'select
    idprofesormateri,
    idhorariodetalle,
    idhorario,
    horainicial,
    horafinal,
    nombreclase,
    nombre,
    apellidop,
    apellidom,
    idmateria,
    unidades,
    opcion
FROM
    (select
        hd.idmateria AS idprofesormateri,
            hd.idhorariodetalle,
            hd.idhorario,
            hd.horainicial,
            hd.horafinal,
            m.nombreclase,
            p.nombre,
            p.apellidop,
            p.apellidom,
            m.idmateria,
            m.unidades,
            1 as opcion
    FROM
        tblhorario_detalle hd
    JOIN tblprofesor_materia pm ON hd.idmateria = pm.idprofesormateria
    JOIN tblmateria m ON m.idmateria = pm.idmateria
    JOIN tblprofesor p ON p.idprofesor = pm.idprofesor
    WHERE hd.idhorario = ' . $idhorario . ' ';
        if (isset($reprobadas) && !empty($reprobadas)) {
            $sql .= " and m.idmateria NOT IN ($reprobadas)";
        }
        $sql .= " AND m.idclasificacionmateria NOT IN (3) AND m.secalifica = 1 ";
        if (isset($idalumno) && !empty($idalumno)) {
            $sql .= ' UNION ALL SELECT
        hd.idmateria AS idprofesormateri,
            hd.idhorariodetalle,
            hd.idhorario,
            hd.horainicial,
            hd.horafinal,
            m.nombreclase,
            p.nombre,
            p.apellidop,
            p.apellidom,
            m.idmateria,
            m.unidades,
            1 as opcion
    FROM
        tblhorario_detalle hd
    JOIN tblprofesor_materia pm ON hd.idmateria = pm.idprofesormateria
    JOIN tblmateria m ON m.idmateria = pm.idmateria
    JOIN tblprofesor p ON p.idprofesor = pm.idprofesor
    JOIN tblhorario_detalle_cursos hdc ON hdc.idhorario = hd.idhorario
    WHERE hd.idhorario = ' . $idhorario . ' ';
            $sql .= " AND hdc.idalumno = $idalumno AND hdc.idprofesormateria = hd.idmateria AND m.secalifica = 1";
        }
        $sql .= ' UNION ALL
        SELECT
        hd.idmateria AS idprofesormateri,
            hd.idhorariodetalle,
            hd.idhorario,
            hd.horainicial,
            hd.horafinal,
            m.nombreclase,
            p.nombre,
            p.apellidop,
            p.apellidom,
            m.idmateria,
            m.unidades,
            0 as opcion
    FROM
        tblmateria_reprobada mr
    INNER JOIN tbldetalle_reprobada dr ON mr.idreprobada = dr.idreprobada
    INNER JOIN tblhorario_detalle hd ON dr.idprofesormateria = hd.idmateria
    INNER JOIN tblhorario h ON h.idhorario = hd.idhorario
    INNER JOIN tblperiodo pe ON h.idperiodo = pe.idperiodo
    JOIN tblprofesor_materia pm ON hd.idmateria = pm.idprofesormateria
    JOIN tblmateria m ON m.idmateria = pm.idmateria
    JOIN tblprofesor p ON p.idprofesor = pm.idprofesor
    WHERE (pe.activo = 1 OR h.activo =1) AND mr.estatus = 1) materias
GROUP BY idmateria order by nombreclase ASC';

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllMateriasAsistencias($idhorario, $reprobadas = '', $idalumno = '')
    {
        $sql = 'select
    idprofesormateri,
    idhorariodetalle,
    idhorario,
    horainicial,
    horafinal,
    nombreclase,
    nombre,
    apellidop,
    apellidom,
    idmateria,
    unidades,
    opcion
FROM
    (select
        hd.idmateria AS idprofesormateri,
            hd.idhorariodetalle,
            hd.idhorario,
            hd.horainicial,
            hd.horafinal,
            m.nombreclase,
            p.nombre,
            p.apellidop,
            p.apellidom,
            m.idmateria,
            m.unidades,
            1 as opcion
    FROM
        tblhorario_detalle hd
    JOIN tblprofesor_materia pm ON hd.idmateria = pm.idprofesormateria
    JOIN tblmateria m ON m.idmateria = pm.idmateria
    JOIN tblprofesor p ON p.idprofesor = pm.idprofesor
    WHERE hd.idhorario = ' . $idhorario . ' ';
        if (isset($reprobadas) && !empty($reprobadas)) {
            $sql .= " and m.idmateria NOT IN ($reprobadas)";
        }
        $sql .= " AND m.idclasificacionmateria NOT IN (3)  ";
        if (isset($idalumno) && !empty($idalumno)) {
            $sql .= ' UNION ALL SELECT
        hd.idmateria AS idprofesormateri,
            hd.idhorariodetalle,
            hd.idhorario,
            hd.horainicial,
            hd.horafinal,
            m.nombreclase,
            p.nombre,
            p.apellidop,
            p.apellidom,
            m.idmateria,
            m.unidades,
            1 as opcion
    FROM
        tblhorario_detalle hd
    JOIN tblprofesor_materia pm ON hd.idmateria = pm.idprofesormateria
    JOIN tblmateria m ON m.idmateria = pm.idmateria
    JOIN tblprofesor p ON p.idprofesor = pm.idprofesor
    JOIN tblhorario_detalle_cursos hdc ON hdc.idhorario = hd.idhorario
    WHERE hd.idhorario = ' . $idhorario . ' ';
            $sql .= " AND hdc.idalumno = $idalumno AND hdc.idprofesormateria = hd.idmateria AND m.secalifica = 1";
        }
        $sql .= ' UNION ALL
        SELECT
        hd.idmateria AS idprofesormateri,
            hd.idhorariodetalle,
            hd.idhorario,
            hd.horainicial,
            hd.horafinal,
            m.nombreclase,
            p.nombre,
            p.apellidop,
            p.apellidom,
            m.idmateria,
            m.unidades,
            0 as opcion
    FROM
        tblmateria_reprobada mr
    INNER JOIN tbldetalle_reprobada dr ON mr.idreprobada = dr.idreprobada
    INNER JOIN tblhorario_detalle hd ON dr.idprofesormateria = hd.idmateria
    INNER JOIN tblhorario h ON h.idhorario = hd.idhorario
    INNER JOIN tblperiodo pe ON h.idperiodo = pe.idperiodo
    JOIN tblprofesor_materia pm ON hd.idmateria = pm.idprofesormateria
    JOIN tblmateria m ON m.idmateria = pm.idmateria
    JOIN tblprofesor p ON p.idprofesor = pm.idprofesor
    WHERE (pe.activo = 1 OR h.activo =1) AND mr.estatus = 1) materias
GROUP BY idmateria order by nombreclase ASC';

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllMateriasPasadas($idhorario, $idalumno, $idperiodo)
    {
        $query = $this->db->query("SELECT   idnivelestudio, idprofesormateri,
    idhorariodetalle,
    idhorario,
    horainicial,
    horafinal,
    nombreclase,
    nombre,
    apellidop,
    apellidom,
    idmateria,
    opcion,
     idgrupo,
    credito
    FROM (
SELECT
    g.idnivelestudio,
    hd.idmateria AS idprofesormateri,
    hd.idhorariodetalle,
    hd.idhorario,
    hd.horainicial,
    hd.horafinal,
    m.nombreclase,
    p.nombre,
    p.apellidop,
    p.apellidom,
    m.idmateria,
    0 AS opcion,
    m.credito,
      g.idgrupo
FROM
    tblmateria_reprobada mr
        INNER JOIN
    tbldetalle_reprobada dr ON mr.idreprobada = dr.idreprobada
        INNER JOIN
    tblhorario_detalle hd ON dr.idprofesormateria = hd.idmateria
        INNER JOIN
    tblhorario h ON h.idhorario = hd.idhorario
        INNER JOIN
    tblperiodo pe ON h.idperiodo = pe.idperiodo
        JOIN
    tblprofesor_materia pm ON hd.idmateria = pm.idprofesormateria
        JOIN
    tblmateria m ON m.idmateria = pm.idmateria
        JOIN
    tblprofesor p ON p.idprofesor = pm.idprofesor
        JOIN
    tblalumno_grupo ag ON ag.idalumnogrupo = mr.idalumnogrupo
    JOIN tblgrupo g ON g.idgrupo = h.idgrupo
    AND h.idperiodo = $idperiodo
    AND ag.idalumno = $idalumno
    AND h.idhorario NOT IN ($idhorario)
    UNION ALL
 SELECT
  g.idnivelestudio,
    hd.idmateria AS idprofesormateri,
    hd.idhorariodetalle,
    hd.idhorario,
    hd.horainicial,
    hd.horafinal,
    m.nombreclase,
    p.nombre,
    p.apellidop,
    p.apellidom,
    m.idmateria,
    1 AS opcion,
    m.credito,
    g.idgrupo
FROM
    tblhorario_detalle hd
        JOIN
    tblprofesor_materia pm ON hd.idmateria = pm.idprofesormateria
        JOIN
    tblmateria m ON m.idmateria = pm.idmateria
        JOIN
    tblprofesor p ON p.idprofesor = pm.idprofesor
        JOIN
    tblhorario h ON h.idhorario = hd.idhorario
        JOIN
    tblalumno_grupo ag ON ag.idperiodo = h.idperiodo
    JOIN tblgrupo g ON g.idgrupo = h.idgrupo
WHERE
    ag.idgrupo = h.idgrupo
        AND h.idperiodo = $idperiodo
        AND ag.idalumno = $idalumno
        AND pm.idmateria NOT IN (SELECT
            ms.idmateriaprincipal
        FROM
            tblmateria_reprobada mr
                INNER JOIN
            tblalumno_grupo ag ON mr.idalumnogrupo = ag.idalumnogrupo
                INNER JOIN
            tblmateria_seriada ms ON ms.idmateriasecundaria = mr.idmateria
              WHERE ag.idalumno = $idalumno
       )
GROUP BY hd.idmateria) tabla");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllTareaAlumno($idhorario = '', $idmateria = '')
    {
        $this->db->select('t.idtarea, hd.idhorariodetalle,hd.idhorario, hd.horainicial, hd.horafinal, m.nombreclase,p.nombre, p.apellidop, p.apellidom,t.tarea, t.fechaentrega');
        $this->db->from('tblhorario_detalle hd');
        $this->db->join('tblprofesor_materia pm', 'hd.idmateria = pm.idprofesormateria');
        $this->db->join('tblmateria m', 'm.idmateria = pm.idmateria');
        $this->db->join('tblprofesor p', 'p.idprofesor = pm.idprofesor');
        $this->db->join('tbltarea t', 't.idhorariodetalle = hd.idhorariodetalle');
        if (isset($idhorario) && !empty($idhorario)) {
            $this->db->where('hd.idhorario', $idhorario);
        }
        if (isset($idmateria) && !empty($idmateria)) {
            $this->db->where('m.idmateria', $idmateria);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showTareaAlumnoMateria($dhorario, $limitar_consulta = '')
    {
        $this->db->select('t.idnotificacionalumno,t.idnotificaciontutor,hd.idhorariodetalle,hd.idhorario, hd.horainicial, hd.horafinal, m.nombreclase,p.nombre, p.apellidop, p.apellidom,LEFT(t.tarea, 90) as tarea, t.idtarea, t.fechaentrega');
        $this->db->from('tblhorario_detalle hd');
        $this->db->join('tblprofesor_materia pm', 'hd.idmateria = pm.idprofesormateria');
        $this->db->join('tblmateria m', 'm.idmateria = pm.idmateria');
        $this->db->join('tblprofesor p', 'p.idprofesor = pm.idprofesor');
        $this->db->join('tbltarea t', 't.idhorariodetalle = hd.idhorariodetalle');
        $this->db->where('hd.idhorario', $dhorario);
        if (isset($limitar_consulta) && !empty($limitar_consulta)) {
            $this->db->where('t.fechaentrega >=', $limitar_consulta);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function validadAlumnoGrupo($idalumno)
    {
        $this->db->select('t.*');
        $this->db->from('tblalumno_grupo t');
        $this->db->where('t.idalumno', $idalumno);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function detalleUnidad($idunidad = '')
    {
        $this->db->select('u.*');
        $this->db->from('tblunidad u');
        $this->db->where('u.idunidad', $idunidad);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllTutoresDisponibles($idplantel = '')
    {
        $this->db->select('t.*');
        $this->db->from('tbltutor t');
        if (isset($idplantel) && !empty($idplantel)) {
            $this->db->where('t.idplantel', $idplantel);
        }
        $this->db->order_by('t.nombre ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllTutores($idalumno)
    {
        $this->db->select('t.idtutoralumno, a.nombre, a.apellidop, a.apellidom');
        $this->db->from('tbltutoralumno t');
        $this->db->join('tbltutor a', 'a.idtutor = t.idtutor');
        $this->db->where('t.idalumno', $idalumno);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllOportunidadesExamen($idplantel)
    {
        $this->db->select('oe.idoportunidadexamen');
        $this->db->from('tbloportunidad_examen oe');
        $this->db->where('oe.idplantel', $idplantel);
        $this->db->order_by('oe.numero ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllTareas($idhorariodetalle)
    {
        $this->db->select('t.*');
        $this->db->from('tbltarea t');
        $this->db->where('t.idhorariodetalle', $idhorariodetalle);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllMotivoAsistencia()
    {
        $this->db->select('t.*');
        $this->db->from('tblmotivo_asistencia t');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function detalleClase($idhorariodetalle = '')
    {
        $this->db->select('m.nombreclase');
        $this->db->from('tblhorario_detalle hd');
        $this->db->join('tblprofesor_materia pm', 'hd.idmateria = pm.idprofesormateria');
        $this->db->join('tblmateria m', 'm.idmateria = pm.idmateria');
        $this->db->where('hd.idhorariodetalle', $idhorariodetalle);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function obtenerTodasMateriaReprobadasActivas($idalumno)
    {
        $this->db->select('ms.idmateriaprincipal, ms.idmateriasecundaria, m.nombreclase, m.idmateria');
        $this->db->from('tblmateria_reprobada mr');
        $this->db->join('tblalumno_grupo ag', 'ag.idalumnogrupo = mr.idalumnogrupo');
        $this->db->join('tblmateria m', 'm.idmateria = mr.idmateria');
        $this->db->join('tblmateria_seriada ms ', 'm.idmateria = ms.idmateriasecundaria');
        $this->db->where('ag.idalumno', $idalumno);
        $this->db->where('mr.estatus', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllAlumnoId($idalumno)
    {
        $this->db->select('t.*, e.nombreespecialidad,');
        $this->db->from('tblalumno t');
        $this->db->where('t.idalumno', $idalumno);
        $this->db->join('tblespecialidad e', 't.idespecialidad = e.idespecialidad');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function calificacionAlumno($idalumno, $idhorario, $idoportunidadexamen)
    {
        $query = $this->db->query("SELECT c.idalumno,  (sum(c.calificacion)/count(c.idunidad)) as calificacion,count(c.idunidad) as totalunidad
            FROM tblcalificacion c
            WHERE c.idalumno = $idalumno
            AND c.idhorario = $idhorario
            AND c.idoportunidadexamen = $idoportunidadexamen
            AND c.idhorariodetalle NOT IN (SELECT
                                            hd.idhorariodetalle
                                        FROM
                                            tblmateria_reprobada mr
                                                INNER JOIN
                                            tbldetalle_reprobada dr ON mr.idreprobada = dr.idreprobada
                                                INNER JOIN
                                            tblhorario_detalle hd ON dr.idprofesormateria = hd.idmateria
                                                INNER JOIN
                                            tblhorario h ON h.idhorario = hd.idhorario
                                                INNER JOIN
                                            tblperiodo pe ON h.idperiodo = pe.idperiodo
                                                JOIN
                                            tblprofesor_materia pm ON hd.idmateria = pm.idprofesormateria
                                                JOIN
                                            tblmateria m ON m.idmateria = pm.idmateria
                                                JOIN
                                            tblprofesor p ON p.idprofesor = pm.idprofesor
                                        WHERE
                                            (pe.activo = 1 OR h.activo = 1))
            GROUP BY c.idhorariodetalle, c.idalumno");

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
        return false;
    }

    public function ultimaFechaAsistencia($idalumno, $idhorariodetalle)
    {
        $this->db->select('a.fecha');
        $this->db->from('tblasistencia a');
        $this->db->where('a.idalumno', $idalumno);
        $this->db->where('a.idhorariodetalle', $idhorariodetalle);
        $this->db->order_by('a.fecha DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public function primeraFechaAsistencia($idalumno, $idhorariodetalle)
    {
        $this->db->select('a.fecha');
        $this->db->from('tblasistencia a');
        $this->db->where('a.idalumno', $idalumno);
        $this->db->where('a.idhorariodetalle', $idhorariodetalle);
        $this->db->order_by('a.fecha ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public function detalleOportunidadExamen($idplantel, $numero = '')
    {
        $this->db->select('oe.*');
        $this->db->from('tbloportunidad_examen oe');
        $this->db->where('oe.idplantel', $idplantel);
        $this->db->where('oe.numero', $numero);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public function siguienteOportunidadExamen($idplantel, $numero = '')
    {
        $this->db->select('oe.*');
        $this->db->from('tbloportunidad_examen oe');
        $this->db->where('oe.idplantel', $idplantel);
        $this->db->where('oe.numero > ', $numero);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public function listaAlumnoPorGrupo($idgrupo = '', $idplantel = '')
    {
        $query = $this->db->query("SELECT * FROM vlistaalumnogrupo WHERE idplantel = $idplantel AND idgrupo = $idgrupo ORDER BY apellidop DESC");
        //  return $query->result();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function horarioDia($idalumno, $idnivelestudio, $iddia)
    {
        $query = $this->db->query("SELECT
                            ne.nombrenivel,
                            g.nombregrupo,
                            m.nombremes as mesinicio,
                            y.nombreyear as yearinicio,
                            m2.nombremes as mesfin,
                            y2.nombreyear as yearfin,
                            d.nombredia,
                            m.nombreclase,
                            pro.nombre,
                            pro.apellidop,
                            pro.apellidom,
                            hd.horainicial,
                            hd.horafinal
                        FROM
                            tblgrupo g
                                INNER JOIN
                            tblalumno_grupo ag ON g.idgrupo = ag.idgrupo
                                INNER JOIN
                            tblnivelestudio ne ON ne.idnivelestudio = g.idnivelestudio
                                INNER JOIN
                            tblhorario h ON h.idgrupo = g.idgrupo
                                INNER JOIN
                            tblperiodo p ON p.idperiodo = h.idperiodo
                                INNER JOIN
                            tblhorario_detalle hd ON hd.idhorario = h.idhorario
                                INNER JOIN
                            tbldia d ON d.iddia = hd.iddia
                                INNER JOIN
                            tblprofesor_materia pm ON pm.idprofesormateria = hd.idmateria
                                INNER JOIN
                            tblmateria m ON m.idmateria = pm.idmateria
                                INNER JOIN
                            tblprofesor pro ON pro.idprofesor = pm.idprofesor
            
                             INNER JOIN
                            tblmes m ON p.idmesinicio = m.idmes
                             INNER JOIN
                            tblmes m2 ON p.idmesfin = m2.idmes
                             INNER JOIN
                            tblyear y ON p.idyearinicio = y.idyear
                             INNER JOIN
                            tblyear y2 ON p.idyearfin = y2.idyear
            
                        WHERE
                            ag.idalumno = $idalumno
                                AND ne.idnivelestudio = $idnivelestudio
                                AND d.iddia = $iddia");
        //  return $query->result();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function nivelEstudio($idalumno)
    {
        $query = $this->db->query("SELECT
                    g.nombregrupo, ne.idnivelestudio, ne.nombrenivel
                FROM
                    tblalumno_grupo ag
                        INNER JOIN
                    tblgrupo g ON ag.idgrupo = g.idgrupo
                        INNER JOIN
                    tblnivelestudio ne ON ne.idnivelestudio = g.idnivelestudio
                    WHERE ag.idalumno = $idalumno
                    ORDER BY ne.idnivelestudio  DESC ");
        //  return $query->result();

        if ($query->num_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public function allKardex($idalumno)
    {
        $query = $this->db->query("SELECT
                            h.idhorario,
                            p.idperiodo,
                            m.nombremes AS mesinicio,
                            y.nombreyear AS yearinicio,
                            m2.nombremes AS mesfin,
                            y2.nombreyear AS yearfin,
                            g.nombregrupo,
                            g.idgrupo,
                            ne.idnivelestudio,
                            ne.nombrenivel,
                            en.idestatusnivel,
                            en.nombreestatusnivel,
                            plantel.idniveleducativo,
                            CASE niv.idniveleducativo 
                                WHEN 3 THEN n.numeroromano
                                WHEN 5 THEN n.numeroromano
                                WHEN 1 THEN n.numeroordinaria
                                WHEN 2 THEN n.numeroordinaria
                                WHEN 4 THEN n.numeroordinaria
                                ELSE ''
                            END AS nivelgrupo
                        FROM
                            tblperiodo p
                                INNER JOIN
                            tblhorario h ON p.idperiodo = h.idperiodo
                                INNER JOIN
                            tblalumno_grupo ag ON ag.idperiodo = p.idperiodo
                                INNER JOIN
                            tblmes m ON p.idmesinicio = m.idmes
                                INNER JOIN
                            tblmes m2 ON p.idmesfin = m2.idmes
                                INNER JOIN
                            tblyear y ON p.idyearinicio = y.idyear
                                INNER JOIN
                            tblyear y2 ON p.idyearfin = y2.idyear
                                INNER JOIN
                            tblgrupo g ON ag.idgrupo = g.idgrupo
                                INNER JOIN
                            tblnivelestudio ne ON ne.idnivelestudio = g.idnivelestudio
                                INNER JOIN
                            tblestatus_nivel en ON en.idestatusnivel = ag.idestatusnivel
                                INNER JOIN
                            tblalumno a ON ag.idalumno = a.idalumno
                                INNER JOIN
                            tblplantel plantel ON a.idplantel = plantel.idplantel
                                INNER JOIN
                            tblniveleducativo niv ON plantel.idniveleducativo = niv.idniveleducativo
                                INNER JOIN
                            tblnivelestudio n ON n.idnivelestudio = g.idnivelestudio
                        WHERE
                            ag.idgrupo = h.idgrupo
                                AND ag.idalumno = $idalumno
                                AND  p.activo = 0 AND h.activo = 0         
                                ORDER BY p.idperiodo DESC");

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function obtenerGrupo($idalumno)
    {
        $query = $this->db->query("SELECT
                                    h.idhorario,
                                    m.nombremes as mesinicio,
                                    y.nombreyear as yearinicio,
                                    m2.nombremes as mesfin,
                                    y2.nombreyear as yearfin,
                                    g.nombregrupo,
                                    ne.idnivelestudio,
                                    ne.nombrenivel
                                FROM
                                    tblalumno_grupo ag
                                        INNER JOIN
                                    tblgrupo g ON ag.idgrupo = g.idgrupo
                                        INNER JOIN
                                    tblnivelestudio ne ON ne.idnivelestudio = g.idnivelestudio
                                        INNER JOIN
                                    tblhorario h ON h.idgrupo = ag.idgrupo
                                        INNER JOIN
                                    tblperiodo p ON p.idperiodo = h.idperiodo
                                     INNER JOIN
                                    tblmes m ON p.idmesinicio = m.idmes
                                     INNER JOIN
                                    tblmes m2 ON p.idmesfin = m2.idmes
                                     INNER JOIN
                                    tblyear y ON p.idyearinicio = y.idyear
                                     INNER JOIN
                                    tblyear y2 ON p.idyearfin = y2.idyear
                                WHERE
                                    p.idperiodo = ag.idperiodo
                                AND h.activo = 1 AND   p.activo = 1
                                AND ag.activo = 1
                                AND  ag.idalumno = $idalumno
                                ORDER BY ne.idnivelestudio DESC");
        //  return $query->result();

        if ($query->num_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public function searchAlumno($match, $idplantel = '')
    {
        $field = 't.nombre,' . "' '" . ',t.apellidop,' . "' '" . ',t.apellidom,' . "' '" . ',t.matricula,' . "' '" . ',n.nombreniveleducativo';
        $this->db->select("t.idalumno, t.nombre, t.apellidop, t.apellidom,t.idplantel, t.idespecialidad,"
            . "t.matricula, t.curp,t.lugarnacimiento, t.nacionalidad, t.domicilio, t.telefono,t.telefonoemergencia,"
            . "t.serviciomedico,t.idtiposanguineo,t.alergiaopadecimiento, t.peso, t.estatura,t.numfolio, t.numacta,numlibro,"
            . "t.foto, t.sexo, t.correo,t.password,t.idalumnoestatus, DATE_FORMAT(t.fechanacimiento,'%d/%m/%Y') as fechanacimiento,n.nombreniveleducativo,ae.idestatusalumno, ae.nombreestatus");
        $this->db->from('tblalumno t');
        $this->db->join('tblplantel p', 't.idplantel = p.idplantel');
        $this->db->join('tblniveleducativo n', 'n.idniveleducativo = p.idniveleducativo');
        $this->db->join('tblalumno_estatus ae', 'ae.idestatusalumno = t.idalumnoestatus');
        if (isset($idplantel) && !empty($idplantel)) {
            $this->db->where('t.idplantel', $idplantel);
        }
        $this->db->like('concat(' . $field . ')', $match);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function searchTutores($match, $idalumno)
    {
        $field = array(
            't.nombre',
            't.apellidop',
            't.apellidom'
        );
        $this->db->select('t.*');
        $this->db->from('tbltutor t');

        $this->db->join('tbltutoralumno ta', 'ta.idtutor = t.idtutor');
        $this->db->where('ta.idalumno', $idalumno);
        $this->db->like('concat(' . implode(',', $field) . ')', $match);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function addAlumno($data)
    {
        $this->db->insert('tblalumno', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function addClaseTaller($data)
    {
        $this->db->insert('tblhorario_detalle_cursos', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function asignarGrupo($data)
    {
        $this->db->insert('tblalumno_grupo', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function addTutorAlumno($data)
    {
        $this->db->insert('tbltutoralumno', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function detalleAlumno($idalumno)
    {
        $this->db->select('t.*,
    e.idespecialidad,
         e.nombreespecialidad,
         p.clave,
         p.nombreplantel,
         p.direccion,
         p.telefono,
         ts.tiposanguineo,
         p.idniveleducativo,
         t.telefono as telefonocelular,
         t.telefonoemergencia
         ');
        $this->db->from('tblalumno t');
        $this->db->join('tblespecialidad e', 'e.idespecialidad = t.idespecialidad');
        $this->db->join('tblplantel p', 'p.idplantel = t.idplantel');
        $this->db->join('tbltiposanguineo ts', 'ts.idtiposanguineo = t.idtiposanguineo');
        $this->db->where('t.idalumno', $idalumno);
        $query = $this->db->get();
        return $query->first_row();
    }

    public function detalleAlumnoNivelEducativo($idalumno, $idperiodo)
    {
        $this->db->select('g.idnivelestudio');
        $this->db->from('tblalumno a');
        $this->db->join('tblalumno_grupo ag', 'ag.idalumno = a.idalumno');
        $this->db->join('tblgrupo g', 'g.idgrupo = ag.idgrupo');
        $this->db->where('a.idalumno', $idalumno);
        $this->db->where('ag.idperiodo', $idperiodo);
        $query = $this->db->get();
        return $query->first_row();
    }

    public function updateAlumno($id, $field)
    {
        $this->db->where('idalumno', $id);
        $this->db->update('tblalumno', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function updateBecaAlumno($id, $field)
    {
        $this->db->where('idalumnogrupo', $id);
        $this->db->where('activo', 1);
        $this->db->update('tblalumno_grupo', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function updateEstatusAlumno($idalumno, $data)
    {
        $this->db->where('idalumno', $idalumno);
        $this->db->update('tblalumno', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function updateAlumnoGrupo($id, $field)
    {
        $this->db->where('idalumnogrupo', $id);
        $this->db->update('tblalumno_grupo', $field);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function detalleGrupoActual($idalumno)
    {
        $this->db->select("ag.idalumnogrupo, g.idgrupo, g.nombregrupo, n.nombrenivel, t.nombreturno, CASE niv.idniveleducativo 
        WHEN 3 THEN n.numeroromano
        WHEN 5 THEN n.numeroromano
        WHEN 1 THEN n.numeroordinaria
        WHEN 2 THEN n.numeroordinaria
        WHEN 4 THEN n.numeroordinaria
        ELSE ''
    END AS nivelgrupo");
        $this->db->from('tblalumno_grupo ag');
        $this->db->join('tblgrupo g', 'ag.idgrupo = g.idgrupo');
        $this->db->join('tblnivelestudio n', 'g.idnivelestudio = n.idnivelestudio');
        $this->db->join('tblturno t', 't.idturno = g.idturno');
        $this->db->join('tblplantel pla', 'pla.idplantel = g.idplantel');
        $this->db->join('tblniveleducativo niv', 'pla.idniveleducativo = niv.idniveleducativo');
        $this->db->where('ag.idalumno', $idalumno);
        $this->db->where('ag.activo', 1);
        $this->db->order_by("n.nombrenivel", "asc");
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public function obtenerCalificacionMateria($idhorariodetalle = '', $idalumno = '', $idunidad = '')
    {
        $this->db->select('c.calificacion');
        $this->db->from('tblcalificacion c');
        $this->db->where('c.idalumno', $idalumno);
        $this->db->where('c.idhorariodetalle', $idhorariodetalle);
        $this->db->where('c.idunidad', $idunidad);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public function detalleReprobado($idreprobado)
    {
        $this->db->select('mr.*');
        $this->db->from('tblmateria_reprobada mr');
        $this->db->where('mr.idreprobada', $idreprobado);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public function obtenerAsistenciaMateria($idhorariodetalle = '', $idalumno = '', $idunidad = '')
    {
        $this->db->select('a.*');
        $this->db->from('tblasistencia a');
        $this->db->where('a.idalumno', $idalumno);
        $this->db->where('a.idhorariodetalle', $idhorariodetalle);
        $this->db->where('a.idunidad', $idunidad);
        $this->db->where('a.idmotivo', 4);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function deleteTutor($id)
    {
        $this->db->where('idtutoralumno', $id);
        $this->db->delete('tbltutoralumno');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function deleteClaseTaller($idalumno, $idhorario)
    {
        $this->db->where('idalumno', $idalumno);
        $this->db->where('idhorario', $idhorario);
        $this->db->delete('tblhorario_detalle_cursos');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteReprobada($id)
    {
        $this->db->where('iddetalle', $id);
        $this->db->delete('tbldetalle_reprobada');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function obtenerCalificacionAlumno($idalumno = '', $idgrupo = '', $idplantel = '')
    {
        $query = $this->db->query(" SELECT
                                    p.nombre,
                                    p.apellidop,
                                    p.apellidom,
                                    m.nombreclase,
                                    COALESCE(SUM(c.calificacion), 0) AS calificacionmateria,
                                    (SELECT
                                            COUNT(*)
                                        FROM
                                            tblunidad WHERE idplantel = $idplantel) AS totalunidad,
                                    (COALESCE(SUM(c.calificacion), 0) / (SELECT
                                            COUNT(*)
                                        FROM
                                            tblunidad WHERE idplantel = $idplantel)) AS calificacionfinal
                                FROM
                                    tblcalificacion c
                                        INNER JOIN
                                    tblhorario_detalle hd ON hd.idhorariodetalle = c.idhorariodetalle
                                        INNER JOIN
                                    tblprofesor_materia pm ON hd.idmateria = pm.idprofesormateria
                                        INNER JOIN
                                    tblmateria m ON pm.idmateria = m.idmateria
                                        INNER JOIN
                                    tblprofesor p ON pm.idprofesor = p.idprofesor
                                    inner join tblhorario h on h.idhorario = c.idhorario
                                WHERE
                                    c.idalumno = $idalumno
                                    and h.idgrupo =$idgrupo
                                GROUP BY c.idhorariodetalle ");
        //  return $query->result();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function obtenerCalificacionFinal($idalumno, $idhorario, $idprofesormateria)
    {
        $query = $this->db->query("SELECT
                    COALESCE((COALESCE(SUM(c.calificacion), 0) / (count(c.idunidad))),
            0)  AS calificacion,
                m.nombreclase,
                m.clave,
                m.credito,
            count(c.idunidad) as totalunidad
            FROM
                tblhorario h
                    INNER JOIN
                tblhorario_detalle hd ON h.idhorario = hd.idhorario
                    INNER JOIN
                tblcalificacion c ON hd.idhorariodetalle = c.idhorariodetalle
                    INNER JOIN
                tblprofesor_materia pm ON hd.idmateria = pm.idprofesormateria
                    INNER JOIN
                tblmateria m ON m.idmateria = pm.idmateria
                    INNER JOIN
                tbloportunidad_examen oe ON oe.idoportunidadexamen = c.idoportunidadexamen
            WHERE
                c.idalumno = $idalumno
                AND hd.idhorario = $idhorario
                AND hd.idmateria = $idprofesormateria
            GROUP BY hd.idmateria ORDER BY oe.numero ASC");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function calificacionSecuPrepa($idalumno = '', $idhorariodetalle = '', $oportunidad = '')
    {
        $query = $this->db->query("SELECT
                         COALESCE((COALESCE(SUM(c.calificacion), 0) / (count(c.idunidad))),
            0)  AS calificacion,
                        m.nombreclase,
                        m.clave,
                        m.credito,
                    count(c.idunidad) as totalunidad
                    FROM
                        tblhorario h
                            INNER JOIN
                        tblhorario_detalle hd ON h.idhorario = hd.idhorario
                            INNER JOIN
                        tblcalificacion c ON hd.idhorariodetalle = c.idhorariodetalle
                            INNER JOIN
                        tblprofesor_materia pm ON hd.idmateria = pm.idprofesormateria
                            INNER JOIN
                        tblmateria m ON m.idmateria = pm.idmateria
                            INNER JOIN
                        tbloportunidad_examen oe ON oe.idoportunidadexamen = c.idoportunidadexamen
                    WHERE
                        c.idalumno = $idalumno
                        AND c.idhorariodetalle = $idhorariodetalle
                    GROUP BY hd.idmateria ORDER BY oe.numero ASC");
        //  return $query->result();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function deleteAlumno($idalumno = '')
    {
        # code...
        $this->db->where('idalumno', $idalumno);
        $this->db->delete('tblalumno');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function obtenerPeriodo($idalumno)
    {
        $this->db->select('a.idalumno,ag.idperiodo, ag.idgrupo, h.idhorario,a.idplantel');
        $this->db->from('tblalumno a');
        $this->db->join('tblalumno_grupo ag', 'a.idalumno = ag.idalumno');
        $this->db->join('tblhorario h', 'ag.idperiodo = h.idperiodo');
        $this->db->join('tblhorario h2', 'ag.idgrupo = h2.idgrupo');
        $this->db->where('ag.activo', 1);
        $this->db->where('ag.idestatusnivel IN (2,4)');
        $this->db->where('a.idalumno', $idalumno);
        //$this->db->where('ag.idgrupo','h.idgrupo');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showAllCalificacionAlumno($idalumno = '', $idhorario = '', $idplantel = '')
    {
        $query = $this->db->query("SELECT
                        COALESCE((COALESCE(SUM(c.calificacion), 0) / (SELECT
                                        COUNT(*)
                                    FROM
                                        tblunidad u WHERE u.idplantel = $idplantel)),
                                0) AS calificacion
                    FROM
                        tblhorario h
                            INNER JOIN
                        tblhorario_detalle hd ON h.idhorario = hd.idhorario
                            INNER JOIN
                        tblcalificacion c ON hd.idhorariodetalle = c.idhorariodetalle
                    WHERE
                        c.idalumno = $idalumno
                    AND c.idhorario = $idhorario
                    GROUP BY c.idhorariodetalle");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function obtenerMateriasHorario($idalumno = '', $idhorario = '')
    {
        $query = $this->db->query("SELECT idhorario,idprofesormateria,idalumno,idmateria ,nombreclase,profesor,mostrar FROM (
            SELECT hd.idhorario , pm.idprofesormateria,  a.idalumno, m.idmateria ,m.nombreclase, CONCAT(p.apellidop,' ',p.apellidom,' ',p.nombre) as profesor,
                CASE 
                     WHEN m.idmateria = (SELECT ms2.idmateriaprincipal FROM tblmateria_reprobada mr INNER JOIN  tblmateria_seriada ms2 ON mr.idmateria = ms2.idmateriasecundaria ) THEN 'NO'
                     WHEN m.idclasificacionmateria = 3 AND pla.idniveleducativo = 3 THEN ' NO'
                ELSE 'SI'
                END AS mostrar
            FROM
                tblalumno a
            INNER JOIN tblalumno_grupo ag ON a.idalumno = ag.idalumno
            INNER JOIN tblhorario h ON h.idgrupo = ag.idgrupo
            INNER JOIN tblhorario_detalle hd ON hd.idhorario  = h.idhorario 
            INNER JOIN tblprofesor_materia pm ON pm.idprofesormateria = hd.idmateria 
            INNER JOIN tblmateria m ON m.idmateria = pm.idmateria 
            INNER JOIN tblprofesor p ON p.idprofesor = pm.idprofesor 
            INNER JOIN tblplantel pla ON pla.idplantel = a.idplantel 
            WHERE
                h.idperiodo = ag.idperiodo
                AND m.secalifica IN (1) 
                /*AND ag.activo = 1*/
                /*AND a.idalumno = 947*/
            GROUP BY hd.idmateria, a.idalumno, h.idhorario  
            UNION ALL 
            SELECT hd.idhorario  , pm.idprofesormateria,  a.idalumno,  m.idmateria ,m.nombreclase, CONCAT(p.apellidop,' ',p.apellidom,' ',p.nombre) as profesor,
                'SI' AS mostrar
            FROM
                tblalumno a
            INNER JOIN tblalumno_grupo ag ON a.idalumno = ag.idalumno
            INNER JOIN tblhorario h ON h.idgrupo = ag.idgrupo
            INNER JOIN tblhorario_detalle hd ON hd.idhorario  = h.idhorario 
            INNER JOIN tblprofesor_materia pm ON pm.idprofesormateria = hd.idmateria 
            INNER JOIN tblmateria m ON m.idmateria = pm.idmateria 
            INNER JOIN tblprofesor p ON p.idprofesor = pm.idprofesor 
            INNER JOIN tblplantel pla ON pla.idplantel = a.idplantel
            INNER JOIN tblhorario_detalle_cursos  hdc ON hdc.idprofesormateria = hd.idmateria 
            WHERE
                h.idperiodo = ag.idperiodo
                AND hdc.idhorario = hd.idhorario 
                /*AND m.secalifica IN (1)*/
                AND a.idalumno = hdc.idalumno 
                /*AND ag.activo = 1*/
                /*AND a.idalumno = 947*/
            GROUP BY hd.idmateria, a.idalumno, h.idhorario  
            UNION ALL 
            SELECT hd.idhorario , pm.idprofesormateria,  a.idalumno , m.idmateria ,m.nombreclase, CONCAT(p.apellidop,' ',p.apellidom,' ',p.nombre) as profesor,
                'SI' AS mostrar
            FROM
                tblalumno a
            INNER JOIN tblalumno_grupo ag ON a.idalumno = ag.idalumno
            INNER JOIN tblhorario h ON h.idgrupo = ag.idgrupo
            INNER JOIN tblhorario_detalle hd ON hd.idhorario  = h.idhorario 
            INNER JOIN tblprofesor_materia pm ON pm.idprofesormateria = hd.idmateria 
            INNER JOIN tblmateria m ON m.idmateria = pm.idmateria 
            INNER JOIN tblprofesor p ON p.idprofesor = pm.idprofesor 
            INNER JOIN tblplantel pla ON pla.idplantel = a.idplantel
            INNER JOIN tblmateria_reprobada  mr ON  mr.idalumnogrupo = ag.idalumnogrupo 
            INNER JOIN tbldetalle_reprobada dr ON dr.idreprobada = mr.idreprobada 
            WHERE
                h.idperiodo = ag.idperiodo 
                AND dr.idhorario = hd.idhorario 
                AND dr.idprofesormateria = hd.idmateria 
                /*AND m.secalifica IN (1)
                AND ag.activo = 1*/
                AND mr.estatus = 1
                /*AND a.idalumno = 947*/
            GROUP BY hd.idmateria, a.idalumno, h.idhorario ) tbl WHERE idalumno  = $idalumno AND idhorario = $idhorario ORDER BY nombreclase ASC");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function obtenerCalificacionPorMateriaPrimaria($idhorario = '', $idprofesormateria = '', $idalumno = '')
    {
        $this->db->select('((SUM(dc.calificacion)/COUNT(dc.idmes))/(SELECT COUNT(u.idunidad) FROM tblunidad u WHERE u.idplantel =  a.idplantel)) AS calificacion');
        $this->db->from('tblcalificacion c');
        $this->db->join('tblhorario_detalle hd', 'c.idhorariodetalle = hd.idhorariodetalle');
        $this->db->join('tbldetalle_calificacion dc', 'dc.idcalificacion = c.idcalificacion');
        $this->db->join('tbloportunidad_examen oe', 'oe.idoportunidadexamen = c.idoportunidadexamen');
        $this->db->join('tblalumno a', 'a.idalumno = c.idalumno');
        $this->db->where('c.idalumno', $idalumno);
        $this->db->where('hd.idhorario', $idhorario);
        $this->db->where('hd.idmateria', $idprofesormateria);
        $this->db->order_by('oe.numero ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }
    public function obtenerCalificacionPorMateriaSecundaria($idhorario = '', $idprofesormateria = '', $idalumno = '', $idoportunidadexamen = '')
    {
        $this->db->select('((SUM(dc.calificacion)/COUNT(dc.idmes))/(SELECT COUNT(u.idunidad) FROM tblunidad u WHERE u.idplantel =  a.idplantel)) AS calificacion');
        $this->db->from('tblcalificacion c');
        $this->db->join('tblhorario_detalle hd', 'c.idhorariodetalle = hd.idhorariodetalle');
        $this->db->join('tbldetalle_calificacion dc', 'dc.idcalificacion = c.idcalificacion');
        $this->db->join('tbloportunidad_examen oe', 'oe.idoportunidadexamen = c.idoportunidadexamen');
        $this->db->join('tblalumno a', 'a.idalumno = c.idalumno');
        $this->db->where('c.idalumno', $idalumno);
        $this->db->where('hd.idhorario', $idhorario);
        $this->db->where('hd.idmateria', $idprofesormateria);
        $this->db->where('c.idoportunidadexamen', $idoportunidadexamen);
        //$this->db->order_by('oe.numero ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public function calificacionFinalPrimaria($idalumno = '', $idhorario = '', $idplantel = '')
    {
        $query = $this->db->query("SELECT
                               FORMAT( COALESCE((COALESCE(SUM(c.calificacion), 0) / (SELECT
                                                COUNT(*)
                                            FROM
                                                tblunidad u
                                            WHERE
                                                u.idplantel = $idplantel)),
                                        0),2) AS calificacion,
                                m.nombreclase,
                                m.clave,
                                m.credito
                            FROM
                                tblhorario h
                                    INNER JOIN
                                tblhorario_detalle hd ON h.idhorario = hd.idhorario
                                    INNER JOIN
                                tblcalificacion c ON hd.idhorariodetalle = c.idhorariodetalle
                                    INNER JOIN
                                tblprofesor_materia pm ON hd.idmateria = pm.idprofesormateria
                                    INNER JOIN
                                tblmateria m ON m.idmateria = pm.idmateria
                            WHERE
                                c.idalumno = $idalumno AND c.idhorario = $idhorario
                            GROUP BY hd.idmateria");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function materiasAsignadas($idplantel = '')
    {
        $query = $this->db->query("SELECT
                dr.iddetalle,
                a.idalumno,
                m.idmateria,
                a.nombre,
                a.apellidop,
                a.apellidom,
                m.nombreclase,
                n.nombrenivel,
                g.nombregrupo,
                n2.nombrenivel AS nombrenivel2,
                g2.nombregrupo AS nombregrupo2,
                m2.nombreclase AS nombreclase2,
                CONCAT(p.nombre,' ', p.apellidop,' ', p.apellidom) AS profesor
            FROM
                tblmateria_reprobada mr
                    INNER JOIN
                tblalumno_grupo ag ON mr.idalumnogrupo = ag.idalumnogrupo
                    INNER JOIN
                tblalumno a ON a.idalumno = ag.idalumno
                    INNER JOIN
                tblmateria m ON m.idmateria = mr.idmateria
                    INNER JOIN
                tblgrupo g ON g.idgrupo = ag.idgrupo
                    INNER JOIN
                tblnivelestudio n ON n.idnivelestudio = g.idnivelestudio
                    INNER JOIN
                tbldetalle_reprobada dr ON dr.idreprobada = mr.idreprobada
                    INNER JOIN
                tblhorario h ON dr.idhorario = h.idhorario
                    INNER JOIN
                tblgrupo g2 ON g2.idgrupo = h.idgrupo
                    INNER JOIN
                tblnivelestudio n2 ON n2.idnivelestudio = g2.idnivelestudio
                    INNER JOIN
                tblprofesor_materia pm ON pm.idprofesormateria = dr.idprofesormateria
                    INNER JOIN
                tblmateria m2 ON m2.idmateria = pm.idmateria
                    INNER JOIN
                tblprofesor p ON p.idprofesor = pm.idprofesor
            WHERE
                mr.estatus = 1
                ANd a.idplantel = $idplantel");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function materiaPendientesAAsignar($idplantel = '')
    {
        $query = $this->db->query(" SELECT
                mr.idreprobada,
                a.idalumno,
                mr.idmateria,
                a.nombre,
                a.apellidop,
                a.apellidom,
                m.nombreclase,
                n.nombrenivel,
                g.nombregrupo
            FROM
                tblmateria_reprobada mr
                    INNER JOIN
                tblalumno_grupo ag ON mr.idalumnogrupo = ag.idalumnogrupo
                    INNER JOIN
                tblalumno a ON a.idalumno = ag.idalumno
                    INNER JOIN
                tblmateria m ON m.idmateria = mr.idmateria
                    INNER JOIN
                tblgrupo g ON g.idgrupo = ag.idgrupo
                inner join tblnivelestudio n on n.idnivelestudio = g.idnivelestudio
            WHERE
                mr.estatus = 1
                AND mr.idreprobada NOT IN (SELECT dr.idreprobada FROM tbldetalle_reprobada dr )
                ANd a.idplantel = $idplantel");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function showMateriaParaAsignar($idmateria, $idplantel = '')
    {
        $query = $this->db->query("SELECT
            hd.idhorariodetalle,
                            h.idhorario,
                            pm.idprofesormateria,
                            n.nombrenivel,
                            g.nombregrupo,
                                   CONCAT(pro.nombre,' ', pro.apellidop,' ', pro.apellidom) AS profesor,
                                   m.nombreclase
                            FROM
                                tblhorario h
                                    INNER JOIN
                                tblhorario_detalle hd ON h.idhorario = hd.idhorario
                                    INNER JOIN
                                tblperiodo p ON p.idperiodo = h.idperiodo
                                    INNER JOIN
                                tblprofesor_materia pm ON pm.idprofesormateria = hd.idmateria
                                    INNER JOIN
                                tblmateria m ON m.idmateria = pm.idmateria
                                    INNER JOIN
                                tblprofesor pro ON pro.idprofesor = pm.idprofesor
                                INNER JOIN tblgrupo g on g.idgrupo  = h.idgrupo
                                inner join tblnivelestudio n on g.idnivelestudio = n.idnivelestudio
                            WHERE
                                (h.activo = 1 OR p.activo = 1)
                                AND m.idmateria = $idmateria
                                AND h.idplantel = $idplantel
                                group by pro.idprofesor, m.idmateria, h.idgrupo");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function validarEliminarReprobada($iddetalle)
    {
        $query = $this->db->query("SELECT
                                    hd.*
                                FROM
                                    tbldetalle_reprobada dr
                                        INNER JOIN
                                    tblmateria_reprobada mr ON mr.idreprobada = dr.idreprobada
                                        INNER JOIN
                                    tblalumno_grupo ag ON ag.idalumnogrupo = mr.idalumnogrupo
                                        INNER JOIN
                                    tblhorario h ON h.idhorario = dr.idhorario
                                        INNER JOIN
                                    tblhorario_detalle hd ON h.idhorario = hd.idhorario
                                        INNER JOIN
                                    tblcalificacion c ON c.idhorariodetalle = hd.idhorariodetalle
                                    where hd.idmateria = dr.idprofesormateria
                                    and ag.idalumno = c.idalumno
                                    and dr.iddetalle = $iddetalle");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function calificacionFinal($idalumno, $idplantel)
    {
        $query = $this->db->query(" SELECT p.idperiodo,
        CONCAT(a.apellidop, ' ', a.apellidom, ' ', a.nombre) AS alumno,
            FORMAT((SUM(c.calificacion) / (COUNT(c.idunidad))), 2) AS calificacionxperiodo,
            m.nombreclase,
            m1.nombremes AS mesinicio,
            y1.nombreyear AS yearinicio,
            m2.nombremes AS mesfin,
            y2.nombreyear AS yearfin,
            MAX(c.idoportunidadexamen) AS oportunidadexamen
    FROM
        tblperiodo p
    INNER JOIN tblhorario h ON p.idperiodo = h.idperiodo
    INNER JOIN tblhorario_detalle hd ON h.idhorario = hd.idhorario
    INNER JOIN tblcalificacion c ON hd.idhorariodetalle = c.idhorariodetalle
    INNER JOIN tblalumno a ON a.idalumno = c.idalumno
    INNER JOIN tblprofesor_materia pm ON pm.idprofesormateria = hd.idmateria
    INNER JOIN tblmateria m ON m.idmateria = pm.idmateria
    INNER JOIN tblmes m1 ON m1.idmes = p.idmesinicio
    INNER JOIN tblmes m2 ON m2.idmes = p.idmesfin
    INNER JOIN tblyear y1 ON y1.idyear = p.idyearinicio
    INNER JOIN tblyear y2 ON y2.idyear = p.idyearfin
    WHERE
        c.idalumno = $idalumno
        AND a.idplantel = $idplantel
          AND (p.activo = 0 OR h.activo = 0)
    GROUP BY p.idperiodo , h.idhorario , c.idalumno , hd.idmateria  ");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function obtenerCalificacionPorOportunidadAlumno($idalumno, $idhorario, $idoportunidad, $idmateria = '')
    {
        $sql = "SELECT
        CASE
            WHEN numero = 1
            AND unidadesregistradas = unidades THEN 'SI'
            WHEN numero > 1 THEN 'SI'
            ELSE 'NO'
        END AS mostrar,
        numero ,
        idalumno,
        apellidop,
        apellidom,
        nombre,
        nombreclase,
	    profesor,
        calificacion ,
        unidadesregistradas,
        unidades
    FROM
        (
        SELECT
            oe.numero , a2.idalumno , a2.apellidop, a2.apellidom , a2.nombre , m2.nombreclase,   concat(p.nombre,' ',p.apellidop,' ',p.apellidom) as profesor,
            CASE
                /* PRIMARIA */
                WHEN p1.idniveleducativo = 1 THEN
                CASE
                    WHEN oe.numero = 1 THEN FORMAT((
                    SELECT
                        ((SUM(dc1.calificacion)/ 8)/(
                        SELECT
                            COUNT(u2.idunidad)
                        FROM
                            tblunidad u2
                        WHERE
                            u2.idplantel = a2.idplantel))
                    FROM
                        tbldetalle_calificacion dc1
                    WHERE
                        dc1.idcalificacion = c1.idcalificacion), 1)
                    ELSE SUM(c1.calificacion)
                END /* SECUNDARIA */
                WHEN p1.idniveleducativo = 2 THEN
                CASE
                    WHEN oe.numero = 1 THEN FORMAT((
                    SELECT
                        ((SUM(dc1.calificacion)/ 8)/(
                        SELECT
                            COUNT(u2.idunidad)
                        FROM
                            tblunidad u2
                        WHERE
                            u2.idplantel = a2.idplantel))
                    FROM
                        tbldetalle_calificacion dc1
                    WHERE
                        dc1.idcalificacion = c1.idcalificacion), 1)
                    ELSE SUM(c1.calificacion)
                END /* PREPA */
                WHEN p1.idniveleducativo = 3 THEN
                CASE
                    WHEN oe.numero = 1 THEN (SUM(c1.calificacion) / (
                    SELECT
                        COUNT(u2.idunidad)
                    FROM
                        tblunidad u2
                    WHERE
                        u2.idplantel = a2.idplantel))
                    ELSE SUM(c1.calificacion)
                END /* LICENCIATUA */
                WHEN p1.idniveleducativo = 5 THEN
                CASE
                    WHEN oe.numero = 1 THEN (SUM(c1.calificacion) / m2.unidades)
                    ELSE SUM(c1.calificacion)
                END
                ELSE ''
            END AS calificacion,
            CASE
                /* PRIMARIA */
                WHEN p1.idniveleducativo = 1 THEN
                CASE
                    WHEN oe.numero = 1 THEN (
                    SELECT
                        COUNT(dc3.idcalificacion)
                    FROM
                        tbldetalle_calificacion dc3
                    WHERE
                        dc3.idcalificacion = c1.idcalificacion)
                    ELSE 28
                END /* SECUNDARIA */
                WHEN p1.idniveleducativo = 2 THEN
                CASE
                    WHEN oe.numero = 1 THEN (
                    SELECT
                        COUNT(dc2.idcalificacion)
                    FROM
                        tbldetalle_calificacion dc2
                    WHERE
                        dc2.idcalificacion = c1.idcalificacion)
                    ELSE 28
                END /* PREPA */
                WHEN p1.idniveleducativo = 3 THEN
                CASE
                    WHEN oe.numero = 1 THEN COUNT(c1.idcalificacion)
                    ELSE 28
                END /* LICENCIATUA */
                WHEN p1.idniveleducativo = 5 THEN
                CASE
                    WHEN oe.numero = 1 THEN COUNT(c1.idcalificacion)
                    ELSE 28
                END
                ELSE ''
            END AS unidadesregistradas,
            CASE
                /* PRIMARIA */
                WHEN p1.idniveleducativo = 1 THEN 8 /* SECUNDARIA */
                WHEN p1.idniveleducativo = 2 THEN 8 /* PREPA */
                WHEN p1.idniveleducativo = 3 THEN (
                SELECT
                    COUNT(u2.idunidad)
                FROM
                    tblunidad u2
                WHERE
                    u2.idplantel = a2.idplantel)/* LICENCIATUA */
                WHEN p1.idniveleducativo = 5 THEN m2.unidades
                ELSE ''
            END AS unidades
        FROM
            tblcalificacion c1
        INNER JOIN tblhorario_detalle hd ON
            hd.idhorariodetalle = c1.idhorariodetalle
        INNER JOIN tbloportunidad_examen oe ON
            c1.idoportunidadexamen = oe.idoportunidadexamen
        INNER JOIN tblalumno a2 ON
            a2.idalumno = c1.idalumno
        INNER JOIN tblplantel p1 ON
            p1.idplantel = a2.idplantel
        INNER JOIN tblprofesor_materia pm2 ON
            pm2.idprofesormateria = hd.idmateria
        INNER JOIN tblmateria m2 ON
            m2.idmateria = pm2.idmateria
        INNER JOIN tblhorario h ON
             h.idhorario = hd.idhorario
        INNER JOIN tblprofesor p ON
		    p.idprofesor  = pm2.idprofesor
        WHERE
               hd.idhorario = $idhorario
            AND c1.idoportunidadexamen = $idoportunidad
            AND a2.idalumno =$idalumno
            AND hd.idmateria NOT IN (
            SELECT
                dr.idprofesormateria
            FROM
                tbldetalle_reprobada dr
            INNER JOIN tblmateria_reprobada mr ON
                dr.idreprobada = mr.idreprobada
            INNER JOIN tblalumno_grupo ag ON
                ag.idalumnogrupo = mr.idalumnogrupo
            WHERE
                ag.idalumno = $idalumno
                AND dr.idhorario = $idhorario";
        if (isset($idmateria) && !empty($idmateria)) {
            $sql .= " AND hd.idmateria = $idmateria";
        }
        $sql .= " )
        GROUP BY
            c1.idoportunidadexamen, a2.idalumno, pm2.idprofesormateria, hd.idhorario, h.idperiodo) tbl
    ORDER BY
        apellidop ASC";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function calificacionPorOportunidad($idalumno, $idhorario, $idoportunidad, $idmateria = '')
    {
        $sql = " SELECT
                        m.nombreclase,
                        concat(p.nombre,' ',p.apellidop,' ',p.apellidom) as profesor,
                        format((sum(c.calificacion) / count(c.idunidad)),2) as calificacionmateria,
                        hd.idmateria
                        
                    FROM
                        tblhorario h
                            INNER JOIN
                        tblhorario_detalle hd ON h.idhorario = hd.idhorario
                            INNER JOIN
                        tblcalificacion c ON hd.idhorariodetalle = c.idhorariodetalle
                        inner join tblprofesor_materia pm on pm.idprofesormateria = hd.idmateria
                        inner join tblmateria m on m.idmateria = pm.idmateria
                        inner join tblprofesor p on p.idprofesor = pm.idprofesor
                    WHERE
                        hd.idmateria NOT IN (SELECT
                                dr.idprofesormateria
                            FROM
                                tbldetalle_reprobada dr
                                    INNER JOIN
                                tblmateria_reprobada mr ON dr.idreprobada = mr.idreprobada
                                    INNER JOIN
                                tblalumno_grupo ag ON ag.idalumnogrupo = mr.idalumnogrupo
                                WHERE ag.idalumno = $idalumno
                     AND dr.idhorario = $idhorario)
                     AND c.idalumno = $idalumno
                     AND h.idhorario = $idhorario
                     AND c.idoportunidadexamen = $idoportunidad";
        if (isset($idmateria) && !empty($idmateria)) {
            $sql .= " AND hd.idmateria = $idmateria";
        }
        $sql .= " GROUP BY hd.idmateria , c.idalumno , h.idhorario";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function calificacionAlumnoParaPromover($idalumno, $idgrupo, $idhorario)
    {
        $sql = " SELECT
                    FORMAT((COALESCE(SUM(c.calificacion),0) / (SELECT  COALESCE(COUNT(u.idunidad),0) FROM tblunidad u WHERE u.idplantel = a.idplantel)),
                        1) AS calificacion,
                    c.idoportunidadexamen,
                    oe.numero,
                    h.idgrupo,
                    c.idalumno,
                    hd.idmateria,
                    h.idhorario,
                    g.idnivelestudio,
                    m.nombreclase,
                    pro.nombre,
                    pro.apellidop,
                    pro.apellidom,
                    COALESCE(COUNT(c.calificacion),0) AS totalunidadesregistradas,
                    COALESCE((SELECT COUNT(u2.idunidad) FROM tblunidad u2 WHERE u2.idplantel = a.idplantel),0) AS totalunidades
                    
                FROM
                    tblhorario h
                        INNER JOIN
                    tblhorario_detalle hd ON h.idhorario = hd.idhorario
                        INNER JOIN
                    tblcalificacion c ON c.idhorariodetalle = hd.idhorariodetalle
                        INNER JOIN
                    tbloportunidad_examen oe ON oe.idoportunidadexamen = c.idoportunidadexamen
                        INNER JOIN
                    tblgrupo g ON g.idgrupo = h.idgrupo
                        INNER JOIN
                    tblprofesor_materia pm  ON pm.idprofesormateria = hd.idmateria
                        INNER JOIN
                    tblmateria m ON m.idmateria = pm.idmateria
                        INNER JOIN
                    tblprofesor pro  ON pro.idprofesor = pm.idprofesor
                    INNER JOIN
                    tblalumno a   ON a.idalumno = c.idalumno
                    
                WHERE
                    h.idgrupo = $idgrupo AND c.idalumno = $idalumno AND h.idhorario = $idhorario
                GROUP BY hd.idmateria , c.idalumno , c.idoportunidadexamen , h.idgrupo
                ORDER BY oe.numero DESC ";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function obtenerMeses()
    {
        $this->db->select('m.idmes,m.nombremes');
        $this->db->from('tblmes as m');
        $this->db->where('m.numero NOT IN(7,8)');
        $this->db->order_by('m.enumeracion ASC');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function obtenerMaterias($idnivelestudio = '')
    {


        $this->db->select('mp.idmateriapreescolar,mp.nombremateria');
        $this->db->from('tblmateria_preescolar as mp');
        if (isset($idnivelestudio) && !empty($idnivelestudio) && $idnivelestudio == 1) {
            $this->db->where('mp.idmateriapreescolar not in (27)');
        }
        $this->db->order_by('mp.numero ASC');


        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function obtenerCalificacionPreescolar($idperiodo = '', $idalumno = '', $idmateria = '', $idmes = '')
    {

        $this->db->select("calificacion.abreviatura");
        $this->db->from('tblcalificacion_preescolar califpreescolar');
        $this->db->join('tblperiodo periodo', 'califpreescolar.idperiodo = periodo.idperiodo');
        $this->db->join('tblalumno alumno', 'califpreescolar.idalumno = alumno.idalumno');
        $this->db->join('tblmateria_preescolar materia', 'califpreescolar.idmateriapreescolar = materia.idmateriapreescolar');
        $this->db->join('tblmes mes', 'califpreescolar.idmes = mes.idmes');
        $this->db->join('tbltipo_calificacion calificacion', 'califpreescolar.idtipocalificacion = calificacion.idtipocalificacion');


        if (
            isset($idperiodo) && !empty($idperiodo)
            && isset($idalumno) && !empty($idalumno)
            && isset($idmateria) && !empty($idmateria)
            && isset($idmes)      && !empty($idmes)
        ) {

            $this->db->where('califpreescolar.idperiodo', $idperiodo);
            $this->db->where('califpreescolar.idalumno', $idalumno);
            $this->db->where('califpreescolar.idmateriapreescolar', $idmateria);
            $this->db->where('califpreescolar.idmes', $idmes);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public function obtenerFaltasPreescolar($idperiodo = '', $idalumno = '', $idmes = '')
    {
        $this->db->select('asistencia.faltas');
        $this->db->from('tblasistencia_preescolar as asistencia');

        if (
            isset($idperiodo) && !empty($idperiodo)
            && isset($idalumno) && !empty($idalumno)
            && isset($idmes)   && !empty($idmes)
        ) {

            $this->db->where('asistencia.idperiodo', $idperiodo);
            $this->db->where('asistencia.idalumno', $idalumno);
            $this->db->where('asistencia.idmes', $idmes);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    public function obtenerNivelEducativoAlumno($idalumno = '')
    {
        $this->db->select('p.idplantel,p.idniveleducativo');
        $this->db->from('tblalumno a');
        $this->db->join('tblplantel p', 'a.idplantel = p.idplantel');

        if (isset($idalumno) && !empty($idalumno)) {
            $this->db->where('a.idalumno', $idalumno);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->first_row();
        } else {
            return false;
        }
    }

    //Nuevo metodos la obtener Horario de Clases por dia.
    public function spObtenerCalificacion($idalumno, $idhorario, $idperiodo)
    {

        $query = $this->db->query("CALL spObtenerCalificacion ($idalumno, $idhorario,$idperiodo)");
        $res = $query->result();
        //add this two line
        $query->next_result();
        $query->free_result();
        //end of new code
        return $res;
    }
    //Fin de codig
}
