<?php
require_once 'config/sessionname.php';
session_start();
require_once 'config/coreconfig.php';
require_once 'config/connectdb.php';
require_once 'lib/function.php';

checkadminlogin();

$action = $_POST['action'];

$timereport_id = isset($_POST['timereport_id']) ? $_POST['timereport_id'] : '';
$timereport_term = isset($_POST['timereport_term']) ? $_POST['timereport_term'] : '';
$timereport_year = isset($_POST['timereport_year']) ? $_POST['timereport_year'] : '';
$timereport_status = isset($_POST['timereport_status']) ? $_POST['timereport_status'] : '';
$start_month = isset($_POST['start_month']) ? $_POST['start_month'] : '';
$start_year = isset($_POST['start_year']) ? $_POST['start_year'] : '';
$end_month = isset($_POST['end_month']) ? $_POST['end_month'] : '';
$end_year = isset($_POST['end_year']) ? $_POST['end_year'] : '';
$timereport_name = isset($_POST['timereport_name']) ? $_POST['timereport_name'] : '';

$timereport_start_month = $start_month . ' ' . $start_year;
$timereport_end_month = $end_month . ' ' . $end_year;

if ($action == 'add') {

    $sql = 'INSERT INTO tb_timereport (timereport_term, timereport_year, timereport_status, timereport_start_month, timereport_end_month, timereport_name) VALUES ("' . $timereport_term . '","' . $timereport_year . '", "1", "' . $timereport_start_month . '", "' . $timereport_end_month . '", "' . $timereport_name . '")';
    $insert = mysqli_query($con, $sql);

    if ($insert) {
        echo json_encode(['success' => '1', 'msg' => 'บันทึกข้อมูลเรียบร้อยแล้ว']);
        exit();
    } else {
        echo json_encode(['success' => '0', 'msg' => 'เกิดข้อผิดพลาด ไม่สามารถบันทึกข้อมูลได้']);
        exit();
    }
}

if ($action == 'edit') {
    $sql = 'UPDATE tb_timereport SET 
                timereport_term = "' . $timereport_term . '", 
                timereport_year = "' . $timereport_year . '", 
                timereport_status = "' . $timereport_status . '", 
                timereport_start_month = "' . $timereport_start_month . '",
                timereport_end_month = "' . $timereport_end_month . '", 
                timereport_name = "' . $timereport_name . '" 
            WHERE 
                timereport_id = "' . $timereport_id . '"';
    $rs = mysqli_query($con, $sql);
    if ($rs) {
        echo json_encode(['success' => '1', 'msg' => 'บันทึกข้อมูลเรียบร้อยแล้ว']);
        exit();
    } else {
        echo json_encode(['success' => '0', 'msg' => 'เกิดข้อผิดพลาด ไม่สามารถบันทึกข้อมูลได้']);
        exit();
    }
}

if ($action == 'delete') {
    $sql = 'DELETE FROM tb_timereport WHERE timereport_id = "' . $timereport_id . '"';
    $rs = mysqli_query($con, $sql);
    if ($rs) {
        echo json_encode(['success' => '1', 'msg' => 'ลบข้อมูลเรียบร้อยแล้ว']);
        exit();
    } else {
        echo json_encode(['success' => '0', 'msg' => 'เกิดข้อผิดพลาด ไม่สามารถบันทึกข้อมูลได้']);
        exit();
    }
}
