<?php
require_once 'config/sessionname.php';
session_start();
require_once 'config/coreconfig.php';
require_once 'config/connectdb.php';
require_once 'lib/function.php';

checklogin();

$sql = 'SELECT * FROM tb_groupstu, tb_field WHERE tb_groupstu.field_id = tb_field.field_id';
$rs = mysqli_query($con, $sql);

$titlepage = 'จัดการหมู่เรียน';
include '_headweb.php';
?>

<!-- Main Content -->
<div id="content">

    <?php include '_topbar.php'; ?>

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">จัดการหมู่เรียน</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">จัดการหมู่เรียน</h6>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col">
                        <p>
                            <a href="groupstu_add.php" class="btn btn-primary" title="เพิ่มหมู่เรียน"><i class="fas fa-plus"></i> เพิ่มหมู่เรียน</a>
                        </p>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr class="text-center">
                                <th>หมู่เรียน</th>
                                <th>สาขาวิชา</th>
                                <th>อาจารย์</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($r = mysqli_fetch_array($rs)) {
                            ?>
                                <tr>
                                    <td class="text-center"><?php echo $r['groupstu_name']; ?></td>
                                    <td class="text-center"><?php echo $r['field_name']; ?></td>
                                    <td class="text-center"><?php echo getFullnameById($r['user_id']); ?></td>
                                    <td class="text-center">
                                        <a href="groupstu_detail.php?id=<?php echo $r['groupstu_id'] ?>" class="btn btn-sm btn-info" title="รายละเอียด"><i class="fas fa-file-alt"></i> รายละเอียด</a>
                                        <a href="groupstu_edit.php?id=<?php echo $r['groupstu_id'] ?>" class="btn btn-sm btn-warning" title="แก้ไข"><i class="fas fa-edit"></i> แก้ไข</a>
                                        <?php

                                        if (count_report_by_groupstu($r['groupstu_id']) > 0) {
                                        ?>
                                            <button type="button" class="btn btn-sm btn-danger" title="ไม่สามารถลบข้อมูลได้ มีการใช้งานอยู่ " disabled><i class="fas fa-trash-alt"></i> ลบ</button>
                                        <?php
                                        } else {
                                        ?>
                                            <a href="groupstu_delete.php?id=<?php echo $r['groupstu_id'] ?>" class="btn btn-sm btn-danger" title="ลบ"><i class="fas fa-trash-alt"></i> ลบ</a>
                                        <?php
                                        }
                                        ?>
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