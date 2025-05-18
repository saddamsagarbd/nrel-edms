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

        @if($isReview)
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
        @endif
        
    </div>

    <div class="row">
        <div class="col-3 col-md-3 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Project Name: {{$entryFile->project->name}}</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Entry File No : <strong>{{$entryFile->file_no}}</strong></li>
                        <li class="list-group-item">Name of Mouza : {{$entryFile->mouza->name}}</li>
                        <li class="list-group-item">Transferer/Seller/Owner:
                            @foreach($entryFile->parties as $party)
                            <span class="mb-1" style="background-color:#f2f2f2; font-size:12px; color:#000">
                                Name: {{$party->p_name}}<br>
                                {{$party->p_phone}} | {{$party->p_address}}
                            </span><br>
                            @endforeach
                        </li>
                        <li class="list-group-item">Agent/Media: <span class="badge badge-secondary"> </span></li>
                        <li class="list-group-item">Deed Nos : {{$entryFile->deed_no}}</li>
                        <li class="list-group-item">Registration Date : {{$entryFile->reg_date}}</li>
                        <li class="list-group-item">Registration office: {{$entryFile->reg_office}}</li>
                        <li class="list-group-item">Mutation Date : {{$entryFile->mutation_date}}</li>
                        <li class="list-group-item">Mutation Zoth No : {{$entryFile->mzoth_no}}</li>
                        <li class="list-group-item">Remarks : {{$entryFile->remarks}}</li>
                        <li class="list-group-item">Land Size : </li>
                        <li class="list-group-item">Nature of Deed : </li>
                        <li class="list-group-item">Nature of land : </li>
                        <li class="list-group-item">Rate/Bigha (Tk) : </li>
                        <li class="list-group-item">Land Cost : </li>
                        <li class="list-group-item">Reg. Expenses : </li>
                        <li class="list-group-item">Total Cost : </li>
                    </ul>
                </div>
            </div>
            <div class="card mt-2">
                <div class="card-body">
                    <div class="d-grid">
                        <button {{$entryFile->status == 2 ? 'disabled':''}} type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#reviewModal">Review</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-9 col-md-9 col-xl-9 grid-margin">
            <div class="row">

                <div class="col-12 col-md-12 col-xl-12 grid-margin">

                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Add Mouzas Dag Info</h6>

                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="bsdag-tab" data-bs-toggle="tab" href="#bsdag" role="tab" aria-controls="bsdag" aria-selected="false">R.S & B.S/City</a>
                                </li>
                            </ul>
                            <div class="tab-content border border-top-0 p-3" id="myTabContent">
                                <div class="tab-pane fade show active" id="bsdag" role="tabpanel" aria-labelledby="bsdag-tab">

                                    <form id="addEntryDagForm" method="POST">
                                        <div class="cs-info">
                                            <div class="row cs-cont mt-3">
                                                <div class="col-sm-2">
                                                    <div class="mb-3">
                                                        <label class="from-label">Dag No (C.S)</label>
                                                        <select class="form-select rounded-0 rsbs_livesearch_by_cs w-100 mb-3 parent_cs" name="parent_dag_cs" data-width="100%">
                                                        </select>
                                                    </div>
                                                </div><!-- Col -->
                                                <div class="col-sm-2">
                                                    <div class="mb-3">
                                                        <label class="from-label">Dag No (R.S)</label>
                                                        <select class="rs_livesearch parent_rs form-select rounded-0 mb-3" name="parent_dag_rs">
                                                        </select>
                                                    </div>
                                                </div><!-- Col -->
                                                <div class="col-sm-2" id="hideBs">
                                                    <div class="mb-3">
                                                        <label class="from-label">Dag No (B.S)</label>
                                                        <select class="bs_livesearch form-select rounded-0 mb-3 parent_bs" id="getDagInfo" name="parent_dag_bs">
                                                        </select>
                                                    </div>
                                                </div>
                                                <!-- Col -->
                                                <div class="col-sm-2">
                                                    <div class="mb-3">
                                                        <label class="from-label">Total Land</label>
                                                        <input type="text" name="land_size" class="form-control rounded-0" placeholder="Land Size" disabled>
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
                                                    <input type="hidden" name="entryFile_id" value="{{$entryFile->id}}">
                                                </div>
                                                <div class="col-sm-1 mt-3 pt-1">
                                                    <button type="button" id="entryFormDagSubmit" class="btn btn-primary mr-2">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Mouza Dag Info</h6>
                            <div class="table-responsive">
                                <table class="table table-hover" id="dataTableEntryDag">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>CS/SA</th>
                                            <th>RS</th>
                                            <th>BS/CITY</th>
                                            <th>Total.Land</th>
                                            <th>Propose.Land</th>
                                            <th>Purchase.Land</th>
                                            <th>Mutation.Land</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($dags as $dag)
                                        <tr>
                                            <th>{{$dag->id}}</th>
                                            <td>{{$dag->csSaDag->dag_no}}</td>
                                            <td>{{$dag->rsDag->dag_no}}</td>
                                            <td>{{!empty($dag->bsCityDag->dag_no) ? $dag->bsCityDag->dag_no: ""}}</td>
                                            <td>{{$dag->land_size}}</td>
                                            <td>{{$dag->propose_land}}</td>
                                            <td>{{$dag->purchase_land}}</td>
                                            <td>{{$dag->mutation_land}}</td>
                                            <td>
                                                @if(!$isMutation)
                                                <a href="javascript:void(0)" data-lsize="{{$dag->land_size}}" data-id="{{$dag->id}}" class="btn btn-light btn-sm btn-sm-custom editEntryDag"><i data-feather="edit" width="18" height="18"></i></a>
                                                @endif
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
                            <h6 class="card-title">Deed Info</h6>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Deed.No</th>
                                            <th>Deed.Type</th>
                                            <th>Land.Size</th>
                                            <th>Expenses</th>
                                            <th>Buyer</th>
                                            <th>Buyer Company</th>
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
                                            <td>{{$deed->expenses}}</td>
                                            <td>{{$deed->buyer}}</td>
                                            <td>{{$deed->company}}</td>
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
                                            <th>Zoth.No</th>
                                            <th>Land.Size</th>
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
                                                <a target="_blank" href="#" class="btn btn-light btn-sm btn-sm-custom"><i data-feather="eye" width="18" height="18"></i></a>
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
                                    <label class="form-label">CS/SA</label>
                                    <input type="text" class="form-control rounded-0" id="cssa" placeholder="CS/SA" disabled>
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="form-label">RS</label>
                                    <input type="text" class="form-control rounded-0" id="rs" placeholder="RS" disabled>
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="form-label">BS/City</label>
                                    <input type="text" class="form-control rounded-0" id="bscity" placeholder="BS/City" disabled>
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
                            @if($entryFile->status == 'registered')
                            <div class="col-sm-4" id="mutationField">
                                <div class="mb-3">
                                    <label class="form-label">Mutation Land </label>
                                    <input type="text" name="mutationLand" class="form-control rounded-0" placeholder="Mutation Land">
                                </div>
                            </div><!-- Col -->
                            @endif
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
                                        <option value="{{$deed->id}}">{{$deed->data_keys}}</option>
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
                                    <label class="form-label">Land Size *</label>
                                    <input type="number" name="deed_land_size" class="form-control rounded-0" id="deed_land_size" placeholder="Land Size">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Registry Expenses *</label>
                                    <input type="number" name="deed_cost" class="form-control rounded-0" id="registryCost" placeholder="Registry Cost">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Registry Date *</label>
                                    <input type="date" name="registry_date" class="form-control rounded-0" id="registry_date" placeholder="Registry date">
                                </div>
                            </div><!-- Col -->

                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Buyer *</label>
                                    <select class="form-select rounded-0 mb-3" name="buyer">
                                        <option selected="">Sselect Buyer</option>
                                        @foreach(App\Models\EstateLookUp::where('data_type', 'entryfile.buyer')->get() as $buyer)
                                        <option value="{{$buyer->id}}">{{$buyer->data_keys}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Company</label>
                                    <select class="form-select rounded-0 mb-3" name="buyer_company">
                                        <option selected="">Select Company</option>
                                        @foreach(App\Models\EstateLookUp::where('data_type', 'entryfile.company')->get() as $company)
                                        <option value="{{$company->id}}">{{$company->data_keys}}</option>
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
                                    <label class="form-label">Zoth No *</label>
                                    <input type="text" name="zoth_no" class="form-control rounded-0" id="zothNo" placeholder="Zoth No">
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
                                    <input type="date" name="case_date" class="form-control rounded-0" placeholder="Mutation date">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-5">
                                <div class="mb-3">
                                    <label class="form-label">Mutation Date *</label>
                                    <input type="date" name="mutation_date" class="form-control rounded-0" id="mutation_date" placeholder="Mutation date">
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


    $('.cs_livesearch, .rs_livesearch, .bs_livesearch').select2();

    function getCsDagInfo() {
        var mouza_id = {{ $entryFile -> mouza_id }};
        if (mouza_id) {
            $.ajax({
                type: "GET",
                url: "{{url('user/mouza-cssa/search')}}?mouza_id=" + mouza_id,
                success: function(res) {
                    if (res) {
                        $(".parent_cs").empty();
                        $(".parent_cs").html(res.data);
                    } else {
                        $(".parent_cs").empty();
                    }
                }
            });
        } else {
            $(".parent_cs").empty();
        }
    }
    getCsDagInfo();

    $('.rsbs_livesearch_by_cs').change(function(e) {
        e.preventDefault();
        var mouza_id = {{ $entryFile -> mouza_id }};
        var csdag_id = $(this).val();
        if (csdag_id) {
            $.ajax({
                type: "GET",
                url: "{{url('user/entryfile/search/mouza-rs-bs')}}?mouza_id=" + mouza_id + '&dag_id=' + csdag_id,
                success: function(res) {
                    if (res) {
                        $(".parent_rs").empty();
                        $(".parent_rs").html(res.rsdata);
                        $(".parent_bs").html(res.bsdata);
                    } else {
                        $(".parent_rs").empty();
                    }
                }
            });
        } else {
            $("#parent_rs").empty();
        }
    });


    $('.rs_livesearch').change(function(e) {
        e.preventDefault();
        var mouza_id = {{ $entryFile -> mouza_id }};
        var rsdag_id = $(this).val();
        if (rsdag_id) {
            $.ajax({
                type: "GET",
                url: "{{url('user/entryfile/search/mouza-bs')}}?mouza_id=" + mouza_id + '&dag_id=' + rsdag_id,
                success: function(res) {
                    if (res) {
                        if (res.pr_dags == 0) {
                            $("#hideBs").css('display', 'none');
                        }
                        $('input[name="land_size"]').val(res.data.land_size);
                        $(".parent_bs").empty();
                        $(".parent_bs").html(res.pr_dags);

                    } else {
                        $(".parent_bs").empty();
                    }
                }
            });
        } else {
            $(".parent_bs").empty();
        }
    });

    $('#getDagInfo').change(function(e) {
        e.preventDefault();
        var mouza_id = {{ $entryFile -> mouza_id }};
        var bsdag_id = $(this).val();
        if (bsdag_id) {
            $.ajax({
                type: "GET",
                url: "{{url('user/entryfile/search')}}?mouza_id=" + mouza_id + '&dag_id=' + bsdag_id,
                success: function(res) {
                    if (res.data) {
                        $('input[name="land_size"]').val(res.data.land_size);
                    }
                }
            });
        } else {
            $(".parent_bs").empty();
        }
    });

    // function for store entry file Dag
    $('#entryFormDagSubmit').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{route('user.entryFile.dag.store')}}",
            method: 'POST',
            data: $('#addEntryDagForm').serialize(),
            success: function(result) {
                if (result.errors) {
                    printErrorMsg(result.errors);
                } else {
                    printSuccessMsg(result.success);
                    $('.alert-danger').hide();
                    $('#addEntryDagForm').trigger("reset");
                    $("#dataTableEntryDag").DataTable().draw();
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
            var land_size = $(this).data('lsize');

            $.get("{{url('user/entryfile/dag')}}" + '/' + dag_id + "/edit", function(data) {

                $('#editDagModallLabel').html("Edit Dag(" + data.rs_dag + "," + data.bs_dag + ")");
                // $('#updateDagBtn').val("edit-dag");
                $('#editDagModal').modal('show');
                $('#dag_id').val(data.id);
                $('#cssa').val(data.cs_dag);
                $('#rs').val(data.rs_dag);
                $('#bscity').val(data.bs_dag);
                $('#totalLand').val(land_size);
                $('#proposedLand').val(data.propose_land);
                $('#purchasedLand').val(data.purchase_land);

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
                url: "{{route('user.entryFile.dag.update')}}",
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
                url: "{{route('user.entryFile.dag.registry')}}",
                data: $('#registryEntryFileForm').serialize(),
                type: "POST",
                dataType: 'json',
                success: function(result) {
                    if (result.errors) {
                        printErrorMsg(result.errors);
                    } else {
                        printSuccessMsg(result.success);
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
                url: "{{route('user.entryFile.mutation')}}",
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
                url: "{{route('user.entryFile.status')}}",
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
</script>
@endpush