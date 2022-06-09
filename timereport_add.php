<?php
require_once 'config/sessionname.php';
session_start();
require_once 'config/coreconfig.php';
require_once 'config/connectdb.php';
require_once 'lib/function.php';

checkadminlogin();

$titlepage = 'เพิ่มช่วงเวลา';
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
                <h6 class="m-0 font-weight-bold">เพิ่มช่วงเวลา</h6>
            </div>
            <div class="card-body">

                <div class="row justify-content-md-center">
                    <div class="col-md-10">
                        <form action="" method="post" id="frmTimeReport">
                            <input type="hidden" name="action" id="action" value="add">

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>เทอม</label>
                                        <input type="number" class="form-control" placeholder="เทอม" name="timereport_term" id="timereport_term" title="เทอม" maxlength="1" min="1">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>ปีการศึกษา</label>
                                        <input type="number" class="form-control" placeholder="ปีการศึกษา" name="timereport_year" id="timereport_year" title="ปีการศึกษา" maxlength="4" min="2500">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>ช่วงเวลา</label>
                                        <input type="text" class="form-control" placeholder="ช่วงเวลา" name="timereport_name" id="timereport_name" title="ช่วงเวลา">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>ตั้งแต่เดือน</label>
                                        <select class="form-control select2bs4" style="width: 100%;" name="start_month" id="start_month" title="เดือน">
                                            <?php
                                            list_month();
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <select class="form-control select2bs4" style="width: 100%;" name="start_year" id="start_year" title="ปี">
                                            <?php
                                            list_year();
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>ถึงเดือน</label>
                                        <select class="form-control select2bs4" style="width: 100%;" name="end_month" id="end_month" title="เดือน">
                                            <?php
                                            list_month();
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <select class="form-control select2bs4" style="width: 100%;" name="end_year" id="end_year" title="ปี">
                                            <?php
                                            list_year();
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="row justify-content-md-center">
                                <div class="col text-center">
                                    <button type="submit" name="submit" id="submit" class="btn btn-primary"><i class="fas fa-save"></i> บันทึก</button>
                                    <button type="reset" name="reset" id="reset" class="btn btn-danger"><i class="fas fa-ban"></i> ยกเลิก</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
            <div class="card-footer">
                <a href="timereport.php" class="btn btn-primary"><i class="fas fa-chevron-left"></i> ย้อนกลับ</a>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<?php
include '_footweb.php';
?>

<script>
    $(function() {
        $('#frmTimeReport').validate({
            rules: {
                timereport_term: {
                    required: true,
                    number: true
                },
                timereport_year: {
                    required: true,
                    number: true
                },
                start_month: {
                    required: true
                },
                start_year: {
                    required: true
                },
                end_month: {
                    required: true
                },
                end_year: {
                    required: true
                }, 
                timereport_name: {
                    required: true
                },
            },
            messages: {
                timereport_term: {
                    required: "กรอกเทอม",
                    number: 'เป็นตัวเลขเท่านั้น'
                },
                timereport_year: {
                    required: 'กรอกปีการศึกษา',
                    number: 'เป็นตัวเลขเท่านั้น'
                },
                start_month: {
                    required: 'เลือกเดือน'
                },
                start_year: {
                    required: 'เลือกปี'
                },
                end_month: {
                    required: 'เลือกเดือน'
                },
                end_year: {
                    required: 'เลือกปี'
                },
                timereport_name: {
                    required: 'กรอกช่วงเวลา'
                },
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function(form) {
                event.preventDefault();
                var formData = $('#frmTimeReport').serialize();

                loading();
                $.ajax({
                    type: 'POST',
                    url: 'timereport_save.php',
                    dataType: 'json',
                    encode: true,
                    data: formData,
                    success: function(data) {
                        Swal.close();
                        if (data.success == '1') {
                            $("#frmTimeReport :input").prop("disabled", true);
                            Swal.fire(data.msg, '', 'success').then(function() {
                                window.location.href = 'timereport.php'
                            });
                        } else {
                            Swal.fire('ข้อผิดพลาด', data.msg, 'error');
                        }
                    },
                    error: function(e) {
                        console.log("ERROR : ", e);
                    }
                });
            }
        });
    });
</script>