<?php
require_once 'config/sessionname.php';
session_start();
require_once 'config/coreconfig.php';
require_once 'config/connectdb.php';
require_once 'lib/function.php';

if (!isset($_GET['id'])) {

    checklogin();

    include '_headweb.php';

    echo '<script>Swal.fire("ข้อผิดพลาด", "เลือกข้อมูลที่ต้องการ", "error").then(function() {window.location.href = "workreport_sum.php"});</script>';
    exit();
}

$timereport_id = $_GET['id'];

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
    include '_headweb.php';

    echo '<script>Swal.fire("ข้อผิดพลาด", "ไม่พบข้อมูลที่ต้องการ", "error").then(function() {window.location.href = "workreport.php"});</script>';
    exit();
}

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
    'default_font' => 'thsarabun',
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
    border: 1px solid;
    border-collapse: collapse;
}
td {
    text-align: center;
}
th, td {
    border: 1px solid;
}
</style>
';

$sql = 'SELECT * FROM tb_timereport WHERE timereport_id = ' . $timereport_id;
$rs_t = mysqli_query($con, $sql);
$r_t = mysqli_fetch_array($rs_t);

$content .= '
<div class="center">
<h3>สรุปรายงานอาจารย์ที่ปรึกษา ประจำภาคเรียน ' . $r_t['timereport_term'] . '/' . $r_t['timereport_year'] . '</h3>
</div>

<table>
<thead>
<tr class="center">
<th rowspan="2">ลำดับที่</th>
<th rowspan="2">หมู่เรียน</th>
<th rowspan="2">สาขาวิชา</th>
<th rowspan="2">อาจารย์</th>
<th colspan="3">จำนวนนักศึกษา</th>
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
<tr class="center">
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
';
$i = 1;
$total_m = 0;
$total_f = 0;
$total_sum = 0;
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
    $total_m += $r['wp_start_male'];
    $total_f += $r['wp_start_female'];
    $total_sum += $r['wp_start_male'] + $r['wp_start_female'];
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

    $content .= '<tr>
    <td class="text-center">' . $i . '</td>
    <td class="text-center">' . $r['groupstu_name'] . '</td>
    <td class="text-center">' . $r['field_name'] . '</td>
    <td class="text-center">' . getFullnameById($r['teacher_id']) . '</td>
    <td class="text-center">' . $r['wp_start_male'] . '</td>
    <td class="text-center">' . $r['wp_start_female'] . '</td>
    <td class="text-center">' . ($r['wp_start_male'] + $r['wp_start_female']) . '</td>
    <td class="text-center">' . $r['wp_break'] . '</td>
    <td class="text-center">' . $r['wp_quit'] . '</td>
    <td class="text-center">' . $r['wp_out'] . '</td>
    <td class="text-center">' . $r['wp_died'] . '</td>
    <td class="text-center">' . $r['wp_no_contact'] . '</td>
    <td class="text-center">' . $r['wp_end_male'] . '</td>
    <td class="text-center">' . $r['wp_end_female'] . '</td>
    <td class="text-center">' . ($r['wp_end_male'] + $r['wp_end_female']) . '</td>
    <td class="text-center">' . $r['wp_scholarship'] . '</td>
    <td class="text-center">' . $r['wp_scholarship_other'] . '</td>
    <td class="text-center">' . $r['wp_event'] . '</td>
    <td class="text-center">' . $r['wp_glorification'] . '</td>
    <td class="text-center">' . $r['wp_lowgrade'] . '</td>
    <td class="text-center">' . $r['wp_meeting'] . '</td>
    <td class="text-center">' . $r['wp_counsel'] . '</td>
    <td class="text-center">' . $r['wp_counsel_count'] . '</td>
</tr>';
    $i++;
}

$content .= '
<tr class="center">
<td colspan="4">รวมทั้งสิ้น</td>
<td>' . $total_m . '</td>
<td>' . $total_f . '</td>
<td>' . $total_sum . '</td>
<td>' . $total_break . '</td>
<td>' . $total_quit . '</td>
<td>' . $total_out . '</td>
<td>' . $total_died . '</td>
<td>' . $total_no_contact . '</td>
<td>' . $total_end_male . '</td>
<td>' . $total_end_female . '</td>
<td>' . $total_end_sum . '</td>
<td>' . $total_scholarship . '</td>
<td>' . $total_scholarship_other . '</td>
<td>' . $total_event . '</td>
<td>' . $total_glorification . '</td>
<td>' . $total_lowgrade . '</td>
<td>' . $total_meeting . '</td>
<td>' . $total_counsel . '</td>
<td>' . $total_counsel_count . '</td>
</tr>
';


$content .= '</table>
';

$mpdf->AddPage('L');
$mpdf->WriteHTML($content);
$mpdf->Output();
