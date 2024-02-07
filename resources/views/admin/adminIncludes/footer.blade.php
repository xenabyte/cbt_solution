
</div>
<!-- End Page-content -->

<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <script>document.write(new Date().getFullYear())</script> © {{ env('APP_NAME') }}.
            </div>
            <div class="col-sm-6">
                <div class="text-sm-end d-none d-sm-block">
                    Design & Develop by {{ env('APP_NAME') }}
                </div>
            </div>
        </div>
    </div>
</footer>
</div>
<!-- end main content-->

</div>
<!-- END layout-wrapper -->




<!--start back-to-top-->
<button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
    <i class="ri-arrow-up-line"></i>
</button>
<!--end back-to-top-->

<!--start back-to-top-->
<button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
    <i class="ri-arrow-up-line"></i>
</button>
<!--end back-to-top-->

<!-- JAVASCRIPT -->
<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
<script src="{{ asset('assets/js/plugins.js') }}"></script>

<!-- form wizard init -->
<script src="{{ asset('assets/js/pages/form-wizard.init.js') }}"></script>

<script src="{{asset('assets/jquery/jquery-3.6.0.min.js')}}"></script>

<!--datatable js-->
<script src="{{asset('assets/datatables/1.11.5/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/datatables/1.11.5/js/dataTables.bootstrap5.min.js')}}"></script>
<script src="{{asset('assets/datatables/responsive/2.2.9/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/datatables/buttons/2.2.2/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/datatables/buttons/2.2.2/js/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/datatables/buttons/2.2.2/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/cloudfare/ajax/libs/pdfmake/0.1.53/vfs_fonts.js')}}"></script>
<script src="{{asset('assets/cloudfare/ajax/libs/pdfmake/0.1.53/pdfmake.min.js')}}"></script>
<script src="{{asset('assets/cloudfare/ajax/libs/jszip/3.1.3/jszip.min.js')}}"></script>

<script src="{{asset('assets/js/pages/datatables.init.js')}}"></script>

<!-- App js -->
<script src="{{ asset('assets/js/app.js') }}"></script>

<script type="text/javascript">
    $(function() {
        $('.option').hide();
        $('#linkType').change(function(){
            $('.option').hide();
            $('#' + $(this).val()).show();
        });
    });
</script>

</body>


</html>
