<?php
require_once 'config/sessionname.php';
session_start();
require_once 'config/coreconfig.php';
require_once 'config/connectdb.php';
require_once 'lib/function.php';

checklogin();

$sql = 'SELECT * FROM tb_user, tb_role 
        WHERE 
            tb_role.role_id = tb_user.role_id 
        AND 
            tb_role.role_id IN (1, 3)';
$rs = mysqli_query($con, $sql);

$titlepage = 'เจ้าหน้าที่/ผู้บริหาร';
include '_headweb.php';
?>

<!-- Main Content -->
<div id="content">

    <?php include '_topbar.php'; ?>

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">เจ้าหน้าที่/ผู้บริหาร</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">เจ้าหน้าที่/ผู้บริหาร</h6>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col">
                        <p>
                            <a href="user_add.php" class="btn btn-primary" title="เพิ่มเจ้าหน้าที่/ผู้บริหาร"><i class="fas fa-plus"></i> เพิ่มเจ้าหน้าที่/ผู้บริหาร</a>
                        </p>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr class="text-center">
                                <th>ชื่อผู้ใช้</th>
                                <th>ชื่อ-นามสกุล</th>
                                <th>ตำแหน่ง</th>
                                <th>เบอร์ติดต่อ</th>
                                <th>ประเภทผู้ใช้</th>
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
                                    <td class="text-center"><?php echo $r['user_position']; ?></td>
                                    <td class="text-center"><?php echo $r['user_tel']; ?></td>
                                    <td class="text-center"><?php echo $r['role_name']; ?></td>
                                    <td class="text-center">
                                        <a href="user_detail.php?id=<?php echo $r['user_id'] ?>" class="btn btn-sm btn-info" title="รายละเอียด"><i class="fas fa-file-alt"></i> รายละเอียด</a>
                                        <a href="user_edit.php?id=<?php echo $r['user_id'] ?>" class="btn btn-sm btn-warning" title="แก้ไข"><i class="fas fa-edit"></i> แก้ไข</a>
                                        <a href="user_delete.php?id=<?php echo $r['user_id'] ?>" class="btn btn-sm btn-danger" title="ลบ"><i class="fas fa-trash-alt"></i> ลบ</a>
                                        <a href="user_resetpass.php?id=<?php echo $r['user_id'] ?>" class="btn btn-sm btn-secondary" title="ตั้งรหัสผ่านใหม่"><i class="fas fa-key"></i> ตั้งรหัสผ่านใหม่</a>
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