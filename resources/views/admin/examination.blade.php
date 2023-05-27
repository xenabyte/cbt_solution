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
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Examinations</a></li>
                                <li class="breadcrumb-item active">Examination</li>
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
                            <h4 class="card-title mb-0 flex-grow-1">Examination</h4>
                            <div class="flex-shrink-0">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addExamination">Create Examination</button>
                            </div>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <div class="row">
                                @foreach($examinations as $examination)
                                <div class="col-sm-6 col-xl-3">
                                    <!-- Simple card -->
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title mb-2">{{ $examination->code }} - {{ $examination->title }}</h4>
                                            <p class="card-text">{!! $examination->description !!}</p>
                                            <p class="card-text"><strong>Examination Added By: </strong>{{ $examination->admin->name }}</p>
                                            <p class="card-text"><strong>Examination Duration: </strong>{{ $examination->duration }}</p>
                                            <p class="card-text"><strong>Question Quantity: </strong>{{ $examination->question_number }}</p>
                                            <div class="text-start">
                                                <a href="{{url('/admin/examination/'.$examination->slug)}}" class="btn btn-info">View</a>
                                                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editExamination{{$examination->id}}" style="margin: 5px" class="btn btn-primary">Edit Examination</a>
                                                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#deleteExamination{{$examination->id}}" style="margin: 5px" class="btn btn-danger">Delete Examination</a>
                                            </div>
                                        </div>
                                    </div><!-- end card -->
                                    <div id="editExamination{{$examination->id}}" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 overflow-hidden">
                                                <div class="modal-header p-3">
                                                    <h4 class="card-title mb-0">Update Examination</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <form action="{{ url('/admin/updateExamination') }}" method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name='examination_id' value="{{ $examination->id }}">
                                                        
                                                        <div class="mb-3">
                                                            <label for="title" class="form-label">Examination Title</label>
                                                            <input type="text" class="form-control" name="title" id="title" value="{{ $examination->title }}">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="description" class="form-label">Description</label>
                                                            <textarea class="form-control" name="description" id="description">{!! $examination->title !!}</textarea>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="code" class="form-label">Examination Code</label>
                                                            <input type="text" class="form-control" name="code" id="code" value="{{ $examination->code }}">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="question" class="form-label">Examination Question Quantity</label>
                                                            <input type="number" class="form-control" name="question_number" id="question" value="{{ $examination->question_number }}">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="duration" class="form-label">Examination Duration (In Minutes)</label>
                                                            <input type="number" class="form-control" name="duration" id="duration" value="{{ $examination->duration }}">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="mark" class="form-label">Mark per question</label>
                                                            <input type="number" class="form-control" name="mark" id="mark" value="{{ $examination->mark }}">
                                                        </div>
                                
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
                    </div><!-- end card -->
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->


            <div id="addExamination" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 overflow-hidden">
                        <div class="modal-header p-3">
                            <h4 class="card-title mb-0">Create Examination</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <form action="{{ url('/admin/addExamination') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="title" class="form-label">Examination Title</label>
                                    <input type="text" class="form-control" name="title" id="title" autofocus>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" name="description" id="description"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="code" class="form-label">Examination Code</label>
                                    <input type="text" class="form-control" name="code" id="code">
                                </div>

                                <div class="mb-3">
                                    <label for="question" class="form-label">Examination Question Quantity</label>
                                    <input type="number" class="form-control" name="question_number" id="question">
                                </div>

                                <div class="mb-3">
                                    <label for="duration" class="form-label">Examination Duration (In Minutes)</label>
                                    <input type="number" class="form-control" name="duration" id="duration">
                                </div>

                                <div class="mb-3">
                                    <label for="mark" class="form-label">Mark per question</label>
                                    <input type="number" class="form-control" name="mark" id="mark">
                                </div>
                                
                                <hr>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Create Examination</button>
                                </div>
                            </form>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->


@include('admin.adminIncludes.footer')
