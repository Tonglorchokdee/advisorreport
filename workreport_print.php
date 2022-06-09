<?php
require_once 'config/sessionname.php';
session_start();
require_once 'config/coreconfig.php';
require_once 'config/connectdb.php';
require_once 'lib/function.php';

if (!isset($_GET['id'])) {

    checklogin();

    include '_headweb.php';

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

if (mysqli_num_rows($rs) == 0) {
    include '_headweb.php';

    echo '<script>Swal.fire("ข้อผิดพลาด", "ไม่พบข้อมูลที่ต้องการ", "error").then(function() {window.location.href = "workreport.php"});</script>';
    exit();
}

$r = mysqli_fetch_array($rs);

require_once 'vendor/autoload.php';
$mpdf = new \Mpdf\Mpdf();
$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$mpdf = new \Mpdf\Mpdf([
    'fontDir' => array_merge($fontDirs, [
        __DIR__ . '/fonts',
    ]),
    'fontdata' => $fontData + [
        'thsarabun' => [
            'R' => 'THSarabunNew.ttf',
            'I' => 'THSarabunNew Italic.ttf',
            'B' => 'THSarabunNew Bold.ttf',
        ]
    ],
    'default_font' => 'thsarabun'
]);

$content = '
<style>
body {
    line-height:0.3;
    font-size:18px;
}
.center {
    text-align: center;
}
.head1 {
    padding-left: 20px;
}
.head2 {
    padding-left: 50px;
}
table {
    width: 100%;
}
td {
    text-align: center;
}
</style>
<div class="center">
<h3>รายงานการปฏิบัติหน้าที่ของอาจารย์ที่ปรึกษารายภาคเรียน</h3>
<h3>ภาคเรียนที่ : ' . $r['timereport_term'] . '/' . $r['timereport_year'] . '</h3>
<hr>
</div>
<p>ชื่ออาจารย์......' . getFullnameById($r['teacher_id']) . '.....หมู่เรียน......' . $r['groupstu_name'] . '......สาขาวิชา......' . $r['field_name'] . '......</p>
<p>1. ข้อมูลนักศึกษาในหมู่เรียน</p>
<p class="head1">1.1 จำนวนนักศึกษาทั้งหมดเมื่อต้นภาคเรียน..........' . $r['wp_start_sum'] . '..........คน ชาย..........' . $r['wp_start_male'] . '..........คน หญิง..........' . $r['wp_start_female'] . '..........คน</p>
<p class="head2">1.1.1 หยุดพักการเรียน..........' . $r['wp_break'] . '..........คน</p>
<p class="head2">1.1.2 ลาออก..........' . $r['wp_quit'] . '..........คน</p>
<p class="head2">1.1.3 พ้นสภาพ..........' . $r['wp_out'] . '..........คน</p>
<p class="head2">1.1.4 เสียชีวิต..........' . $r['wp_died'] . '..........คน จากสาเหตุ..........' . $r['wp_died_text'] . '..........</p>
<p class="head2">1.1.5 หายไปไม่สามารถติดต่อได้..........' . $r['wp_no_contact'] . '..........คน</p>
<p class="head1">1.2 จำนวนนักศึกษาทั้งหมดเมื่อสิ้นภาคเรียน..........' . $r['wp_end_sum'] . '..........คน ชาย..........' . $r['wp_end_male'] . '..........คน หญิง..........' . $r['wp_end_female'] . '..........คน</p>
<p class="head1">1.3 จำนวนนักศึกษาที่ได้รับทุนกู้ยืมทางการศึกษา..........' . $r['wp_scholarship'] . '..........คน</p>
<p class="head1">1.4 จำนวนนักศึกษาที่ได้รับทุนอื่นๆ..........' . $r['wp_scholarship_other'] . '..........คน</p>
<p class="head1">1.5 จำนวนนักศึกษาที่เข้าร่วมกิจกรรมนักศึกษา (องค์กรนักศึกษา สภาฯ สโมสรนักศึกษาประจำคณะ)..........' . $r['wp_event'] . '..........คน</p>
<p class="head1">1.6 จำนวนนักศึกษาที่ได้รับการเชิดชูเกียรติ (ด้านวิชาการ กีฬา ดนตรี ศิลปะ อื่นๆ..........' . $r['wp_glorification'] . '..........คน</p>
<p class="head1">1.7 จำนวนนักศึกษาที่มีผลการเรียนต่ำ (ต่ำกว่า 2.00)..........' . $r['wp_lowgrade'] . '..........คน</p>
<p>2. การเข้าพบนักศึกษาในชั่วโมงที่ปรึกษา จำนวน..........' . $r['wp_meeting'] . '.........ครั้ง</p>
<p>3. การให้คำปรึกษาเป็นรายบุคคล จำนวน..........' . $r['wp_counsel'] . '.........คน..........' . $r['wp_counsel_count'] . '.........ครั้ง</p>';

$sql = 'SELECT * FROM tb_student_problems WHERE wp_id = "' . $wp_id . '"';
$rs = mysqli_query($con, $sql);

$content .= '
<p>4. สรุปปัญหาของนักศึกษาและแนวทางแก้ไข</p>';
if (mysqli_num_rows($rs) > 0) {
    $i = 1;
    while ($r = mysqli_fetch_array($rs)) {
        $content .= '<p class="head1">4.'.$i.' &nbsp;&nbsp;ปัญหา &nbsp;&nbsp;&nbsp;&nbsp;'.$r['student_problems_problem'].'</p>';
        $content .= '<p class="head2">แนวทางแก้ไข&nbsp;&nbsp;&nbsp;&nbsp;'.$r['student_problems_solution'].'</p>';
        $i++;
    }
} else {
    $content .= '<p class="head1">-</p>';
}


$sql = 'SELECT * FROM tb_student_problem_no WHERE wp_id = "' . $wp_id . '"';
$rs = mysqli_query($con, $sql);

$content .= '
<p>5. สรุปปัญหาของนักศึกษาที่ไม่สามารถแก้ไขได้</p>';

if (mysqli_num_rows($rs) > 0) {
    $i = 1;
    while ($r = mysqli_fetch_array($rs)) {
        $content .= '<p class="head1">5.'.$i.' '.$r['student_problem_no_problem'].'</p>';
        $i++;
    }
} else {
    $content .= '<p class="head1">-</p>';
}

$sql = 'SELECT * FROM tb_event WHERE wp_id = "' . $wp_id . '"';
$rs = mysqli_query($con, $sql);

$content .= '
<p>6. กิจกรรมเสริมที่อาจารย์จัดให้นักศึกษานอกเหนือจากการเข้าพอในชั่วโมงที่ปรึกษา</p>';

if (mysqli_num_rows($rs) > 0) {
    $i = 1;
    while ($r = mysqli_fetch_array($rs)) {
        $content .= '<p class="head1">6.'.$i.' '.$r['event_text'].'</p>';
        $i++;
    }
} else {
    $content .= '<p class="head1">-</p>';
}

$sql = 'SELECT * FROM tb_comment WHERE wp_id = "' . $wp_id . '"';
$rs = mysqli_query($con, $sql);

$content .= '
<p>7. ปัญหาและอุปสรรคในการปฏิบัติหน้าที่ และข้อเสนอแนะ</p>';
if (mysqli_num_rows($rs) > 0) {
    $i = 1;
    while ($r = mysqli_fetch_array($rs)) {
        $content .= '<p class="head1">7.'.$i.' '.$r['comment_text'].'</p>';
        $i++;
    }
} else {
    $content .= '<p class="head1">-</p>';
}

$content .= '
<hr>
<table>
<tr style="text-align: center;">
<td>..........................................................................ลงชื่ออาจารย์ที่ปรึกษา</td>
<td>..........................................................................ลงชื่อคณบดี</td>
</tr>
<tr>
<td style="text-align:left; padding-left:25px;">(....................................................................)</td>
<td style="text-align:left; padding-left:25px;">(....................................................................)</td>
</tr>
</table>
';

$mpdf->WriteHTML($content);
$mpdf->Output();
