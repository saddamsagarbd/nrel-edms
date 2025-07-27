@extends('layouts.backend')
@section('title','Entry File Details')
@push('css')
<link rel="stylesheet" href="{{asset('backend/assets/vendors/toastr.js/toastr.min.css')}}">
<link rel="stylesheet" href="{{asset('backend/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('backend/assets/vendors/select2/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('backend/assets/vendors/flatpickr/flatpickr.min.css')}}">
<style>
    .table th,
    .datepicker table th,
    .table td,
    .datepicker table td {
        white-space: normal !important;
    }

    .table th,
    .table td {
        padding: 0.3rem 0.5375rem !important;
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
$isMutation = isMutation($entryFile->id);
$isReview = isReviewed($entryFile->id, 2);
@endphp

<div class="page-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">EntryFile</a></li>
                    <li class="breadcrumb-item" aria-current="page">Manage</li>
                    <li class="breadcrumb-item active" aria-current="page">{{$entryFile->project->name}}</li>
                </ol>
            </nav>
        </div>

        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <button type="button" class="btn btn-info btn-icon-text mb-2 mb-md-0" data-bs-toggle="modal" data-bs-target="#registryEntryModal">
                <i class="btn-icon-prepend" data-feather="check"></i>
                Deed
            </button>
            <button type="button" class="btn btn-success btn-icon-text mb-2 mb-md-0 ms-1" data-bs-toggle="modal" data-bs-target="#mutationEntryModal" {{ $isMutation ?  'disabled' : ''}}>
                <i class="btn-icon-prepend" data-feather="check"></i>
                Mutation
            </button>
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
                            <h6 class="card-title">Add Land Area against Mouzas, Dag and Khatian</h6>
                            <form id="addEntryDagForm" method="POST">
                                <div class="cs-info">
                                    <div class="row cs-cont mt-3">
                                        <div class="col-sm-2">
                                            <div class="mb-3">
                                                <label class="from-label"> <span class="text-uppercase">{{ !empty($entryFile->khatianType->data_values)? $entryFile->khatianType->data_values:''}} </span> Dag No</label>
                                                <select class="dag_livesearch form-select rounded-0 mb-3" id="dagId" name="dag_id">
                                                </select>
                                            </div>
                                        </div>
                                        <!-- Col -->
                                        <div class="col-sm-2">
                                            <div class="mb-3">
                                                <label class="from-label">K.Land Area</label>
                                                <input type="text" name="khatian_land" class="form-control rounded-0" placeholder="Land area" disabled>
                                            </div>
                                        </div><!-- Col -->
                                        <div class="col-sm-2">
                                            <div class="mb-3">
                                                <label class="from-label">Propose Land</label>
                                                <input type="text" name="propose_land" class="form-control rounded-0" placeholder="Propose land">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="mb-3">
                                                <label class="from-label">Purchase Land</label>
                                                <input type="text" name="purchase_land" class="form-control rounded-0" placeholder="Purchase land">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="mb-3">
                                                <label class="from-label">Rest Land</label>
                                                <input type="text" name="rest_land" class="form-control rounded-0" placeholder="Rest land">
                                            </div>
                                        </div>
                                        <div class="col-sm-1 mt-3 pt-1">
                                            <button type="button" id="entryFormDagSubmit" class="btn btn-primary mr-2">Save</button>
                                        </div>

                                        <input type="hidden" name="entryFile_id" id="entryFileId" value="{{$entryFile->id}}">
                                        <input type="hidden" name="khatianType" id="khatianTypeId" value="{{$entryFile->khatype_id}}">
                                        <input type="hidden" name="mouza_name" id="mouzaId" value="{{$entryFile->mouza_id}}">

                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Mouza Dag (<span class="text-uppercase">{{!empty($entryFile->khatianType->data_values)? $entryFile->khatianType->data_values:''}}</span>) Info</h6>
                            <div class="table-responsive">
                                <table class="table table-hover" id="dataTableEntryDag">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th><span class="text-uppercase">{{!empty($entryFile->khatianType->data_values)?$entryFile->khatianType->data_values:''}}</span> Dag</th>
                                            <th>Total.Land</th>
                                            <th>Propose.Land</th>
                                            <th>Purchase.Land</th>
                                            <th>Mutation.Land</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i=1; $tpr_land = 0; $tp_land = 0; $tm_land = 0; @endphp
                                        @foreach($dags as $dag)
                                        <tr>
                                            <th>{{$i}}</th>
                                            <td>{{$dag->dag_no}}</td>
                                            <td>{{number_format($dag->khatian_land,4)}}</td>
                                            <td>{{number_format($dag->propose_land,4)}}</td>
                                            <td>{{number_format($dag->purchase_land,4)}}</td>
                                            <td>{{number_format($dag->mutation_land,4)}}</td>
                                            <td>
                                                <a href="javascript:void(0)" data-lsize="{{$dag->khatian_land}}" data-id="{{$dag->id}}" class="btn btn-light btn-sm btn-sm-custom editEntryDag"><i data-feather="edit" width="18" height="18"></i></a>
                                            </td>
                                        </tr>
                                        @php
                                        $i++ ;
                                        $tpr_land = $tpr_land + $dag->propose_land ;
                                        $tp_land = $tp_land+ $dag->purchase_land;
                                        $tm_land = $tm_land + $dag->mutation_land ;
                                        @endphp
                                        @endforeach
                                        <tr style="background-color:#f2f2f2">
                                            <th colspan="3">Total</th>
                                            <th>{{number_format($tpr_land,4)}}</th>
                                            <th>{{number_format($tp_land, 4)}}</th>
                                            <th>{{number_format($tm_land, 4)}}</th>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-12 col-xl-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Deed Info</h6>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Deed.No</th>
                                            <th>Deed.Type</th>
                                            <th>Land.Area</th>
                                            <th>Land.Value</th>
                                            <th>Deed.Expenses</th>
                                            <th>Buyer</th>
                                            <th>Deed.Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($entryFile->entryDeed as $deed)
                                        <tr>
                                            <th>{{$deed->id}}</th>
                                            <td>{{$deed->deed_no}}</td>
                                            <td>{{$deed->deed_name}}</td>
                                            <td>{{$deed->dland_size}}</td>
                                            <td>{{number_format($deed->land_value, 2)}}</td>
                                            <td>{{ number_format($deed->expenses,2)}}</td>
                                            <td>{{$deed->deedBuyer->data_values}}</td>
                                            <td>{{$deed->deed_date}}</td>
                                            <td>
                                                <a href="#" class="btn btn-light btn-sm btn-sm-custom"><i data-feather="edit" width="18" height="18"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-12 col-xl-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Mutation Info</h6>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Jote.No</th>
                                            <th>Land.Area</th>
                                            <th>Khatian No</th>
                                            <th>Mutation date</th>
                                            <th>Case Date</th>
                                            <th>Created</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($entryFile->entryMutation as $mutation)
                                        <tr>
                                            <th>{{$mutation->id}}</th>
                                            <td>{{$mutation->zoth_no}}</td>
                                            <td>{{$mutation->mland_size}}</td>
                                            <td>{{$mutation->mkhatian_no}}</td>
                                            <td>{{$mutation->m_date}}</td>
                                            <td>{{$mutation->mcase_date}}</td>
                                            <td>{{$mutation->created_at}}</td>
                                            <td>
                                                <a href="#" class="btn btn-light btn-sm btn-sm-custom"><i data-feather="eye" width="18" height="18"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-12 col-xl-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Documents</h6>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Document type</th>
                                            <th>File Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($entryFile->files as $file)
                                        <tr>
                                            <th>{{$file->id}}</th>
                                            <td>
                                                @php
                                                $json = $file->doc_type;
                                                $type = implode(", ", json_decode($json));
                                                echo $type;
                                                @endphp
                                            </td>
                                            <td>{{$file->file_name}}</td>
                                            <td>
                                                <a target="_blank" href="{{asset($file->file_path) . '/' . $file->file_name}}" class="btn btn-light btn-sm btn-sm-custom"><i data-feather="eye" width="18" height="18"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <!-- Start Dag Modal Edit -->
    <div class="modal fade" id="editDagModal" tabindex="-1" aria-labelledby="editDagModallLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDagModallLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <form id="updateDagForm">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="form-label">Dag No</label>
                                    <input type="text" class="form-control rounded-0" id="csrsbs" placeholder="Dag No" disabled>
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="form-label">Total Land</label>
                                    <input type="text" class="form-control rounded-0" id="totalLand" placeholder="Total Land" disabled>
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">Proposed Land</label>
                                    <input type="text" name="proposedLand" class="form-control rounded-0" id="proposedLand" placeholder="Propose Land">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">Purchase Land </label>
                                    <input type="text" name="purchasedLand" class="form-control rounded-0" id="purchasedLand" placeholder="Purchased Land">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4" id="mutationField">
                                <div class="mb-3">
                                    <label class="form-label">Mutation Land </label>
                                    <input type="text" name="mutationLand" id="mutationLand" class="form-control rounded-0" placeholder="Mutation Land">
                                </div>
                            </div><!-- Col -->
                            <input type="hidden" id="dag_id" name="dag_id" value="">
                        </div><!-- Row -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="updateDagBtn" class="btn btn-primary rounded-0">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Dag Modal Edit -->

    <!-- Start Registry Entry Modal Edit -->
    <div class="modal fade" id="registryEntryModal" tabindex="-1" aria-labelledby="registryModallLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="registryModallLabel">Registry The Entry File</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <form id="registryEntryFileForm">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Deed Type *</label>
                                    <select class="form-select rounded-0 mb-3" name="deed_type">
                                        <option selected="" disabled>Select Deed Type</option>
                                        @foreach(App\Models\EstateLookUp::where('data_type', 'deed.type')->get() as $deed)
                                        <option value="{{$deed->data_keys}}">{{$deed->data_values}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="form-label">Deed No *</label>
                                    <input type="text" name="deed_no" class="form-control rounded-0" id="dalilNo" placeholder="Dalil No">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="form-label">Land Area *</label>
                                    <input type="number" name="deed_khatian_land" class="form-control rounded-0" id="deed_khatian_land" placeholder="Land Area">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Land Value *</label>
                                    <input type="number" name="land_value" class="form-control rounded-0" id="land_value" placeholder="Land Size">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Deed Expenses *</label>
                                    <input type="number" name="deed_cost" class="form-control rounded-0" id="registryCost" placeholder="Registry Cost">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Registry Date *</label>
                                    <div class="input-group flatpickr" id="flatpickr-date">
                                        <input type="text" name="registry_date" id="registry_date" class="form-control" placeholder="Select date" data-input>
                                        <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                    </div>
                                </div>
                            </div><!-- Col -->

                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Buyer *</label>
                                    <select class="form-select rounded-0 mb-3" name="buyer">
                                        <option selected="">Select Buyer</option>
                                        @foreach(App\Models\EstateLookUp::where('data_type', 'entryfile.buyer')->get() as $buyer)
                                        <option value="{{$buyer->data_keys}}">{{$buyer->data_values}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Registry Office *</label>
                                    <input type="text" name="registry_office" class="form-control rounded-0" id="registryOffice" placeholder="Registry Office">
                                </div>
                            </div><!-- Col -->

                            <div class="mb-4">
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" name="isReview" id="isReview">
                                    <label class="form-check-label" for="isReview">
                                        Did you review the Entry File?
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="entryFileId" value="{{$entryFile->id}}">
                            <input type="hidden" id="statusId" name="status" value="{{$entryFile->status}}">
                        </div><!-- Row -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="registryEntryBtn" class="btn btn-primary rounded-0">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Registry Modal Edit -->

    <!-- Start Mutation Entry Modal Edit -->
    <div class="modal fade" id="mutationEntryModal" tabindex="-1" aria-labelledby="mutationModallLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="mutationModallLabel">Mutation The Entry File</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <form id="mutationEntryFileForm">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">Jote No *</label>
                                    <input type="text" name="zoth_no" class="form-control rounded-0" id="zothNo" placeholder="Jote No">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">Khatian No *</label>
                                    <input type="text" name="mkhatian_no" class="form-control rounded-0" id="mKhatianNo" placeholder="Khatian No">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">Case No *</label>
                                    <input type="text" name="case_no" class="form-control rounded-0" id="caseNo" placeholder="Case No">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-5">
                                <div class="mb-3">
                                    <label class="form-label">Mutation Land Size *</label>
                                    <input type="text" name="mutation_land" class="form-control rounded-0" id="mutation_land" placeholder="Mutation Land Size">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-5">
                                <div class="mb-3">
                                    <label class="form-label">Case Date *</label>
                                    <div class="input-group flatpickr" id="flatpickr-date">
                                        <input type="text" name="case_date" id="registry_date" class="form-control" placeholder="Select date" data-input>
                                        <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                    </div>
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-5">
                                <div class="mb-3">
                                    <label class="form-label">Mutation Date *</label>
                                    <div class="input-group flatpickr" id="flatpickr-date">
                                        <input type="text" name="mutation_date" id="mutation_date" class="form-control" placeholder="Select date" data-input>
                                        <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                    </div>
                                </div>
                            </div><!-- Col -->
                            <div class="mb-4">
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" name="isReview" id="isReview">
                                    <label class="form-check-label" for="isReview">
                                        Did you Check everything this Entry File?
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="entryFileId" value="{{$entryFile->id}}">
                            <input type="hidden" id="statusId" name="status" value="{{$entryFile->status}}">
                        </div><!-- Row -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="mutationEntryBtn" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Registry Modal Edit -->

    <!-- Review modal -->
    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewModalLabel">Review The Entry File</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <form id="reviewModalForm">
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-4">
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" name="checked_file" id="isChecked">
                                    <label class="form-check-label" for="isChecked">
                                        Did you review everything in this Entry File?
                                    </label>
                                    <input type="hidden" name="entryFileId" value="{{$entryFile->id}}">
                                    <input type="hidden" name="status" value="{{$entryFile->status}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="reviewSubmit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end Review Modal -->


</div>


@endsection

@push('js')
<script src="{{asset('backend/assets/vendors/select2/select2.min.js')}}"></script>
<script src="{{asset('backend/assets/js/select2.js')}}"></script>
<script src="{{asset('backend/assets/vendors/datatables.net/jquery.dataTables.js')}}"></script>
<script src="{{asset('backend/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js')}}"></script>
<script src="{{asset('backend/assets/js/data-table.js')}}"></script>
<script src="{{asset('backend/assets/vendors/toastr.js/toastr.min.js')}}"></script>
<script src="{{asset('backend/assets/vendors/flatpickr/flatpickr.min.js')}}"></script>
<script src="{{asset('backend/assets/js/flatpickr.js')}}"></script>
<script>
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


    $('.cs_livesearch, .rs_livesearch, .bs_livesearch, .dag_livesearch').select2();

    // Start seach Entry file number

    var khatian_type = document.getElementById('khatianTypeId').value;
    var mouza_id = document.getElementById('mouzaId').value;

    $('.dag_livesearch').select2({
        ajax: {
            url: "{{ url('/dag/search') }}",
            data: function(params) {
                return {
                    search: params.term,
                    mouza_id: mouza_id,
                    khatian_type: khatian_type
                };
            },
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

    $('#dagId').change(function(e) {
        e.preventDefault();
        var dag_id = $(this).val();
        if (dag_id) {
            $.ajax({
                type: "GET",
                url: "{{url('/dag/search/land-size')}}?dag_id=" + dag_id,
                success: function(res) {
                    if (res.data) {
                        var t_land = parseFloat(res.data.khatian_land).toFixed(2);
                        var p_land = parseFloat(res.data.purchase_land).toFixed(2);
                        $('input[name="khatian_land"]').val(res.data.khatian_land);
                        $('input[name="rest_land"]').val(parseFloat(t_land - p_land).toFixed(2));
                    }
                }
            });
        } else {
            $(".parent_bs").empty();
        }
    });

    // end seach Entry file number

    // function for store entry file Dag
    $('#entryFormDagSubmit').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{route('admin.entryFile.dag.store')}}",
            method: 'POST',
            data: $('#addEntryDagForm').serialize(),
            success: function(res) {
                if (res.errors) {
                    printErrorMsg(res.errors);
                } else {
                    printSuccessMsg(res.success);
                    $('.alert-danger').hide();
                    $('#addEntryDagForm').trigger("reset");
                    if (res.data) {
                        var html = '<tr>';
                        html += '<td>' + res.data.id + '</td>';
                        html += '<td>' + res.data.dag_id + '</td>';
                        html += '<td>' + res.data.khatian_land + '</td>';
                        html += '<td>' + res.data.propose_land + '</td>';
                        html += '<td>' + res.data.purchase_land + '</td>';
                        html += '<td></td>';
                        html += '<td> <a href="javascript:void(0)"class="btn btn-light btn-sm btn-sm-custom editEntryDag"><i data-feather="edit" width="18" height="18"></i></a></td>';
                        html += '</tr>';

                        $('#dataTableEntryDag').prepend(html);
                    }

                    //$("#dataTableEntryDag").DataTable().draw();
                }
            }
        });
        e.preventDefault();

    });


    $(function() {
        /*------------------------------------------
        Click to Edit Button
        -------------------------------------------- */
        $('body').on('click', '.editEntryDag', function() {
            var dag_id = $(this).data('id');
            var khatian_land = $(this).data('lsize');

            $.get("{{url('user/entryfile/dag')}}" + '/' + dag_id + "/edit", function(data) {

                $('#editDagModallLabel').html("Edit Dag(" + data.dag_no + ")");
                // $('#updateDagBtn').val("edit-dag");
                $('#editDagModal').modal('show');
                $('#dag_id').val(data.id);
                $('#csrsbs').val(data.dag_no);
                $('#totalLand').val(khatian_land);
                $('#proposedLand').val(data.propose_land);
                $('#purchasedLand').val(data.purchase_land);
                $('#mutationLand').val(data.mutation_land);

            })
        });

        /*------------------------------------------
        --------------------------------------------
        Edit Mouza Dag
        --------------------------------------------
        --------------------------------------------*/
        $('#updateDagBtn').click(function(e) {
            e.preventDefault();
            $(this).html('Sending..');
            $.ajax({
                url: "{{route('admin.entryFile.dag.update')}}",
                data: $('#updateDagForm').serialize(),
                type: "POST",
                dataType: 'json',
                success: function(result) {
                    if (result.errors) {
                        printErrorMsg(result.errors);
                    } else {
                        printSuccessMsg(result.success);
                        $('#updateDagForm').trigger("reset");
                        $('#editDagModal').modal('hide');
                        //$("table#dataTableEntryDag").draw();
                        table.draw();
                    }
                },
                error: function(data) {
                    console.log('Error:', data);
                    $('#updateDagBtn').html('Save Changes');
                }
            });
        });

        /*------------------------------------------
        --------------------------------------------
        Regsitry Entry File
        --------------------------------------------
        --------------------------------------------*/
        $('#registryEntryBtn').click(function(e) {
            e.preventDefault();
            $(this).html('Sending..');
            $.ajax({
                url: "{{route('admin.entryFile.dag.registry')}}",
                data: $('#registryEntryFileForm').serialize(),
                type: "POST",
                dataType: 'json',
                success: function(response) {
                    if (response.errors) {
                        printErrorMsg(response.errors);
                    } else {
                        printSuccessMsg(response.success);
                        $('#registryEntryFileForm').trigger("reset");
                        $('#registryEntryModal').modal('hide');
                        table.draw();
                    }
                },
                error: function(data) {
                    console.log('Error:', data);
                    $('#registryEntryBtn').html('Save Changes');
                }
            });
        });

        /*------------------------------------------
        --------------------------------------------
        Mutation Entry File
        --------------------------------------------
        --------------------------------------------*/
        $('#mutationEntryBtn').click(function(e) {
            e.preventDefault();
            $(this).html('Sending..');
            $.ajax({
                url: "{{route('admin.entryFile.mutation')}}",
                data: $('#mutationEntryFileForm').serialize(),
                type: "POST",
                dataType: 'json',
                success: function(result) {
                    if (result.errors) {
                        printErrorMsg(result.errors);
                    } else {
                        printSuccessMsg(result.success);
                        $('#mutationEntryFileForm').trigger("reset");
                        $('#mutationEntryModal').modal('hide');
                        table.draw();
                    }
                },
                error: function(data) {
                    console.log('Error:', data);
                    $('#mutationEntryBtn').html('Save Changes');
                }
            });
        });

        // review

        $('#reviewSubmit').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{route('admin.entryFile.status')}}",
                method: 'POST',
                data: $('#reviewModalForm').serialize(),
                success: function(result) {
                    if (result.errors) {
                        printErrorMsg(result.errors);
                    } else {
                        printSuccessMsg(result.success);
                        $('.alert-danger').hide();
                        $('#reviewModalForm').trigger("reset");
                        $('#reviewModal').modal('hide');
                    }
                }
            });
            e.preventDefault();

        });
        //end review

    });

    // flatpickr issue editable soln
    document.addEventListener('focusin', (e) => {
        if (e.target.closest(".flatpickr-calendar") !== null) {
            e.stopImmediatePropagation();
        }
    });
</script>
@endpush