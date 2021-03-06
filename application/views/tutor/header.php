<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SICE®</title>

     <link rel="shortcut icon" href="<?php echo base_url(); ?>/assets/images/icosice.ico">  
        <link rel="icon" href="<?php echo base_url(); ?>/assets/images/icosice.ico">

      <link href="<?php echo base_url(); ?>/assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <link href="<?php echo base_url(); ?>/assets/fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assets/css/animate.min.css" rel="stylesheet">

   <link href="<?php echo base_url(); ?>/assets/css/style2.css" rel="stylesheet">
   <link href="<?php echo base_url(); ?>/assets/css/new_style.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>/assets/plugins/node-waves/waves.css" rel="stylesheet">
    <!-- Custom styling plus plugins -->
    <link href="<?php echo base_url(); ?>/assets/css/custom.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assets/css/icheck/flat/green.css" rel="stylesheet">

    <link href="<?php echo base_url(); ?>/assets/css/calendar/fullcalendar.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assets/css/calendar/fullcalendar.print.css" rel="stylesheet" media="print">
    <script src="<?php echo base_url(); ?>/assets/js/jquery.min.js"></script>
 
    <script src="<?php echo base_url() ?>/assets/vue/vue/vue.min.js"></script>
    <script src="<?php echo base_url() ?>/assets/vue/axios/axios.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vue/pagination/pagination.js"></script>
    <script src="<?php echo base_url(); ?>/assets/vue/vue-column-sortable.js"></script>

    <link href="<?php echo base_url(); ?>/assets/css/bootstrap-select.css" rel="stylesheet" type="text/css"/>
   
    <link href="<?php echo base_url(); ?>/assets/media/css/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>/assets/js/datatables/buttons.bootstrap.min.css" rel="stylesheet"
        type="text/css" />
    <link href="<?php echo base_url(); ?>/assets/js/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet"
        type="text/css" />
    <link href="<?php echo base_url(); ?>/assets/js/datatables/responsive.bootstrap.min.css" rel="stylesheet"
        type="text/css" />
    <link href="<?php echo base_url(); ?>/assets/js/datatables/scroller.bootstrap.min.css" rel="stylesheet"
        type="text/css" />



    <!-- SweetAlert -->
    <script src="<?php echo base_url(); ?>/assets/js/sweetalert2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/js/sweetalert2/dist/sweetalert2.min.css">
    <script src="<?php echo base_url(); ?>/assets/js/jquery.validate.min.js"></script>

    <script type="text/javascript" src="<?php echo base_url(); ?>/assets/js/bootstrapValidator.min.js"></script>
    <script type="text/javascript" src="https://openpay.s3.amazonaws.com/openpay.v1.min.js"></script>
    <script type='text/javascript' src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script>

    <link href="<?php echo base_url(); ?>/assets/css/estilomodal.css" rel="stylesheet" type="text/css" />

    <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

</head>


<body class="nav-md">
    <div id="loadingnew"></div>
    <div class="container body">


        <div class="main_container">

            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">

                <div class="navbar nav_title" style="border: 0; "  align="center">
                            <a href="#" class="site_title"> <img class="imglogo" src="<?php echo base_url(); ?>/assets/images/sicelogo.png" alt=""> </a>

                        </div>
                    <div class="clearfix"></div>


                    <!-- menu prile quick info -->
                    <div class="profile" style="margin-top: 50px;">
                        <div class="profile_pic">
                            <img src="<?php echo base_url(); ?>/assets/images/user2.png" alt="..."
                                class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Bienvenido,</span>
                            <h2><?php echo $this->session->nombre ?></h2>
                        </div>
                    </div>
                    <!-- /menu prile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                        <div class="menu_section">
                            <h3>   
                                <?php
                                    if ((isset($this->session->nivel_educativo) && !empty($this->session->nivel_educativo)) &&
                                            (isset($this->session->idplantel) && !empty($this->session->idplantel) && $this->session->idplantel != 2)) {
                                        if ($this->session->idplantel == 7) {
                                            echo $this->session->nivel_educativo . " PRIMARIA";
                                        } elseif ($this->session->idplantel == 8) {
                                            echo $this->session->nivel_educativo . " PREESCOLAR";
                                        } else {
                                            echo $this->session->nivel_educativo;
                                        }
                                    } else {
                                        echo 'Profesor';
                                    }
                                    ?>
                            </h3>
                            <ul class="nav side-menu">
                                <li><a href="<?= base_url('/Tutores/') ?>"><i class="fa fa-home"></i> Inicio</a></li>
                                <li><a href="<?= base_url('/Tutores/alumnos') ?>"><i class="fa fa-users"></i> Hijos</a>
                                </li>
                                <li><a href="<?= base_url('/Tutores/kardex') ?>"><i class="fa fa-list"></i> Kardex</a>
                                </li>
                            </ul>
                        </div>


                    </div>
                    <!-- /sidebar menu -->

                </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav">

                <div class="nav_menu">
                    <nav class="" role="navigation">
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                        </div>

                        <ul class="nav navbar-nav navbar-right">
                            <li class="">
                                <a  style=" padding:0 10px 0 0;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                                    aria-expanded="false">
                                    <img src="<?php echo base_url(); ?>/assets/images/user2.png"
                                        alt=""><?php echo $this->session->nombre  ?>
                                    <span class=" fa fa-angle-down"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
                                     <?php
                                        if (isset($this->session->planteles) && !empty($this->session->planteles)) {
                                            foreach ($this->session->planteles as $row) {
                                            	   if($row->idplantel == 7){ ?>
                                                   <li><a href="<?= base_url('/welcome/cambiarplantelTutor/' . $row->idplantel.'/'.$row->idtutor) ?>">LICENCIATURA PRIMARIA</a></li>  
                                               <?php 
                                               
                                                } else if($row->idplantel == 8){  ?>
                                                   <li><a href="<?= base_url('/welcome/cambiarplantelTutor/' . $row->idplantel.'/'.$row->idtutor) ?>">LICENCIATURA PREESCOLAR</a></li>  
                                               <?php 
                                                }else { ?>
                                                <li><a href="<?= base_url('/welcome/cambiarplantelTutor/' . $row->idplantel.'/'.$row->idtutor) ?>"><?php echo $row->nombreniveleducativo ?></a></li>
                                                <?php
                                                } 
                                            }
                                        }
                                        ?>
                                                 <li><a href="<?= base_url('/perfil/tutor') ?>"><i
                                                class="fa fa-cog pull-right"></i> PERFIL</a>
                                    </li>
                                    <li><a href="<?= base_url('/welcome/logout') ?>"><i
                                                class="fa fa-sign-out pull-right"></i> SALIR</a>
                                    </li>
                                </ul>
                            </li>



                        </ul>
                    </nav>
                </div>

            </div>
            <!-- /top navigation -->