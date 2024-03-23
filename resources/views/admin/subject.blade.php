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
                                <li class="breadcrumb-item active">{{ $subject->subject }}</li>
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
                                    <h4 class="card-title mb-0 flex-grow-1">Subject Overview - {{ $subject->subject }}</h4>
                                    <div class="flex-shrink-0">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editSubject">Update Subject</button>
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
                                    {!! $subject->description !!}
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->
                        <div class="col-xl-5">
                            <div class="card card-height-100">
                                <div class="card-body pt-0">
                                   <hr>

                                   <div class="mini-stats-wid d-flex align-items-center mt-3">
                                        Total Subject Questions
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1"></h6>
                                        </div>
                                        <div class="form-check form-switch">
                                            {{ $subject->questions->count() }} questions
                                        </div>
                                   </div>
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
                            <h4 class="card-title mb-0 flex-grow-1">Subject Questions</h4>
                            <div class="flex-shrink-0">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadBulkQuestion">Upload Question</button>
                            </div>
                        </div><!-- end card header -->
            
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table table-bordered table-hover nowrap table-striped align-middle" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">Id</th>
                                            <th scope="col">Question</th>
                                            <th scope="col">Options</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($subject->questions as $question)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{!! $question->text !!}</td>
                                            <td>
                                                <ul>
                                                    @foreach ($question->options as $option)
                                                    <li>
                                                        {{ $option->option_text }} @if($option->is_correct)(A)@endif
                                                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#deleteOption{{$option->id}}" class="link-danger"><i class="ri-delete-bin-5-line"></i></a>
                                                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editOption{{$option->id}}" class="link-primary"><i class="ri-edit-circle-fill"></i></a>

                                                        <div id="deleteOption{{$option->id}}" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-body text-center p-5">
                                                                        <div class="text-end">
                                                                            <button type="button" class="btn-close text-end" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="mt-2">
                                                                            <lord-icon src="https://cdn.lordicon.com/wwneckwc.json" trigger="hover" style="width:150px;height:150px">
                                                                            </lord-icon>
                                                                            <h4 class="mb-3 mt-4">Are you sure you want to delete <br> {{ $option->option_text }}?</h4>
                                                                            <form action="{{ url('/admin/deleteOption') }}" method="POST">
                                                                                @csrf
                                                                                <input name="option_id" type="hidden" value="{{$option->id}}">
        
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

                                                        <div id="editOption{{$option->id}}" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content border-0 overflow-hidden">
                                                                    <div class="modal-header p-3">
                                                                        <h4 class="card-title mb-0">Edit Option</h4>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                            
                                                                    <div class="modal-body">
                                                                        <form action="{{ url('/admin/updateOption') }}" method="post" enctype="multipart/form-data">
                                                                            @csrf
                                                                            <input name="option_id" type="hidden" value="{{$option->id}}">

                                                                            <div class="mb-3">
                                                                                <label for="optin" class="form-label">Option</label>
                                                                                <input type="text" class="form-control" name="option_text" id="option" value="{{ $option->option_text }}">
                                                                            </div>
                                            
                                                                            <div class="form-check form-switch">
                                                                                <input class="form-check-input" type="checkbox" name="is_correct" role="switch" @if($option->is_correct) checked @endif />
                                                                                <span class="text-primary"> Set as correct answer</span>
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
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>
                                                <div class="hstack gap-3 fs-15">
                                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#deleteQuestion{{$question->id}}" class="link-danger"><i class="ri-delete-bin-5-line"></i></a>
                                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editQuestion{{$question->id}}" class="link-primary"><i class="ri-edit-circle-fill"></i></a>
                                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addOption{{$question->id}}" class="link-success"><i class="ri-menu-add-fill"></i></a>

                                                    <div id="deleteQuestion{{$question->id}}" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-body text-center p-5">
                                                                    <div class="text-end">
                                                                        <button type="button" class="btn-close text-end" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="mt-2">
                                                                        <lord-icon src="https://cdn.lordicon.com/wwneckwc.json" trigger="hover" style="width:150px;height:150px">
                                                                        </lord-icon>
                                                                        <h4 class="mb-3 mt-4">Are you sure you want to delete <br> {{ $question->text }}?</h4>
                                                                        <form action="{{ url('/admin/deleteQuestion') }}" method="POST">
                                                                            @csrf
                                                                            <input name="question_id" type="hidden" value="{{$question->id}}">

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

                                                    <div id="editQuestion{{$question->id}}" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content border-0 overflow-hidden">
                                                                <div class="modal-header p-3">
                                                                    <h4 class="card-title mb-0">Edit Question</h4>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                        
                                                                <div class="modal-body">
                                                                    <form action="{{ url('/admin/updateQuestion') }}" method="post" enctype="multipart/form-data">
                                                                        @csrf
                                        
                                                                        <input name="question_id" type="hidden" value="{{$question->id}}">

                                                                        <div class="mb-3">
                                                                            <label for="question" class="form-label">Question</label>
                                                                            <textarea class="form-control" name="text" id="question">{{ $question->text }}</textarea>
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

                                                    <div id="addOption{{$question->id}}" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content border-0 overflow-hidden">
                                                                <div class="modal-header p-3">
                                                                    <h4 class="card-title mb-0">Add Option</h4>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                        
                                                                <div class="modal-body">
                                                                    <form action="{{ url('/admin/addOption') }}" method="post" enctype="multipart/form-data">
                                                                        @csrf
                                        
                                                                        <input name="question_id" type="hidden" value="{{$question->id}}">
                                                                        <div class="mb-3">
                                                                            <label for="option" class="form-label">Option</label>
                                                                            <input type="text" class="form-control" name="option_text" id="option">
                                                                        </div>
                                        
                                                                        <div class="form-check form-switch">
                                                                            <input class="form-check-input" type="checkbox" name="is_correct" role="switch" />
                                                                            <span class="text-primary"> Set as correct answer</span>
                                                                        </div>
                                        
                                                                        <hr>
                                                                        <div class="text-end">
                                                                            <button type="submit" class="btn btn-primary">Add Option</button>
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
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div><!-- end col --> 
            </div><!-- end row -->


            <div id="uploadBulkQuestion" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 overflow-hidden">
                        <div class="modal-header p-3">
                            <h4 class="card-title mb-0">Upload Subject Question</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <form action="{{ url('/admin/uploadBulkQuestion') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                                <div class="mb-3">
                                    <label for="file" class="form-label">File(CSV)</label>
                                    <input type="file" class="form-control" name="file" id="type">
                                </div>

                                <hr>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Upload Question</button>
                                </div>
                            </form>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            
            <div id="editSubject" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
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
        

@include('admin.adminIncludes.footer')
