<?php
$page = basename($_SERVER['PHP_SELF']);

$arr_page = array(
    'user.php', 'user_add.php', 'user_edit.php', 'user_delete.php', 'user_detail.php', 'user_resetpass.php',
    'advisor.php', 'advisor_add.php', 'advisor_edit.php', 'advisor_delete.php', 'advisor_detail.php', 'advisor_resetpass.php'
);
if (in_array($page, $arr_page)) {
    $active = 'active';
    $show = 'show';
} else {
    $active = '';
    $show = '';
}
?>
<li class="nav-item <?php echo $active; ?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#user" aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-fw fa-users"></i>
        <span>จัดการผู้ใช้ระบบ</span>
    </a>
    <div id="user" class="collapse <?php echo $show; ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">ข้อมูลผู้ใช้ระบบ :</h6>
            <?php
            $arr_page = array(
                'user.php', 'user_add.php', 'user_edit.php', 'user_delete.php', 'user_detail.php', 'user_resetpass.php',
            );
            if (in_array($page, $arr_page)) {
                $active = 'active';
            } else {
                $active = '';
            }
            ?>
            <a class="collapse-item <?php echo $active; ?>" href="user.php">เจ้าหน้าที่/ผู้บริหาร</a>
            <?php
            $arr_page = array(
                'advisor.php', 'advisor_add.php', 'advisor_edit.php', 'advisor_delete.php', 'advisor_detail.php', 'advisor_resetpass.php'
            );
            if (in_array($page, $arr_page)) {
                $active = 'active';
            } else {
                $active = '';
            }
            ?>
            <a class="collapse-item <?php echo $active; ?>" href="advisor.php">อาจารย์</a>
        </div>
    </div>
</li>
<?php
$arr_page = array(
    'field.php', 'field_add.php', 'field_edit.php', 'field_delete.php', 'field_detail.php'
);
if (in_array($page, $arr_page)) {
    $active = 'active';
    $show = 'show';
} else {
    $active = '';
    $show = '';
}
?>
<li class="nav-item <?php echo $active; ?>">
    <a class="nav-link" href="field.php">
        <i class="fas fa-fw fa-folder"></i>
        <span>จัดการสาขาวิชา</span></a>
</li>
<?php
$arr_page = array(
    'groupstu.php', 'groupstu_add.php', 'groupstu_edit.php', 'groupstu_delete.php', 'groupstu_detail.php'
);
if (in_array($page, $arr_page)) {
    $active = 'active';
    $show = 'show';
} else {
    $active = '';
    $show = '';
}
?>
<li class="nav-item <?php echo $active; ?>">
    <a class="nav-link" href="groupstu.php">
        <i class="fas fa-fw fa-file-alt"></i>
        <span>จัดการหมู่เรียน</span></a>
</li>
<?php
$arr_page = array(
    'timereport.php', 'timereport_add.php', 'timereport_edit.php', 'timereport_delete.php', 'timereport_detail.php'
);
if (in_array($page, $arr_page)) {
    $active = 'active';
    $show = 'show';
} else {
    $active = '';
    $show = '';
}
?>
<li class="nav-item <?php echo $active; ?>">
    <a class="nav-link" href="timereport.php">
        <i class="fas fa-calendar-alt"></i>
        <span>จัดการช่วงเวลา</span></a>
</li>
<?php
$arr_page = array(
    'workreport_history.php', 'workreport_sum.php'
);
if (in_array($page, $arr_page)) {
    $active = 'active';
    $show = 'show';
} else {
    $active = '';
    $show = '';
}
?>
<li class="nav-item <?php echo $active; ?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#report" aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-fw fa-copy"></i>
        <span>รายงานปฏิบัติหน้าที่</span>
    </a>
    <div id="report" class="collapse <?php echo $show; ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">รายงานปฏิบัติหน้าที่ :</h6>
            <?php
            $arr_page = array(
                'workreport_history.php'
            );
            if (in_array($page, $arr_page)) {
                $active = 'active';
                $show = 'show';
            } else {
                $active = '';
                $show = '';
            }
            ?>
            <a class="collapse-item <?php echo $active; ?>" href="workreport_history.php">ประวัติรายงาน</a>
            <?php
            $arr_page = array(
                'workreport_sum.php'
            );
            if (in_array($page, $arr_page)) {
                $active = 'active';
            } else {
                $active = '';
            }
            ?>
            <a class="collapse-item <?php echo $active; ?>" href="workreport_sum.php">รายงานสรุป</a>
        </div>
    </div>
</li>