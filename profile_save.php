<?php
require_once 'config/sessionname.php';
session_start();
require_once 'config/coreconfig.php';
require_once 'config/connectdb.php';
require_once 'lib/function.php';

checkadminlogin();

$action = $_POST['action'];

if ($action == 'user') {

    $user_id = $_POST['user_id'];
    $user_id = $_POST['user_id'];

    $user_title = trim($_POST['user_title']);
    $user_fname = trim($_POST['user_fname']);
    $user_lname = trim($_POST['user_lname']);
    $user_position = trim($_POST['user_position']);
    $user_address = nl2br(trim($_POST['user_address']));
    $user_tel = trim($_POST['user_tel']);
    $user_email = trim($_POST['user_email']);

    $sql = 'UPDATE tb_user SET 
                user_title = "' . $user_title . '", 
                user_fname = "' . $user_fname . '", 
                user_lname = "' . $user_lname . '", 
                user_position = "' . $user_position . '", 
                user_address = "' . $user_address . '", 
                user_tel = "' . $user_tel . '", 
                user_email = "' . $user_email . '" 
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

if ($action == 'advisor') {
    $user_id = $_POST['user_id'];

    $user_title = trim($_POST['user_title']);
    $user_fname = trim($_POST['user_fname']);
    $user_lname = trim($_POST['user_lname']);
    $user_address = nl2br(trim($_POST['user_address']));
    $user_tel = trim($_POST['user_tel']);
    $user_email = trim($_POST['user_email']);
    $user_position = trim($_POST['user_position']);

    $sql = 'UPDATE tb_user SET 
                user_title = "' . $user_title . '", 
                user_fname = "' . $user_fname . '", 
                user_lname = "' . $user_lname . '", 
                user_position = "' . $user_position . '", 
                user_address = "' . $user_address . '", 
                user_tel = "' . $user_tel . '", 
                user_email = "' . $user_email . '" 
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
