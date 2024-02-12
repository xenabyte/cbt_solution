<div class="page-content">
    <div class="container-fluid">

        <div class="row mt-5">
            <div class="col-xxl-3">
                <div class="row justify-content-center">
                    <div class="col-lg-12 mt-5">
                        <div class="card card-body text-center">
                            <div class="avatar-md mb-3 mx-auto">
                                <img src="{{asset('assets/images/users/user.png')}}" alt="" id="candidate-img" class="img-thumbnail rounded-circle shadow-none">
                            </div>
    
                            <h5 id="candidate-name" class="mb-0">{{ $user->firstname .' '. $user->lastname }}</h5>
                            <p id="candidate-position" class="text-muted">{{ $user->email }}</p>
                        </div>
                    </div>
                </div>
            </div> <!-- end col-->

            <div class="col-xxl-6">
                <div class="row justify-content-center">
                    <div class="col-md-12 mt-5">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">{{ $examination->title }}</h4>
                            </div><!-- end card header -->
                            <div class="card-body">
                                <form action="#" class="form-steps" autocomplete="off">
                                    <div class="step-arrow-nav mb-4">
                                        <ul class="nav nav-pills custom-nav nav-justified" role="tablist">
                                            @foreach($candidateQuestions as $candidateQuestion)
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link @if($loop->iteration == 1) active @endif" id="question{{$loop->iteration}}" data-bs-toggle="pill" data-bs-target="#question{{$loop->iteration}}-tab" type="button" role="tab" aria-controls="question{{$loop->iteration}}-tab" aria-selected="true">{{ $loop->iteration }}</button>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                    <div class="tab-content mt-5">
                                        @foreach($candidateQuestions as $candidateQuestion)
                                        <div class="tab-pane fade @if($loop->iteration == 1) show active @endif" id="question{{$loop->iteration}}-tab" role="tabpanel" aria-labelledby="question{{$loop->iteration}}">
                                            <div>
                                                <div class="row">
                                                    <div class="col-lg-12 mb-5">
                                                        <div class="mb-3">
                                                            <h5>Question {{ $loop->iteration }}: {!! $candidateQuestion->question->text !!}</h5>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        @foreach($candidateQuestion->question->options as $option)
                                                        <!-- Base Radios -->
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="radio" name="option{{ $candidateQuestion->question->id }}" id="option{{ $option->id }}" value="{{ $option->id }}" onchange="selectOption(this.value, {{$candidateQuestion->id}})" {{ $option->id == $candidateQuestion->candidate_option ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="option{{ $option->id }}">
                                                                {{ $option->option_text }}
                                                            </label>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                        
                                            </div>
                                            <div class="d-flex align-items-start gap-3 mt-4">
                                                @if($loop->iteration > 1)<button type="button" class="btn btn-light btn-label previestab" data-previous="question{{ $loop->iteration - 1 }}"><i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Previous</button>@endif
                                                @if($loop->last)
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#cbtSubmit{{$examination->id}}" class="btn btn-success btn-block btn-label right ms-auto nexttab nexttab"><i class="ri-checkbox-circle-fill label-icon align-middle fs-16 ms-2"></i>Submit</button>
                                                @else
                                                    <button type="button" class="btn btn-primary btn-label right ms-auto previestab" data-previous="question{{ $loop->iteration + 1 }}"><i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Next</button>
                                                @endif
                                        </div>
                                        @endforeach
                                    </div>
                                    <!-- end tab content -->
                                </form>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div><!-- end row -->
                </div>
            </div><!-- end col -->
            <div class="col-xxl-3">
                <div class="row justify-content-center">
                    <div class="col-md-12 mt-5">
                        <div class="card card-body">
                            <h5 class="fs-14">Assessment Instruction</h5>
                            <div class="mini-stats-wid d-flex align-items-center mt-3">
                                Total Questions
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1"></h6>
                                </div>
                                <div class="form-check form-switch">
                                    {{ $candidateQuestions->count() }} questions
                                </div>
                            </div>

                            <div class="mini-stats-wid d-flex align-items-center mt-3">
                                Answered Questions
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1"></h6>
                                </div>
                                <div class="form-check form-switch">
                                        <span class="text-warning" id="answeredQuestions">{{ $candidateQuestions->where("candidate_option", "!=", null)->count() }}</span> of {{ $candidateQuestions->count() }} questions
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

                            <button type="button" data-bs-toggle="modal" data-bs-target="#cbtSubmit{{$examination->id}}" class="btn btn-success btn-block btn-label right ms-auto nexttab nexttab"><i class="ri-checkbox-circle-fill label-icon align-middle fs-16 ms-2"></i>Submit</button>

                        </div><!-- end cardbody -->
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="card card-body">
                            <h5 class="fs-14 mb-2">Assessment Timer</h5>
                            <br>
                            <h5 id="demo"></h5>
                        </div>
                    </div>
                </div>
            </div> <!-- end col-->
        </div> <!-- end row-->
    </div>
    <!-- container-fluid -->
</div>
<!-- End Page-content -->
<div id="cbtSubmit{{$examination->id}}" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-5">
                <div class="text-end">
                    <button type="button" class="btn-close text-end" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="mt-2">
                    <lord-icon src="https://cdn.lordicon.com/tqywkdcz.json" trigger="hover" style="width:150px;height:150px">
                    </lord-icon>
                    <h4 class="mb-3 mt-4">Are you sure you want to submit assessment?</h4>
                    <form action="{{ url('/cbt/submitExam') }}" method="POST">
                        @csrf
                        <input name="examinationId" type="hidden" value="{{$examination->id}}">
                        <input name="candidateId" type="hidden" value="{{$candidate->id}}">
                        <button type="submit" class="btn btn-success w-100">Yes, Submit</button>
                    </form>
                </div>
            </div>
            <div class="modal-footer bg-light p-3 justify-content-center">

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
    // Variable to store the selected option
    var selectedOption = null;
    var mainQuestionId = null;


    function saveSelectedOption() {
        // Save the selected option to the server
        axios.post('/cbt/saveOption', {
            optionId: selectedOption,
            questionId: mainQuestionId
        })
        .then(function (response) {
            // Successful response handling if needed
            document.getElementById('answeredQuestions').innerHTML = response.data;
        })
        .catch(function (error) {
            console.log(error);
        });
    }

    function selectOption(optionId, questionId) {
        // Update the selected option variable
        selectedOption = optionId;
        mainQuestionId = questionId;

        saveSelectedOption()
    }

</script>
<script>
    var candidateId = '{{ $candidate->candidate_id }}';
    var examinationId = '{{ $examination->id }}';

    var endTimeString = '{{ $candidate->exam_end_at }}';
    
    // Convert end time string to a JavaScript Date object
    var countDownDate = new Date(endTimeString).getTime();


    // Update the count down every 1 second
    var x = setInterval(function() {
        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Display the result in the element with id="demo"
        document.getElementById("demo").innerHTML = days + "d " + hours + "h "
        + minutes + "m " + seconds + "s ";

        // If the count down is finished, write some text
        if (distance < 0) {
            clearInterval(x);
            console.log(distance);
            // Call a function to submit the exam
            submitExam();
        }
    }, 1000);

    function submitExam() {
        axios.post('/cbt/forceSubmit', {
            candidateId: candidateId,
            examinationId: examinationId
        })
        .then(function (response) {
            // Successful response handling if needed
            redirectToURL("{{ env('APP_URL') }}");
        })
        .catch(function (error) {
            console.log(error);
        });
    }

    function redirectToURL(url) {
        window.location.href = url;
    }


</script>