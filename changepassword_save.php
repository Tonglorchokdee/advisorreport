<?php
require_once 'config/sessionname.php';
session_start();
require_once 'config/coreconfig.php';
require_once 'config/connectdb.php';
require_once 'lib/function.php';

checkadminlogin();

$old_password = trim($_POST['old_password']);
$password = trim($_POST['password']);
$password2 = trim($_POST['password2']);
$user_id = $_POST['user_id'];

$sql = 'SELECT * FROM tb_user WHERE user_id = "' . $user_id . '" AND user_password = "' . MD5($old_password) . '"';
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) < 0) {
    echo json_encode(['success' => '0', 'msg' => 'รหัสผ่านเดิมไม่ถูกต้อง']);
    exit();
} else {
    $sql = 'UPDATE tb_user SET  
                    user_password = "' . MD5($password) . '" 
                WHERE  
                    user_id = "' . $user_id . '"';
    $update = mysqli_query($con, $sql);

    if ($update) {
        echo json_encode(['success' => '1', 'msg' => 'เปลี่ยนรหัสผ่านเรียบร้อยแล้ว เข้าสู่ระบบใหม่อีกครั้ง']);
        exit();
    } else {
        echo json_encode(['success' => '0', 'msg' => 'เกิดข้อผิดพลาดไม่สามารถบันทึกข้อมูลได้'.mysqli_error($con)]);
        exit();
    }
}
