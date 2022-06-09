<?php
require_once 'config/sessionname.php';
session_start();
require_once 'config/coreconfig.php';
require_once 'config/connectdb.php';
require_once 'lib/function.php';

checklogin();

$sql = 'SELECT * FROM tb_timereport';
$rs = mysqli_query($con, $sql);

$titlepage = 'จัดการช่วงเวลา';
include '_headweb.php';
?>

<!-- Main Content -->
<div id="content">

    <?php include '_topbar.php'; ?>

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">จัดการช่วงเวลา</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">จัดการช่วงเวลา</h6>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col">
                        <p>
                            <a href="timereport_add.php" class="btn btn-primary" title="เพิ่มสาขาวิชา"><i class="fas fa-plus"></i> เพิ่มช่วงเวลา</a>
                        </p>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr class="text-center">
                                <th>เทอม/ปีการศึกษา</th>
                                <th>ช่วงเดือน</th>
                                <th>ช่วงเวลา</th>
                                <th>สถานะ</th>
                                <th>จำนวนรายงาน</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($r = mysqli_fetch_array($rs)) {
                            ?>
                                <tr>
                                    <td class="text-center"><?php echo $r['timereport_term'].'/'.$r['timereport_year']; ?></td>
                                    <td class="text-center"><?php echo $r['timereport_start_month'] .' - '.$r['timereport_end_month']; ?></td>
                                    <td class="text-center"><?php echo $r['timereport_name']; ?></td>
                                    <td class="text-center"><?php echo getTimereportStatus($r['timereport_status']); ?></td>
                                    <td class="text-center">
                                        <?php
                                        $count_report = count_report_by_timereport($r['timereport_id']);
                                        echo $count_report;
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="timereport_detail.php?id=<?php echo $r['timereport_id'] ?>" class="btn btn-sm btn-info" title="รายละเอียด"><i class="fas fa-file-alt"></i> รายละเอียด</a>
                                        <a href="timereport_edit.php?id=<?php echo $r['timereport_id'] ?>" class="btn btn-sm btn-warning" title="แก้ไข"><i class="fas fa-edit"></i> แก้ไข</a>
                                        <?php
                                        if ($count_report > 0) {
                                        ?>
                                            <button type="button" class="btn btn-sm btn-danger" title="ไม่สามารถลบข้อมูลได้ มีการใช้งานอยู่ " disabled><i class="fas fa-trash-alt"></i> ลบ</button>
                                        <?php
                                        } else {
                                        ?>
                                            <a href="timereport_delete.php?id=<?php echo $r['timereport_id'] ?>" class="btn btn-sm btn-danger" title="ลบ"><i class="fas fa-trash-alt"></i> ลบ</a>
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