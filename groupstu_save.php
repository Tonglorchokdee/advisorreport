<?php
require_once 'config/sessionname.php';
session_start();
require_once 'config/coreconfig.php';
require_once 'config/connectdb.php';
require_once 'lib/function.php';

checkadminlogin();

$action = $_POST['action'];

$groupstu_id = isset($_POST['groupstu_id']) ? $_POST['groupstu_id'] : '';
$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
$field_id = isset($_POST['field_id']) ? $_POST['field_id'] : '';
$groupstu_name = isset($_POST['groupstu_name']) ? $_POST['groupstu_name'] : '';

if ($action == 'add') {

    $sql = 'INSERT INTO tb_groupstu (groupstu_name, field_id, user_id) VALUES ("' . $groupstu_name . '", "' . $field_id . '", "' . $user_id . '")';
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
    $sql = 'UPDATE tb_groupstu SET 
                groupstu_name = "' . $groupstu_name . '", 
                field_id = "' . $field_id . '",  
                user_id = "' . $user_id . '" 
            WHERE 
                groupstu_id = "' . $groupstu_id . '"';
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
    $sql = 'DELETE FROM tb_groupstu WHERE groupstu_id = "' . $groupstu_id . '"';
    $rs = mysqli_query($con, $sql);
    if ($rs) {
        echo json_encode(['success' => '1', 'msg' => 'ลบข้อมูลเรียบร้อยแล้ว']);
        exit();
    } else {
        echo json_encode(['success' => '0', 'msg' => 'เกิดข้อผิดพลาด ไม่สามารถบันทึกข้อมูลได้']);
        exit();
    }
}

if ($action == 'listgroupstu') {
    $field_id = $_POST['field_id'];

    $sql = 'SELECT * FROM tb_groupstu WHERE field_id = "' . $field_id . '"';
    $result = mysqli_query($con, $sql);
    while ($r = mysqli_fetch_array($result)) {
        $arr[] = array("groupstu_id" => $r['groupstu_id'], "groupstu_name" => $r['groupstu_name']);
    }

    echo json_encode($arr);
}
