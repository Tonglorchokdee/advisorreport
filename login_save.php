<?php
require_once 'config/sessionname.php';
session_start();
require_once 'config/coreconfig.php';
require_once 'config/connectdb.php';
require_once 'lib/function.php';

$username = $_POST['username'];
$password = $_POST['password'];

$sql = 'SELECT * FROM tb_user WHERE tb_user.user_username = "' . $username . '" AND tb_user.user_password = "' . MD5($password) . '"';
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0) {
    $r = mysqli_fetch_array($result);

    $_SESSION['login'] = 1;
    $_SESSION['role_id'] = $r['role_id'];
    $_SESSION['username'] = $r['user_username'];
    $_SESSION['user_id'] = $r['user_id'];

    echo json_encode(['success' => '1', 'msg' => 'เข้าสู่ระบบเรียบร้อยแล้ว']);
    exit();
} else {
    echo json_encode(['success' => '0', 'msg' => 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง']);
    exit();
}
