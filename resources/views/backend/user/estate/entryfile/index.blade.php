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
    }
    body.modal-open {
        overflow: auto;
    }

    .table th,
    .table td {
        padding: 0.7rem 0.5375rem !important;
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
                    <li class="breadcrumb-item active" aria-current="page">Entry File</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <button type="button" class="btn btn-primary btn-icon-text mb-md-0" data-bs-toggle="modal" data-bs-target="#entryFileModal">
                <i class="btn-icon-prepend" data-feather="plus-circle"></i>
                Add New
            </button>
        </div>
    </div>

    <div class="row">
        @include('backend.slices.messages')
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title float-left">Land File Information</h6>
                    <div class="table-responsive">
                        <table id="dataTableEntryFile" class="table">
                            <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th>File No</th>
                                    <th>Agent(s)</th>
                                    <th>Landowners</th>
                                    <th>Project</th>
                                    <th>Mouza</th>
                                    <th>Khatian</th>
                                    <th style="background-color: #f7f7f7;">Dag(RS/BS)</th>
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
    <div class="modal fade" id="entryFileModal" tabindex="-1" role="dialog" aria-labelledby="entryFileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="entryFileModalLabel">Add Land File Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <form class="form-horizontal" id="entryFileForm" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-danger" style="display:none"></div>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="form-label">Entry File No *</label>
                                    <input type="text" name="file_no" class="form-control" placeholder="Entry File No">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="form-label"> Khatian Type *</label>
                                    <select class="form-select" name="khatian_type" id="khatian_type">
                                        <option selected disabled>Select Type</option>
                                        @foreach(App\Models\EstateLookUp::where('data_type', 'khatian')->get() as $ktype)
                                            <option value="{{$ktype->data_keys}}">{{$ktype->data_values}}</option>
                                        @endforeach
                                        <option value="0">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="form-label">Projects *</label>
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
                                    <label class="form-label"> Agent *</label>
                                    <select class="form-select liveSelect2 agent-media" name="agent" id="agent" data-width="100%" >
                               
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="form-label"> Name Of Mouza *</label>
                                    <select class="form-select mb-3 liveSelect2" name="mouza" id="mouza" data-width="100%">
                                        <option selected disabled>Select Mouza</option>
                                        @foreach(App\Models\Mouza::all() as $mouzas)
                                        <option value="{{$mouzas->id}}">{{$mouzas->name}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
									<label class="form-label">Landowner * </label>
									<select class="landowner form-select" name="landowner[]" multiple="multiple" data-width="100%">
									</select>
								</div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Remarks</label>
                                    <textarea name="remarks" class="form-control" placeholder="Remarks" rows='1'></textarea>
                                </div>
                            </div><!-- Col -->
                        </div> <!-- Row -->
                        <!-- CS khatian -->

                    </div>
                    <div class="modal-footer">
                        <button type="button" id="entryFileSubmit" class="btn btn-primary mr-2">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal -->

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
			var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
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
            dropdownParent: $('#entryFileModal')
        });

        // store data function

        $('#entryFileSubmit').click(function(e) {
            //console.log($('#addAssetForm').serialize());
            $.ajax({
                url: "{{route('user.entryFile.store')}}",
                method: 'POST',
                data: $('#entryFileForm').serialize(),
                success: function(result) {
                    if (result.errors) {
                        printErrorMsg(result.errors);
                    } else {
                        printSuccessMsg(result.success);
                        $('.alert-danger').hide();
                        $('#entryFileForm').trigger("reset");
                        $('#entryFileModal').modal('hide');
                        $("#dataTableEntryFile").DataTable().draw();
                    }
                }
            });
            e.preventDefault();

        });


        $(function() {
            var table = $('#dataTableEntryFile').DataTable({
                processing: true,
                serverSide: true,
                "order": [[ 0, "DESC" ]],
                "autoWidth": false,
                columnDefs: [
                    { "width": "15%", "targets": [2, 3] }
                ],
                ajax:{
                    "url": "{{ route('user.entryFile.index') }}",
                    "dataType": "json",
                    "type": "GET",
                    data:{"_token":" {{csrf_token()}} "}
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'file_no', name: 'file_no'},
                    {data: 'media_name', name: 'media_name'},
                    {data: 'landowner', name: 'landowner'},
                    {data: 'project_name', name: 'project_name'},
                    {data: 'mouza_name', name: 'mouza_name'},
                    {data: 'khatian_type', name: 'khatian_type'},
                    {data: 'dags', name: 'dags'},
                    {data: 'status', name: 'status'},
                    {data: 'username', name: 'username'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},                    
                ]
            });

        });


        $('.landowner').select2({
            dropdownParent: $('#entryFileModal'),
            placeholder: 'Select landowner',
            ajax: {
                url: "{{ url('/lanowner/search') }}",
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: data,
                    };
                },
                cache: true
            }
        });

        $('.agent-media').select2({
            dropdownParent: $('#entryFileModal'),
            placeholder: 'Select agent or media',
            ajax: {
                url: "{{ url('/agent/search') }}",
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: data,
                    };
                },
                cache: true
            }
        });

         // flatpickr issue editable soln
        document.addEventListener('focusin', (e) => {
            if (e.target.closest(".flatpickr-calendar") !== null) {
                e.stopImmediatePropagation();
            }
        });

    });
</script>
@endpush