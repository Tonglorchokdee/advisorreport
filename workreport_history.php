<?php
require_once 'config/sessionname.php';
session_start();
require_once 'config/coreconfig.php';
require_once 'config/connectdb.php';
require_once 'lib/function.php';

checkadminlogin();

$titlepage = 'ประวัติรายงานการปฏิบัติหน้าที่';
include '_headweb.php';
?>

<!-- Main Content -->
<div id="content">

    <?php include '_topbar.php'; ?>

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">ประวัติรายงานการปฏิบัติหน้าที่</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">ประวัติรายงานการปฏิบัติหน้าที่</h6>
            </div>
            <div class="card-body">

                <div class="row justify-content-md-center">
                    <div class="col-md-10">
                        <form action="" method="post" id="frmWorkReport">
                            <div class="row justify-content-md-center">
                                <div class="col text-center">
                                    <h5>กำหนดเงื่อนไขที่ต้องการ</h5>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>สาขาวิชา</label>
                                        <select class="form-control select2bs4" style="width: 100%;" name="field_id" id="field_id" title="เดือน">
                                            <?php
                                            list_field();
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>หมู่เรียน</label>
                                        <select class="form-control select2bs4" style="width: 100%;" name="groupstu_id" id="groupstu_id" title="เดือน">
                                            <option value=''>เลือกหมู่เรียน</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <label>วันที่รายงาน ตั้งแต่วันที่</label>
                                    <input type="date" class="form-control" name="wp_date_start" id="wp_date_start" title="วันที่รายงาน ตั้งแต่วันที่">
                                </div>
                                <div class="col">
                                    <label>ถึงวันที่</label>
                                    <input type="date" class="form-control" name="wp_date_end" id="wp_date_end" title="ถึงวันที่">
                                </div>
                            </div>

                            <hr>

                            <div class="row justify-content-md-center">
                                <div class="col text-center">
                                    <button type="submit" name="submit" id="submit" class="btn btn-primary"><i class="fas fa-tv"></i> แสดงรายงาน</button>
                                    <button type="reset" name="reset" id="reset" class="btn btn-danger"><i class="fas fa-ban"></i> ยกเลิก</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php
        if (isset($_POST['submit'])) {
            $field_id = $_POST['field_id'];
            $groupstu_id = $_POST['groupstu_id'];
            $wp_date_start = $_POST['wp_date_start'];
            $wp_date_end = $_POST['wp_date_end'];

            $sql = 'SELECT * FROM tb_workreport, tb_user, tb_groupstu, tb_timereport, tb_field 
                            WHERE 
                            tb_workreport.teacher_id = tb_user.user_id AND 
                            tb_workreport.groupstu_id = tb_groupstu.groupstu_id AND 
                            tb_workreport.field_id = tb_field.field_id AND 
                            tb_workreport.timereport_id = tb_timereport.timereport_id ';
            if ($field_id != '') {
                $sql .= ' AND  tb_workreport.field_id = "' . $field_id . '" ';
            }
            if ($groupstu_id != '') {
                $sql .= ' AND tb_workreport.groupstu_id = "' . $groupstu_id . '" ';
            }
            if (($wp_date_start != '') && ($wp_date_end != '')) {
                $sql .= ' AND tb_workreport.wp_createdate BETWEEN "' . $wp_date_start . ' 00:00:00" AND "' . $wp_date_end . ' 23:59:59"';
            }
            $sql .= ' ORDER BY tb_workreport.field_id, tb_workreport.groupstu_id, tb_workreport.wp_createdate ASC';

            $rs = mysqli_query($con, $sql);

        ?>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">ประวัติรายงานการปฏิบัติหน้าที่</h6>
                </div>
                <div class="card-body">

                    <div class="row justify-content-md-center">
                        <div class="col">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="text-center">
                                            <th>ลำดับที่</th>
                                            <th>สาขาวิชา</th>
                                            <th>หมู่เรียน</th>
                                            <th>รายงาน</th>
                                            <th>เทอม/ปีการศึกษา</th>
                                            <th>อาจารย์</th>
                                            <th>วันที่ส่งรายงาน</th>
                                            <th>สถานะ</th>
                                            <th>พิมพ์</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        while ($r = mysqli_fetch_array($rs)) {
                                        ?>
                                            <tr>
                                                <td class="text-center"><?php echo $i; ?></td>
                                                <td class="text-center"><?php echo $r['field_name']; ?></td>
                                                <td class="text-left"><?php echo $r['groupstu_name']; ?></td>
                                                <td class="text-left">รายงานการปฏิบัติหน้าที่ฯ <?php echo $r['groupstu_name']; ?></td>
                                                <td class="text-center"><?php echo $r['timereport_term'] . '/' . $r['timereport_year']; ?></td>
                                                <td class="text-center"><?php echo getFullnameById($r['user_id']) ?></td>
                                                <td class="text-center"><?php echo datetimeformat($r['wp_createdate']); ?></td>
                                                <td class="text-center">
                                                <?php
                                                    if ($r['manager_id'] == '') {
                                                        ?>
                                                    <a class="btn btn-sm btn-danger">
                                                        <?php
                                                                echo 'รออนุมัติ';
                                                        ?> 
                                                    </a>
                                                        <?php
                                                            }else {
                                                        ?>
                                                    <a class="btn btn-sm btn-success">
                                                        <?php
                                                                echo 'อนุมัติแล้ว';
                                                        }
                                                        ?>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="workreport_print.php?id=<?php echo $r['wp_id'] ?>" target="_blank" class="btn btn-sm btn-secondary" title="พิมพ์"><i class="fas fa-print"></i> พิมพ์</a>
                                                </td>
                                            </tr>
                                        <?php
                                            $i++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<?php
include '_footweb.php';
?>

<script>
    $(function() {
        $('#field_id').change(function(e) {
            event.preventDefault();
            var field_id = $(this).val();
            $("#groupstu_id").empty();
            $("#groupstu_id").append("<option value=''>เลือกหมู่เรียน</option>");
            $("#groupstu_id").prop("disabled", false);

            loading();

            $.ajax({
                type: 'post',
                dataType: 'json',
                url: 'groupstu_save.php',
                data: {
                    action: 'listgroupstu',
                    field_id: field_id
                },
                success: function(response) {
                    Swal.close();
                    var len = response.length;
                    $("#groupstu_id").empty();
                    $("#groupstu_id").append("<option value=''>เลือกหมู่เรียน</option>");
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['groupstu_id'];
                        var name = response[i]['groupstu_name'];
                        $("#groupstu_id").append("<option value='" + id + "'>" + name + "</option>");
                    }
                    $("#groupstu_id").prop("disabled", false);
                },
                error: function(e) {
                    Swal.fire('ข้อผิดพลาด', 'เกิดข้อผิดพลาดร้ายแรงติดต่อผู้ดูแลระบบ', 'error');
                    console.log("ERROR : ", e);
                }
            });
        });
    });
</script>