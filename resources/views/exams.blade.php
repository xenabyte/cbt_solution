@include('cbt.cbtIncludes.header')
<?php $user = Auth::guard('student')->user() ?>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <div class="row mt-5">
                    <div class="col-xxl-3">
                    </div> <!-- end col-->

                    <div class="col-xxl-6">
                        <div class="row justify-content-center">
                            <div class="col-lg-12 mt-5">
                                <div class="card-body text-center">
                                    <div class="avatar-md mb-3 mx-auto">
                                        <img src="{{asset('assets/images/users/user.png')}}" alt="" id="candidate-img" class="img-thumbnail rounded-circle shadow-none">
                                    </div>
            
                                    <h5 id="candidate-name" class="mb-0">{{ $user->firstname .' '. $user->lastname }}</h5>
                                    <p id="candidate-position" class="text-muted">{{ $user->email }}</p>
                                </div>
                            </div>
                            <div class="col-md-12 mt-2">
                                <!-- Rounded Ribbon -->
                                <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body">
                                        <div class="ribbon ribbon-primary round-shape">Active Assessments</div>
                                        <h5 class="fs-14 text-end">Your Active Assessments</h5>
                                        <hr>
                                        <div class="ribbon-content mt-5 text-muted">
                                        @if($candidates->count() > 0)
                                            <div class="table-responsive">
                                                <table class="table table-nowrap align-middle justify-content-center mb-0">
                                                    <tbody>

                                                            @foreach($candidates as $candidate)
                                                               <tr>
                                                                    <td>
                                                                        {{ ucwords($candidate->examination->title) }} ({{ $candidate->examination->code }})
                                                                    </td>
                                                                    @if($candidate->examination->status == 'Active')
                                                                        <td class="text-end">
                                                                            <a href="{{ url('cbt/takeExam/'.$candidate->examination->slug)  }}" class="btn btn-primary btn-sm">Take Assessment</a>
                                                                        </td>
                                                                    @else
                                                                        <td class="text-end">
                                                                            <a style="display:block; margin-top: 10px" class="btn btn-primary btn-sm">Assessment is not active, contact adminstrator</a> <br/>
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                            @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            @else
                                            <div class="card-body text-center">
                                                <div class="avatar-sm mx-auto mb-3">
                                                    <div class="avatar-title bg-soft-danger text-danger fs-17 rounded">
                                                        <i class=" ri-close-circle-line"></i>
                                                    </div>
                                                </div>
                                                <h4 class="card-title">No active assessment</h4>
                                                <p class="card-text text-muted">If you are sure to write exam, kindly inform the administrator.</p>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- end col -->
                    <div class="col-xxl-3">
                    </div> <!-- end col-->
                </div> <!-- end row-->
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
@include('cbt.cbtIncludes.footer')