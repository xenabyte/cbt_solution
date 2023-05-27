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
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updatePageButton">Update page button</button>
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
                                <div class="card-header border-0">
                                    <h4 class="card-title mb-0">Page Options</h4>
                                </div><!-- end cardheader -->
                                <div class="card-body pt-0">
                                    <h6 class="fw-semibold text-muted">Select sections to be on the webpage</h6>
                                    <hr>
                                    <form action='{{ url('admin/updatePageSections') }}' method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name='page_id' value="{{ $examination->id }}">

                                        <div class="mini-stats-wid d-flex align-items-center mt-3">
                                            Add news section to page
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1"></h6>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" name="is_news" type="checkbox" role="switch" @if($examination->is_news == 'on') checked @endif />
                                            </div>
                                        </div><!-- end -->

                                        <div class="mini-stats-wid d-flex align-items-center mt-3">
                                            Add testimonial section to page
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1"></h6>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="is_testimonial" role="switch" @if($examination->is_testimonial == 'on') checked @endif />
                                            </div>
                                        </div><!-- end -->

                                        <div class="mini-stats-wid d-flex align-items-center mt-3">
                                            Add student board section to page
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1"></h6>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="is_student_board" role="switch" @if($examination->is_student_board == 'on') checked @endif />
                                            </div>
                                        </div><!-- end -->

                                        <div class="mini-stats-wid d-flex align-items-center mt-3">
                                            Add sponsor section to page
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1"></h6>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="is_sponsors" role="switch" @if($examination->is_sponsors == 'on') checked @endif />
                                            </div>
                                        </div><!-- end -->

                                        <div class="mini-stats-wid d-flex align-items-center mt-3">
                                            Add award section to page
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1"></h6>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="is_award" role="switch" @if($examination->is_award == 'on') checked @endif />
                                            </div>
                                        </div><!-- end -->

                                        <div class="mini-stats-wid d-flex align-items-center mt-3">
                                            Add prefect section to page
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1"></h6>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="is_prefects" role="switch" @if($examination->is_prefects == 'on') checked @endif />
                                            </div>
                                        </div><!-- end -->

                                        <div class="mini-stats-wid d-flex align-items-center mt-3">
                                            Add staff section to page
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1"></h6>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="is_staff" role="switch" @if($examination->is_staff == 'on') checked @endif />
                                            </div>
                                        </div><!-- end -->

                                        <div class="mini-stats-wid d-flex align-items-center mt-3">
                                            Add alumni section to page
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1"></h6>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="is_alumni" role="switch" @if($examination->is_alumni == 'on') checked @endif />
                                            </div>
                                        </div><!-- end -->

                                        <div class="mini-stats-wid d-flex align-items-center mt-3">
                                            Add department section to page
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1"></h6>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="is_department" role="switch" @if($examination->is_department == 'on') checked @endif />
                                            </div>
                                        </div><!-- end -->

                                        <div class="mini-stats-wid d-flex align-items-center mt-3">
                                            Add external examination section to page
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1"></h6>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="is_examination" role="switch"@if($examination->is_examination == 'on') checked @endif />
                                            </div>
                                        </div><!-- end -->
                                        <br>

                                        <div class="card-header p-0 border-0 bg-soft-light">
                                            <div class="row g-0 text-center">
                                                <div class="col-12 col-sm-12">
                                                    <div class="p-3 border border-dashed border-start-0">

                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- end card header -->
                                        <div class="mt-3 text-center">
                                            <button type="submit" class="btn btn-primary">
                                                Update Sections</button>
                                        </div>

                                    </form>

                                </div><!-- end cardbody -->
                            </div><!-- end card -->
                        </div>
                    </div><!-- end row -->
                </div><!-- end col -->
            </div><!-- end row -->


            <div class="row">
                <div class="col-xxl-3 col-lg-6">
                    <div class="card card-height-100">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Metrics</h4>
                            <div class="flex-shrink-0">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMetrics">Add Metric</button>
                            </div>
                        </div><!-- end card header -->
                        <div class="card-body">

                            <div class="table-responsive table-card">
                                <table class="table table-borderless table-nowrap align-middle mb-0">
                                    <thead class="table-light text-muted">
                                        <tr>
                                            <th scope="col">Title</th>
                                            <th scope="col">Score</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
                                        <tr>
                                            <td class="d-flex">
                                                <div>
                                                    <p class="fs-12 mb-0 text-muted"></p>
                                                </div>
                                            </td>

                                            <td>
                                            </td>

                                            <td style="width:5%;">
                                                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editPageCounter" style="margin: 5px" class="link-primary"><i class="ri-edit-circle-fill"></i></a>
                                                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#deletePageCounter" style="margin: 5px" class="link-danger"><i class="ri-delete-bin-5-line"></i></a>
                                            </td>
                                        </tr>
                                        <div id="deletePageCounter" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body text-center p-5">
                                                        <div class="text-end">
                                                            <button type="button" class="btn-close text-end" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="mt-2">
                                                            <lord-icon src="https://cdn.lordicon.com/wwneckwc.json" trigger="hover" style="width:150px;height:150px">
                                                            </lord-icon>
                                                            <h4 class="mb-3 mt-4">Are you sure you want to delete <br>?</h4>
                                                            <form action="{{ url('/admin/deleteMetrics') }}" method="POST">
                                                                @csrf
                                                                <input name="metric_id" type="hidden" value="">
    
                                                                <hr>
                                                                <button type="submit" class="btn btn-danger w-100">Yes, Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer bg-light p-3 justify-content-center">
    
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal --><!-- end tr -->
                                        <div id="editPageCounter" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body p-5">
                                                        <div class="text-end">
                                                            <button type="button" class="btn-close text-end" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="mt-2">
                                                            <form action="{{ url('/admin/updateMetrics') }}" method="POST">
                                                                @csrf
                                                                <input name="metric_id" type="hidden" value="">
    
                                                                <div class="mb-3">
                                                                    <label for="title" class="form-label">Metric Title</label>
                                                                    <input type="text" class="form-control" name="title" id="name" value="">
                                                                </div>
                                    
                                                                <div class="mb-3">
                                                                    <label for="score" class="form-label">Score</label>
                                                                    <input class="form-control" name="score" id="score" value="">
                                                                </div>
                                                                <hr>
                                                                <button type="submit" class="btn btn-info w-100">Save changes</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer bg-light p-3 justify-content-center">
    
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal --><!-- end tr -->
                                    </tbody><!-- end tbody -->
                                </table><!-- end table -->
                            </div>
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div><!-- end col -->

                <div class="col-xxl-9 col-lg-6">
                    <div class="card card-height-100">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">History Card</h4>
                            <div class="flex-shrink-0">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addHistory">Add History</button>
                            </div>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title mb-0 flex-grow-1"></h4>
                                            <hr>
                                            <hr>
                                            <div class="text-center">
                                                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editHistory" style="margin: 5px" class="btn btn-info">Edit History</a>
                                                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#deleteDelete" style="margin: 5px" class="btn btn-danger">Delete History</a>
                                            </div>
                                        </div>
                                    </div><!-- end card -->

                                    <div id="deleteDelete" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-body text-center p-5">
                                                    <div class="text-end">
                                                        <button type="button" class="btn-close text-end" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="mt-2">
                                                        <lord-icon src="https://cdn.lordicon.com/wwneckwc.json" trigger="hover" style="width:150px;height:150px">
                                                        </lord-icon>
                                                        <h4 class="mb-3 mt-4">Are you sure you want to delete <br>?</h4>
                                                        <form action="{{ url('/admin/deleteHistory') }}" method="POST">
                                                            @csrf
                                                            <input name="history_id" type="hidden" value="">
                            
                                                            <hr>
                                                            <button type="submit" class="btn btn-danger w-100">Yes, Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="modal-footer bg-light p-3 justify-content-center">
                            
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal --><!-- end tr -->

                                    <div id="editHistory" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 overflow-hidden">
                                                <div class="modal-header p-3">
                                                    <h4 class="card-title mb-0">Update History</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                            
                                                <div class="modal-body">
                                                    <form action="{{ url('/admin/updateHistory') }}" method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="history_id" value="">
                            
                                                        <div class="mb-3">
                                                            <label for="title" class="form-label">Title</label>
                                                            <input type="text" class="form-control" name="title" id="title" value="">
                                                        </div>
                            
                                                        <div class="mb-3">
                                                            <label for="description" class="form-label">Description</label>
                                                            <textarea class="form-control" name="description" id="description"></textarea>
                                                        </div>
                                                        <hr>
                                                        <div class="text-end">
                                                            <button type="submit" class="btn btn-primary">Save InfoCard</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                </div>
                            </div>

                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div><!-- end col -->

                <div class="col-xxl-4 col-lg-6">
                    <div class="card card-height-100">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Tour</h4>
                            <div class="flex-shrink-0">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTour">Add/Update Tour</button>
                                    @if(!empty($examination->tour))
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteTour">Delete Tour</button>
                                    @endif
                            </div>
                        </div><!-- end card header -->

                        <div class="card-body">
                            @if($examination->tour)
                                <h4 class="card-title mb-0 flex-grow-1">{{ !empty($examination->tour) ? $examination->tour->title : '' }}</h4>
                                <hr>
                                {!! !empty($examination->tour) ? $examination->tour->description : '' !!}
                                <hr>
                                <!-- Ratio Video 16:9 -->
                                <div class="ratio ratio-16x9">
                                    <iframe src="https://www.youtube.com/embed/{{ !empty($examination->tour) ? $examination->tour->link : ''}}" title="{{ !empty($examination->tour) ? $examination->tour->title : '' }}" allowfullscreen></iframe>
                                </div>
                            @endif
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div><!-- end col -->

                <div class="col-xxl-8 col-lg-6">
                    <div class="card card-height-100">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">InfoCard</h4>
                            <div class="flex-shrink-0">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateInfoCard">Save InfoCard</button>
                                @if(!empty($examination->infoCard))
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteInfoCard"><i class="ri-delete-bin-5-line"></i></button>
                                @endif
                            </div>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <h4 class="card-title mb-0 flex-grow-1">{{ !empty($examination->infoCard) ? $examination->infoCard->title : '' }}</h4>
                            <hr>
                            {!! !empty($examination->infoCard) ? $examination->infoCard->description : '' !!}
                            <hr>
                            @if(!empty($examination->infoCard))
                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addInfoCardItem">Add Card Item</button>
                            @endif
                            <hr>
                            <div class="table-responsive table-card">
                                <table class="table table-borderless table-nowrap align-middle mb-0">
                                    <thead class="table-light text-muted">
                                        <tr>
                                            <th scope="col">Title</th>
                                            <th scope="col">Icon</th>
                                            <th scope="col"></th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($$examination->infoCard->items))
                                        @foreach($examination->infoCard->items as $item)
                                            <tr>
                                                <td class="d-flex">
                                                    <div>
                                                        <p class="fs-12 mb-0 text-muted">{{ $item->title }}</p>
                                                    </div>
                                                </td>

                                                <td>
                                                    <i class="fa fa-{{$item->icon }}"></i>
                                                </td>

                                                <td>
                                                    {!! $item->description !!}
                                                </td>

                                                <td style="width:5%;">
                                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editCardItem{{$item->id}}" style="margin: 5px" class="link-primary"><i class="ri-edit-circle-fill"></i></a>
                                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#deleteCardItem{{$item->id}}" style="margin: 5px" class="link-danger"><i class="ri-delete-bin-5-line"></i></a>
                                                </td>
                                            </tr>
                                            <div id="deleteCardItem{{$item->id}}" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body text-center p-5">
                                                            <div class="text-end">
                                                                <button type="button" class="btn-close text-end" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="mt-2">
                                                                <lord-icon src="https://cdn.lordicon.com/wwneckwc.json" trigger="hover" style="width:150px;height:150px">
                                                                </lord-icon>
                                                                <h4 class="mb-3 mt-4">Are you sure you want to delete <br>{{ $item->title }}?</h4>
                                                                <form action="{{ url('/admin/deleteInfoCardItem') }}" method="POST">
                                                                    @csrf
                                                                    <input name="info_card_item_id" type="hidden" value="{{$item->id}}">
        
                                                                    <hr>
                                                                    <button type="submit" class="btn btn-danger w-100">Yes, Delete</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer bg-light p-3 justify-content-center">
        
                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal --><!-- end tr -->
                                            <div id="editCardItem{{$item->id}}" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body p-5">
                                                            <div class="text-end">
                                                                <button type="button" class="btn-close text-end" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="mt-2">
                                                                <form action="{{ url('/admin/updateInfoCardItem') }}" method="POST">
                                                                    @csrf
                                                                    <input name="info_card_item_id" type="hidden" value="{{$item->id}}">
        
                                                                    <div class="mb-3">
                                                                        <label for="title" class="form-label"> Title</label>
                                                                        <input type="text" class="form-control" name="title" id="title" value="{{ $item->title }}">
                                                                    </div>
                                        
                                                                    <div class="mb-3">
                                                                        <label for="description" class="form-label">Description</label>
                                                                        <textarea class="form-control" name="description" id="description" >{!! $item->description !!}</textarea>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="icon" class="form-label">Select Icon</label>
                                                                        <select class="form-select" aria-label="icon" name="icon">
                                                                            <option value= "">Select Icon </option>
                                                                            <option value="address-book">&#xf2b9; Address Book</option>
                                                                            <option value="anchor">&#xf13d; Anchor</option>
                                                                            <option value="battery-full">&#xf240; Battery Full</option>
                                                                            <option value="bell">&#xf0f3; Bell</option>
                                                                            <option value="book">&#xf02d; Book</option>
                                                                            <option value="calendar">&#xf073; Calendar</option>
                                                                            <option value="car">&#xf1b9; Car</option>
                                                                            <option value="check">&#xf00c; Check</option>
                                                                            <option value="cog">&#xf013; Cog</option>
                                                                            <option value="desktop">&#xf108; Desktop</option>
                                                                            <option value="dice">&#xf522; Dice</option>
                                                                            <option value="envelope">&#xf0e0; Envelope</option>
                                                                            <option value="file">&#xf15b; File</option>
                                                                            <option value="flag">&#xf024; Flag</option>
                                                                            <option value="gift">&#xf06b; Gift</option>
                                                                            <option value="heart">&#xf004; Heart</option>
                                                                            <option value="id-badge">&#xf2c1; ID Badge</option>
                                                                            <option value="leaf">&#xf06c; Leaf</option>
                                                                            <option value="lock">&#xf023; Lock</option>
                                                                            <option value="map">&#xf279; Map</option>
                                                                            <option value="microphone">&#xf130; Microphone</option>
                                                                            <option value="mobile-alt">&#xf3cd; Mobile</option>
                                                                            <option value="music">&#xf001; Music</option>
                                                                            <option value="paper-plane">&#xf1d8; Paper Plane</option>
                                                                            <option value="paw">&#xf1b0; Paw</option>
                                                                            <option value="pen">&#xf304; Pen</option>
                                                                            <option value="phone">&#xf095; Phone</option>
                                                                            <option value="plane">&#xf072; Plane</option>
                                                                            <option value="print">&#xf02f; Print</option>
                                                                            <option value="rocket">&#xf135; Rocket</option>
                                                                            <option value="search">&#xf002; Search</option>
                                                                            <option value="shopping-bag">&#xf290; Shopping Bag</option>
                                                                            <option value="star">&#xf005; Star</option>
                                                                            <option value="sun">&#xf185; Sun</option>
                                                                            <option value="tablet">&#xf10a; Tablet</option>
                                                                            <option value="thumbs-up">&#xf164; Thumbs Up</option>
                                                                            <option value="tools">&#xf7d9; Tools</option>
                                                                            <option value="tree">&#xf1bb; Tree</option>
                                                                            <option value="user">&#xf007; User</option>
                                                                            <option value="video">&#xf03d; Video</option>
                                                                            <option value="wallet">&#xf555; Wallet</option>
                                                                            <option value="wheelchair">&#xf193; Wheelchair</option>
                                                                            <option value="wrench">&#xf0ad; Wrench</option>
                                                                            <option value="yen-sign">&#xf157; Yen Sign</option>
                                                                            <option value="zoom-in">&#xf00e; Zoom In</option>
                                                                            <option value="cloud">&#xf0c2; Cloud</option>
                                                                            <option value="coffee">&#xf0f4; Coffee</option>
                                                                            <option value="eye">&#xf06e; Eye</option><option value="address-book">&#xf2b9; Address Book</option>
                                                                            <option value="anchor">&#xf13d; Anchor</option>
                                                                            <option value="battery-full">&#xf240; Battery Full</option>
                                                                            <option value="bell">&#xf0f3; Bell</option>
                                                                            <option value="book">&#xf02d; Book</option>
                                                                            <option value="calendar">&#xf073; Calendar</option>
                                                                            <option value="car">&#xf1b9; Car</option>
                                                                            <option value="check">&#xf00c; Check</option>
                                                                            <option value="cog">&#xf013; Cog</option>
                                                                            <option value="desktop">&#xf108; Desktop</option>
                                                                            <option value="dice">&#xf522; Dice</option>
                                                                            <option value="envelope">&#xf0e0; Envelope</option>
                                                                            <option value="file">&#xf15b; File</option>
                                                                            <option value="flag">&#xf024; Flag</option>
                                                                            <option value="gift">&#xf06b; Gift</option>
                                                                            <option value="heart">&#xf004; Heart</option>
                                                                            <option value="id-badge">&#xf2c1; ID Badge</option>
                                                                            <option value="leaf">&#xf06c; Leaf</option>
                                                                            <option value="lock">&#xf023; Lock</option>
                                                                            <option value="map">&#xf279; Map</option>
                                                                            <option value="microphone">&#xf130; Microphone</option>
                                                                            <option value="mobile-alt">&#xf3cd; Mobile</option>
                                                                            <option value="music">&#xf001; Music</option>
                                                                            <option value="paper-plane">&#xf1d8; Paper Plane</option>
                                                                            <option value="paw">&#xf1b0; Paw</option>
                                                                            <option value="pen">&#xf304; Pen</option>
                                                                            <option value="phone">&#xf095; Phone</option>
                                                                            <option value="plane">&#xf072; Plane</option>
                                                                            <option value="print">&#xf02f; Print</option>
                                                                            <option value="rocket">&#xf135; Rocket</option>
                                                                            <option value="search">&#xf002; Search</option>
                                                                            <option value="shopping-bag">&#xf290; Shopping Bag</option>
                                                                            <option value="star">&#xf005; Star</option>
                                                                            <option value="sun">&#xf185; Sun</option>
                                                                            <option value="tablet">&#xf10a; Tablet</option>
                                                                            <option value="thumbs-up">&#xf164; Thumbs Up</option>
                                                                            <option value="tools">&#xf7d9; Tools</option>
                                                                            <option value="tree">&#xf1bb; Tree</option>
                                                                            <option value="user">&#xf007; User</option>
                                                                            <option value="video">&#xf03d; Video</option>
                                                                            <option value="wallet">&#xf555; Wallet</option>
                                                                            <option value="wheelchair">&#xf193; Wheelchair</option>
                                                                            <option value="wrench">&#xf0ad; Wrench</option>
                                                                            <option value="yen-sign">&#xf157; Yen Sign</option>
                                                                            <option value="zoom-in">&#xf00e; Zoom In</option>
                                                                            <option value="cloud">&#xf0c2; Cloud</option>
                                                                            <option value="coffee">&#xf0f4; Coffee</option>
                                                                            <option value="eye">&#xf06e; Eye</option>
                                                                            <option value="globe">&#xf0ac; Globe</option>
                                                                            <option value="graduation-cap">&#xf19d; Graduation Cap</option>
                                                                            <option value="home">&#xf015; Home</option>
                                                                            <option value="laptop">&#xf109; Laptop</option>
                                                                            <option value="moon">&#xf186; Moon</option>
                                                                            <option value="newspaper">&#xf1ea; Newspaper</option>
                                                                            <option value="paint-brush">&#xf1fc; Paint Brush</option>
                                                                            <option value="pencil">&#xf040; Pencil</option>
                                                                            <option value="recycle">&#xf1b8; Recycle</option>
                                                                            <option value="server">&#xf233; Server</option>
                                                                            <option value="smile">&#xf118; Smile</option>
                                                                            <option value="thumbs-down">&#xf165; Thumbs Down</option>
                                                                            <option value="trash">&#xf1f8; Trash</option>
                                                                            <option value="umbrella">&#xf0e9; Umbrella</option>
                                                                            <option value="wifi">&#xf1eb; WiFi</option>
                                                                        </select>
                                                                    </div>
                                                                    <hr>
                                                                    <button type="submit" class="btn btn-info w-100">Save changes</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer bg-light p-3 justify-content-center">
        
                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal --><!-- end tr -->
                                        @endforeach
                                    @endif
                                    </tbody><!-- end tbody -->
                                </table><!-- end table -->
                            </div>
                                
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div><!-- end col -->

                
            </div><!-- end row -->



        <div id="addMetrics" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 overflow-hidden">
                    <div class="modal-header p-3">
                        <h4 class="card-title mb-0">Add Metric</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form action="{{ url('/admin/addMetrics') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="page_id" value="{{ $examination->id }}">
                            <div class="mb-3">
                                <label for="title" class="form-label">Metric Title</label>
                                <input type="text" class="form-control" name="title" id="name" placeholder="Enter Metric Title">
                            </div>

                            <div class="mb-3">
                                <label for="score" class="form-label">Score</label>
                                <input class="form-control" name="score" id="score" placeholder="Score">
                            </div>
                            <hr>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Add Metric</button>
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div id="addTour" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 overflow-hidden">
                    <div class="modal-header p-3">
                        <h4 class="card-title mb-0">Add Tour</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form action="{{ url('/admin/updateTour') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="page_id" value="{{ $examination->id }}">
                            <input type="hidden" name="tour_id" value="{{ !empty($examination->tour) ? $examination->tour->id : '' }}">

                            <div class="mb-3">
                                <label for="title" class="form-label">Tour Heading</label>
                                <input type="text" class="form-control" name="title" id="name" value="{{ !empty($examination->tour) ? $examination->tour->title : '' }}">
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="score" >{!! !empty($examination->tour) ? $examination->tour->description : '' !!}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="link" class="form-label">Video Link</label>
                                <input type="text" class="form-control" name="link" id="name" value="{{ !empty($examination->tour) ? $examination->tour->link : '' }}">
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Image <code>Dimension: 1920px by 780px</code></label>
                                <input type="file" class="form-control" name='image' id="image">
                            </div>
                            <hr>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Save Tour</button>
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div id="deleteTour" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center p-5">
                        <div class="text-end">
                            <button type="button" class="btn-close text-end" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="mt-2">
                            <lord-icon src="https://cdn.lordicon.com/wwneckwc.json" trigger="hover" style="width:150px;height:150px">
                            </lord-icon>
                            <h4 class="mb-3 mt-4">Are you sure you want to delete <br>{{ !empty($examination->tour) ? $examination->tour->title : '' }}?</h4>
                            <form action="{{ url('/admin/deleteTour') }}" method="POST">
                                @csrf
                                <input name="tour_id" type="hidden" value="{{ !empty($examination->tour) ? $examination->tour->id : '' }}">

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

        <div id="updateInfoCard" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 overflow-hidden">
                    <div class="modal-header p-3">
                        <h4 class="card-title mb-0">Save InfoCard</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form action="{{ url('/admin/updateInfoCard') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="page_id" value="{{ $examination->id }}">
                            <input type="hidden" name="info_card_id" value="{{ !empty($examination->infoCard) ? $examination->infoCard->id : '' }}">

                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" name="title" id="title" value="{{ !empty($examination->infoCard) ? $examination->infoCard->title : '' }}">
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="description">{!! !empty($examination->infoCard) ? $examination->infoCard->description : '' !!}</textarea>
                            </div>
                            <hr>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Save InfoCard</button>
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div id="deleteInfoCard" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center p-5">
                        <div class="text-end">
                            <button type="button" class="btn-close text-end" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="mt-2">
                            <lord-icon src="https://cdn.lordicon.com/wwneckwc.json" trigger="hover" style="width:150px;height:150px">
                            </lord-icon>
                            <h4 class="mb-3 mt-4">Are you sure you want to delete <br>{{ !empty($examination->infoCard) ? $examination->infoCard->title : '' }}?</h4>
                            <form action="{{ url('/admin/deleteInfoCard') }}" method="POST">
                                @csrf
                                <input name="infoCard_id" type="hidden" value="{{ !empty($examination->infoCard) ? $examination->infoCard->id : '' }}">

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

        <div id="addInfoCardItem" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 overflow-hidden">
                    <div class="modal-header p-3">
                        <h4 class="card-title mb-0">Add InfoCard</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form action="{{ url('/admin/addInfoCardItem') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="page_id" value="{{ $examination->id }}">
                            <input type="hidden" name="info_card_id" value="{{ !empty($examination->infoCard) ? $examination->infoCard->id : '' }}">

                            <div class="mb-3">
                                <label for="title" class="form-label"> Sub Title</label>
                                <input type="text" class="form-control" name="title" id="name" placeholder="Enter Sub Title">
                            </div>
                            <div class="mb-3">
                                <label for="Description" class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="description" placeholder="Description"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="icon" class="form-label">Select Icon</label>
                                <select class="form-select" aria-label="icon" name="icon">
                                    <option value= "">Select Icon </option>
                                    <option value="address-book">&#xf2b9; Address Book</option>
                                    <option value="anchor">&#xf13d; Anchor</option>
                                    <option value="battery-full">&#xf240; Battery Full</option>
                                    <option value="bell">&#xf0f3; Bell</option>
                                    <option value="book">&#xf02d; Book</option>
                                    <option value="calendar">&#xf073; Calendar</option>
                                    <option value="car">&#xf1b9; Car</option>
                                    <option value="check">&#xf00c; Check</option>
                                    <option value="cog">&#xf013; Cog</option>
                                    <option value="desktop">&#xf108; Desktop</option>
                                    <option value="dice">&#xf522; Dice</option>
                                    <option value="envelope">&#xf0e0; Envelope</option>
                                    <option value="file">&#xf15b; File</option>
                                    <option value="flag">&#xf024; Flag</option>
                                    <option value="gift">&#xf06b; Gift</option>
                                    <option value="heart">&#xf004; Heart</option>
                                    <option value="id-badge">&#xf2c1; ID Badge</option>
                                    <option value="leaf">&#xf06c; Leaf</option>
                                    <option value="lock">&#xf023; Lock</option>
                                    <option value="map">&#xf279; Map</option>
                                    <option value="microphone">&#xf130; Microphone</option>
                                    <option value="mobile-alt">&#xf3cd; Mobile</option>
                                    <option value="music">&#xf001; Music</option>
                                    <option value="paper-plane">&#xf1d8; Paper Plane</option>
                                    <option value="paw">&#xf1b0; Paw</option>
                                    <option value="pen">&#xf304; Pen</option>
                                    <option value="phone">&#xf095; Phone</option>
                                    <option value="plane">&#xf072; Plane</option>
                                    <option value="print">&#xf02f; Print</option>
                                    <option value="rocket">&#xf135; Rocket</option>
                                    <option value="search">&#xf002; Search</option>
                                    <option value="shopping-bag">&#xf290; Shopping Bag</option>
                                    <option value="star">&#xf005; Star</option>
                                    <option value="sun">&#xf185; Sun</option>
                                    <option value="tablet">&#xf10a; Tablet</option>
                                    <option value="thumbs-up">&#xf164; Thumbs Up</option>
                                    <option value="tools">&#xf7d9; Tools</option>
                                    <option value="tree">&#xf1bb; Tree</option>
                                    <option value="user">&#xf007; User</option>
                                    <option value="users">&#xf007; Users</option>
                                    <option value="video">&#xf03d; Video</option>
                                    <option value="wallet">&#xf555; Wallet</option>
                                    <option value="wheelchair">&#xf193; Wheelchair</option>
                                    <option value="wrench">&#xf0ad; Wrench</option>
                                    <option value="yen-sign">&#xf157; Yen Sign</option>
                                    <option value="zoom-in">&#xf00e; Zoom In</option>
                                    <option value="cloud">&#xf0c2; Cloud</option>
                                    <option value="coffee">&#xf0f4; Coffee</option>
                                    <option value="eye">&#xf06e; Eye</option>
                                    <option value="globe">&#xf0ac; Globe</option>
                                    <option value="graduation-cap">&#xf19d; Graduation Cap</option>
                                    <option value="home">&#xf015; Home</option>
                                    <option value="laptop">&#xf109; Laptop</option>
                                    <option value="moon">&#xf186; Moon</option>
                                    <option value="newspaper">&#xf1ea; Newspaper</option>
                                    <option value="paint-brush">&#xf1fc; Paint Brush</option>
                                    <option value="pencil">&#xf040; Pencil</option>
                                    <option value="recycle">&#xf1b8; Recycle</option>
                                    <option value="server">&#xf233; Server</option>
                                    <option value="smile">&#xf118; Smile</option>
                                    <option value="thumbs-down">&#xf165; Thumbs Down</option>
                                    <option value="trash">&#xf1f8; Trash</option>
                                    <option value="umbrella">&#xf0e9; Umbrella</option>
                                    <option value="wifi">&#xf1eb; WiFi</option>
                                </select>
                            </div>
                            <hr>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Add InfoCard Item</button>
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div id="addHistory" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 overflow-hidden">
                    <div class="modal-header p-3">
                        <h4 class="card-title mb-0">Add History</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form action="{{ url('/admin/addHistory') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="page_id" value="{{ $examination->id }}">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" name="title" id="name" placeholder="Enter Title">
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Details</label>
                                <textarea class="form-control" name="description" id="description"></textarea>
                            </div>
                            <hr>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Add History</button>
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div id="addCard" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 overflow-hidden">
                    <div class="modal-header p-3">
                        <h4 class="card-title mb-0">Add Slider Card</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form action="{{ url('/admin/addSliderCard') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="page_id" value="{{ $examination->id }}">

                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" name="title" id="name" placeholder="Enter Title">
                            </div>
                            <div class="mb-3">
                                <label for="Description" class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="description" placeholder="Description"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="icon" class="form-label">Select Icon</label>
                                <select class="form-select" aria-label="icon" name="icon">
                                    <option value= "">Select Icon </option>
                                    <option value="address-book">&#xf2b9; Address Book</option>
                                    <option value="anchor">&#xf13d; Anchor</option>
                                    <option value="battery-full">&#xf240; Battery Full</option>
                                    <option value="bell">&#xf0f3; Bell</option>
                                    <option value="book">&#xf02d; Book</option>
                                    <option value="calendar">&#xf073; Calendar</option>
                                    <option value="car">&#xf1b9; Car</option>
                                    <option value="check">&#xf00c; Check</option>
                                    <option value="cog">&#xf013; Cog</option>
                                    <option value="desktop">&#xf108; Desktop</option>
                                    <option value="dice">&#xf522; Dice</option>
                                    <option value="envelope">&#xf0e0; Envelope</option>
                                    <option value="file">&#xf15b; File</option>
                                    <option value="flag">&#xf024; Flag</option>
                                    <option value="gift">&#xf06b; Gift</option>
                                    <option value="heart">&#xf004; Heart</option>
                                    <option value="id-badge">&#xf2c1; ID Badge</option>
                                    <option value="leaf">&#xf06c; Leaf</option>
                                    <option value="lock">&#xf023; Lock</option>
                                    <option value="map">&#xf279; Map</option>
                                    <option value="microphone">&#xf130; Microphone</option>
                                    <option value="mobile-alt">&#xf3cd; Mobile</option>
                                    <option value="music">&#xf001; Music</option>
                                    <option value="paper-plane">&#xf1d8; Paper Plane</option>
                                    <option value="paw">&#xf1b0; Paw</option>
                                    <option value="pen">&#xf304; Pen</option>
                                    <option value="phone">&#xf095; Phone</option>
                                    <option value="plane">&#xf072; Plane</option>
                                    <option value="print">&#xf02f; Print</option>
                                    <option value="rocket">&#xf135; Rocket</option>
                                    <option value="search">&#xf002; Search</option>
                                    <option value="shopping-bag">&#xf290; Shopping Bag</option>
                                    <option value="star">&#xf005; Star</option>
                                    <option value="sun">&#xf185; Sun</option>
                                    <option value="tablet">&#xf10a; Tablet</option>
                                    <option value="thumbs-up">&#xf164; Thumbs Up</option>
                                    <option value="tools">&#xf7d9; Tools</option>
                                    <option value="tree">&#xf1bb; Tree</option>
                                    <option value="user">&#xf007; User</option>
                                    <option value="users">&#xf007; Users</option>
                                    <option value="video">&#xf03d; Video</option>
                                    <option value="wallet">&#xf555; Wallet</option>
                                    <option value="wheelchair">&#xf193; Wheelchair</option>
                                    <option value="wrench">&#xf0ad; Wrench</option>
                                    <option value="yen-sign">&#xf157; Yen Sign</option>
                                    <option value="zoom-in">&#xf00e; Zoom In</option>
                                    <option value="cloud">&#xf0c2; Cloud</option>
                                    <option value="coffee">&#xf0f4; Coffee</option>
                                    <option value="eye">&#xf06e; Eye</option>
                                    <option value="globe">&#xf0ac; Globe</option>
                                    <option value="graduation-cap">&#xf19d; Graduation Cap</option>
                                    <option value="home">&#xf015; Home</option>
                                    <option value="laptop">&#xf109; Laptop</option>
                                    <option value="moon">&#xf186; Moon</option>
                                    <option value="newspaper">&#xf1ea; Newspaper</option>
                                    <option value="paint-brush">&#xf1fc; Paint Brush</option>
                                    <option value="pencil">&#xf040; Pencil</option>
                                    <option value="recycle">&#xf1b8; Recycle</option>
                                    <option value="server">&#xf233; Server</option>
                                    <option value="smile">&#xf118; Smile</option>
                                    <option value="thumbs-down">&#xf165; Thumbs Down</option>
                                    <option value="trash">&#xf1f8; Trash</option>
                                    <option value="umbrella">&#xf0e9; Umbrella</option>
                                    <option value="wifi">&#xf1eb; WiFi</option>
                                </select>
                            </div>
                            <hr>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Add Slider Card</button>
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div id="addSlider" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 overflow-hidden">
                    <div class="modal-header p-3">
                        <h4 class="card-title mb-0">Add Slider</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form action="{{ url('/admin/addSlider') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="page_id" value="{{ $examination->id }}">

                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" name="title" id="name" placeholder="Enter Title">
                            </div>

                            <div class="mb-3">
                                <label for="Description" class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="description" placeholder="Description"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="text" class="form-label">Button Text</label>
                                <input type="text" class="form-control" name="button_text" id="text" placeholder="Enter Button Text">
                            </div>
                            
                            <div class="mb-3">
                                <label for="link" class="form-label">Button Link</label>
                                <input type="text" class="form-control" name="button_link" id="link" placeholder="Enter Button Link">
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Image <code>Dimension: 1920px by 780px</code></label>
                                <input type="file" class="form-control" name='image' id="image">
                            </div>

                            <hr>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Add Slider</button>
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div id="updatePageButton" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 overflow-hidden">
                    <div class="modal-header p-3">
                        <h4 class="card-title mb-0">Save Page Button</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form action="{{ url('/admin/updatePageButton') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="page_id" value="{{ $examination->id }}">

                            <div class="mb-3">
                                <label for="text" class="form-label">Button Text</label>
                                <input type="text" class="form-control" name="button_text" id="text" value="{{ $examination->button_text }}">
                            </div>

                            <div class="mb-3">
                                <label for="link" class="form-label">Button Link</label>
                                <input type="url" class="form-control" name="button_link" id="link" value="{{ $examination->button_link }}">
                            </div>
                            <hr>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Save Page Button</button>
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        

@include('admin.adminIncludes.footer')
