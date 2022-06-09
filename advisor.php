<?php
require_once 'config/sessionname.php';
session_start();
require_once 'config/coreconfig.php';
require_once 'config/connectdb.php';
require_once 'lib/function.php';

checklogin();

$sql = 'SELECT * FROM tb_user, tb_field 
        WHERE 
            tb_user.field_id = tb_field.field_id 
        AND 
            tb_user.role_id = 2';
$rs = mysqli_query($con, $sql);

$titlepage = 'อาจารย์';
include '_headweb.php';
?>

<!-- Main Content -->
<div id="content">

    <?php include '_topbar.php'; ?>

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">อาจารย์</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">อาจารย์</h6>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col">
                        <p>
                            <a href="advisor_add.php" class="btn btn-primary" title="เพิ่มอาจารย์"><i class="fas fa-plus"></i> เพิ่มอาจารย์</a>
                        </p>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr class="text-center">
                                <th>ชื่อผู้ใช้</th>
                                <th>ชื่อ-นามสกุล</th>
                                <th>สาขาวิชา</th>
                                <th>จำนวนรายงาน</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($r = mysqli_fetch_array($rs)) {
                            ?>
                                <tr>
                                    <td class="text-center"><?php echo $r['user_username']; ?></td>
                                    <td><?php echo $r['user_title'] . $r['user_fname'] . ' ' . $r['user_lname']; ?></td>
                                    <td class="text-center"><?php echo $r['field_name']; ?></td>
                                    <td class="text-center"><?php echo count_report_by_advisor($r['user_id']); ?></td>
                                    <td class="text-center">
                                        <a href="advisor_detail.php?id=<?php echo $r['user_id'] ?>" class="btn btn-sm btn-info" title="รายละเอียด"><i class="fas fa-file-alt"></i> รายละเอียด</a>
                                        <a href="advisor_edit.php?id=<?php echo $r['user_id'] ?>" class="btn btn-sm btn-warning" title="แก้ไข"><i class="fas fa-edit"></i> แก้ไข</a>
                                        <?php
                                        if (count_report_by_advisor($r['user_id']) > 0) {
                                        ?>
                                            <button type="button" class="btn btn-sm btn-danger" title="ไม่สามารถลบข้อมูลได้ มีการใช้งานอยู่ " disabled><i class="fas fa-trash-alt"></i> ลบ</button>
                                        <?php
                                        } else {
                                        ?>
                                            <a href="advisor_delete.php?id=<?php echo $r['user_id'] ?>" class="btn btn-sm btn-danger" title="ลบ"><i class="fas fa-trash-alt"></i> ลบ</a>
                                        <?php
                                        }
                                        ?>
                                        <a href="advisor_resetpass.php?id=<?php echo $r['user_id'] ?>" class="btn btn-sm btn-secondary" title="ตั้งรหัสผ่านใหม่"><i class="fas fa-key"></i> ตั้งรหัสผ่านใหม่</a>
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