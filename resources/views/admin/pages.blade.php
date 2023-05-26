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
                                <li class="breadcrumb-item active">Website Page</li>
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
                            <h4 class="card-title mb-0 flex-grow-1">Page</h4>
                            <div class="flex-shrink-0">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPages">Add Page</button>
                            </div>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <div class="row">
                                @foreach($pages as $page)
                                <div class="col-sm-6 col-xl-3">
                                    <!-- Simple card -->
                                    <div class="card">
                                        <div class="card-body">
                                            <img class="rounded shadow" alt="{{ $page->image }}" width="100%" src="{{ asset($page->image) }}">
                                            <hr>
                                            <h4 class="card-title mb-2">{{ $page->title }}</h4>
                                            <p class="card-text">{!! $page->details !!}</p>
                                            <p class="card-text"><strong>Page Link: </strong>{{ env('APP_URL').'/page/'.$page->slug }}</p>
                                            <div class="text-start">
                                                <a href="{{url('/admin/page/'.$page->slug)}}" class="btn btn-info">View</a>
                                                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editPages{{$page->id}}" style="margin: 5px" class="btn btn-primary">Edit Page</a>
                                                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#deletePages{{$page->id}}" style="margin: 5px" class="btn btn-danger">Delete Page</a>
                                            </div>
                                        </div>
                                    </div><!-- end card -->
                                    <div id="editPages{{$page->id}}" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 overflow-hidden">
                                                <div class="modal-header p-3">
                                                    <h4 class="card-title mb-0">Update Page</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <form action="{{ url('/admin/updatePages') }}" method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name='page_id' value="{{ $page->id }}">
                                                        
                                                        <div class="mb-3">
                                                            <label for="title" class="form-label">Page Name</label>
                                                            <input type="text" class="form-control" name="title" id="title" value="{{ $page->title }}">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="keywords" class="form-label">Page Keywords</label>
                                                            <input type="text" class="form-control" name="keywords" id="keywords" value="{{ $page->keywords }}">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="description" class="form-label">Description</label>
                                                            <textarea class="form-control" name="description" id="description">{!! $page->description !!}</textarea>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="category" class="form-label">Select Page Type</label>
                                                            <select class="form-select" aria-label="category" name="type">
                                                                <option selected value= "">Select Page Type </option>
                                                                @foreach($pageTypes as $pageType)
                                                                <option @if($page->type == $pageType->id ) selected @endif value="{{ $pageType->id }}">{{ $pageType->type }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                        
                        
                                                        <div class="mb-3">
                                                            <label for="category" class="form-label">Select Page Category</label>
                                                            <select class="form-select" aria-label="category" name="category_id">
                                                                <option selected value= "">Select Page Category </option>
                                                                @foreach($pageCategories as $pageCategory)
                                                                <option @if($page->category_id == $pageCategory->id ) selected @endif value="{{ $pageCategory->id }}">{{ $pageCategory->title }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                        
                                                        <div class="mb-3">
                                                            <label for="category" class="form-label">Select Page Sub-Category</label>
                                                            <select class="form-select" aria-label="category" name="sub_category_id">
                                                                <option selected value= "">Select Page Sub-Category </option>
                                                                @foreach($subCategories as $subCategory)
                                                                <option @if($page->sub_category_id == $subCategory->id ) selected @endif value="{{ $subCategory->id }}">{{ $subCategory->title }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                        
                                                        <div class="mb-3">
                                                            <label for="details" class="form-label">Details</label>
                                                            <textarea class="form-control" name="details" id="details">{!! $page->details !!}</textarea>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="image" class="form-label">Image <code>Dimension: 870px by 413px</code></label>
                                                            <input type="file" class="form-control" name='image' id="image">
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

                                    <div id="deletePages{{$page->id}}" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-body text-center p-5">
                                                    <div class="text-end">
                                                        <button type="button" class="btn-close text-end" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="mt-2">
                                                        <lord-icon src="https://cdn.lordicon.com/wwneckwc.json" trigger="hover" style="width:150px;height:150px">
                                                        </lord-icon>
                                                        <h4 class="mb-3 mt-4">Are you sure you want to delete <br>{{ $page->title }}?</h4>
                                                        <form action="{{ url('/admin/deletePages') }}" method="POST">
                                                            @csrf
                                                            <input name="page_id" type="hidden" value="{{$page->id}}">

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


            <div id="addPages" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 overflow-hidden">
                        <div class="modal-header p-3">
                            <h4 class="card-title mb-0">Add Page</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <form action="{{ url('/admin/addPages') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="title" class="form-label">Page Name</label>
                                    <input type="text" class="form-control" name="title" id="title">
                                </div>

                                <div class="mb-3">
                                    <label for="keywords" class="form-label">Page Keywords</label>
                                    <input type="text" class="form-control" name="keywords" id="keywords">
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" name="description" id="description"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="category" class="form-label">Select Page Type</label>
                                    <select class="form-select" aria-label="category" name="type">
                                        <option selected value= "">Select Page Type </option>
                                        @foreach($pageTypes as $pageType)
                                        <option  value="{{ $pageType->id }}">{{ $pageType->type }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="mb-3">
                                    <label for="category" class="form-label">Select Page Category</label>
                                    <select class="form-select" aria-label="category" name="category_id">
                                        <option selected value= "">Select Page Category </option>
                                        @foreach($pageCategories as $pageCategory)
                                        <option value="{{ $pageCategory->id }}">{{ $pageCategory->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="category" class="form-label">Select Page Sub-Category</label>
                                    <select class="form-select" aria-label="category" name="sub_category_id">
                                        <option selected value= "">Select Page Sub-Category </option>
                                        @foreach($subCategories as $subCategory)
                                        <option value="{{ $subCategory->id }}">{{ $subCategory->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="details" class="form-label">Details</label>
                                    <textarea class="form-control" name="details" id="details" ></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="image" class="form-label">Image <code>Dimension: 870px by 413px</code></label>
                                    <input type="file" class="form-control" name='image' id="image">
                                </div>

                                <hr>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Create Page</button>
                                </div>
                            </form>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->


@include('admin.adminIncludes.footer')
