<?php
function checklogin()
{
    if (!isset($_SESSION['user_id'])) {
        echo '<meta http-equiv="refresh" content="1; URL = login.php" />';
        exit();
    }
}

function checkadminlogin()
{
    if (!isset($_SESSION['role_id'])) {
        echo '<meta http-equiv="refresh" content="1; URL = login.php" />';
        exit();

        if ($_SESSION['role_id'] != 1) {
            echo '<meta http-equiv="refresh" content="1; URL = login.php" />';
            exit();
        }
    }
}

function getFullname()
{
    global $con;

    $fullname = '';

    $sql = 'SELECT * FROM tb_user WHERE tb_user.user_id = "' . $_SESSION['user_id'] . '"';
    $rs = mysqli_query($con, $sql);
    $r = mysqli_fetch_array($rs);
    $fullname = $r['user_title'] . $r['user_fname'] . ' ' . $r['user_lname'];

    return $fullname;
}

function getFullnameById($v)
{
    global $con;

    $fullname = '';

    $sql = 'SELECT * FROM tb_user WHERE tb_user.user_id = "' . $v . '"';
    $rs = mysqli_query($con, $sql);
    $r = mysqli_fetch_array($rs);
    $fullname = $r['user_title'] . $r['user_fname'] . ' ' . $r['user_lname'];

    return $fullname;
}

function getFullnameAndRoleName()
{
    global $con;

    $fullname = '';

    $sql = 'SELECT * FROM tb_user, tb_role WHERE tb_user.role_id = tb_role.role_id AND tb_user.user_id = "' . $_SESSION['user_id'] . '"';
    $rs = mysqli_query($con, $sql);
    $r = mysqli_fetch_array($rs);
    $fullname = $r['user_title'] . $r['user_fname'] . ' ' . $r['user_lname'] . ' [' . $r['role_name'] . ']';

    return $fullname;
}

function list_role($v = '')
{
    global $con;

    $sql = 'SELECT * FROM tb_role WHERE role_id IN (1,3)';
    $rs = mysqli_query($con, $sql);

    $opt = '<option value="">เลือกประเภทผู้ใช้</value>';
    $select = '';
    while ($r = mysqli_fetch_array($rs)) {
        if ($v == $r['role_id']) {
            $select = ' selected';
        } else {
            $select = '';
        }
        $opt .= '<option value="' . $r['role_id'] . '"' . $select . '>' . $r['role_name'] . '</option>';
    }

    echo $opt;
}

function count_groupstu_by_field($v = '')
{
    global $con;

    $sql = 'SELECT * FROM tb_groupstu WHERE field_id = ' . $v;
    $rs = mysqli_query($con, $sql);
    $count = mysqli_num_rows($rs);

    return $count;
}

function count_advisor_by_field($v = '')
{
    global $con;

    $sql = 'SELECT * FROM tb_user WHERE tb_user.field_id = ' . $v;
    $rs = mysqli_query($con, $sql);
    $count = mysqli_num_rows($rs);

    return $count;
}

function count_advisor_by_groupstu($v = '')
{
    global $con;

    $sql = 'SELECT * FROM tb_advisor WHERE tb_advisor.groupstu_id = ' . $v;
    $rs = mysqli_query($con, $sql);
    $count = mysqli_num_rows($rs);

    return $count;
}

function count_report_by_advisor($v = '')
{
    global $con;

    $sql = 'SELECT * FROM tb_workreport WHERE teacher_id = ' . $v;
    $rs = mysqli_query($con, $sql);
    $count = mysqli_num_rows($rs);

    return $count;
}

function count_report_by_timereport($v = '')
{
    global $con;

    $sql = 'SELECT * FROM tb_workreport WHERE timereport_id = ' . $v;
    $rs = mysqli_query($con, $sql);
    $count = mysqli_num_rows($rs);

    return $count;
}

function count_report_by_groupstu($v = '')
{
    global $con;

    $sql = 'SELECT * FROM tb_workreport WHERE groupstu_id = ' . $v;
    $rs = mysqli_query($con, $sql);
    $count = mysqli_num_rows($rs);

    return $count;
}


function list_field($v = '')
{
    global $con;

    $sql = 'SELECT * FROM tb_field';
    $rs = mysqli_query($con, $sql);

    $opt = '<option value="">เลือกสาขาวิชา</value>';
    $select = '';
    while ($r = mysqli_fetch_array($rs)) {
        if ($v == $r['field_id']) {
            $select = ' selected';
        } else {
            $select = '';
        }
        $opt .= '<option value="' . $r['field_id'] . '"' . $select . '>' . $r['field_name'] . '</option>';
    }

    echo $opt;
}

function getTimereportStatus($v)
{
    $status = '';

    if ($v == 1) {
        $status = 'ดำเนินการ';
    } else {
        $status = 'ปีที่ผ่านมา';
    }

    return $status;
}

