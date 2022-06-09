<?php
$page = basename($_SERVER['PHP_SELF']);
?>
<?php
$arr_page = array(
    'workreport_manager.php', 'workreport_detail.php'
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
    <a class="nav-link" href="workreport_manager.php">
        <i class="fas fa-file-alt"></i>
        <span>รายงานการปฏิบัติหน้าที่</span></a>
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
        <span>ประวัติและรายงานสรุป</span>
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