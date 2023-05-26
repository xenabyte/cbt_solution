@include('admin.adminIncludes.header')

<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ Auth::guard('admin')->user()->name }}'s Dashboard</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-xl-4 col-md-6">
                    <div class="card  bg-success card-height-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-info text-white rounded-2 fs-2 shadow">
                                        <i class="bx bxs-user-account"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="text-uppercase fw-medium text-white-50 mb-3">Unique Visitor(s)</p>
                                    <h4 class="fs-4 mb-3 text-white"><span class="counter-value" data-target="30">30</span></h4>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div>
                </div> <!-- end col-->

                <div class="col-xl-4 col-md-6">
                    <div class="card card-height-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-warning text-white rounded-2 fs-2 shadow">
                                        <i class="bx bxs-user-account"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="text-uppercase fw-medium text-muted mb-3">Newsletters</p>
                                    <h4 class="fs-4 mb-3"><span class="counter-value" data-target="30">30</span></h4>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div>
                </div> <!-- end col-->

                <div class="col-xl-4 col-md-6">
                    <div class="card card-height-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-success text-white rounded-2 fs-2 shadow">
                                        <i class="bx bxs-user-account"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="text-uppercase fw-medium text-muted mb-3">Faculties</p>
                                    <h4 class="fs-4 mb-3"><span class="counter-value" data-target="30">30</span></h4>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div>
                </div> <!-- end col-->
            </div> <!-- end row-->

                <hr>
            <div class="row">
                
            </div>
            <!-- end row -->

@include('admin.adminIncludes.footer')