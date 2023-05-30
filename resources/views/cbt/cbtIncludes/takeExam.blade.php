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
                                <div class="ribbon ribbon-primary round-shape">{{ $examination->code }}</div>
                                <h5 class="fs-14 text-end">{{ $examination->title }}</h5>
                                <hr>
                                <div class="ribbon-content mt-5 text-muted">
                                    <h5 class="fs-14">Assessment Instruction</h5>

                                    <div class="card-body pt-0">
                                        <div class="mini-stats-wid d-flex align-items-center mt-3">
                                            Total Questions
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1"></h6>
                                            </div>
                                            <div class="form-check form-switch">
                                                {{ $examination->question_number }} questions
                                            </div>
                                        </div>
    
                                        <div class="mini-stats-wid d-flex align-items-center mt-3">
                                        Assessment Duration
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1"></h6>
                                            </div>
                                            <div class="form-check form-switch">
                                                {{ $examination->duration }} minutes
                                            </div>
                                        </div>
    
                                        <hr>
                                        <form action="{{ url('/cbt/startExam') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="examination_id" value="{{$examination->id}}" />
                                            <input type="hidden" name="candidate_id" value="{{$candidate->id}}" />

                                            <button type="submit" class="btn btn-success">Start Exam</button>
                                        </form>
                                     </div><!-- end cardbody -->
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