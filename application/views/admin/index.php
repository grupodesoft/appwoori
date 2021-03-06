<!-- page content -->
      <div class="right_col" role="main">

   
 <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <?php if (isset($_SESSION['err'])): ?>
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">Permiso!</h4>
                    <p>Acceso denegado para entrar a esta opcion.</p>
                    <hr>
                    <p class="mb-0">Si requiere permiso solicitelo al administrador.</p>
                </div>
            <?php endif ?>
             <?php if (isset($_SESSION['informacion'])): ?>
                <div class="alert alert-info" role="alert">
                    <h4 class="alert-heading">INFORMACIÓN!</h4>
                    <p>DEBE DE SELECCIÓN EL NIVEL.</p>
                    <hr>
                    <p class="mb-0">Para hacer esto debe de seleccionar el nivel dentro de la opción de cerrar sesión.</p>
                </div>
            <?php endif ?>
            <?php if (isset($_SESSION['seleccionar_escuela'])): ?>
                <div class="alert alert-info" role="alert">
                    <h4 class="alert-heading">INFORMACIÓN!</h4>
                    <p><?php echo $_SESSION['seleccionar_escuela'] ?></p>
                    <hr>
                    <p class="mb-0">Para hacer esto debe de seleccionar el nivel dentro de la opción de cerrar sesión.</p>
                </div>
            <?php endif ?>
               <?php if (isset($_SESSION['informacion_exito'])): ?>
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading">EXITO!</h4>
                    <p>EL NIVEL FUE SELECCIONADO CON EXITO.</p>
                    <hr>
                    <p class="mb-0">Ya puede ver los registros para este nivel seleccionado.</p>
                </div>
            <?php endif ?>
        </div>  
    </div>

      
        <br />

 <div class="row">
   <div class="x_content">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                     <div class="dashboard_graph">
              <h1>Bienvenido</h1>
              <h2>SICE - Sistema Integral para el Control Escolar</h2>
            </div>
            </div>
            </div>
  
</div> 
      </div>
      <!-- /page content -->