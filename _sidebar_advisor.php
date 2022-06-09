<?php
$page = basename($_SERVER['PHP_SELF']);
?>
<?php
$arr_page = array(
    'workreport.php', 'workreport_add.php', 'workreport_detail.php'
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
    <a class="nav-link" href="workreport.php">
        <i class="fas fa-file-alt"></i>
        <span>รายงานการปฏิบัติหน้าที่</span></a>
</li>