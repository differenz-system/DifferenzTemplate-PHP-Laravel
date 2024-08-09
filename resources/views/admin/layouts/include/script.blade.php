<!-- Mainly scripts -->
<script src="{{ asset('adminAssets/js/main/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('adminAssets/js/main/popper.min.js') }}"></script>
<script src="{{ asset('adminAssets/js/main/bootstrap.js') }}"></script>
<script src="{{ asset('adminAssets/js/main/inspinia.js') }}"></script>
<script src="{{ asset('adminAssets/js/pace/pace.min.js') }}"></script>
<script src="{{ asset('adminAssets/js/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('adminAssets/js/slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('adminAssets/js/cropImage/croppie.js') }}"></script>
<script src="{{ asset('adminAssets/js/sweetalert/sweetalert.min.js') }}"></script>

<!-- Form- Validation  -->
<script src="{{ asset('adminAssets/js/form-validation/jquery.validate.js') }}"></script>
<script src="{{ asset('adminAssets/js/form-validation/additional-methods.min.js') }}"></script>
<script src="{{ asset('adminAssets/js/form-validation/custom-form-validation.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

<script src="{{ asset('adminAssets/js/notify/bootstrap-notify.min.js') }}"></script>

<!-- DataTables JS -->
<script src="{{ asset('adminAssets/js/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('adminAssets/js/datatables/dataTables.bootstrap4.min.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
</script>
