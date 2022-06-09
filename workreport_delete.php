<?php
require_once 'config/sessionname.php';
session_start();
require_once 'config/coreconfig.php';
require_once 'config/connectdb.php';
require_once 'lib/function.php';

checklogin();

$titlepage = 'รายงานการปฏิบัติหน้าที่';
include '_headweb.php';

if (!isset($_GET['id'])) {
    echo '<script>Swal.fire("ข้อผิดพลาด", "เลือกข้อมูลที่ต้องการ", "error").then(function() {window.location.href = "workreport.php"});</script>';
    exit();
}
$wp_id = $_GET['id'];

$sql = 'SELECT * FROM tb_workreport, tb_user, tb_groupstu, tb_timereport, tb_field 
        WHERE 
            tb_workreport.teacher_id = tb_user.user_id AND
            tb_workreport.groupstu_id = tb_groupstu.groupstu_id AND
            tb_workreport.timereport_id = tb_timereport.timereport_id AND 
            tb_workreport.field_id = tb_field.field_id AND
            tb_workreport.wp_id = "' . $wp_id . '"';
$rs = mysqli_query($con, $sql);
$r = mysqli_fetch_array($rs);

$manager_id = $r['manager_id'];

$field_id = $r['field_id'];
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

                <form action="" method="post" id="frmWorkReport">
                    <input type="hidden" name="action" id="action" value="delete">
                    <input type="hidden" name="wp_id" id="wp_id" value="<?php echo $wp_id; ?>">
                    <input type="hidden" name="teacher_id" id="teacher_id" value="<?php echo $teacher_id; ?>">
                    <input type="hidden" name="field_id" id="field_id" value="<?php echo $field_id ?>">
                    <input type="hidden" name="groupstu_id" id="groupstu_id" value="<?php echo $groupstu_id; ?>">
                    <input type="hidden" name="timereport_id" id="timereport_id" value="<?php echo $timereport_id ?>">


                    <div class="row justify-content-md-center">
                        <div class="col-md-12">
                            <div class="row justify-content-md-center">
                                <div class="col text-center">
                                    <h5 class="text-danger">== ยืนยันการลบข้อมูล ==</h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-center">
                                    <h4>รายงานการปฏิบัติหน้าที่ของอาจารย์ที่ปรึกษารายภาคเรียน</h4>
                                    <h4>ภาคเรียนที่ : <?php echo $r['timereport_term'] . '/' . $r['timereport_year']; ?></h4>
                                    <h5>หมู่เรียน : <?php echo $r['groupstu_name']; ?></h5>
                                    <h5><?php echo $r['field_name']; ?></h5>
                                </div>
                            </div>

                            <!-- 1.ข้อมูลนักศึกษาในหมู่เรียน -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h6>1. ข้อมูลนักศึกษาในหมู่เรียน</h6>
                                            <hr>
                                            <div class="row">
                                                <div class="col">
                                                    <p>1.1 จำนวนนักศึกษาทั้งเมื่อต้นภาคเรียน</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>รวม (คน)</label>
                                                        <input type="number" class="form-control" placeholder="รวม (คน)" name="wp_start_sum" id="wp_start_sum" title="รวม (คน)" min="0" value="<?php echo $r['wp_start_sum']; ?>" disabled>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>ชาย (คน)</label>
                                                        <input type="number" class="form-control" placeholder="ชาย (คน)" name="wp_start_male" id="wp_start_male" title="ชาย (คน)" min="0" value="<?php echo $r['wp_start_male']; ?>" disabled>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>หญิง (คน)</label>
                                                        <input type="number" class="form-control" placeholder="หญิง (คน)" name="wp_start_female" id="wp_start_female" title="หญิง (คน)" min="0" value="<?php echo $r['wp_start_female']; ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>1.1.1 หยุดพักการเรียน (คน)</label>
                                                        <input type="number" class="form-control" placeholder="หยุดพักการเรียน (คน)" name="wp_break" id="wp_break" title="หยุดพักการเรียน (คน)" min="0" value="<?php echo $r['wp_break']; ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>1.1.2 ลาออก (คน)</label>
                                                        <input type="number" class="form-control" placeholder="ลาออก (คน)" name="wp_quit" id="wp_quit" title="ลาออก (คน)" value="<?php echo $r['wp_quit']; ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>1.1.3 พ้นสภาพ (คน)</label>
                                                        <input type="number" class="form-control" placeholder="พ้นสภาพ (คน)" name="wp_out" id="wp_out" title="พ้นสภาพ (คน)" value="<?php echo $r['wp_out']; ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>1.1.4 เสียชีวิต (คน)</label>
                                                        <input type="number" class="form-control" placeholder="เสียชีวิต (คน)" name="wp_died" id="wp_died" title="เสียชีวิต (คน)" min="0" value="<?php echo $r['wp_died']; ?>" disabled>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>จากสาเหตุ</label>
                                                        <input type="text" class="form-control" placeholder="จากสาเหตุ" name="wp_died_text" id="wp_died_text" title="จากสาเหตุ" value="<?php echo $r['wp_died_text']; ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>1.1.5 หายไปไม่สามารถติดต่อได้ (คน)</label>
                                                        <input type="number" class="form-control" placeholder="หายไปไม่สามารถติดต่อได้ (คน)" name="wp_no_contact" id="wp_no_contact" title="หายไปไม่สามารถติดต่อได้ (คน)" value="<?php echo $r['wp_no_contact']; ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col">
                                                    <p>1.2 จำนวนนักศึกษาทั้งเมื่อสิ้นภาคเรียน</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>รวม (คน)</label>
                                                        <input type="number" class="form-control" placeholder="รวม (คน)" name="wp_end_sum" id="wp_end_sum" title="รวม (คน)" min="0" value="<?php echo $r['wp_end_sum']; ?>" disabled>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>ชาย (คน)</label>
                                                        <input type="number" class="form-control" placeholder="ชาย (คน)" name="wp_end_male" id="wp_end_male" title="ชาย (คน)" min="0" value="<?php echo $r['wp_end_male']; ?>" disabled>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>หญิง (คน)</label>
                                                        <input type="number" class="form-control" placeholder="หญิง (คน)" name="wp_end_female" id="wp_end_female" title="หญิง (คน)" min="0" value="<?php echo $r['wp_end_female']; ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>1.3 จำนวนนักศึกษาที่รับทุนกู้ยืมทางการศึกษา (คน)</label>
                                                        <input type="number" class="form-control" placeholder="จำนวน (คน)" name="wp_scholarship" id="wp_scholarship" title="จำนวนนักศึกษาที่รับทุนกู้ยืมทางการศึกษา (คน)" min="0" value="<?php echo $r['wp_scholarship']; ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>1.4 จำนวนนักศึกษาที่รับทุนอื่น ๆ (คน)</label>
                                                        <input type="number" class="form-control" placeholder="จำนวน (คน)" name="wp_scholarship_other" id="wp_scholarship_other" title="จำนวนนักศึกษาที่รับทุนอื่น ๆ (คน)" min="0" value="<?php echo $r['wp_scholarship_other']; ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>1.5 จำนวนนักศึกษาที่เข้าร่วมกิจกรรมนักศึกษา (องค์การนักศึกษา สภาฯ สโมสรนักศึกษาประจำคณะ) (คน)</label>
                                                        <input type="number" class="form-control" placeholder="จำนวน (คน)" name="wp_event" id="wp_event" title="จำนวนนักศึกษาที่เข้าร่วมกิจกรรมนักศึกษา (องค์การนักศึกษา สภาฯ สโมสรนักศึกษาประจำคณะ) (คน)" min="0" value="<?php echo $r['wp_event']; ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>1.6 จำนวนนักศึกษาที่ได้รับการเชิดชูเกียรติ (ด้านวิชาการ กีฬา ดนตรี ศิลปะ อื่น ๆ) (คน)</label>
                                                        <input type="number" class="form-control" placeholder="จำนวน (คน)" name="wp_glorification" id="wp_glorification" title="จำนวนนักศึกษาที่ได้รับการเชิดชูเกียรติ (ด้านวิชาการ กีฬา ดนตรี ศิลปะ อื่น ๆ) (คน)" min="0" value="<?php echo $r['wp_glorification']; ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>1.7 จำนวนนักศึกษาที่มีผลการเรียนต่ำ (ต่ำกว่า 2.00) (คน)</label>
                                                        <input type="number" class="form-control" placeholder="จำนวน (คน)" name="wp_lowgrade" id="wp_lowgrade" title="จำนวนนักศึกษาที่มีผลการเรียนต่ำ (ต่ำกว่า 2.00) (คน)" min="0" value="<?php echo $r['wp_lowgrade']; ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <p>&nbsp;</p>

                            <!-- 2.การเข้าพบนักศึกษาในช่ั่วโมง -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h6>2. การเข้าพบนักศึกษาในช่ั่วโมงที่ปรึกษา (ครั้ง)</h6>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>จำนวน (ครั้ง)</label>
                                                <input type="number" class="form-control" placeholder="จำนวน (ครั้ง)" name="wp_meeting" id="wp_meeting" title="การเข้าพบนักศึกษาในช่ั่วโมงที่ปรึกษา (ครั้ง)" min="0" value="<?php echo $r['wp_meeting']; ?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <p>&nbsp;</p>

                            <!-- 3.การให้คำปรึกษารายบุคคล -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h6>3. การให้คำปรึกษาเป็นรายบุคคล</h6>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>จำนวน (ครั้ง)</label>
                                                <input type="number" class="form-control" placeholder="จำนวน (ครั้ง)" name="wp_counsel" id="wp_counsel" title="การให้คำปรึกษาเป็นรายบุคคล (ครั้ง)" min="0" value="<?php echo $r['wp_counsel']; ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label>จำนวน (คน)</label>
                                                <input type="number" class="form-control" placeholder="จำนวน (คน)" name="wp_counsel_count" id="wp_counsel_count" title="การให้คำปรึกษาเป็นรายบุคคล (คน)" min="0" value="<?php echo $r['wp_counsel_count']; ?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <p>&nbsp;</p>

                            <!-- 4.สรุปปัญหาของนักศึกษาและแนวทางแก้ไข -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h6>4. สรุปปัญหาของนักศึกษาและแนวทางแก้ไข</h6>
                                            <hr>
                                        </div>
                                    </div>

                                    <?php
                                    $sql = 'SELECT * FROM tb_student_problems WHERE wp_id = "' . $wp_id . '"';
                                    $rs = mysqli_query($con, $sql);
                                    ?>
                                    <div class="container_student_problems">
                                        <div class="element_student_problems" id="student_problems_1">
                                            <?php
                                            while ($r = mysqli_fetch_array($rs)) {
                                            ?>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>ปัญหา</label>
                                                            <textarea class="form-control" placeholder="ปัญหา" name="student_problems_problem_0" id="student_problems_problem_0" rows="3" title="ปัญหา" maxlength="200" disabled><?php echo strip_tags($r['student_problems_problem']); ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>แนวทางแก้ไข</label>
                                                            <textarea class="form-control" placeholder="แนวทางแก้ไข" name="student_problems_solution_0" id="student_problems_solution_0" rows="3" title="แนวทางแก้ไข" maxlength="200" disabled><?php echo strip_tags($r['student_problems_solution']); ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <p>&nbsp;</p>

                            <!-- 5.สรุปปัญหาของนักศึกษาที่ไม่สามารถแก้ไขได้ -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h6>5. สรุปปัญหาของนักศึกษาที่ไม่สามารถแก้ไขได้</h6>
                                            <hr>
                                        </div>
                                    </div>

                                    <?php
                                    $sql = 'SELECT * FROM tb_student_problem_no WHERE wp_id = "' . $wp_id . '"';
                                    $rs = mysqli_query($con, $sql);
                                    ?>
                                    <div class="container_student_problem_no">
                                        <div class="element_student_problem_no" id="student_problems_no_1">
                                            <?php
                                            while ($r = mysqli_fetch_array($rs)) {
                                            ?>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label></label>
                                                            <textarea class="form-control" placeholder="รายละเอียด" name="student_problem_no_problem_0" id="student_problem_no_problem_0" rows="3" title="รายละเอียด" disabled><?php echo strip_tags($r['student_problem_no_problem']); ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <p>&nbsp;</p>

                            <!-- 6.กิจกรรมเสริมที่อาจารย์จัดนอกเหนือการเข้าพบ -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h6>6. กิจกรรมเสริมที่อาจารย์จัดให้นักศึกษานอกเหนือจากการเข้าพบในชั่วโมงที่ปรึกษา</h6>
                                            <hr>
                                        </div>
                                    </div>

                                    <?php
                                    $sql = 'SELECT * FROM tb_event WHERE wp_id = "' . $wp_id . '"';
                                    $rs = mysqli_query($con, $sql);
                                    ?>
                                    <div class="container_event">
                                        <div class="element_event" id="event_1">
                                            <?php
                                            while ($r = mysqli_fetch_array($rs)) {
                                            ?>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label></label>
                                                            <textarea class="form-control" placeholder="รายละเอียด" name="event_text_0" id="event_text_0" rows="3" title="รายละเอียด" disabled><?php echo strip_tags($r['event_text']); ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <p>&nbsp;</p>

                            <!-- 7.ปัญหาอุปสรรค และข้อเสนอแนะ -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h6>7. ปัญหาอุปสรรคในการปฏิบัติหน้าที่ และข้อเสนอแนะ</h6>
                                            <hr>
                                        </div>
                                    </div>

                                    <?php
                                    $sql = 'SELECT * FROM tb_comment WHERE wp_id = "' . $wp_id . '"';
                                    $rs = mysqli_query($con, $sql);
                                    ?>
                                    <div class="container_comment">
                                        <div class="element_comment" id="comment_1">
                                            <?php
                                            while ($r = mysqli_fetch_array($rs)) {
                                            ?>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label></label>
                                                            <textarea class="form-control" placeholder="รายละเอียด" name="comment_text_0" id="comment_text_0" rows="3" title="รายละเอียด" disabled><?php echo strip_tags($r['comment_text']); ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <p>&nbsp;</p>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h6>สถานะรายงาน</h6>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="สถานะ" title="สถานะรายงาน" value="<?php echo ($manager_id == '') ? 'รออนุมัติ' : 'อนุมัติแล้ว'; ?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="row justify-content-md-center">
                                <div class="col text-center">
                                    <button type="submit" name="submit" id="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i> ลบ</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

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
        $('#btn_student_problems').click(function(e) {
            var total_element = $(".element_student_problems").length;

            var lastid = $(".element_student_problems:last").attr("id");
            var split_id = lastid.split("_");
            var nextindex = Number(split_id[2]) + 1;

            var max = 10;
            // Check total number elements
            if (total_element < max) {
                // Adding new div container after last occurance of element class
                $('.element_student_problems:last').after('<div class="element_student_problems" id="student_problems_' + nextindex + '"></div>');

                // Adding element to <>
                $("#student_problems_" + nextindex).append('<div class="row"><div class="col"><div class="form-group"><label>ปัญหา</label><textarea class="form-control" placeholder="ปัญหา" name="student_problems_problem_' + nextindex + '" id="student_problems_problem_' + nextindex + '" rows="3" title="ปัญหา" maxlength="200"></textarea></div></div><div class="col"><div class="form-group"><label>แนวทางแก้ไข</label><textarea class="form-control" placeholder="แนวทางแก้ไข" name="student_problems_solution_' + nextindex + '" id="student_problems_solution_' + nextindex + '" rows="3" title="แนวทางแก้ไข" maxlength="200"></textarea></div></div></div><div class="row"><div class="col text-right"><p><button type="button" id="remove_' + nextindex + '" class="btn btn-danger btn-sm remove" title="ลบ"><i class="fas fa-minus-square"></i> ลบ</button></p></div></div>');
            }
        });

        // Remove element
        $('.container_student_problems').on('click', '.remove', function() {

            var id = this.id;
            var split_id = id.split("_");
            var deleteindex = split_id[1];

            // Remove <div> with id
            $("#student_problems_" + deleteindex).remove();
        });

        $('#btn_student_problem_no').click(function(e) {
            var total_element = $(".element_student_problem_no").length;

            var lastid = $(".element_student_problem_no:last").attr("id");
            var split_id = lastid.split("_");
            var nextindex = Number(split_id[3]) + 1;

            var max = 10;
            // Check total number elements
            if (total_element < max) {
                // Adding new div container after last occurance of element class
                $('.element_student_problem_no:last').after('<div class="element_student_problem_no" id="student_problem_no_' + nextindex + '"></div>');

                // Adding element to <>
                $("#student_problem_no_" + nextindex).append('<div class="row"><div class="col"><div class="form-group"><label></label><textarea class="form-control" placeholder="รายละเอียด" name="student_problem_no_problem_' + nextindex + '" id="student_problem_no_problem_' + nextindex + '" rows="3" title="รายละเอียด"></textarea></div></div></div><div class="row"><div class="col text-right"><p><button type="button" id="remove_' + nextindex + '" class="btn btn-danger btn-sm remove" title="ลบ"><i class="fas fa-minus-square"></i> ลบ</button></p></div></div>');

            }
        });

        // Remove element
        $('.container_student_problem_no').on('click', '.remove', function() {

            var id = this.id;
            var split_id = id.split("_");
            var deleteindex = split_id[1];

            // Remove <div> with id
            $("#student_problem_no_" + deleteindex).remove();
        });

        $('#btn_event').click(function(e) {
            var total_element = $(".element_event").length;

            var lastid = $(".element_event:last").attr("id");
            var split_id = lastid.split("_");
            var nextindex = Number(split_id[1]) + 1;

            var max = 10;
            // Check total number elements
            if (total_element < max) {
                // Adding new div container after last occurance of element class
                $('.element_event:last').after('<div class="element_event" id="event_' + nextindex + '"></div>');

                // Adding element to <>
                $("#event_" + nextindex).append('<div class="row"><div class="col"><div class="form-group"><label></label><textarea class="form-control" placeholder="รายละเอียด" name="event_text_' + nextindex + '" id="event_text_' + nextindex + '" rows="3" title="รายละเอียด"></textarea></div></div></div><div class="row"><div class="col text-right"><p><button type="button" id="remove_' + nextindex + '" class="btn btn-danger btn-sm remove" title="ลบ"><i class="fas fa-minus-square"></i> ลบ</button></p></div></div>');

            }
        });

        // Remove element
        $('.container_event').on('click', '.remove', function() {

            var id = this.id;
            var split_id = id.split("_");
            var deleteindex = split_id[1];

            // Remove <div> with id
            $("#event_" + deleteindex).remove();
        });

        $('#btn_comment').click(function(e) {
            var total_element = $(".element_comment").length;

            var lastid = $(".element_comment:last").attr("id");
            var split_id = lastid.split("_");
            var nextindex = Number(split_id[1]) + 1;

            var max = 10;
            // Check total number elements
            if (total_element < max) {
                // Adding new div container after last occurance of element class
                $('.element_comment:last').after('<div class="element_comment" id="comment_' + nextindex + '"></div>');

                // Adding element to <>
                $("#comment_" + nextindex).append('<div class="row"><div class="col"><div class="form-group"><label></label><textarea class="form-control" placeholder="รายละเอียด" name="comment_text_' + nextindex + '" id="comment_text_' + nextindex + '" rows="3" title="รายละเอียด"></textarea></div></div></div><div class="row"><div class="col text-right"><p><button type="button" id="remove_' + nextindex + '" class="btn btn-danger btn-sm remove" title="ลบ"><i class="fas fa-minus-square"></i> ลบ</button></p></div></div>');

            }
        });

        // Remove element
        $('.container_comment').on('click', '.remove', function() {

            var id = this.id;
            var split_id = id.split("_");
            var deleteindex = split_id[1];

            // Remove <div> with id
            $("#comment_" + deleteindex).remove();
        });


        $('#frmWorkReport').validate({
            rules: {
                wp_start_male: {
                    required: true,
                },
                wp_start_female: {
                    required: true,
                },
                wp_start_sum: {
                    required: true,
                },
                wp_break: {
                    required: true,
                },
                wp_quit: {
                    required: true,
                },
                wp_out: {
                    required: true,
                },
                wp_died: {
                    required: true,
                },
                wp_no_contact: {
                    required: true,
                },
                wp_end_male: {
                    required: true,
                },
                wp_end_female: {
                    required: true,
                },
                wp_end_sum: {
                    required: true,
                },
                wp_scholarship: {
                    required: true,
                },
                wp_scholarship_other: {
                    required: true,
                },
                wp_event: {
                    required: true,
                },
                wp_glorification: {
                    required: true,
                },
                wp_lowgrade: {
                    required: true,
                },
                wp_meeting: {
                    required: true,
                },
                wp_counsel: {
                    required: true,
                },
                wp_counsel_count: {
                    required: true,
                }
            },
            messages: {
                wp_start_male: {
                    required: 'กรอกข้อมูล หากไม่มีข้อมูลให้ใส่ 0',
                },
                wp_start_female: {
                    required: 'กรอกข้อมูล หากไม่มีข้อมูลให้ใส่ 0',
                },
                wp_start_sum: {
                    required: 'กรอกข้อมูล หากไม่มีข้อมูลให้ใส่ 0',
                },
                wp_break: {
                    required: 'กรอกข้อมูล หากไม่มีข้อมูลให้ใส่ 0',
                },
                wp_quit: {
                    required: 'กรอกข้อมูล หากไม่มีข้อมูลให้ใส่ 0',
                },
                wp_out: {
                    required: 'กรอกข้อมูล หากไม่มีข้อมูลให้ใส่ 0',
                },
                wp_died: {
                    required: 'กรอกข้อมูล หากไม่มีข้อมูลให้ใส่ 0',
                },
                wp_no_contact: {
                    required: 'กรอกข้อมูล หากไม่มีข้อมูลให้ใส่ 0',
                },
                wp_end_male: {
                    required: 'กรอกข้อมูล หากไม่มีข้อมูลให้ใส่ 0',
                },
                wp_end_female: {
                    required: 'กรอกข้อมูล หากไม่มีข้อมูลให้ใส่ 0',
                },
                wp_end_sum: {
                    required: 'กรอกข้อมูล หากไม่มีข้อมูลให้ใส่ 0',
                },
                wp_scholarship: {
                    required: 'กรอกข้อมูล หากไม่มีข้อมูลให้ใส่ 0',
                },
                wp_scholarship_other: {
                    required: 'กรอกข้อมูล หากไม่มีข้อมูลให้ใส่ 0',
                },
                wp_event: {
                    required: 'กรอกข้อมูล หากไม่มีข้อมูลให้ใส่ 0',
                },
                wp_glorification: {
                    required: 'กรอกข้อมูล หากไม่มีข้อมูลให้ใส่ 0',
                },
                wp_lowgrade: {
                    required: 'กรอกข้อมูล หากไม่มีข้อมูลให้ใส่ 0',
                },
                wp_meeting: {
                    required: 'กรอกข้อมูล หากไม่มีข้อมูลให้ใส่ 0',
                },
                wp_counsel: {
                    required: 'กรอกข้อมูล หากไม่มีข้อมูลให้ใส่ 0',
                },
                wp_counsel_count: {
                    required: 'กรอกข้อมูล หากไม่มีข้อมูลให้ใส่ 0',
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
                var formData = $('#frmWorkReport').serialize();
                console.log(formData);

                loading();
                $.ajax({
                    type: 'POST',
                    url: 'workreport_save.php',
                    dataType: 'json',
                    encode: true,
                    data: formData,
                    success: function(data) {
                        Swal.close();
                        if (data.success == '1') {
                            $("#frmWorkReport :input").prop("disabled", true);
                            Swal.fire(data.msg, '', 'success').then(function() {
                                window.location.href = 'workreport.php'
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