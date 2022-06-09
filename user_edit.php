<?php
require_once 'config/sessionname.php';
session_start();
require_once 'config/coreconfig.php';
require_once 'config/connectdb.php';
require_once 'lib/function.php';

checkadminlogin();

$titlepage = 'แก้ไขเจ้าหน้าที่/ผู้บริหาร';
include '_headweb.php';

if (!isset($_GET['id'])) {
    echo '<script>Swal.fire("ข้อผิดพลาด", "เลือกข้อมูลที่ต้องการแก้ไข", "error").then(function() {window.location.href = "user.php"});</script>';
    exit();
}

$user_id = $_GET['id'];
$sql = 'SELECT * FROM tb_user, tb_role 
        WHERE 
            tb_role.role_id = tb_user.role_id 
        AND 
            tb_user.user_id = "' . $user_id . '"';

$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0) {
    $r = mysqli_fetch_array($result);
} else {
    echo '<script>Swal.fire("ข้อผิดพลาด", "ไม่พบข้อมูลที่ต้องการ", "error").then(function() {window.location.href = "user.php"});</script>';
    exit();
}

?>

<!-- Main Content -->
<div id="content">

    <?php include '_topbar.php'; ?>

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">เจ้าหน้าที่/ผู้บริหาร</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">แก้ไขเจ้าหน้าที่/ผู้บริหาร</h6>
            </div>
            <div class="card-body">

                <div class="row justify-content-md-center">
                    <div class="col-md-10">
                        <form action="" method="post" id="frmuser">
                            <input type="hidden" name="action" id="action" value="edit">
                            <input type="hidden" name="user_id" id="user_id" value="<?php echo $r['user_id'] ?>">

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>ชื่อผู้ใช้</label>
                                        <input type="text" class="form-control" placeholder="กรอกชื่อผู้ใช้" name="user_username" id="user_username" title="ชื่อผู้ใช้" value="<?php echo $r['user_username']; ?>" disabled>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>คำนำหน้าชื่อ</label>
                                        <select class="form-control select2bs4" style="width: 100%;" name="user_title" id="user_title" title="คำนำหน้าชื่อ">
                                            <?php
                                            list_titlename($r['user_title']);
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>ชื่อ</label>
                                        <input type="text" class="form-control" placeholder="กรอกชื่อ" name="user_fname" id="user_fname" value="<?php echo $r['user_fname']; ?>">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>นามสกุล</label>
                                        <input type="text" class="form-control" placeholder="กรอกนามสกุล" name="user_lname" id="user_lname" value="<?php echo $r['user_lname']; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>ตำแหน่ง</label>
                                        <input type="text" class="form-control" placeholder="กรอกตำแหน่ง" name="user_position" id="user_position" value="<?php echo $r['user_position']; ?>">
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>ที่อยู่</label>
                                        <textarea class="form-control" placeholder="กรอกที่อยู่" name="user_address" id="user_address" rows="4" title="ที่อยู่"><?php echo strip_tags($r['user_address']); ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>เบอร์โทรศัพท์</label>
                                        <input type="text" class="form-control" placeholder="กรอกเบอร์โทรศัพท์" maxlength="10" name="user_tel" id="user_tel" title="เบอร์โทรศัพท์" value="<?php echo $r['user_tel']; ?>">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>อี-เมล์</label>
                                        <input type="email" name="user_email" id="user_email" class="form-control" title="อี-เมล์" placeholder="กรอกอีเมล์" value="<?php echo $r['user_email']; ?>">
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>ประเภทผู้ใช้</label>
                                        <select class="form-control select2bs4" style="width: 100%;" name="role_id" id="role_id" title="ประเภทผู้ใช้">
                                            <?php
                                            list_role($r['role_id']);
                                            ?>
                                        </select>
                                    </div>
                                </div>
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
                <a href="user.php" class="btn btn-primary"><i class="fas fa-chevron-left"></i> ย้อนกลับ</a>
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
        $('#frmuser').validate({
            rules: {
                user_title: {
                    required: true,
                },
                user_fname: {
                    required: true,
                },
                user_lname: {
                    required: true,
                },
                user_position: {
                    required: true,
                },
                user_address: {
                    required: true,
                },
                user_tel: {
                    required: true,
                    minlength: 10,
                    maxlength: 10
                },
                user_email: {
                    email: true
                },
                role_id: {
                    required: true
                },
            },
            messages: {
                user_title: {
                    required: 'กรอกคำนำหน้าชื่อ',
                },
                user_fname: {
                    required: 'กรอกชื่อ',
                },
                user_lname: {
                    required: 'กรอกนามสกุล',
                },
                user_position: {
                    required: 'กรอกตำแหน่ง',
                },
                user_address: {
                    required: 'กรอกที่อยู่',
                },
                user_tel: {
                    required: 'กรอกเบอร์โทรศัพท์',
                    minlength: jQuery.validator.format("เบอรโทรศัพท์ต้องมี {0} ตัว"),
                    maxlength: jQuery.validator.format("เบอรโทรศัพท์ต้องมี {0} ตัว")
                },
                user_email: {
                    email: 'รูปแบบ อี-เมล์ ไม่ถูกต้อง'
                },
                role_id: {
                    required: 'เลือกประเภทผู้ใช้'
                },
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
                var formData = $('#frmuser').serialize();

                loading();
                $.ajax({
                    type: 'POST',
                    url: 'user_save.php',
                    dataType: 'json',
                    encode: true,
                    data: formData,
                    success: function(data) {
                        Swal.close();
                        if (data.success == '1') {
                            $("#frmuser :input").prop("disabled", true);
                            Swal.fire(data.msg, '', 'success').then(function() {
                                window.location.href = 'user.php'
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