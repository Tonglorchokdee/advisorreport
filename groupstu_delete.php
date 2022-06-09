<?php
require_once 'config/sessionname.php';
session_start();
require_once 'config/coreconfig.php';
require_once 'config/connectdb.php';
require_once 'lib/function.php';

checkadminlogin();

$titlepage = 'ลบหมู่เรียน';
include '_headweb.php';

if (!isset($_GET['id'])) {
    echo '<script>Swal.fire("ข้อผิดพลาด", "เลือกข้อมูลที่ต้องการแก้ไข", "error").then(function() {window.location.href = "groupstu.php"});</script>';
    exit();
}

$groupstu_id = $_GET['id'];
$sql = 'SELECT * FROM tb_groupstu  
        WHERE 
            tb_groupstu.groupstu_id = "' . $groupstu_id . '"';
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0) {
    $r = mysqli_fetch_array($result);
} else {
    echo '<script>Swal.fire("ข้อผิดพลาด", "ไม่พบข้อมูลที่ต้องการ", "error").then(function() {window.location.href = "groupstu.php"});</script>';
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
            <h1 class="h3 mb-0 text-gray-800">จัดการหมู่เรียน</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">แก้ไขจัดการหมู่เรียน</h6>
            </div>
            <div class="card-body">

                <div class="row justify-content-md-center">
                    <div class="col-md-10">
                        <form action="" method="post" id="frmGroupstu">
                            <input type="hidden" name="action" id="action" value="delete">
                            <input type="hidden" name="groupstu_id" id="groupstu_id" value="<?php echo $r['groupstu_id']; ?>">

                            <div class="row justify-content-md-center">
                                <div class="col text-center">
                                    <h5 class="text-danger">== ยืนยันการลบข้อมูล ==</h5>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>หมู่เรียน</label>
                                        <input type="text" class="form-control" placeholder="กรอกชื่อหมู่เรียน" name="groupstu_name" id="groupstu_name" title="หมู่เรียน" value="<?php echo $r['groupstu_name'] ?>" disabled>
                                    </div>
                                </div>
                            </div>

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

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>อาจารย์</label>
                                        <select class="form-control select2bs4" style="width: 100%;" name="user_id" id="user_id" title="อาจารย์" disabled required>
                                            <option value="">เลือกอาจารย์</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="row justify-content-md-center">
                                <div class="col text-center">
                                    <button type="submit" name="submit" id="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i> ลบ</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
            <div class="card-footer">
                <a href="groupstu.php" class="btn btn-primary"><i class="fas fa-chevron-left"></i> ย้อนกลับ</a>
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
        $('#frmGroupstu').validate({
            rules: {
                field_id: {
                    required: true,
                },
                groupstu_name: {
                    required: true,
                },
            },
            messages: {
                groupstu_id: {
                    required: 'เลือกสาขาวิชา',
                },
                groupstu_name: {
                    required: "กรอกชื่อหมู่เรียน",
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
                var formData = $('#frmGroupstu').serialize();

                loading();
                $.ajax({
                    type: 'POST',
                    url: 'groupstu_save.php',
                    dataType: 'json',
                    encode: true,
                    data: formData,
                    success: function(data) {
                        Swal.close();
                        if (data.success == '1') {
                            $("#frmGroupstu :input").prop("disabled", true);
                            Swal.fire(data.msg, '', 'success').then(function() {
                                window.location.href = 'groupstu.php'
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

        loadadvisor();
    });

    function loadadvisor() {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'user_save.php',
            data: {
                action: 'listadvisor',
                field_id: '<?php echo $r['field_id'] ?>'
            },
            success: function(response) {
                Swal.close();
                var len = response.length;
                $("#user_id").empty();
                $("#user_id").append("<option value='0'>เลือกอาจารย์</option>");
                var user_id = '<?php echo $r['user_id'] ?>';
                for (var i = 0; i < len; i++) {
                    var id = response[i]['user_id'];
                    var name = response[i]['user_fullname'];
                    if (id == user_id) {
                        $("#user_id").append("<option value='" + id + "' selected>" + name + "</option>");
                    } else {
                        $("#user_id").append("<option value='" + id + "'>" + name + "</option>");
                    }
                }
                $("#user_id").prop("disabled", true);
            },
            error: function(e) {
                Swal.fire('ข้อผิดพลาด', 'เกิดข้อผิดพลาดร้ายแรงติดต่อผู้ดูแลระบบ', 'error');
                console.log("ERROR : ", e);
            }
        });
    }
</script>