<?php include '_footer.php'; ?>

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->
<?php
include '_topbutton.php';
include '_logoutmodal.php';
?>

<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Page level plugins -->
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="js/demo/datatables-demo.js"></script>

<!-- jquery-validation -->
<script src="vendor/jquery-validation/jquery.validate.min.js"></script>
<script src="vendor/jquery-validation/additional-methods.min.js"></script>

<!-- Select2 -->
<script src="vendor/select2/js/select2.full.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>

</body>

</html>
<script>
    $(function() {
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });
    });

    function loading() {
        swal.fire({
            title: 'กำลังประมวลผล',
            html: 'โปรดรอสักครู่',
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading()
            }
        });
    }
</script>