<?php
require_once 'config/sessionname.php';
session_start();
require_once 'config/coreconfig.php';
require_once 'config/connectdb.php';
require_once 'lib/function.php';

checklogin();

$titlepage = 'หน้าหลัก';
include '_headweb.php';
?>

<!-- Main Content -->
<div id="content">

    <?php include '_topbar.php'; ?>

    <!-- Begin Page Content -->
    <div class="container-fluid">

    <!-- Custom scripts for all pages-->
    <!-- <script src="js/index.js"></script>
    <link href="css/index.css" rel="stylesheet"> -->
 
    <!-- Page Heading -->
        <div class="text-center">
            <h1 class="display-3">คณะวิทยาการจัดการ</h1>
                <p class="lead"><strong>ระบบรายงานการปฏิบัติหน้าที่ของอาจารย์ที่ปรึกษารายภาคเรียน</strong> คณะวิทยาการจัดการ มหาวิทยาลัยราชภัฏเลย</p>
                <hr>
                <!-- <p>ประวัติรายงานการปฏิบัติหน้าที่ <a href="workreport_history.php">คลิก</a></p> -->
        
        </div>
        

        <?php
        if($_SESSION['role_id'] == '2'){
            
        }
        ?>


    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<?php
include '_footweb.php';
?>