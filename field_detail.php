<?php
require_once 'config/sessionname.php';
session_start();
require_once 'config/coreconfig.php';
require_once 'config/connectdb.php';
require_once 'lib/function.php';

checkadminlogin();

$titlepage = 'รายละเอียดสาขาวิชา';
include '_headweb.php';

if (!isset($_GET['id'])) {
    echo '<script>Swal.fire("ข้อผิดพลาด", "เลือกข้อมูลที่ต้องการแก้ไข", "error").then(function() {window.location.href = "field.php"});</script>';
    exit();
}

$field_id = $_GET['id'];
$sql = 'SELECT * FROM tb_field 
        WHERE 
            tb_field.field_id = "' . $field_id . '"';
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0) {
    $r = mysqli_fetch_array($result);
} else {
    echo '<script>Swal.fire("ข้อผิดพลาด", "ไม่พบข้อมูลที่ต้องการ", "error").then(function() {window.location.href = "field.php"});</script>';
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
            <h1 class="h3 mb-0 text-gray-800">จัดการสาขาวิชา</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">รายละเอียดสาขาวิชา</h6>
            </div>
            <div class="card-body">

                <div class="row justify-content-md-center">
                    <div class="col-md-10">
                        <form action="" method="post" id="frmField">
                            <input type="hidden" name="action" id="action" value="edit">
                            <input type="hidden" name="field_id" id="field_id" value="<?php echo $r['field_id'] ?>">

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>สาขาวิชา</label>
                                        <input type="text" class="form-control" placeholder="กรอกชื่อสาขา" name="field_name" id="field_name" title="สาขาวิชา" value="<?php echo $r['field_name']; ?>" disabled>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="row justify-content-md-center">
                                <div class="col text-center">
                                    <a href="field_edit.php?id=<?php echo $r['field_id']; ?>" class="btn btn-warning"><i class="fas fa-edit"></i> แก้ไข</a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
            <div class="card-footer">
                <a href="field.php" class="btn btn-primary"><i class="fas fa-chevron-left"></i> ย้อนกลับ</a>
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
        $('#frmField').validate({
            rules: {
                field_name: {
                    required: true,
                    minlength: 4,
                },
            },
            messages: {
                field_name: {
                    required: "กรอกชื่อสาขาวิชา",
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
                var formData = $('#frmField').serialize();

                loading();
                $.ajax({
                    type: 'POST',
                    url: 'field_save.php',
                    dataType: 'json',
                    encode: true,
                    data: formData,
                    success: function(data) {
                        Swal.close();
                        if (data.success == '1') {
                            $("#frmField :input").prop("disabled", true);
                            Swal.fire(data.msg, '', 'success').then(function() {
                                window.location.href = 'field.php'
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