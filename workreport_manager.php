<?php
require_once 'config/sessionname.php';
session_start();
require_once 'config/coreconfig.php';
require_once 'config/connectdb.php';
require_once 'lib/function.php';

checklogin();

$teacher_id = $_SESSION['user_id'];

$sql = 'SELECT * FROM tb_workreport, tb_user, tb_groupstu, tb_timereport, tb_field
        WHERE 
            tb_workreport.teacher_id = tb_user.user_id AND
            tb_workreport.groupstu_id = tb_groupstu.groupstu_id AND
            tb_workreport.timereport_id = tb_timereport.timereport_id AND
            tb_workreport.field_id = tb_field.field_id';
            
$rs = mysqli_query($con, $sql);

$titlepage = 'รายงานการปฏิบัติหน้าที่';
include '_headweb.php';
?>

<!-- Main Content -->
<div id="content">

    <?php include '_topbar.php'; ?>

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">รายงานการปฏิบัติหน้าที่</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">รายงานการปฏิบัติหน้าที่</h6>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr class="text-center">
                                <th>รายงาน</th>
                                <th>สาขา</th>
                                <th>หมู่เรียน</th>
                                <th>เทอม/ปีการศึกษา</th>
                                <th>อาจารย์</th>
                                <th>วันที่ส่งรายงาน</th>
                                <th>สถานะ</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($r = mysqli_fetch_array($rs)) {
                            ?>
                                <tr>
                                    <td class="text-left">รายงานการปฏิบัติหน้าที่ฯ <?php echo $r['groupstu_name']; ?></td>
                                    <td class="text-left"><?php echo $r['field_name']; ?></td>
                                    <td class="text-left"><?php echo $r['groupstu_name']; ?></td>
                                    <td class="text-center"><?php echo $r['timereport_term'] . '/' . $r['timereport_year']; ?></td>
                                    <td class="text-center"><?php echo getFullnameById($r['user_id']) ?></td>
                                    <td class="text-center"><?php echo datetimeformat($r['wp_createdate']); ?></td>
                                    <td class="text-center">

                                        <?php
                                            if ($r['manager_id'] == '') {
                                        ?>
                                    <a class="btn btn-sm btn-danger">
                                        <?php
                                                echo 'รออนุมัติ';
                                        ?> 
                                    </a>
                                        <?php
                                            }else {
                                        ?>
                                    <a class="btn btn-sm btn-success">
                                        <?php
                                                echo 'อนุมัติแล้ว';
                                        }
                                        ?>
                                    </a>

                                    </td>
                                    <td class="text-center">
                                        <a href="workreport_print.php?id=<?php echo $r['wp_id'] ?>" target="_blank" class="btn btn-sm btn-secondary" title="พิมพ์"><i class="fas fa-print"></i> พิมพ์</a>
                                        <a href="workreport_detail.php?id=<?php echo $r['wp_id'] ?>" class="btn btn-sm btn-success" title="รายละเอียด"><i class="fas fa-file-alt"></i> รายละเอียด / <i class="fas fa-check"></i> อนุมัติ</a>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<?php
include '_footweb.php';
?>