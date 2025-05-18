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
    }

    .select2-container .select2-selection--single {
        height: 37px;
    }
</style>
@endpush

@section('content')

@php

@endphp

<div class="page-content">

    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Estate</a></li>
                    <li class="breadcrumb-item" aria-current="page">Plot</li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <button type="button" class="btn btn-info btn-icon-text mb-2 mb-md-0" data-bs-toggle="modal" data-bs-target="#registryEntryModal"  >
                <i class="btn-icon-prepend" data-feather="check"></i>
                Book
            </button>
            <button type="button" class="btn btn-warning btn-icon-text mb-2 mb-md-0 ms-1" data-bs-toggle="modal" data-bs-target="#mutationEntryModal">
                <i class="btn-icon-prepend" data-feather="check"></i>
                Sale
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-3 col-md-3 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Name Information </h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Plot No : </li>
                        <li class="list-group-item">Transferer/Seller/Owner: <span class="badge badge-secondary"> </span></li>
                        <li class="list-group-item">Vendors/Media: <span class="badge badge-secondary"> </span></li>
                        <li class="list-group-item">Deed Nos : </li>
                        <li class="list-group-item">Registration Date : </li>
                        <li class="list-group-item">Name of Media : </li>
                        <li class="list-group-item">Remarks : </li>
                        <li class="list-group-item">Khatian No : </li>
                        <li class="list-group-item">Purchased Area : </li>
                        <li class="list-group-item">Rate/Bigha (Tk) : </li>
                        <li class="list-group-item">Nature of Deed : </li>
                        <li class="list-group-item">Nature of land : </li>
                        <li class="list-group-item">Land Cost : </li>
                        <li class="list-group-item">Reg. Expenses : </li>
                        <li class="list-group-item">Total Cost : </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-9 col-md-9 col-xl-9 grid-margin">
            <div class="row">
                <div class="col-12 col-md-12 col-xl-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Dag</h6>
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
                                        <tr>
                                            <th>1</th>
                                            <td>Landowner</td>
                                            <td>higland-landowner.pdf</td>
                                            <td>
                                                <a href="#" class="btn btn-light btn-sm btn-sm-custom"><i data-feather="download" width="18" height="18"></i></a>
                                                <a href="#" class="btn btn-light btn-sm btn-sm-custom"><i data-feather="printer" width="18" height="18"></i></a>
                                                <a href="#" class="btn btn-light btn-sm btn-sm-custom"><i data-feather="eye" width="18" height="18"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>2</th>
                                            <td>Mutation</td>
                                            <td>higland-Mutation.pdf</td>
                                            <td>
                                                <a href="#" class="btn btn-light btn-sm btn-sm-custom"><i data-feather="download" width="18" height="18"></i></a>
                                                <a href="#" class="btn btn-light btn-sm btn-sm-custom"><i data-feather="printer" width="18" height="18"></i></a>
                                                <a href="#" class="btn btn-light btn-sm btn-sm-custom"><i data-feather="eye" width="18" height="18"></i></a>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
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



        
</script>
@endpush