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
                        <h4 class="mb-sm-0">{{ Auth::guard()->user()->name }}'s Dashboard</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                                <li class="breadcrumb-item active">Students Records</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Students</h4>
                            <div class="flex-shrink-0">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSingleStudent">Add Single Student</button>
                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addBulkStudent">Upload Bulk Students</button>
                            </div>
                        </div><!-- end card header -->
                        @if(!empty($students))
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-sm-6 col-xl-12">
                                    
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
                                                                        <form action="{{ url('/admin/updateStudent') }}" method="post" enctype="multipart/form-data">
                                                                            @csrf

                                                                            <input name="student_id" type="hidden" value="{{$student->id}}">
                                            
                                                                            <div class="mb-3">
                                                                                <label for="firstname" class="form-label">Firstname</label>
                                                                                <input type="text" class="form-control" name="firstname" id="firstname" value="{{ $student->firstname }}">
                                                                            </div>
                                            
                                                                            <div class="mb-3">
                                                                                <label for="lastname" class="form-label">Lastname</label>
                                                                                <input type="text" class="form-control" name="lastname" id="lastname" value="{{ $student->lastname }}">
                                                                            </div>
                                            
                                                                            <div class="mb-3">
                                                                                <label for="matric" class="form-label">Matric Number</label>
                                                                                <input type="text" class="form-control" name="matric_number" id="matric" value="{{ $student->matric_number }}">
                                                                            </div>

                                                                            <div class="mb-3">
                                                                                <label for="reg" class="form-label">Registration Number</label>
                                                                                <input type="text" class="form-control" name="reg_number" id="reg" value="{{ $student->reg_number }}">
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

                                    <hr>

                                    <div class="text-end">
                                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addSingleStudent" class="btn btn-primary">Add Single Student</a>
                                    </div>
                                </div><!-- end col -->
                            </div>
                        </div>
                        @endif
                    </div><!-- end card -->
                </div>
            </div>
            <!-- end row -->

            <div id="addBulkStudent" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 overflow-hidden">
                        <div class="modal-header p-3">
                            <h4 class="card-title mb-0">Upload Bulk Student</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <form action="{{ url('/admin/addBulkStudent') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label for="file" class="form-label">File(CSV)</label>
                                    <input type="file" class="form-control" name="file" id="type">
                                </div>

                                <hr>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Upload Bulk Students</button>
                                </div>
                            </form>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <div id="addSingleStudent" class="modal fade" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" style="display: none;">
                <!-- Fullscreen Modals -->
                <div class="modal-dialog modal-lg">
                    <div class="modal-content border-0 overflow-hidden">
                        <div class="modal-header p-3">
                            <h4 class="card-title mb-0">Add Single Student</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <form action="{{ url('/admin/addSingleStudent') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="firstname" class="form-label">Firstname</label>
                                    <input type="text" class="form-control" name="firstname" id="firstname">
                                </div>

                                <div class="mb-3">
                                    <label for="lastname" class="form-label">Lastname</label>
                                    <input type="text" class="form-control" name="lastname" id="lastname">
                                </div>

                                <div class="mb-3">
                                    <label for="matric" class="form-label">Matric Number</label>
                                    <input type="text" class="form-control" name="matric_number" id="matric">
                                </div>

                                <div class="mb-3">
                                    <label for="reg" class="form-label">Registration Number</label>
                                    <input type="text" class="form-control" name="reg_number" id="reg">
                                </div>

                                <hr>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Add Single Student</button>
                                </div>
                            </form>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

@include('admin.adminIncludes.footer')
