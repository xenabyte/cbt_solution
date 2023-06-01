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
                                    <p class="text-uppercase fw-medium text-white-50 mb-3">Students</p>
                                    <h4 class="fs-4 mb-3 text-white"><span class="counter-value" data-target="{{ $students->count() }}">{{ $students->count() }}</span></h4>
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
                                    <p class="text-uppercase fw-medium text-muted mb-3">Ongoing Assessments</p>
                                    <h4 class="fs-4 mb-3"><span class="counter-value" data-target="{{ $examinations->where('status', 'Start')->count() }}">{{ $examinations->where('status', 'Start')->count() }}</span></h4>
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
                                    <p class="text-uppercase fw-medium text-muted mb-3">Total Assessment</p>
                                    <h4 class="fs-4 mb-3"><span class="counter-value" data-target="{{ $examinations->count() }}">{{ $examinations->count() }}</span></h4>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div>
                </div> <!-- end col-->
            </div> <!-- end row-->

            <hr>
            <div class="row project-wrapper">
                <div class="col-xxl-12">
                    <div class="card card-body">
                        <table id="fixed-header" class="table table-borderedless dt-responsive nowrap table-striped align-middle" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Firstname</th>
                                    <th scope="col">Lastname</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Matric Number</th>
                                    <th scope="col">Registration Number</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $student->firstname }} </td>
                                    <td>{{ $student->lastname }} </td>
                                    <td>{{ $student->email }}</td>
                                    <td>{{ $student->matric_number }} </td>
                                    <td>{{ $student->reg_number }} </td>
                                    <td>
                                        <div class="hstack gap-3 fs-15">
                                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#deleteStudent{{$student->id}}" class="link-danger"><i class="ri-delete-bin-5-line"></i></a>
                                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editStudent{{$student->id}}" class="link-primary"><i class="ri-edit-circle-fill"></i></a>
    
                                            <div id="deleteStudent{{$student->id}}" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body text-center p-5">
                                                            <div class="text-end">
                                                                <button type="button" class="btn-close text-end" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="mt-2">
                                                                <lord-icon src="https://cdn.lordicon.com/wwneckwc.json" trigger="hover" style="width:150px;height:150px">
                                                                </lord-icon>
                                                                <h4 class="mb-3 mt-4">Are you sure you want to delete <br/> {{ $student->firstname .' '. $student->lastname }}?</h4>
                                                                <form action="{{ url('/admin/deleteStudent') }}" method="POST">
                                                                    @csrf
                                                                    <input name="student_id" type="hidden" value="{{$student->id}}">
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
    
                                            <div id="editStudent{{$student->id}}" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content border-0 overflow-hidden">
                                                        <div class="modal-header p-3">
                                                            <h4 class="card-title mb-0">Update Student</h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                
                                                        <div class="modal-body">
                                                            <hr>
                                                            <form action="{{ url('/admin/updateStudent') }}" method="post" enctype="multipart/form-data">
                                                                @csrf
    
                                                                <div class="mb-3">
                                                                    <label for="matric" class="form-label">Matric Number</label>
                                                                    <input type="text" class="form-control" name="matric_number" id="matric" value="{{ $student->matric_number }}">
                                                                </div>
    
                                                                <div class="mb-3">
                                                                    <label for="reg" class="form-label">Registration Number</label>
                                                                    <input type="text" class="form-control" name="reg_number" id="reg" value="{{ $student->reg_number }}">
                                                                </div>
    
                                                                <hr>
    
                                                                <input name="student_id" type="hidden" value="{{$student->id}}">
                                
                                                                <div class="mb-3">
                                                                    <label for="firstname" class="form-label">Firstname</label>
                                                                    <input type="text" class="form-control" name="firstname" id="firstname" value="{{ $student->firstname }}">
                                                                </div>
                                
                                                                <div class="mb-3">
                                                                    <label for="lastname" class="form-label">Lastname</label>
                                                                    <input type="text" class="form-control" name="lastname" id="lastname" value="{{ $student->lastname }}">
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
                    </div>
                </div><!-- end col -->

                <div class="col-xxl-12">
                    <div class="card card-body">
                        @foreach($examinations as $examination)
                        <div class="col-sm-6 col-xl-3">
                            <!-- Simple card -->
                            <div class="card card-body">
                                <h4 class="card-title mb-2">{{ $examination->code }} - {{ $examination->title }}</h4>
                                <p class="card-text">{!! $examination->description !!}</p>
                                <p class="card-text"><strong>Assessment Added By: </strong>{{ $examination->admin->name }}</p>
                                <p class="card-text"><strong>Assessment Duration: </strong>{{ $examination->duration }}</p>
                                <p class="card-text"><strong>Question Quantity: </strong>{{ $examination->question_number }}</p>
                                <div class="text-start">
                                    <a href="{{url('/admin/examination/'.$examination->slug)}}" class="btn btn-info">View</a>
                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editExamination{{$examination->id}}" style="margin: 5px" class="btn btn-primary">Edit Assessment</a>
                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#deleteExamination{{$examination->id}}" style="margin: 5px" class="btn btn-danger">Delete Assessment</a>
                                </div>
                            </div>
                            <div id="editExamination{{$examination->id}}" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 overflow-hidden">
                                        <div class="modal-header p-3">
                                            <h4 class="card-title mb-0">Update Assessment</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            <form action="{{ url('/admin/updateExamination') }}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name='examination_id' value="{{ $examination->id }}">
                                                
                                                <div class="mb-3">
                                                    <label for="title" class="form-label">Assessment Title</label>
                                                    <input type="text" class="form-control" name="title" id="title" value="{{ $examination->title }}">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="description" class="form-label">Description</label>
                                                    <textarea class="form-control" name="description" id="description">{!! $examination->title !!}</textarea>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="code" class="form-label">Assessment Code</label>
                                                    <input type="text" class="form-control" name="code" id="code" value="{{ $examination->code }}">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="question" class="form-label">Assessment Question Quantity</label>
                                                    <input type="number" class="form-control" name="question_number" id="question" value="{{ $examination->question_number }}">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="duration" class="form-label">Assessment Duration (In Minutes)</label>
                                                    <input type="number" class="form-control" name="duration" id="duration" value="{{ $examination->duration }}">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="mark" class="form-label">Mark per question</label>
                                                    <input type="number" class="form-control" name="mark" id="mark" value="{{ $examination->mark }}">
                                                </div>
                        
                                                <hr>
                                                <button type="submit" class="btn btn-info w-100">Save Changes</button>
                                            </form>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->

                            <div id="deleteExamination{{$examination->id}}" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body text-center p-5">
                                            <div class="text-end">
                                                <button type="button" class="btn-close text-end" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="mt-2">
                                                <lord-icon src="https://cdn.lordicon.com/wwneckwc.json" trigger="hover" style="width:150px;height:150px">
                                                </lord-icon>
                                                <h4 class="mb-3 mt-4">Are you sure you want to delete <br>{{ $examination->title }}?</h4>
                                                <form action="{{ url('/admin/deleteExamination') }}" method="POST">
                                                    @csrf
                                                    <input name="examination_id" type="hidden" value="{{$examination->id}}">

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
                        </div><!-- end col -->
                    @endforeach
                    </div>
                </div>
            </div><!-- end row -->
            <!-- end row -->

@include('admin.adminIncludes.footer')