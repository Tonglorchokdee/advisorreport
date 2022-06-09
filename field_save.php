<?php
require_once 'config/sessionname.php';
session_start();
require_once 'config/coreconfig.php';
require_once 'config/connectdb.php';
require_once 'lib/function.php';

checkadminlogin();

$action = $_POST['action'];

$field_id = isset($_POST['field_id']) ? $_POST['field_id'] : '';
$field_name = isset($_POST['field_name']) ? $_POST['field_name'] : '';

if ($action == 'add') {

    $sql = 'INSERT INTO tb_field (field_name) VALUES ("' . $field_name . '")';
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
    $sql = 'UPDATE tb_field SET 
                field_name = "' . $field_name . '" 
            WHERE 
                field_id = "' . $field_id . '"';
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
    $sql = 'DELETE FROM tb_field WHERE field_id = "' . $field_id . '"';
    $rs = mysqli_query($con, $sql);
    if ($rs) {
        echo json_encode(['success' => '1', 'msg' => 'ลบข้อมูลเรียบร้อยแล้ว']);
        exit();
    } else {
        echo json_encode(['success' => '0', 'msg' => 'เกิดข้อผิดพลาด ไม่สามารถบันทึกข้อมูลได้']);
        exit();
    }
}
