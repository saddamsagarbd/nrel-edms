@extends('layouts.backend')
@section('title','Entry File Details')
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

    .list-group-item {
        padding: 0.3rem 0.55rem !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 1.5;
        height: 35px !important;
    }
</style>
@endpush

@section('content')

@php
$isRegistry = isExistFileActivity($entryFile->id, 2);
$isMutation = isExistFileActivity($entryFile->id, 3);
@endphp

<div class="page-content">

    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">EntryFile</a></li>
                    <li class="breadcrumb-item">Edit</li>
                    <li class="breadcrumb-item active" aria-current="page">{{$entryFile->project->name}}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-3 col-md-3 col-xl-3">
            @include('backend.slices.left-show-more')
        </div>

        <div class="col-9 col-md-9 col-xl-9 grid-margin">
            <div class="row">
                <div class="col-12 col-md-12 col-xl-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Edit Entry File Information</h6>
                            <form class="form-horizontal" id="entryFileForm" method="post">
                                @method('PUT')
                                @csrf
                                <div class="modal-body">
                                    <div class="alert alert-danger" style="display:none"></div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="mb-3">
                                                <label class="form-label">Entry File No</label>
                                                <input type="text" name="file_no" value="{{$entryFile->file_no}}" class="form-control" placeholder="Entry File No" disabled>
                                            </div>
                                        </div>
                                        <input type="hidden" name="entryFile_id" value="{{$entryFile->id}}">
                                        <div class="col-sm-3">
                                            <div class="mb-3">
                                                <label class="form-label">Estate Projects </label>
                                                <select class="form-select liveSelect2" data-width="100%" name="project" disabled>

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
                                                <label class="form-label"> Name Of Mouza </label>
                                                <select class="form-select mb-3" name="mouza" id="mouza" disabled>
                                                    <option selected disabled>Select Mouza</option>
                                                    @foreach(App\Models\Mouza::all() as $mouzas)
                                                    <option value="{{$mouzas->id}}" {{$mouzas->id == $entryFile->mouza_id ? 'selected' :''}}>{{$mouzas->name}} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="mb-3">
                                                <label class="form-label"> Khatian Type </label>
                                                <select class="form-select" name="khatian_type" id="khatian_type" disabled>
                                                    <option selected disabled>Select Type</option>
                                                    @foreach(App\Models\EstateLookUp::where('data_type', 'khatian')->get() as $ktype)
                                                    <option value="{{$ktype->data_keys}}" {{$ktype->id == $entryFile->khatype_id ? 'selected' :''}}>{{$ktype->data_values}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="mb-3">
                                                <label class="form-label"> Agent/Media</label>
                                                <select class="form-select liveSelect2" name="agent" id="agent" data-width="100%">
                                                    <option selected disabled>Select Name</option>
                                                    @foreach(App\Models\EstateVendor::where('client_type','media')->get() as $media)
                                                    <option value="{{$media->id}}" {{$media->id == $entryFile->agent_id ? 'selected' :''}}>{{$media->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label">Landowner/Party Inoformation * </label>
                                                <select class="landowner form-select" name="landowner[]" multiple="multiple" data-width="100%">
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-9">
                                            <div class="mb-3">
                                                <label class="form-label">Remarks</label>
                                                <textarea name="remarks" class="form-control" placeholder="Remarks" rows='1'> {{$entryFile->remarks}}</textarea>
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
            </div>
        </div>

    </div>


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

        // C.S Add More

       // store data function

        $('#entryFileSubmit').click(function(e) {
            $.ajax({
                url: "{{route('user.entryFile.update')}}",
                method: 'PUT',
                data: $('#entryFileForm').serialize(),
                success: function(result) {
                    if (result.errors) {
                        printErrorMsg(result.errors);
                    } else {
                        printSuccessMsg(result.success);
                        $('.alert-danger').hide();
                        $('#entryFileForm').trigger("reset");
                    }
                }
            });
            e.preventDefault();

        });

        $('.landowner').select2({
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

        $('.liveSelect2').select2();

        // flatpickr issue editable soln
        document.addEventListener('focusin', (e) => {
            if (e.target.closest(".flatpickr-calendar") !== null) {
                e.stopImmediatePropagation();
            }
        });


    });
</script>
@endpush