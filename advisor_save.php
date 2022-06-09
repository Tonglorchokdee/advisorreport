<?php
require_once 'config/sessionname.php';
session_start();
require_once 'config/coreconfig.php';
require_once 'config/connectdb.php';
require_once 'lib/function.php';

checkadminlogin();

$action = $_POST['action'];

$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';

$user_username = strtolower(trim((isset($_POST['user_username'])) ? $_POST['user_username'] : ''));
$user_password = MD5(trim(isset($_POST['user_password']) ? $_POST['user_password'] : ''));

$user_title = trim(isset($_POST['user_title']) ? $_POST['user_title'] : '');
$user_fname = trim(isset($_POST['user_fname']) ? $_POST['user_fname'] : '');
$user_lname = trim(isset($_POST['user_lname']) ? $_POST['user_lname'] : '');
$user_address = nl2br(trim(isset($_POST['user_address']) ? $_POST['user_address'] : ''));
$user_position = trim(isset($_POST['user_position']) ? $_POST['user_position'] : '');
$user_tel = trim(isset($_POST['user_tel']) ? $_POST['user_tel'] : '');
$user_email = trim(isset($_POST['user_email']) ? $_POST['user_email'] : '');
$field_id = trim(isset($_POST['field_id']) ? $_POST['field_id'] : '');
$role_id = trim(isset($_POST['role_id']) ? $_POST['role_id'] : '');

if ($action == 'add') {
    $sql = 'SELECT * FROM tb_user WHERE user_username = "' . $user_username . '"';
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo json_encode(['success' => '0', 'msg' => 'มีชื่อผู้ใช้นี้ในระบบแล้ว !!!']);
        exit();
    }

    $sql = 'INSERT INTO tb_user (user_username, user_password, user_title, user_fname, user_lname, user_position, user_address, user_tel, user_email, role_id, field_id) VALUES ("' . $user_username . '", "' . $user_password . '", "' . $user_title . '", "' . $user_fname . '", "' . $user_lname . '", "' . $user_position . '", "' . $user_address . '", "' . $user_tel . '", "' . $user_email . '", "' . $role_id . '", "'.$field_id.'")';

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
    $sql = 'UPDATE tb_user SET 
                user_title = "' . $user_title . '", 
                user_fname = "' . $user_fname . '", 
                user_lname = "' . $user_lname . '", 
                user_address = "' . $user_address . '", 
                user_position = "'.$user_position.'", 
                user_tel = "' . $user_tel . '", 
                user_email = "' . $user_email . '", 
                field_id = "' . $field_id . '" 
            WHERE 
                user_id = "' . $user_id . '"';
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
    $sql = 'DELETE FROM tb_user WHERE user_id = "' . $user_id . '"';
    $rs = mysqli_query($con, $sql);
    if ($rs) {
        echo json_encode(['success' => '1', 'msg' => 'ลบข้อมูลเรียบร้อยแล้ว']);
        exit();
    } else {
        echo json_encode(['success' => '0', 'msg' => 'เกิดข้อผิดพลาด ไม่สามารถบันทึกข้อมูลได้']);
        exit();
    }
}

if ($action == 'resetpass') {
    $sql = 'UPDATE tb_user SET 
                user_password = "' . MD5('12345678') . '"  
            WHERE 
                user_id = "' . $user_id . '"';
    $rs = mysqli_query($con, $sql);
    if ($rs) {
        echo json_encode(['success' => '1', 'msg' => 'ตั้งรหัสผ่านใหม่ <br>เป็นค่าเริ่มต้น(12345678) เรียบร้อยแล้ว']);
        exit();
    } else {
        echo json_encode(['success' => '0', 'msg' => 'เกิดข้อผิดพลาด ไม่สามารถบันทึกข้อมูลได้']);
        exit();
    }
}
