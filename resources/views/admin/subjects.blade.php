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
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Subject</a></li>
                                <li class="breadcrumb-item active">Subject</li>
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
                            <h4 class="card-title mb-0 flex-grow-1">Subject</h4>
                            <div class="flex-shrink-0">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSubject">Create Subject</button>
                            </div>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <div class="row">
                                <table id="buttons-datatables" class="table table-borderedless dt-responsive nowrap table-striped align-middle" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">SN</th>
                                            <th scope="col">Subject Name</th>
                                            <th scope="col">Code</th>
                                            <th scope="col">Subject Exam Type</th>
                                            <th scope="col">Subject Questions</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($subjects as $subject)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $subject->subject }} </td>
                                            <td>{{ $subject->code }} </td>
                                            <td>{{ $subject->type->type }} </td>
                                            <td>{{ $subject->questions->count() }} </td>
                                            <td>
                                                <div class="hstack gap-3 fs-15">
                                                    <a href="{{url('/admin/subject/'.$subject->slug)}}" class="link-info"><i class="ri-eye-line"></i></a>

                                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#deleteSubject{{$subject->id}}" class="link-danger"><i class="ri-delete-bin-5-line"></i></a>
                                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editSubject{{$subject->id}}" class="link-primary"><i class="ri-edit-circle-fill"></i></a>
    
                                                    <div id="editSubject{{$subject->id}}" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content border-0 overflow-hidden">
                                                                <div class="modal-header p-3">
                                                                    <h4 class="card-title mb-0">Update Subject</h4>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                
                                                                <div class="modal-body">
                                                                    <form action="{{ url('/admin/updateSubject') }}" method="post" enctype="multipart/form-data">
                                                                        @csrf
                                                                        <input type="hidden" name='subject_id' value="{{ $subject->id }}">
                                                                        
                                                                        <div class="mb-3">
                                                                            <label for="title" class="form-label">Subject Name</label>
                                                                            <input type="text" class="form-control" name="subject" id="title" value="{{ $subject->subject }}">
                                                                        </div>
                
                                                                        <div class="mb-3">
                                                                            <label for="code" class="form-label">Subject Code</label>
                                                                            <input type="text" class="form-control" name="code" id="code" value="{{ $subject->code }}">
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label class="control-label">Exam Type</label>
                                                                            <select class="form-control" name="examination_type_id" required>
                                                                                @foreach($examinationTypes as $examinationType)<option @if($examinationType->id == $subject->examination_type_id) selected @endif  value="{{ $examinationType->id }}">{{ $examinationType->type }}</option>@endforeach
                                                                            </select>
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label for="description" class="form-label">Description</label>
                                                                            <textarea class="form-control" name="description" id="description">{!! $subject->description !!}</textarea>
                                                                        </div>
            
                                                                        <hr>
                                                                        <button type="submit" class="btn btn-info w-100">Save Changes</button>
                                                                    </form>
                                                                </div>
                                                            </div><!-- /.modal-content -->
                                                        </div><!-- /.modal-dialog -->
                                                    </div><!-- /.modal -->
                
                                                    <div id="deleteSubject{{$subject->id}}" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-body text-center p-5">
                                                                    <div class="text-end">
                                                                        <button type="button" class="btn-close text-end" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="mt-2">
                                                                        <lord-icon src="https://cdn.lordicon.com/wwneckwc.json" trigger="hover" style="width:150px;height:150px">
                                                                        </lord-icon>
                                                                        <h4 class="mb-3 mt-4">Are you sure you want to delete <br>{{ $subject->subject }}?</h4>
                                                                        <form action="{{ url('/admin/deleteSubject') }}" method="POST">
                                                                            @csrf
                                                                            <input name="subject_id" type="hidden" value="{{$subject->id}}">
                
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
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><!-- end card -->
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->


            <div id="addSubject" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 overflow-hidden">
                        <div class="modal-header p-3">
                            <h4 class="card-title mb-0">Create Subject</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <form action="{{ url('/admin/addSubject') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="title" class="form-label">Subject Name</label>
                                    <input type="text" class="form-control" name="subject" id="title" autofocus>
                                </div>

                                <div class="mb-3">
                                    <label for="code" class="form-label">Subject Code</label>
                                    <input type="text" class="form-control" name="code" id="code">
                                </div>
                                

                                <div class="mb-3">
                                    <label class="control-label">Exam Type</label>
                                    <select class="form-control" name="examination_type_id" required>
                                        <option value="" selected>Select Exam Type</option>
                                        @foreach($examinationTypes as $examinationType)<option value="{{ $examinationType->id }}">{{ $examinationType->type }}</option>@endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" name="description" id="description"></textarea>
                                </div>
                               
                                <hr>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Create Subject</button>
                                </div>
                            </form>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->


@include('admin.adminIncludes.footer')
