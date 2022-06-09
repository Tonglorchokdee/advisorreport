<?php
require_once 'config/sessionname.php';
session_start();
require_once 'config/coreconfig.php';
require_once 'config/connectdb.php';
require_once 'lib/function.php';

if (isset($_SESSION['user_id'])) {
    echo '<meta http-equiv="refresh" content="1; URL = index.php" />';
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>เข้าสู่ระบบ : <?php echo SYSTEMNAME; ?></title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.css" rel="stylesheet">

    <link rel="icon" href="img/cropped-logo-fms64-v06-200-1-32x32.png" sizes="32x32" />

    <!-- Sweet Alert -->
    <link href="vendor/sweetalert2/sweetalert2.css" rel="stylesheet">
    <script src="vendor/sweetalert2/sweetalert2.min.js"></script>

    <style>
        .error {
            color: red;
            font-size: small;
            margin-top: 10px;
        }
    </style>

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6">
                                <img src="img/bg_login.png" class="img-fluid rounded" alt="<?php echo SYSTEMNAME; ?>">
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">ลงชื่อเข้าใช้</h1>
                                    </div>
                                    <form class="user" id="frmlogin" method="post">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="username" name="username" aria-describedby="emailHelp" placeholder="กรอกชื่อผู้ใช้">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="กรอกรหัสผ่าน">
                                        </div>
                                        <hr>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
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
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- jquery-validation -->
    <script src="vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="vendor/jquery-validation/additional-methods.min.js"></script>

</body>

</html>
<script>
    $(function() {
        $('#frmlogin').validate({
            rules: {
                username: {
                    required: true
                },
                password: {
                    required: true
                }
            },
            messages: {
                username: {
                    required: "กรอกชื่อผู้ใช้"
                },
                password: {
                    required: "กรอกรหัสผ่าน"
                }
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function(form) {
                event.preventDefault();
                var formData = new FormData($('#frmlogin')[0]);

                loading();
                $.ajax({
                    type: 'POST',
                    url: 'login_save.php',
                    dataType: 'json',
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    encode: true,
                    success: function(data) {
                        console.log(data.messages);
                        Swal.close();
                        if (data.success == '1') {
                            $("#frmlogin :input").prop("disabled", true);
                            window.location.href = 'index.php'
                        } else {
                            Swal.fire('ข้อผิดพลาด', data.msg, 'error');
                        }
                    },
                    error: function(e) {
                        console.log("ERROR : ", e);
                    }
                });
            }
        });
    });

    function loading() {
        swal.fire({
            title: 'กำลังประมวลผล',
            html: 'โปรดรอสักครู่',
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading()
            }
        });
    }
</script>