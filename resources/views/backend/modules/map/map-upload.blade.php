@extends('layouts.backend')
@section('title','Graphical View')
@push('css')

<link rel="stylesheet" href="{{asset('backend/assets/vendors/toastr.js/toastr.min.css')}}">
<link rel="stylesheet" href="{{asset('backend/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('backend/assets/vendors/select2/select2.min.css')}}">

<style>
    .datepicker table th,
    .table td,
    .datepicker table td {
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
                    <li class="breadcrumb-item active" aria-current="page">Uploads</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <button type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0" data-bs-toggle="modal" data-bs-target="#fileUploadModal">
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
                    <h6 class="card-title float-left">Plot Map</h6>
                    <div class="table-responsive">
                        <table id="dataTableDocuments" class="table">
                            <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th>File Name</th>
                                    <th>Project Name</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($files as $file)
                                <tr>
                                    <td>{{$file->id}}</td>
                                    <td>{{$file->file_name}}</td>
                                    <td>{{$file->project_id}}</td>
                                    <td>{{$file->created_at}}</td>
                                    <td></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="fileUploadModal" tabindex="-1" role="dialog" aria-labelledby="fileUploadModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fileUploadModalLabel">Upload Map</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <form class="form-horizontal" action="{{route('map.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body">
                        <div class="alert alert-danger" style="display:none"></div>
                        <div class="row">
                            <div class="col-sm-7">
                                <div class="mb-3">
                                    <label class="form-label">Project Name</label>
                                    <select class="form-select" name="project">
                                        <option disabled>Select Project</option>
                                        <option value="2">Higland 1</option>
                                        <option value="3">Highland 2</option>
                                        <option value="4">Highland 3</option>
                                        <option value="5">Southern Ville</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label" for="formFile">File upload</label>
                                    <input class="form-control" type="file" name="image" id="formFile">
                                </div>
                            </div>
                        </div> <!-- Row -->

                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="formSubmit" class="btn btn-primary mr-2">Upload</button>
                    </div>
                </form>
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

@endpush