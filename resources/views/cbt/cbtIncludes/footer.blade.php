

    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <script>document.write(new Date().getFullYear())</script> © {{ env('APP_NAME') }}.
                </div>
                <div class="col-sm-6">
                    <div class="text-sm-end d-none d-sm-block">
                        Design & Develop by TAU ICT
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

<!-- JAVASCRIPT -->
<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
<script src="{{asset('assets/jquery/jquery-3.6.0.min.js')}}"></script>

{{-- <script src="{{ asset('assets/js/plugins.js') }}"></script> --}}

<!-- form wizard init -->
<script src="{{ asset('assets/js/pages/form-wizard.init.js') }}"></script>

<script src="{{ asset('assets/js/axios.min.js') }}"></script>
<script src="{{ asset('assets/js/moment.min.js') }}"></script>

<!-- App js -->
<script src="{{ asset('assets/js/app.js') }}"></script>
<script>
    $(document).ready(function() {
      $("#submit-button").click(function() {
        // Disable the button
        $(this.form).submit();

        $(this).prop("disabled", true);
    
        // Remove the text
        $(this).text("");
    
        // Replace the text with a spinner
        $(this).html("<i class='fa fa-spinner fa-spin'></i>");
      });
    });
</script>
</body>

</html>