<?php
require_once 'config/sessionname.php';
session_start();
require_once 'config/coreconfig.php';
require_once 'config/connectdb.php';
require_once 'lib/function.php';

checkadminlogin();

$titlepage = 'รายงานการปฏิบัติหน้าที่';
include '_headweb.php';
?>

<!-- Main Content -->
<div id="content">

    <?php include '_topbar.php'; ?>

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">รายงานการปฏิบัติหน้าที่</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">รายงานการปฏิบัติหน้าที่</h6>
            </div>
            <div class="card-body">

                <div class="row justify-content-md-center">
                    <div class="col-md-10">
                        <form action="workreport_add.php" method="post" id="frmWorkSelect">
                            <input type="hidden" name="action" id="action" value="add">
                            <?php
                            /*
                            $sql = 'SELECT * FROM tb_timereport WHERE timereport_status = "1" AND timereport_id NOT IN (
                                SELECT DISTINCT timereport_id FROM tb_workreport WHERE teacher_id = "' . $_SESSION['user_id'] . '")';
                            echo $sql;
                            $rs = mysqli_query($con, $sql);
                            $r = mysqli_fetch_array($rs);
                            */

                            $sql = 'SELECT * FROM tb_timereport WHERE timereport_status = "1"';
                            $rs_t = mysqli_query($con, $sql);

                            if (mysqli_num_rows($rs_t) == 0) {
                                echo '<script>Swal.fire("ข้อความ", "ส่งรายงานครบแล้ว หรือยังไม่มีภาคเรียนที่ต้องรายงาน", "warning").then(function() {window.location.href = "workreport.php"});</script>';
                                exit();
                            } else {
                                $timereport_id = '';
                                $timereport_term = '';

                                $sql = 'SELECT * FROM tb_groupstu WHERE tb_groupstu.user_id = "' . $_SESSION['user_id'] . '"';
                                $rs_g = mysqli_query($con, $sql);
                                $my_group = mysqli_num_rows($rs_g);

                                while ($r_t = mysqli_fetch_array($rs_t)) {
                                    $sql = 'SELECT * FROM tb_workreport WHERE tb_workreport.teacher_id = "' . $_SESSION['user_id'] . '" AND tb_workreport.timereport_id = "' . $r_t['timereport_id'] . '"';
                                    $rs_w = mysqli_query($con, $sql);
                                    if ($my_group != mysqli_num_rows($rs_w)) {
                                        $timereport_id = $r_t['timereport_id'];
                                        $timereport_term = $r_t['timereport_term'] . '/' . $r_t['timereport_year'];
                                        break;
                                    }
                                }

                                if ($timereport_id == '') {
                                    echo '<script>Swal.fire("ข้อความ", "ส่งรายงานครบแล้ว หรือยังไม่มีภาคเรียนที่ต้องรายงาน", "warning").then(function() {window.location.href = "workreport.php"});</script>';
                                    exit();
                                }
                            }

                            ?>
                            <input type="hidden" name="timereport_id" id="timereport_id" value="<?php echo $timereport_id; ?>">

                            <div class="row justify-content-md-center">
                                <div class="col text-center">
                                    <h5>เลือกหมู่เรียน</h5>
                                    <p>หมายเหตุ : แสดงเฉพาะ หมู่เรียน ที่ยังไม่ได้รายงานเท่านั้น</p>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>เทอม/ปีการศึกษา</label>
                                        <input type="text" class="form-control" title="รวม (คน)" min="0" value="<?php echo $timereport_term; ?>" disabled>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>หมู่เรียน</label>
                                        <select class="form-control select2bs4" style="width: 100%;" name="groupstu_id" id="groupstu_id" title="เดือน">
                                            <?php
                                            list_select_groupstu($timereport_id);
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="row justify-content-md-center">
                                <div class="col text-center">
                                    <button type="submit" name="submit" id="submit" class="btn btn-primary">ถัดไป <i class="fas fa-angle-right"></i></button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
            <div class="card-footer">
                <a href="workreport.php" class="btn btn-primary"><i class="fas fa-chevron-left"></i> ย้อนกลับ</a>
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
        $('#frmWorkSelect').validate({
            rules: {
                timereport_id: {
                    required: true,
                },
                groupstu_id: {
                    required: true,
                },
            },
            messages: {
                timereport_id: {
                    required: "เลือกเทอม/ปีการศึกษา",
                },
                groupstu_id: {
                    required: "เลือกหมู่เรียน",
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
            }
        });
    });
</script>