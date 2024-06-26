@include('admin.adminIncludes.header')
<style>
	select{
		font-family: fontAwesome
	}
</style>

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
                                <li class="breadcrumb-item active">{{ $examination->title }}</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row project-wrapper">
                <div class="col-xxl-12">
                    <div class="row">
                        <div class="col-xl-7">
                            <div class="card card-height-100">
                                <div class="card-header border-0 align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Examination Overview - {{ $examination->title }}</h4>
                                    <div class="flex-shrink-0">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editExamination">Update Examination</button>
                                    </div>
                                </div><!-- end card header -->

                                <div class="card-header p-0 border-0 bg-soft-light">
                                    <div class="row g-0 text-center">
                                        <div class="col-6 col-sm-3">
                                            <div class="p-3 border border-dashed border-start-0">

                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-6 col-sm-3">
                                            <div class="p-3 border border-dashed border-start-0">

                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-6 col-sm-3">
                                            <div class="p-3 border border-dashed border-start-0">

                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-6 col-sm-3">
                                            <div class="p-3 border border-dashed border-start-0 border-end-0">

                                            </div>
                                        </div>
                                        <!--end col-->
                                    </div>
                                </div><!-- end card header -->
                                <div class="card-body">
                                    <hr>
                                    {!! $examination->description !!}
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->
                        <div class="col-xl-5">
                            <div class="card card-height-100">
                                <div class="card-header border-0 align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Examination Information
                                        @if($examination->status == 'Active') 
                                            <button type="button" class="btn btn-primary position-relative">{{ $examination->status }}</button>
                                        @endif
                                        @if($examination->status == 'Inactive') 
                                            <button type="button" class="btn btn-warning position-relative">{{ $examination->status }}</button>
                                        @endif
                                        @if($examination->status == 'Start') 
                                            <button type="button" class="btn btn-success position-relative">{{ $examination->status }}</button>
                                        @endif
                                        @if($examination->status == 'End') 
                                            <button type="button" class="btn btn-danger position-relative">{{ $examination->status }}</button>
                                        @endif
                                    </h4>

                                    @if(empty(Auth::guard('admin')->user()->role))
                                    <div class="flex-shrink-0">
                                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#examStatus">Update Exam Status</button>
                                    </div>
                                    @endif
                                </div><!-- end cardheader -->
                                <div class="card-body pt-0">
                                   <hr>

                                    <div class="mini-stats-wid d-flex align-items-center mt-3">
                                       Examination Duration
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1"></h6>
                                        </div>
                                        <div class="form-check form-switch">
                                            {{ $examination->duration }} minutes
                                        </div>
                                    </div>

                                    <div class="mini-stats-wid d-flex align-items-center mt-3">
                                        Enrolled Candidates
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1"></h6>
                                        </div>
                                        <div class="form-check form-switch">
                                            {{ $examination->candidates->count() }} candidates
                                        </div>
                                    </div><!-- end -->
                                    
                                </div><!-- end cardbody -->
                            </div><!-- end card -->
                        </div>
                    </div><!-- end row -->
                </div><!-- end col -->
            </div><!-- end row -->


             <div class="row">
                <div class="col-xxl-12 col-lg-12">
                    <div class="card card-height-100">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Examination Candidates</h4>
                            <div class="flex-shrink-0">
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#clearCandidates">Clear Candidates</button>
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#bulkUpload">Bulk Upload Candidate</button>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#generateCandidateQuestions">Generate Candidate Questions</button>
                            </div>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <table id="buttons-datatables" class="table table-borderedless dt-responsive nowrap table-striped align-middle" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">Id</th>
                                        <th scope="col">Firstname</th>
                                        <th scope="col">Lastname</th>
                                        <th scope="col">Matric Number</th>
                                        <th scope="col">Registration Number</th>
                                        <th scope="col">Enrolled Subject(s)</th>
                                        <th scope="col">Result</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($examination->candidates as $candidate)
                                    @php
                                        $candidateSubjects = \App\Models\CandidateExamSubject::with('subject')->where('examination_id', $examination->id)->where('candidate_id', $candidate->id)->get();    
                                    @endphp
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $candidate->student->firstname }} </td>
                                        <td>{{ $candidate->student->lastname }} </td>
                                        <td>{{ $candidate->student->matric_number }} </td>
                                        <td>{{ $candidate->student->reg_number }} </td>
                                        <td>
                                            @foreach($candidateSubjects as $candidateSubject) <li> {{ $candidateSubject->subject->subject}}  -   {{ $candidateSubject->student_score}}</li>@endforeach
                                        </td>
                                        <td>{{ $candidate->result }} </td>
                                        <td>
                                            <div class="hstack gap-3 fs-15">
                                                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#deleteCandidate{{$candidate->id}}" class="link-danger"><i class="ri-delete-bin-5-line"></i></a>
                                                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editCandidate{{$candidate->id}}" class="link-primary"><i class="ri-edit-circle-fill"></i></a>

                                                <div id="deleteCandidate{{$candidate->id}}" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-body text-center p-5">
                                                                <div class="text-end">
                                                                    <button type="button" class="btn-close text-end" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="mt-2">
                                                                    <lord-icon src="https://cdn.lordicon.com/wwneckwc.json" trigger="hover" style="width:150px;height:150px">
                                                                    </lord-icon>
                                                                    <h4 class="mb-3 mt-4">Are you sure you want to delete <br/> {{ $candidate->student->firstname .' '. $candidate->student->lastname }}?</h4>
                                                                    <form action="{{ url('/admin/deleteCandidate') }}" method="POST">
                                                                        @csrf
                                                                        <input name="candidate_id" type="hidden" value="{{$candidate->id}}">
                                                                        <hr>
                                                                        <button type="submit" class="btn btn-danger w-100">Yes, Delete</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer bg-light p-3 justify-content-center">

                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->

                                                <div id="editCandidate{{$candidate->id}}" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content border-0 overflow-hidden">
                                                            <div class="modal-header p-3">
                                                                <h4 class="card-title mb-0">Update Candidate</h4>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                    
                                                            <div class="modal-body">
                                                                <form action="{{ url('/admin/updateStudent') }}" method="post" enctype="multipart/form-data">
                                                                    @csrf

                                                                    <input name="student_id" type="hidden" value="{{$candidate->student->id}}">

                                                                    <div class="mb-3">
                                                                        <label for="matric" class="form-label">Matric Number</label>
                                                                        <input type="text" class="form-control" name="matric_number" readonly id="matric" value="{{ $candidate->student->matric_number }}">
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="reg" class="form-label">Registration Number</label>
                                                                        <input type="text" class="form-control" name="reg_number" id="reg" readonly value="{{ $candidate->student->reg_number }}">
                                                                    </div>

                                                                    <hr>
                                    
                                                                    <div class="mb-3">
                                                                        <label for="firstname" class="form-label">Firstname</label>
                                                                        <input type="text" class="form-control" name="firstname" id="firstname" value="{{ $candidate->student->firstname }}">
                                                                    </div>
                                    
                                                                    <div class="mb-3">
                                                                        <label for="lastname" class="form-label">Lastname</label>
                                                                        <input type="text" class="form-control" name="lastname" id="lastname" value="{{ $candidate->student->lastname }}">
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="email" class="form-label">Email</label>
                                                                        <input type="text" class="form-control" name="email" id="email" value="{{ $candidate->student->email }}">
                                                                    </div>
                                    
                                                                    <hr>
                                                                    <div class="text-end">
                                                                        <button type="submit" class="btn btn-primary">Update Record</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div><!-- end col --> 
            </div><!-- end row -->


            <div id="bulkUpload" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 overflow-hidden">
                        <div class="modal-header p-3">
                            <h4 class="card-title mb-0">Upload Bulk Candidate</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <form action="{{ url('/admin/addBulkCandidate') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="examination_id" value="{{ $examination->id }}">
                                <div class="mb-3">
                                    <label for="file" class="form-label">File(CSV)</label>
                                    <input type="file" class="form-control" name="file" id="type">
                                </div>

                                <hr>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Upload Bulk Candidates</button>
                                </div>
                            </form>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->


            <div id="generateCandidateQuestions" class="modal fade" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" style="display: none;">
                <!-- Fullscreen Modals -->
                <div class="modal-dialog modal-lg">
                    <div class="modal-content border-0 overflow-hidden">
                        <div class="modal-header p-3">
                            <h4 class="card-title mb-0">Generate Candidate Question</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <form action="{{ url('/admin/generateCandidateQuestions') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="examination_id" value="{{ $examination->id }}">
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Generate Candidate Questions</button>
                                </div>
                            </form>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <div id="examStatus" class="modal fade" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" style="display: none;">
                <!-- Fullscreen Modals -->
                <div class="modal-dialog modal-lg">
                    <div class="modal-content border-0 overflow-hidden">
                        <div class="modal-header p-3">
                            <h4 class="card-title mb-0">Update Exam Status</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <form action="{{ url('/admin/examStatus') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="examination_id" value="{{ $examination->id }}">
                                

                                <div class="mb-3">
                                    <label for="status" class="form-label">Select Status</label>
                                    <select class="form-select" aria-label="status" name="status">
                                        <option value= "">Select Status </option>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                        <option value="Start">Start Exam</option>
                                        <option value="End">End Exam</option>
                                    </select>
                                </div>

                                <hr>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <div id="editExamination" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 overflow-hidden">
                        <div class="modal-header p-3">
                            <h4 class="card-title mb-0">Update Examination</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div class="modal-body">
                                <form action="{{ url('/admin/updateExamination') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name='examination_id' value="{{ $examination->id }}">
                                    
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Examination Title</label>
                                        <input type="text" class="form-control" name="title" id="title" value="{{ $examination->title }}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="control-label">Exam Type</label>
                                        <select class="form-control" name="examination_type_id" required>
                                            @foreach($examinationTypes as $examinationType)<option @if($examinationType->id == $examination->examination_type_id) selected @endif  value="{{ $examinationType->id }}">{{ $examinationType->type }}</option>@endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="duration" class="form-label">Examination Duration (In Minutes)</label>
                                        <input type="number" class="form-control" name="duration" id="duration" value="{{ $examination->duration }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control ckeditor" name="description" id="description">{!! $examination->title !!}</textarea>
                                    </div>
            
                                    <hr>
                                    <button type="submit" class="btn btn-info w-100">Save Changes</button>
                                </form>
                            </div>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <div id="clearCandidates" class="modal fade" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" style="display: none;">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body text-center p-5">
                            <div class="text-end">
                                <button type="button" class="btn-close text-end" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="mt-2">
                                <lord-icon src="https://cdn.lordicon.com/wwneckwc.json" trigger="hover" style="width:150px;height:150px">
                                </lord-icon>
                                <h4 class="mb-3 mt-4">Are you sure you want to remove all candidates for <br/> {{ $examination->title }}? This will delete all candidates and allocated questions to candidates</h4>
                                <form action="{{ url('/admin/clearCandidates') }}" method="POST">
                                    @csrf
                                    <input name="examination_id" type="hidden" value="{{$examination->id}}">
                                    <hr>
                                    <button type="submit" id="submit-button" class="btn btn-primary w-100">Yes, Approve</button>
                                </form>
                            </div>
                        </div>
                        <div class="modal-footer bg-light p-3 justify-content-center">
            
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        

@include('admin.adminIncludes.footer')
