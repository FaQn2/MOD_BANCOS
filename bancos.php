

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title> 

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="AdminLTE320/plugins/fontawesome-free/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="AdminLTE320/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="AdminLTE320/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="AdminLTE320/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="AdminLTE320/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">

    <!-- JQueryUI - Autocomplete -->
    <!-- <link rel="stylesheet" href="js/libs/JQueryUI/jquery-ui.css"> -->
</head>


<body class="hold-transition sidebar-mini sidebar-collapse">


<!-- Navbar -->
<?php require_once('components/navbar.php'); ?>

<!-- main sidebar-->
<?php require_once('components/aside.php'); ?>

    
    <div class="wrapper">
       

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Listado de Bancos <button id="btn_add" type="button" class="btn btn-primary"><i class="fa-solid fa-square-plus"></i> Nvo. Banco | Alt+A</button></h1>
                        </div>
                        
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <!-- /.card -->
                            
                            <div class="card">
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="table" class="table table-bordered table-striped table-hover">
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

     

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- MODAL -->
    <div class="modal fade" id="modal" tabindex="-1">
    <div id="alert-container"></div>

        <!-- modal-dialog -->
        <div class="modal-dialog modal-lg">

            <!-- modal-content -->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="modal_titulo" class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" tabindex="-1">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="input_descripcion">Inserte un nuevo banco</label>
                                <input maxlength="150" name="denom" type="text" class="form-control" id="input_banco" >
                            </div>
                            <div class="form-group col-md-12">
                                <label id="cod_label"  for="input_descripcion">Codigo de banco</label>
                                <input maxlength="150" name="cod_entidad" type="text" class="form-control" id="input_cod"  >
                            </div>
                        </div>
                        <div class="d-flex justify-content-around">
                            <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-danger">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i>Cancelar
                            </button>
                            <button id="btn_aceptar" type="submit" class="btn btn-primary">
                                <span></span> Aceptar
                            </button>
                        </div>
                    </form>
                </div>

            </div>
            <!-- /.modal-content -->

        </div>
        <!-- /.modal-dialog -->
    </div>
       <!-- jQuery -->
      <script src="AdminLTE320/plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap 4 -->
    <script src="AdminLTE320/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="AdminLTE320/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="AdminLTE320/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="AdminLTE320/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="AdminLTE320/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="AdminLTE320/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="AdminLTE320/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="AdminLTE320/plugins/jszip/jszip.min.js"></script>
    <script src="AdminLTE320/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="AdminLTE320/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="AdminLTE320/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="AdminLTE320/plugins/datatables-buttons/js/buttons.print.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <script src="AdminLTE320/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

    <!-- tags -->
    

    <!-- AdminLTE App -->
    <script src="AdminLTE320/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <!-- <script src="AdminLTE320/dist/js/demo.js"></script> -->
    <!-- JQueryUI - Autocomplete -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- Page specific script -->
    <script type="module" src="bancos.js"></script>
    
     <!--  <script>
        const navItemBases = document.getElementById('idNavMainSideBarBases');
        navItemBases.classList.add('menu-is-opening', 'menu-open');

        const navLinkBases = document.getElementById('idMainSideBarBases');
        navLinkBases.classList.add('active');

        const navLinkActive = document.getElementById('idMainSideBarModelos');
        navLinkActive.classList.add('active');
    </script>   -->
<script>
        const navItemBases = document.getElementById('idNavMainSideBarBases');
        if(navItemBases) {
            navItemBases.classList.add('menu-is-opening', 'menu-open');
        }

        const navLinkBases = document.getElementById('idMainSideBarBases');
        if(navLinkBases) {
            navLinkBases.classList.add('active');
        }

        const navLinkActive = document.getElementById('idMainSideBarBancos');
        if(navLinkActive) {
            navLinkActive.classList.add('active');
        }
    </script>

</body>

</html>
