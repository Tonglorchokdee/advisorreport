<?php
require_once 'config/sessionname.php';
session_start();
require_once 'config/coreconfig.php';
require_once 'config/connectdb.php';
require_once 'lib/function.php';

checklogin();

$titlepage = 'เปลี่ยนรหัสผ่าน';
include '_headweb.php';
?>

<!-- Main Content -->
<div id="content">

    <?php include '_topbar.php'; ?>

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">เปลี่ยนรหัสผ่าน</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">เปลี่ยนรหัสผ่าน</h6>
            </div>
            <div class="card-body">

                <div class="row justify-content-md-center">
                    <div class="col-md-10">
                        <form action="" method="post" id="frmChangepass">
                            <input type="hidden" name="user_id" id="user_id" value="<?php echo $_SESSION['user_id'] ?>">

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>ชื่อผู้ใช้</label>
                                        <input type="text" class="form-control" placeholder="กรอกชื่อผู้ใช้" name="username" id="username" title="ชื่อผู้ใช้" value="<?php echo $_SESSION['username']; ?>" disabled>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="form-group">
                                <label for="mem_password">รหัสผ่านเดิม</label>
                                <input type="password" id="old_password" name="old_password" class="form-control" placeholder="รหัสผ่านเดิม" required>
                            </div>
                            <div class="form-group">
                                <label for="mem_password">รหัสผ่านใหม่</label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="รหัสผ่าน" required>
                            </div>
                            <div class="form-group">
                                <label for="mem_password2">ยืนยันรหัสผ่าน</label>
                                <input type="password" id="password2" name="password2" class="form-control" placeholder="รหัสผ่าน" required>
                            </div>

                            <hr>

                            <div class="row justify-content-md-center">
                                <div class="col text-center">
                                    <button type="submit" name="submit" id="submit" class="btn btn-primary"><i class="fas fa-save"></i> บันทึก</button>
                                    <button type="reset" name="reset" id="reset" class="btn btn-danger"><i class="fas fa-ban"></i> ยกเลิก</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="index.php" class="btn btn-primary"><i class="fas fa-chevron-left"></i> ย้อนกลับ</a>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<?php
include '_footweb.php';
?>
<script>
    $(function() {
        $('#frmChangepass').validate({
            rules: {
                old_password: {
                    required: true,
                },
                password: {
                    required: true,
                    minlength: 8
                },
                password2: {
                    required: true,
                    equalTo: '#password'
                }
            },
            messages: {
                old_password: {
                    required: "กรอกรหัสผ่านเดิม",
                },
                password: {
                    required: 'กรอกรหัสผ่านใหม่',
                    minlength: jQuery.validator.format("รหัสผ่านต้องไม่ต่ำกว่า {0} ตัวอักษร")
                },
                password2: {
                    required: 'ยืนยันรหัสผ่านใหม่',
                    equalTo: 'กรอกรหัสผ่าน 2 ครั้ง ไม่ตรงกัน'
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
                var formData = new FormData($('#frmChangepass')[0]);

                loading();
                $.ajax({
                    type: 'POST',
                    url: 'changepassword_save.php',
                    dataType: 'json',
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    encode: true,
                    success: function(data) {
                        Swal.close();
                        if (data.success == '1') {
                            $("#frmChangepass :input").prop("disabled", true);
                            Swal.fire(data.msg, '', 'success').then(function() {
                                window.location.href = 'logout.php'
                            });
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
</script>