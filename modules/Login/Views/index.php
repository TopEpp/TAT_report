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
    <link href="public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link rel="stylesheet" href="public/css/sweetalert2.css">
    <!-- Custom styles for this template-->
    <link href="public/css/sb-admin-2.css" rel="stylesheet">

</head>

<body class="bg-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-6 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <!-- <div class="col-lg-6 d-none d-lg-block bg-login-image"></div> -->
                            <div class="col-lg-12">
                              <br><br>
                                <div class="p-5">
                                    <div class="text-center">
                                        <img src="<?php echo base_url('/public/img/logotat_b.jpeg')?>" style="width: 180px;" ><br>
                                        <h6 class="h6 text-gray-900 mb-2 mt-2" style="line-height: 0.7">Tourism Authority of Thailand </h6>
                                        <h6 class="h6 text-gray-900 mb-2 mt-2" style="line-height: 0.7">การท่องเที่ยวแห่งประเทศไทย</h6>
                                    </div>
                                    <form class="user" action="<?php echo base_url('/login/auth'); ?>" method="post">
                                        <div class="form-group mt-3">
                                            <input  type="text" class="form-control form-control-user <?php if (!empty(@$session->getFlashdata('error'))): ?>
                                              <?php echo 'border-danger'; ?>
                                            <?php endif; ?>" id="user_name" name="user_name" value=""  aria-describedby="" placeholder="Username">
                                        </div>
                                        <div class="form-group mt-3">
                                            <input  type="password" id="password" name="password" value="" class="form-control form-control-user <?php if (!empty(@$session->getFlashdata('error'))): ?>
                                              <?php echo 'border-danger'; ?>
                                            <?php endif; ?>" placeholder="Password">
                                        </div>
                                        <button type="submit" class="btn btn-orange btn-block">
                                            เข้าสู่ระบบ
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="public/vendor/jquery/jquery.min.js"></script>
    <script src="public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="public/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="public/js/sb-admin-2.min.js"></script>
    <script src="public/js/sweetalert2.js"></script>

    <?php if (!empty($session->getFlashdata('error'))): ?>
    <script>
     $(window).on('load', function() {
        swal({
      title: "<p style='font-size:18px;'><?php echo @$session->getFlashdata('error');  ?><p>",
      type: 'error'
      });
    });
    </script>
    <?php endif; ?>

</body>

</html>