function list_timereport_status($v = '')
{
    global $con;

    $arr = array('1' => 'ดำเนินการ', '2' => 'ปีที่ผ่านมา');

    $opt = '<option value="">เลือกสถานะ</value>';
    foreach ($arr as $k => $val) {
        if ($k == $v) {
            $select = ' selected';
        } else {
            $select = '';
        }
        $opt .= '<option value="' . $k . '"' . $select . '>' . $val . '</option>';
    }

    echo $opt;
}

function list_timereport($v = '')
{
    global $con;

    $sql = 'SELECT * FROM tb_timereport';
    $rs = mysqli_query($con, $sql);

    $opt = '<option value="">เลือกเทอม/ภาคเรียน</value>';
    $select = '';
    while ($r = mysqli_fetch_array($rs)) {
        if ($v == $r['timereport_id']) {
            $select = ' selected';
        } else {
            $select = '';
        }
        $opt .= '<option value="' . $r['timereport_id'] . '"' . $select . '>' . $r['timereport_term'] . '/' . $r['timereport_year'] . '</option>';
    }

    echo $opt;
}

function getTimereportName($v = '')
{
    global $con;

    $sql = 'SELECT * FROM tb_timereport WHERE timereport_id = "' . $v . '"';
    $rs = mysqli_query($con, $sql);
    $r = mysqli_fetch_array($rs);

    echo $r['timereport_term'] . '/' . $r['timereport_year'];
}

function list_titlename($v = '')
{
    global $con;

    $arr = array('นาย', 'นาง', 'นางสาว', 'ดร.', 'ผศ.ดร.', 'รศ.ดร.', 'ศ.ดร.');

    $opt = '<option value="">คำนำหน้าชื่อ</value>';
    foreach ($arr as $val) {
        if ($val == $v) {
            $select = ' selected';
        } else {
            $select = '';
        }
        $opt .= '<option value="' . $val . '"' . $select . '>' . $val . '</option>';
    }

    echo $opt;
}

function list_month($v = '')
{
    global $con;

    $arr = array('มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม');

    $opt = '<option value="">เดือน</value>';
    foreach ($arr as $val) {
        if ($val == $v) {
            $select = ' selected';
        } else {
            $select = '';
        }
        $opt .= '<option value="' . $val . '"' . $select . '>' . $val . '</option>';
    }

    echo $opt;
}

function list_year($v = '')
{
    global $con;

    $arr = array('2564', '2565', '2566', '2567');

    $opt = '<option value="">ปี</value>';
    foreach ($arr as $val) {
        if ($val == $v) {
            $select = ' selected';
        } else {
            $select = '';
        }
        $opt .= '<option value="' . $val . '"' . $select . '>' . $val . '</option>';
    }

    echo $opt;
}

function list_select_timereport($v = '')
{
    global $con;

    $teacher_id = $_SESSION['user_id'];

    $sql = 'SELECT * FROM tb_timereport WHERE timereport_status = "1" AND timereport_id NOT IN (SELECT timereport_id FROM tb_workreport WHERE teacher_id = "' . $teacher_id . '") ';

    $rs = mysqli_query($con, $sql);

    $opt = '<option value="">เลือกเทอม/ปีการศึกษา</value>';
    $select = '';
    while ($r = mysqli_fetch_array($rs)) {
        if ($v == $r['timereport_id']) {
            $select = ' selected';
        } else {
            $select = '';
        }
        $timereport_name = $r['timereport_term'] . '/' . $r['timereport_year'] . ' [' . $r['timereport_start_month'] . ' - ' . $r['timereport_end_month'] . ']';
        $opt .= '<option value="' . $r['timereport_id'] . '"' . $select . '>' . $timereport_name . '</option>';
    }

    echo $opt;
}

function list_select_groupstu($v = '')
{
    global $con;

    $teacher_id = $_SESSION['user_id'];

    $sql = 'SELECT * FROM tb_groupstu WHERE tb_groupstu.user_id = '.$teacher_id.' AND tb_groupstu.groupstu_id NOT IN (
        SELECT groupstu_id FROM tb_workreport WHERE tb_workreport.teacher_id = '.$_SESSION['user_id'].' AND tb_workreport.timereport_id = "'.$v.'")';

    $rs = mysqli_query($con, $sql);

    $opt = '<option value="">เลือกหมู่เรียน</value>';
    $select = '';
    while ($r = mysqli_fetch_array($rs)) {
        $opt .= '<option value="' . $r['groupstu_id'] . '">' . $r['groupstu_name'] . '</option>';
    }

    echo $opt;
}

function datetimeformat($datetime)
{
    $d = date_format(date_create($datetime), 'd-m-Y H:s');

    return $d;
}
