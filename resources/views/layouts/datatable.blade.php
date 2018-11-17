@section('footer')

<?php $root = url('/') . '/public/' ?>
<!-- start - This is for export functionality only -->
<script src="<?= $root ?>plugins/1.2.2/js/dataTables.buttons.min.js"></script>
<script src="<?= $root ?>plugins/1.2.2/js/buttons.flash.min.js"></script>
<script src="<?= $root ?>plugins/jszip.min.js"></script>
<script src="<?= $root ?>plugins/1.2.2/js/buttons.html5.min.js"></script>
<script src="<?= $root ?>plugins/1.2.2/js/buttons.print.min.js"></script>
<script type="text/javascript">
    $('#school_region').change(function () {
        var id = $(this).val();
        window.location.href = '?region=' + id;
    });
</script>
<script type="text/javascript">
    $('.table').DataTable({
        dom: 'Bfrtip'
        , buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
</script>
@endsection