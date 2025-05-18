@extends('layouts.backend')
@section('title','Projects')
@push('css')
<link rel="stylesheet" href="{{asset('backend/assets/vendors/toastr.js/toastr.min.css')}}">
<link rel="stylesheet" href="{{asset('backend/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('backend/assets/vendors/select2/select2.min.css')}}">
<style>
    .table th,
    .datepicker table th,
    .table td,
    .datepicker table td {
        white-space: normal !important;
        padding: 0.3rem .5rem;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 1.5;
    }

    .select2-container .select2-selection--single {
        height: 37px;
    }
</style>
@endpush

@section('content')

<div class="page-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0"></h4>
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page">Plots</li>
                    <li class="breadcrumb-item active" aria-current="page">Manage</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <button type="button" class="btn btn-primary btn-icon-text mb-md-0" data-bs-toggle="modal" data-bs-target="#landPlotModal">
                <i class="btn-icon-prepend" data-feather="plus-circle"></i>
                Add New
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-xl-12 stretch-card">
            <div class="row flex-grow-1">

                @php $sum = 0; @endphp

                @foreach($sstatus as $status)
                @php
                $status_name = json_decode($status->data_values);
                @endphp
                <div class="col-md-3 grid-margin stretch-card" style="color:{{$status_name->color}}">
                    <div class="card">
                        <div class="card-body">

                            <h5 class="card-title">{{ $status_name->name }}</h5>
                            <p class="card-text">{{ $status->total }}</p>
                        </div>
                    </div>
                </div>
                @php $sum = $sum+$status->total; @endphp
                @endforeach

                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total</h5>
                            <p class="card-text">{{$sum}}</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <div class="row">
        @include('backend.slices.messages')
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title float-left">Land Plots</h6>
                    <div class="table-responsive">
                        <table id="plotDataTable" class="table">
                            <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th>PlotNo</th>
                                    <th>Sector</th>
                                    <th>Road.No</th>
                                    <th>Plot.Area</th>
                                    <th>Road.Width</th>
                                    <th>Facing</th>
                                    <th>Sales.Person</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="landPlotModal" tabindex="-1" role="dialog" aria-labelledby="landPlotModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="landPlotModalLabel">Add Land File Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <form class="form-horizontal" id="landPlotForm" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-danger" style="display:none"></div>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="form-label">Estate Projects </label>
                                    <select class="form-select liveSelect2" data-width="100%" name="project">

                                        <option selected disabled>Select Project</option>
                                        @foreach(App\Models\EstateProject::where('parent_id', NULL)->get() as $project)
                                        @php
                                        $subparents = App\Models\EstateProject::where('parent_id', $project->id)->get()
                                        @endphp
                                        <option value="{{$project->id}}" {{count($subparents) > 0 ? 'disabled' : '' }}>{{$project->name}}</option>
                                        @foreach($subparents as $subproject)
                                        <option value="{{$subproject->id}}"> -- {{$subproject->name}}</option>
                                        @endforeach
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="form-label">Sector/Block</label>
                                    <input type="text" name="sector" class="form-control" placeholder="Entry File No">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="form-label">Road No</label>
                                    <input type="text" name="road_no" class="form-control" placeholder="Entry File No">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="form-label">Road Width(ft)</label>
                                    <input type="text" name="road_no" class="form-control" placeholder="Entry File No">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="form-label">Plot No</label>
                                    <input type="text" name="plot_no" class="form-control" placeholder="Entry Plot No">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="form-label">Plot Area</label>
                                    <input type="text" name="plot_size" class="form-control" placeholder="Entry File No">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="form-label"> Faching </label>
                                    <select class="form-select mb-3" name="mouza" id="mouza">
                                        <option selected disabled>Select Faching</option>
                                        <option>East</option>
                                        <option>West</option>
                                        <option>North</option>
                                        <option>South</option>
                                        <option>North-East</option>
                                        <option>North-West</option>
                                        <option>South-East</option>
                                        <option>South-West</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Descriptions</label>
                                    <textarea name="description" class="form-control" placeholder="Remarks" rows='1'></textarea>
                                </div>
                            </div><!-- Col -->
                        </div> <!-- Row -->

                    </div>
                    <div class="modal-footer">
                        <button type="button" id="landPlotSubmitBtn" class="btn btn-primary mr-2">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal -->

    <!-- Start Status Modal Edit -->
    <div class="modal fade" id="editStatusModal" tabindex="-1" aria-labelledby="editStatusModallLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStatusModallLabel">Modal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <form id="updatePlotStatusForm">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-4" id="plotStatusField">
                            </div><!-- Col -->
                        </div><!-- Row -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="updatePlotStatusBtn" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Status Modal Edit -->


