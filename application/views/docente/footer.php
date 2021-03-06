 <script src="<?php echo base_url(); ?>/assets/js/bootstrap.min.js"></script>

 <!-- bootstrap progress js -->
 <script src="<?php echo base_url(); ?>/assets/js/progressbar/bootstrap-progressbar.min.js"></script>
 <script src="<?php echo base_url(); ?>/assets/js/nicescroll/jquery.nicescroll.min.js"></script>


 <script src="<?php echo base_url(); ?>/assets/js/custom.js"></script>
 <!-- pace -->
 <script src="<?php echo base_url(); ?>/assets/js/pace/pace.min.js"></script>

 <!-- image cropping -->
 <script src="<?php echo base_url(); ?>/assets/js/cropping/cropper.min.js"></script>
 <script src="<?php echo base_url(); ?>/assets/js/cropping/main.js"></script>

 <!-- Datatables-->
 <script src="<?php echo base_url(); ?>/assets/js/datatables/jquery.dataTables.min.js"></script>
 <script src="<?php echo base_url(); ?>/assets/js/datatables/dataTables.bootstrap.js"></script>
 <script src="<?php echo base_url(); ?>/assets/js/datatables/dataTables.buttons.min.js"></script>
 <script src="<?php echo base_url(); ?>/assets/js/datatables/buttons.bootstrap.min.js"></script>
 <script src="<?php echo base_url(); ?>/assets/js/datatables/jszip.min.js"></script>
 <script src="<?php echo base_url(); ?>/assets/js/datatables/pdfmake.min.js"></script>
 <script src="<?php echo base_url(); ?>/assets/js/datatables/vfs_fonts.js"></script>
 <script src="<?php echo base_url(); ?>/assets/js/datatables/buttons.html5.min.js"></script>
 <script src="<?php echo base_url(); ?>/assets/js/datatables/buttons.print.min.js"></script>
 <script src="<?php echo base_url(); ?>/assets/js/datatables/dataTables.fixedHeader.min.js"></script>
 <script src="<?php echo base_url(); ?>/assets/js/datatables/dataTables.keyTable.min.js"></script>
 <script src="<?php echo base_url(); ?>/assets/js/datatables/dataTables.responsive.min.js"></script>
 <script src="<?php echo base_url(); ?>/assets/js/datatables/responsive.bootstrap.min.js"></script>
 <script src="<?php echo base_url(); ?>/assets/js/datatables/dataTables.scroller.min.js"></script>
 <script src="<?php echo base_url(); ?>/assets/plugins/node-waves/waves.js"></script>
 <script src="<?php echo base_url(); ?>/assets/js/admin.js"></script>
 <!-- image cropping -->
 <script src="<?php echo base_url(); ?>/assets/js/cropping/cropper.min.js"></script>
 <script src="<?php echo base_url(); ?>/assets/js/cropping/main.js"></script>
 <script src="<?php echo base_url(); ?>/assets/js/moment/moment.min.js"></script>
 <script src="<?php echo base_url(); ?>/assets/js/calendar/fullcalendar.min.js"></script>

 <!-- PNotify -->
 <script type="text/javascript" src="<?php echo base_url(); ?>/assets/js/notify/pnotify.core.js"></script>
 <script type="text/javascript" src="<?php echo base_url(); ?>/assets/js/notify/pnotify.buttons.js"></script>
 <script type="text/javascript" src="<?php echo base_url(); ?>/assets/js/notify/pnotify.nonblock.js"></script>

 <script>
     $(function() {
         var cnt = 10; //$("#custom_notifications ul.notifications li").length + 1;
         TabbedNotification = function(options) {
             var message = "<div id='ntf" + cnt + "' class='text alert-" + options.type +
                 "' style='display:none'><h2><i class='fa fa-bell'></i> " + options.title +
                 "</h2><div class='close'><a href='javascript:;' class='notification_close'><i class='fa fa-close'></i></a></div><p>" +
                 options.text + "</p></div>";

             if (document.getElementById('custom_notifications') == null) {
                 alert('doesnt exists');
             } else {
                 $('#custom_notifications ul.notifications').append("<li><a id='ntlink" + cnt +
                     "' class='alert-" + options.type + "' href='#ntf" + cnt +
                     "'><i class='fa fa-bell animated shake'></i></a></li>");
                 $('#custom_notifications #notif-group').append(message);
                 cnt++;
                 CustomTabs(options);
             }
         }

         CustomTabs = function(options) {
             $('.tabbed_notifications > div').hide();
             $('.tabbed_notifications > div:first-of-type').show();
             $('#custom_notifications').removeClass('dsp_none');
             $('.notifications a').click(function(e) {
                 e.preventDefault();
                 var $this = $(this),
                     tabbed_notifications = '#' + $this.parents('.notifications').data(
                         'tabbed_notifications'),
                     others = $this.closest('li').siblings().children('a'),
                     target = $this.attr('href');
                 others.removeClass('active');
                 $this.addClass('active');
                 $(tabbed_notifications).children('div').hide();
                 $(target).show();
             });
         }

         CustomTabs();

         var tabid = idname = '';
         $(document).on('click', '.notification_close', function(e) {
             idname = $(this).parent().parent().attr("id");
             tabid = idname.substr(-2);
             $('#ntf' + tabid).remove();
             $('#ntlink' + tabid).parent().remove();
             $('.notifications a').first().addClass('active');
             $('#notif-group div').first().css('display', 'block');
         });
     })
 </script>
 <script type="text/javascript">
     var permanotice, tooltip, _alert;
     $(function() {
         <?php
            if (isset($_SESSION['nombre_saludar'])) {
                $saludar = $_SESSION['saludar'];
                $nombre = $_SESSION['nombre_saludar'];
            ?>
             new PNotify({

                 title: <?php echo  '"' . $saludar . '"';  ?>,
                 text: <?php echo  '"Bienvenido(a) <strong>' . $nombre . '</strong>"';  ?>,
                 type: 'success',
                 delay: 4000,
                 hide: true,


                 before_close: function(PNotify) {
                     // You can access the notice's options with this. It is read only.
                     //PNotify.options.text;

                     // You can change the notice's options after the timer like this:
                     PNotify.update({
                         title: PNotify.options.title + " - Enjoy your Stay",
                         before_close: null
                     });
                     PNotify.queueRemove();
                     return false;
                 }
             });
         <?php  } ?>

     });
 </script>

 <script type="text/javascript">
     $(document).ready(function() {
         $('#tablageneral3').DataTable({
             keys: false,
             "scrollX": false,

             buttons: [
                 'excelHtml5'
             ],
             "language": {
                 "sProcessing": "Procesando...",
                 "sLengthMenu": "Mostrar _MENU_ registros",
                 "sZeroRecords": "No se encontraron resultados",
                 "sEmptyTable": "Ningún dato disponible en esta tabla",
                 "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                 "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                 "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                 "sInfoPostFix": "",
                 "sSearch": "Buscar:",
                 "sUrl": "",
                 "sInfoThousands": ",",
                 "sLoadingRecords": "Cargando...",
                 "oPaginate": {
                     "sFirst": "Primero",
                     "sLast": "Último",
                     "sNext": "Siguiente",
                     "sPrevious": "Anterior"
                 },
                 "oAria": {
                     "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                     "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                 }
             }
         });

     });
 </script>


 </body>

 </html>