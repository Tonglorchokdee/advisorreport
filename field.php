<?php
require_once 'config/sessionname.php';
session_start();
require_once 'config/coreconfig.php';
require_once 'config/connectdb.php';
require_once 'lib/function.php';

checklogin();

$sql = 'SELECT * FROM tb_field';
$rs = mysqli_query($con, $sql);

$titlepage = 'จัดการสาขาวิชา';
include '_headweb.php';
?>

<!-- Main Content -->
<div id="content">

    <?php include '_topbar.php'; ?>

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">จัดการสาขาวิชา</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">จัดการสาขาวิชา</h6>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col">
                        <p>
                            <a href="field_add.php" class="btn btn-primary" title="เพิ่มสาขาวิชา"><i class="fas fa-plus"></i> เพิ่มสาขาวิชา</a>
                        </p>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr class="text-center">
                                <th>สาขาวิชา</th>
                                <th>จำนวนอาจารย์</th>
                                <th>จำนวนหมู่เรียน</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($r = mysqli_fetch_array($rs)) {
                            ?>
                                <tr>
                                    <td class="text-left"><?php echo $r['field_name']; ?></td>
                                    <td class="text-center">
                                        <?php
                                        $count_advisor = count_advisor_by_field($r['field_id']);
                                        echo $count_advisor;
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        $count_groupstu = count_groupstu_by_field($r['field_id']);
                                        echo $count_groupstu;
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="field_detail.php?id=<?php echo $r['field_id'] ?>" class="btn btn-sm btn-info" title="รายละเอียด"><i class="fas fa-file-alt"></i> รายละเอียด</a>
                                        <a href="field_edit.php?id=<?php echo $r['field_id'] ?>" class="btn btn-sm btn-warning" title="แก้ไข"><i class="fas fa-edit"></i> แก้ไข</a>
                                        <?php
                                        if ($count_groupstu > 0 || $count_advisor > 0) {
                                        ?>
                                            <button type="button" class="btn btn-sm btn-danger" title="ไม่สามารถลบข้อมูลได้ มีการใช้งานอยู่ " disabled><i class="fas fa-trash-alt"></i> ลบ</button>
                                        <?php
                                        } else {
                                        ?>
                                            <a href="field_delete.php?id=<?php echo $r['field_id'] ?>" class="btn btn-sm btn-danger" title="ลบ"><i class="fas fa-trash-alt"></i> ลบ</a>
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