</div>

@endsection

@push('js')
<script src="{{asset('backend/assets/vendors/select2/select2.min.js')}}"></script>
<script src="{{asset('backend/assets/js/select2.js')}}"></script>
<script src="{{asset('backend/assets/vendors/datatables.net/jquery.dataTables.js')}}"></script>
<script src="{{asset('backend/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js')}}"></script>
<script src="{{asset('backend/assets/js/data-table.js')}}"></script>
<script src="{{asset('backend/assets/vendors/toastr.js/toastr.min.js')}}"></script>

<script>
    function uuidv4() {
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
            var r = Math.random() * 16 | 0,
                v = c == 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
        });
    }

    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function printErrorMsg(msg) {
            toastr.options = {
                "closeButton": true,
                "newestOnTop": true,
                "positionClass": "toast-top-right"
            };
            var error_html = '';
            for (var count = 0; count < msg.length; count++) {
                error_html += '<p>' + msg[count] + '</p>';
            }
            toastr.error(error_html);
        }

        function printSuccessMsg(msg) {
            toastr.options = {
                "closeButton": true,
                "newestOnTop": true,
                "positionClass": "toast-top-right"
            };
            toastr.success(msg);
        }

        $('.liveSelect2').select2({
            dropdownParent: $('#landPlotModal')
        });
        // C.S Add More

        $(".party-info").on('click', '.trash', function() {
            $(this).closest('.cs-cont').remove();
            return false;
        });

        // store data function

        $('#landPlotSubmitBtn').click(function(e) {
            //console.log($('#addAssetForm').serialize());
            $.ajax({
                url: "{{route('user.plot.store')}}",
                method: 'POST',
                data: $('#landPlotForm').serialize(),
                success: function(result) {
                    if (result.errors) {
                        printErrorMsg(result.errors);
                    } else {
                        printSuccessMsg(result.success);
                        $('.alert-danger').hide();
                        $('#landPlotForm').trigger("reset");
                        $("#plotDataTable").DataTable().draw();
                    }
                }
            });
            e.preventDefault();

        });

        //function for get plot data
        $(function() {
            var table = $('#plotDataTable').DataTable({
                "autoWidth": false,
                processing: true,
                serverSide: true,
                "order": [
                    [0, "DESC"]
                ],
                ajax: {
                    "url": "{{ route('user.plot.index') }}",
                    "dataType": "json",
                    "type": "GET",
                    data: {
                        "_token": " {{csrf_token()}} "
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'plot_no',
                        name: 'plot_no'
                    },
                    {
                        data: 'sector_no',
                        name: 'sector_no'
                    },
                    {
                        data: 'road_no',
                        name: 'road_no'
                    },
                    {
                        data: 'plot_size',
                        name: 'plot_size'
                    },
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'facing',
                        name: 'facing'
                    },
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 's_status',
                        name: 's_status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

        });
        // end plot data

         /*------------------------------------------
        Click to change status button Button
        -------------------------------------------- */
        $('body').on('click', '.editSaleStatus', function () {
            var plot_id = $(this).data('id');
            console.log(plot_id);
            $.get("{{url('user/plot/status')}}"+'/'+plot_id+"/edit", function (data) {
                $('#editStatusModallLabel').html("Plot: "+data.plot_no);
                $('#editStatusModal').modal('show');
                $('#plotStatusField').html('<div class="mb-3">'+
										'<label for="status" class="form-label">Change Status</label>'+
										'<select class="form-select" id="status" name="status">'+
											'<option selected="" disabled="">Select status</option>'+
											'<option value="2">Booked</option>'+
											'<option value="3">Sold</option>'+
										'</select>'+
                                        '<input type="hidden" id="plot_id" name="plot_id" value="'+data.id+'">'+
									'</div>');
            })
        });

        // start data function
        $('#updatePlotStatusBtn').click(function(e) {
            e.preventDefault(e);
            $.ajax({
                url: "{{route('user.plot.status.update')}}",
                method: 'POST',
                data: $('#updatePlotStatusForm').serialize(),
                success: function(result) {
                    if (result.errors) {
                        printErrorMsg(result.errors);
                    } else {
                        printSuccessMsg(result.success);
                        $('.alert-danger').hide();
                        $('#updatePlotStatusForm').trigger("reset");
                        $("#plotDataTable").DataTable().draw();
                        $('#editStatusModal').modal('hide');
                    }
                }
            });
            e.preventDefault();
        });
        // end status function



    });
</script>
@endpush