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
                            <input type="hidden" name="action" id="action" value="add">
                            <div class="row justify-content-md-center">
                                <div class="col text-center">
                                    <h5>กำหนดเงื่อนไขที่ต้องการ</h5>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>เทอม/ภาคเรียน</label>
                                        <select class="form-control select2bs4" style="width: 100%;" name="timereport_id" id="timereport_id" title="ช่วงเวลา" required>
                                            <?php
                                            list_timereport();
                                            ?>
                                        </select>
                                    </div>
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
            $timereport_id = $_POST['timereport_id'];

            $sql = 'SELECT * FROM tb_workreport, tb_user, tb_groupstu, tb_timereport, tb_field 
                    WHERE 
                        tb_workreport.teacher_id = tb_user.user_id AND
                        tb_workreport.groupstu_id = tb_groupstu.groupstu_id AND
                        tb_workreport.timereport_id = tb_timereport.timereport_id AND 
                        tb_workreport.field_id = tb_field.field_id AND 
                        tb_workreport.manager_id != "" AND
                        tb_workreport.timereport_id = "' . $timereport_id . '"';
            $rs = mysqli_query($con, $sql);

            if (mysqli_num_rows($rs) == 0) {
        ?>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold">ประวัติรายงานการปฏิบัติหน้าที่</h6>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-md-center">
                            <div class="col-md-10">
                                <div class="row justify-content-md-center">
                                    <div class="col text-center">
                                        <h5>สรุปรายงานอาจารย์ที่ปรึกษา ภาคเรียนที่ <?php echo getTimereportName($timereport_id); ?></h5>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col text-center">
                                        <h5>ยังไม่มีการส่งรายงาน/การอนุมัติรายงาน</h5>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            <?php
            } else {

            ?>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold">ประวัติรายงานการปฏิบัติหน้าที่</h6>
                    </div>
                    <div class="card-body">

                        <div class="row justify-content-md-center">
                            <div class="col">

                                <div class="row justify-content-md-center">
                                    <div class="col text-center">
                                        <h5>สรุปรายงานอาจารย์ที่ปรึกษา ประจำภาคเรียน <?php echo getTimereportName($timereport_id); ?></h5>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="table-responsive">
                                            <table class="table table-bordered text-sm" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th rowspan="2">ลำดับที่</th>
                                                        <th rowspan="2">หมู่เรียน</th>
                                                        <th rowspan="2">สาขาวิชา</th>
                                                        <th rowspan="2">อาจารย์</th>
                                                        <th colspan="3">จำนวนนักศึกษาต้นภาคเรียน</th>
                                                        <th rowspan="2">หยุดพักการเรียน</th>
                                                        <th rowspan="2">ลาออก</th>
                                                        <th rowspan="2">พ้นสภาพ</th>
                                                        <th rowspan="2">เสียชีวิต</th>
                                                        <th rowspan="2">ไม่สามารถติดต่อได้</th>
                                                        <th colspan="3">จำนวนนักศึกษาสิ้นภาคเรียน</th>
                                                        <th rowspan="2">ทุนกู้ยืม</th>
                                                        <th rowspan="2">ทุนอื่นๆ</th>
                                                        <th rowspan="2">ร่วมกิจกรรมนักศึกษา</th>
                                                        <th rowspan="2">เชิดชูเกียรติ</th>
                                                        <th rowspan="2">ผลการเรียนต่ำ</th>
                                                        <th rowspan="2">พบ นศ.</th>
                                                        <th colspan="2">ปรึกษารายบุคคล</th>
                                                    </tr>
                                                    <tr class="text-center">
                                                        <th>ชาย</th>
                                                        <th>หญิง</th>
                                                        <th>รวม</th>
                                                        <th>ชาย</th>
                                                        <th>หญิง</th>
                                                        <th>รวม</th>
                                                        <th>คน</th>
                                                        <th>ครั้ง</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    $total_start_m = 0;
                                                    $total_start_f = 0;
                                                    $total_start_sum = 0;
                                                    $total_break = 0;
                                                    $total_quit = 0;
                                                    $total_out = 0;
                                                    $total_died = 0;
                                                    $total_no_contact = 0;
                                                    $total_end_male = 0;
                                                    $total_end_female = 0;
                                                    $total_end_sum = 0;
                                                    $total_scholarship = 0;
                                                    $total_scholarship_other = 0;
                                                    $total_event = 0;
                                                    $total_glorification = 0;
                                                    $total_lowgrade = 0;
                                                    $total_meeting = 0;
                                                    $total_counsel = 0;
                                                    $total_counsel_count = 0;
                                                    while ($r = mysqli_fetch_array($rs)) {
                                                        $total_start_m += $r['wp_start_male'];
                                                        $total_start_f += $r['wp_start_female'];
                                                        $total_start_sum += $r['wp_start_male'] + $r['wp_start_female'];
                                                        $total_break += $r['wp_break'];
                                                        $total_quit += $r['wp_quit'];
                                                        $total_out += $r['wp_out'];
                                                        $total_died += $r['wp_died'];
                                                        $total_no_contact += $r['wp_no_contact'];
                                                        $total_end_male += $r['wp_end_male'];
                                                        $total_end_female += $r['wp_end_female'];
                                                        $total_end_sum += $r['wp_end_male'] + $r['wp_end_female'];
                                                        $total_scholarship += $r['wp_scholarship'];
                                                        $total_scholarship_other += $r['wp_scholarship_other'];
                                                        $total_event += $r['wp_event'];
                                                        $total_glorification += $r['wp_glorification'];
                                                        $total_lowgrade += $r['wp_lowgrade'];
                                                        $total_meeting += $r['wp_meeting'];
                                                        $total_counsel += $r['wp_counsel'];
                                                        $total_counsel_count += $r['wp_counsel_count'];
                                                    ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $i; ?></td>
                                                            <td class="text-center"><?php echo $r['groupstu_name']; ?></td>
                                                            <td class="text-center"><?php echo $r['field_name']; ?></td>
                                                            <td class="text-center"><?php echo getFullnameById($r['teacher_id']); ?></td>
                                                            <td class="text-center"><?php echo $r['wp_start_male']; ?></td>
                                                            <td class="text-center"><?php echo $r['wp_start_female']; ?></td>
                                                            <td class="text-center"><?php echo $r['wp_start_male'] + $r['wp_start_female']; ?></td>
                                                            <td class="text-center"><?php echo $r['wp_break']; ?></td>
                                                            <td class="text-center"><?php echo $r['wp_quit']; ?></td>
                                                            <td class="text-center"><?php echo $r['wp_out']; ?></td>
                                                            <td class="text-center"><?php echo $r['wp_died']; ?></td>
                                                            <td class="text-center"><?php echo $r['wp_no_contact']; ?></td>
                                                            <td class="text-center"><?php echo $r['wp_end_male']; ?></td>
                                                            <td class="text-center"><?php echo $r['wp_end_female']; ?></td>
                                                            <td class="text-center"><?php echo $r['wp_end_male'] + $r['wp_end_female']; ?></td>
                                                            <td class="text-center"><?php echo $r['wp_scholarship']; ?></td>
                                                            <td class="text-center"><?php echo $r['wp_scholarship_other']; ?></td>
                                                            <td class="text-center"><?php echo $r['wp_event']; ?></td>
                                                            <td class="text-center"><?php echo $r['wp_glorification']; ?></td>
                                                            <td class="text-center"><?php echo $r['wp_lowgrade']; ?></td>
                                                            <td class="text-center"><?php echo $r['wp_meeting']; ?></td>
                                                            <td class="text-center"><?php echo $r['wp_counsel']; ?></td>
                                                            <td class="text-center"><?php echo $r['wp_counsel_count']; ?></td>
                                                        </tr>
                                                    <?php
                                                        $i++;
                                                    }
                                                    ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr class="text-center">
                                                        <td colspan="4">รวมทั้งสิ้น</td>
                                                        <td><?php echo $total_start_m; ?></td>
                                                        <td><?php echo $total_start_f; ?></td>
                                                        <td><?php echo $total_start_sum; ?></td>
                                                        <td><?php echo $total_break; ?></td>
                                                        <td><?php echo $total_quit; ?></td>
                                                        <td><?php echo $total_out; ?></td>
                                                        <td><?php echo $total_died; ?></td>
                                                        <td><?php echo $total_no_contact; ?></td>
                                                        <td><?php echo $total_end_male; ?></td>
                                                        <td><?php echo $total_end_female; ?></td>
                                                        <td><?php echo $total_end_sum; ?></td>
                                                        <td><?php echo $total_scholarship; ?></td>
                                                        <td><?php echo $total_scholarship_other; ?></td>
                                                        <td><?php echo $total_event; ?></td>
                                                        <td><?php echo $total_glorification; ?></td>
                                                        <td><?php echo $total_lowgrade; ?></td>
                                                        <td><?php echo $total_meeting; ?></td>
                                                        <td><?php echo $total_counsel; ?></td>
                                                        <td><?php echo $total_counsel_count; ?></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="row justify-content-md-center">
                            <div class="col text-center">
                                <a href="workreport_sum_print.php?id=<?php echo $timereport_id; ?>" target="_blank" class="btn btn-success" target="_blank"><i class="fas fa-print"></i> พิมพ์</a>
                            </div>
                        </div>

                    </div>
                </div>
        <?php
            }
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
        $('#frmWorkReport').validate({
            rules: {
                timereport_id: {
                    required: true,
                },
            },
            messages: {
                timereport_id: {
                    required: "เลือกเทอม/ปีการศึกษา",
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