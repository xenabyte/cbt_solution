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
                                <li class="breadcrumb-item active">Media</li>
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
                            <h4 class="card-title mb-0 flex-grow-1">Media Files</h4>
                            <div class="flex-shrink-0">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addmediaFile">Add Media</button>
                            </div>
                        </div><!-- end card header -->
                        @if(!empty($media))
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-sm-6 col-xl-12">
                                    
                                    <table id="fixed-header" class="table table-borderedless dt-responsive nowrap table-striped align-middle" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">Id</th>
                                                <th scope="col">Filename</th>
                                                <th scope="col">Type</th>
                                                <th scope="col">Size</th>
                                                <th scope="col">Filepath</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($media as $mediaFile)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if($mediaFile->type == 'ZIP')
                                                        <div class="avatar-sm">
                                                            <div class="avatar-title bg-soft-primary text-primary rounded fs-20 shadow">
                                                                <i class="ri-file-zip-fill"></i>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        @if($mediaFile->type == 'PNG')
                                                        <div class="avatar-sm">
                                                            <div class="avatar-title bg-soft-danger text-danger rounded fs-20 shadow">
                                                                <i class="ri-image-2-fill"></i>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        @if($mediaFile->type == 'PDF')
                                                        <div class="avatar-sm">
                                                            <div class="avatar-title bg-soft-danger text-danger rounded fs-20 shadow">
                                                                <i class="ri-file-pdf-fill"></i>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        @if($mediaFile->type == 'DOC')
                                                        <div class="avatar-sm">
                                                            <div class="avatar-title bg-soft-danger text-danger rounded fs-20 shadow">
                                                                <i class="ri-file-word-fill"></i>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        @if($mediaFile->type == 'PPT')
                                                        <div class="avatar-sm">
                                                            <div class="avatar-title bg-soft-danger text-danger rounded fs-20 shadow">
                                                                <i class="ri-file-ppt-2-fill"></i>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        @if($mediaFile->type == 'JPG')
                                                        <div class="avatar-sm">
                                                            <div class="avatar-title bg-soft-danger text-danger rounded fs-20 shadow">
                                                                <i class="ri-image-fill"></i>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        <div class="ms-3 flex-grow-1">
                                                            <h6 class="fs-15 mb-0"><a href="javascript:void(0)">{{ $mediaFile->filename }}</a>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $mediaFile->type }} File</td>
                                                <td>{{ $mediaFile->size }} </td>
                                                <td>{{ env('APP_URL').'/'.$mediaFile->filepath }}</td>
                                                <td>
                                                    <div class="hstack gap-3 fs-15">
                                                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#deletemediaFile{{$mediaFile->id}}" class="link-danger"><i class="ri-delete-bin-5-line"></i></a>
                                                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editmediaFile{{$mediaFile->id}}" class="link-primary"><i class="ri-edit-circle-fill"></i></a>
        
                                                        <div id="deletemediaFile{{$mediaFile->id}}" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-body text-center p-5">
                                                                        <div class="text-end">
                                                                            <button type="button" class="btn-close text-end" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="mt-2">
                                                                            <lord-icon src="https://cdn.lordicon.com/wwneckwc.json" trigger="hover" style="width:150px;height:150px">
                                                                            </lord-icon>
                                                                            <h4 class="mb-3 mt-4">Are you sure you want to delete <br/> {{ $mediaFile->filename }}?</h4>
                                                                            <form action="{{ url('/admin/deleteMedia') }}" method="POST">
                                                                                @csrf
                                                                                <input name="media_id" type="hidden" value="{{$mediaFile->id}}">
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

                                                        <div id="editmediaFile{{$mediaFile->id}}" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content border-0 overflow-hidden">
                                                                    <div class="modal-header p-3">
                                                                        <h4 class="card-title mb-0">Edit mediaFile</h4>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                            
                                                                    <div class="modal-body">
                                                                        <form action="{{ url('/admin/updateMedia') }}" method="post" enctype="multipart/form-data">
                                                                            @csrf

                                                                            <input name="mediaFile_id" type="hidden" value="{{$mediaFile->id}}">
                                            
                                                                            <div class="mb-3">
                                                                                <label for="filename" class="form-label">Filename</label>
                                                                                <input type="text" class="form-control" name="filename" id="filename" value="{{ $mediaFile->filename }}">
                                                                            </div>
                                            
                                                                            <div class="mb-3">
                                                                                <label for="fileType" class="form-label">Select File Type</label>
                                                                                <select class="form-select" aria-label="fileType" name="type">
                                                                                    <option selected value= "">Select File Type </option>
                                                                                    <option value="PDF">PDF</option>
                                                                                    <option value="PNG">PNG</option>
                                                                                    <option value="DOC">DOC</option>
                                                                                    <option value="ZIP">ZIP</option>
                                                                                    <option value="JPG">JPG</option>
                                                                                    <option value="PPT">PPT</option>
                                                                                </select>
                                                                            </div>

                                                                            <div class="mb-3">
                                                                                <label for="file" class="form-label">File</label>
                                                                                <input type="file" class="form-control" name='file' id="file">
                                                                            </div>
                                            
                                                                            <hr>
                                                                            <div class="text-end">
                                                                                <button type="submit" class="btn btn-primary">Edit Media</button>
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

                                    <div class="text-end">
                                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addmediaFile" class="btn btn-primary">Add Media</a>
                                    </div>
                                </div><!-- end col -->
                            </div>
                        </div>
                        @endif
                    </div><!-- end card -->
                </div>
            </div>
            <!-- end row -->

            <div id="addmediaFile" class="modal fade" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" style="display: none;">
                <!-- Fullscreen Modals -->
                <div class="modal-dialog modal-lg">
                    <div class="modal-content border-0 overflow-hidden">
                        <div class="modal-header p-3">
                            <h4 class="card-title mb-0">Add Media</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <form action="{{ url('/admin/addMedia') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label for="filename" class="form-label">Filename</label>
                                    <input type="text" class="form-control" name="filename" id="filename">
                                </div>

                                <div class="mb-3">
                                    <label for="fileType" class="form-label">Select File Type</label>
                                    <select class="form-select" aria-label="fileType" name="type">
                                        <option selected value= "">Select File Type </option>
                                        <option value="PDF">PDF</option>
                                        <option value="PNG">PNG</option>
                                        <option value="DOC">DOC</option>
                                        <option value="ZIP">ZIP</option>
                                        <option value="JPG">JPG</option>
                                        <option value="PPT">PPT</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="file" class="form-label">File</label>
                                    <input type="file" class="form-control" name='file' id="file">
                                </div>

                                <hr>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Add Media</button>
                                </div>
                            </form>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->



@include('admin.adminIncludes.footer')
