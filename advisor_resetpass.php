<?php
require_once 'config/sessionname.php';
session_start();
require_once 'config/coreconfig.php';
require_once 'config/connectdb.php';
require_once 'lib/function.php';

checkadminlogin();

$titlepage = 'ตั้งค่ารหัสผ่านใหม่';
include '_headweb.php';

if (!isset($_GET['id'])) {
    echo '<script>Swal.fire("ข้อผิดพลาด", "เลือกข้อมูลที่ต้องการ", "error").then(function() {window.location.href = "advisor.php"});</script>';
    exit();
}

$user_id = $_GET['id'];
$sql = 'SELECT * FROM tb_user, tb_role, tb_field
        WHERE 
            tb_role.role_id = tb_user.role_id 
        AND 
            tb_user.field_id = tb_field.field_id 
        AND 
            tb_user.user_id = "' . $user_id . '"';
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0) {
    $r = mysqli_fetch_array($result);
} else {
    echo '<script>Swal.fire("ข้อผิดพลาด", "ไม่พบข้อมูลที่ต้องการ", "error").then(function() {window.location.href = "advisor.php"});</script>';
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
                <h6 class="m-0 font-weight-bold">รายละเอียดเจ้าหน้าที่/ผู้บริหาร</h6>
            </div>
            <div class="card-body">

                <div class="row justify-content-md-center">
                    <div class="col-md-10">
                        <form action="" method="post" id="frmuser">
                            <input type="hidden" name="action" id="action" value="delete">
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
                                <div class="col">
                                    <div class="form-group">
                                        <label>สาขาวิชา</label>
                                        <select class="form-control select2bs4" style="width: 100%;" name="field_id" id="field_id" title="สาขาวิชา" disabled>
                                            <?php
                                            list_field($r['field_id']);
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>คำนำหน้าชื่อ</label>
                                        <input type="text" class="form-control" placeholder="กรอกคำนำหน้าชื่อ" name="user_title" id="user_title" value="<?php echo $r['user_title']; ?>" disabled>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>ชื่อ</label>
                                        <input type="text" class="form-control" placeholder="กรอกชื่อ" name="user_fname" id="user_fname" value="<?php echo $r['user_fname']; ?>" disabled>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>นามสกุล</label>
                                        <input type="text" class="form-control" placeholder="กรอกนามสกุล" name="user_lname" id="user_lname" value="<?php echo $r['user_lname']; ?>" disabled>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>ที่อยู่</label>
                                        <textarea class="form-control" placeholder="กรอกที่อยู่" name="user_address" id="user_address" rows="4" title="ที่อยู่" disabled><?php echo $r['user_address']; ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>ที่อยู่</label>
                                        <textarea class="form-control" placeholder="กรอกที่อยู่" name="user_address" id="user_address" rows="4" title="ที่อยู่" disabled><?php echo $r['user_address']; ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>เบอร์โทรศัพท์</label>
                                        <input type="text" class="form-control" placeholder="กรอกเบอร์โทรศัพท์" maxlength="10" name="user_tel" id="user_tel" title="เบอร์โทรศัพท์" value="<?php echo $r['user_tel']; ?>" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>อี-เมล์</label>
                                        <input type="email" name="user_email" id="user_email" class="form-control" title="อี-เมล์" placeholder="กรอกอีเมล์" value="<?php echo $r['user_email']; ?>" disabled>
                                    </div>
                                </div>
                            </div>

                            <hr>

                        </form>
                    </div>
                </div>

            </div>
            <div class="card-footer">
                <a href="advisor.php" class="btn btn-primary"><i class="fas fa-chevron-left"></i> ย้อนกลับ</a>
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
        loading();
        $.ajax({
            type: 'POST',
            url: 'advisor_save.php',
            dataType: 'json',
            encode: true,
            data: {action : 'resetpass', user_id : '<?php echo $r['user_id']; ?>'},
            success: function(data) {
                Swal.close();
                if (data.success == '1') {
                    Swal.fire(data.msg, '', 'success').then(function() {
                        window.location.href = 'advisor.php'
                    });
                } else {
                    Swal.fire('ข้อผิดพลาด', data.msg, 'error');
                }
            },
            error: function(e) {
                console.log("ERROR : ", e);
            }
        });
    });
</script>