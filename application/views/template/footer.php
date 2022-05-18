<footer class="main-footer">
    <strong>Copyright &copy; <?= date("Y") ?> <?= $author ?></strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> <a href="<?= base_url() ?>"> <?= VERSION ?> </a>
    </div>
</footer>
</div>

<aside class="control-sidebar control-sidebar-dark">
</aside>
<script src="<?= lte("plugins/jquery-ui/jquery-ui.min.js") ?>"></script>
<script src="<?= lte("plugins/sweetalert2/sweetalert2.min.js") ?>"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="<?= lte("plugins/bootstrap/js/bootstrap.bundle.min.js") ?>"></script>
<script src="<?= lte("plugins/select2/js/select2.full.min.js") ?>"></script>
<script src="<?= lte("plugins/chart.js/Chart.min.js") ?>"></script>
<script src="<?= lte("plugins/sparklines/sparkline.js") ?>"></script>
<script src="<?= lte("plugins/jqvmap/jquery.vmap.min.js") ?>"></script>
<script src="<?= lte("plugins/jqvmap/maps/jquery.vmap.usa.js") ?>"></script>
<script src="<?= lte("plugins/jquery-knob/jquery.knob.min.js") ?>"></script>
<script src="<?= lte("plugins/moment/moment.min.js") ?>"></script>
<script src="<?= lte("plugins/daterangepicker/daterangepicker.js") ?>"></script>
<script src="<?= lte("plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js") ?>"></script>
<script src="<?= lte("plugins/summernote/summernote-bs4.min.js") ?>"></script>
<script src="<?= lte("plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js") ?>"></script>
<script src="<?= lte("dist/js/adminlte.js") ?>"></script>
<script src="<?= lte("dist/js/demo.js") ?>"></script>

<script>
    $(function() {
        $('.select2').select2()
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    })

    function validate(element) {
        element.value = element.value.replace(/[^0-9.]/, '');
    };
</script>
</div>
</body>

</html>