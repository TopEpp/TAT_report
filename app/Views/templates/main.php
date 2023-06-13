<?php $session = session(); ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>การท่องเที่ยวแห่งประเทศไทย</title>

    <!-- Custom fonts for this template-->

    <link href="<?php echo base_url('public/vendor/fontawesome-free/css/all.css') ?>" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('public/vendor/bootstrap/datepicker/datepicker.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('public/vendor/datatables/dataTables.bootstrap4.min.css'); ?>">
    <!-- Custom styles for this template-->
    <link href="<?php echo base_url('public/css/sb-admin-2.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('public/css/jquery.toast.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('public/css/style.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('public/vendor/Sweetalert/css/sweetalert2.min.css') ?>">

    <link rel="stylesheet" href="<?php echo base_url('public/vendor/datatables/jquery.dataTables.min.css') ?>">


    <?php $this->renderSection('stylesheet'); ?>

    <style type="text/css">
        .drop_menu {
            background: none;
            border: none;
            padding: 0;
        }

        .drop_menu .btn-primary {
            background-color: white;
            border-color: #29B5A4;
            color: #29B5A4;
            text-align: left;
        }
    </style>
</head>
<input type="hidden" id="base_url" value="<?php echo base_url(); ?>">

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->

        <?php if($session->get('report_type') != 'none' || $session->get('report_type') == ''){ echo view('templates/menu'); }?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content" style="background: #F2F8F8;">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 " style="width:100%; text-align: center;">
                        <span style="font-size:1.8em; ">สถิตินักท่องเที่ยวระหว่างประเทศที่เดินทางเข้าประเทศไทย</span>
                    </div>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Admin TAT</span>
                                <img class="img-profile rounded-circle" src="<?php echo base_url('public/img/logotat.png') ?>">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid" style="padding-bottom: 10px;">

                    <?php $this->renderSection('content');

                     ?>
                    <?php if(!empty($Mydate)){?>
                    <div class="row" style="padding:10px" >
                        <div class="col-md-6 col-6">
                            ที่มา : สำนักงานตรวจคนเข้าเมือง <br>
                            จัดทำโดย : ด้านดิจิทัล วิจัย และพัฒนา
                        </div>
                        <div class="col-md-6 col-6" style="text-align: right;">
                            ข้อมูล ณ วันที่ <?php echo $Mydate->date_eng2thai(date('Y-m-d'), 543) ?> <br>
                            ระบบนี้นำเข้าข้อมูลตั้งแต่วันที่ 1 มกราคม 2566
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->


    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('public/vendor/jquery/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('public/js/common.js'); ?>"></script>

    <script src="<?= base_url('public/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?= base_url('public/vendor/bootstrap/datepicker/bootstrap-datepicker.js') ?>"></script>
    <script src="<?= base_url('public/vendor/bootstrap/datepicker/locales/bootstrap-datepicker.th.js') ?>"></script>
    <script src="<?= base_url('public/vendor/bootstrap/datepicker/bootstrap-datepicker-thai.js') ?>"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('public/vendor/datatables/jquery.dataTables.js') ?>"></script>

    <!-- Page level custom scripts -->
    <script src="<?= base_url('public/js/sb-admin-2.min.js'); ?>"></script>
    <script src="<?= base_url('public/js/jquery.toast.js'); ?>"></script>


    <script src="<?= base_url('public/vendor/Sweetalert/js/sweetalert2.min.js'); ?>"></script>
    <script src="<?= base_url('public/js/main.js'); ?>"></script>
    <script src="<?= base_url('public/js/scripts.js'); ?>"></script>

    <script type="text/javascript">
        var base_url = '<?php echo base_url(); ?>';
    </script>


    <?php $this->renderSection('scripts'); ?>
    <script>
        $(document).ready(function() {
            $('#userDropdown').click(function() {
                $('#dropdown-menu-top').toggle('show');
            });


            $('form').on('keyup keypress', function(e) {
                var keyCode = e.keyCode || e.which;
                if (keyCode === 13) {
                    e.preventDefault();
                    return false;
                }
            });



        });

        $(document).ajaxStart(function() {
            $('body').addClass("loading");
        });

        $(document).ajaxStop(function() {
            $('body').removeClass("loading");
        });
    </script>
</body>
<footer style="background:#007C84; padding: 10px; color: #FFF;">
    <div class="row">
        <div class="col-md-12" style="text-align:center;">
            <img src="<?php echo base_url('public/img/logotat_w.png') ?>" width="50px"> การท่องเที่ยวแห่งประเทศไทย
        </div>
    </div>

</footer>

</html>
<script type="text/javascript">
    $('textarea').keypress(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            this.value = this.value.substring(0, this.selectionStart) + "" + "\n" + this.value.substring(this.selectionEnd, this.value.length);
        }
    });
</script>