@extends('layouts.backend')
@section('title','Projects')
@push('css')
    <link rel="stylesheet" href="{{asset('backend/assets/vendors/toastr.js/toastr.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/assets/vendors/toastr.js/toastr.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css')}}">
    <style>
        .table th, .datepicker table th, .table td, .datepicker table td {
            white-space: normal !important;
        }
        body.modal-open {
            overflow: auto;
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
                    <li class="breadcrumb-item active" aria-current="page">Highland</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <button type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0" data-bs-toggle="modal" data-bs-target="#exampleModal">
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
                    <h6 class="card-title float-left">Navana Highland</h6>
                    <div class="table-responsive">
                        <table id="dataTableProjects" class="table">
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Vendor(s)/Transferer</th>
                                <th>Police Station / Upazilla</th>
                                <th> District</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td> Haji Jalal Uddin</td>
                                <td> Dhaka</td>
                                <td> Dhaka</td>
                                <td> 10/05/2021</td>
                                <td> 
                                    <a href="#" class="btn btn-light btn-sm btn-sm-custom"><i data-feather="edit-2" width="18" height="18"></i></a>
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

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Vendor(s) /Transferer/ Seller Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <form class="form-horizontal" action="#" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">  
                        <div class="alert alert-danger" style="display:none"></div> 

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">Select Project </label>
                                    <select class="form-control" name="status" id="exampleFormControlSelect1">
                                        <option selected disabled>Select Project</option>
                                        <option>Matia </option>
                                        <option>Highland</option>
                                        <option>Cornet</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">Vendor(s) /Transferer/ Seller / Owner</label>
                                    <input type="text" name="location" class="form-control" placeholder="Vendors name">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="control-label">Nature of land</label>
                                    <input type="text" name="zone" class="form-control" placeholder="Land nature">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">Police Station / Upazilla</label>
                                    <input type="text" name="zone" class="form-control" placeholder="Enter District">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">District</label>
                                    <input type="text" name="zone" class="form-control" placeholder="Enter Division">
                                </div>
                            </div><!-- Col -->
                        </div><!-- Row -->

                    </div>
                    <div class="modal-footer">
                        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                        <button type="submit" id="formSubmit" class="btn btn-primary mr-2">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</div>
            
@endsection

@push('js')
<script src="{{asset('backend/assets/vendors/datatables.net/jquery.dataTables.js')}}"></script>
<script src="{{asset('backend/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js')}}"></script>
<script src="{{asset('backend/assets/js/data-table.js')}}"></script>
<script src="{{asset('backend/assets/vendors/toastr.js/toastr.min.js')}}"></script>
<script>
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            function printErrorMsg (msg) {
                toastr.options = {
                    "closeButton": true,
                    "newestOnTop": true,
                    "positionClass": "toast-top-right"
                };
                var error_html = '';
                for(var count = 0; count < msg.length; count++){
                    error_html += '<p>'+msg[count]+'</p>';
                }
                toastr.error(error_html);
            }

            function printSuccessMsg (msg) {
                toastr.options = {
                    "closeButton": true,
                    "newestOnTop": true,
                    "positionClass": "toast-top-right"
                };
                toastr.success(msg);
            }

            $(function () {
            
                var table = $('#dataTableProjects').DataTable({
                    processing: true,
                    serverSide: false,
                    "order": [[ 0, "DESC" ]]
                });

            });
        });
</script>
@endpush