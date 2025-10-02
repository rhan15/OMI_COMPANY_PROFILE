<footer class="main-footer">
    <strong>Copyright &copy; 2020 <a href="#">CMS-OMI</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0
    </div>
</footer>

@if(session()->has('invalid_role_msg'))
    <script>
        $(function invalid_role_msg() {
            var invalid_role_msg = <?php echo json_encode( session('invalid_role_msg') ); ?>;
            toastr["error"](invalid_role_msg);
        });
    </script>
@endif

@if(session()->has('success_role_msg'))
    <script>
        $(function success_role_msg() {
            var success_role_msg = <?php echo json_encode( session('success_role_msg') ); ?>;
            toastr["success"](success_role_msg);
        });
    </script>
@endif
