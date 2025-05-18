@extends('layouts.backend')
@section('title','Projects')
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
                    <h6 class="card-title float-left">Land Document Information</h6>
                    <div class="table-responsive">
                        <table id="dataTableDocuments" class="table">
                            <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th>EntryNo</th>
                                    <th>File Name</th>
                                    <th>Shelf No</th>
                                    <th>Document type</th>
                                    <th>Created At</th>
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
    <div class="modal fade" id="fileUploadModal" tabindex="-1" role="dialog" aria-labelledby="fileUploadModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fileUploadModalLabel">Upload Land Documents</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <form class="form-horizontal" action="{{route('user.estate.upload.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body">
                        <div class="alert alert-danger" style="display:none"></div>

                        <div class="row">
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="form-label">Entry File No</label>
                                    <select class="livesearch w-100 form-control mb-3" id="entryFileNo" name="entryFileNo" data-width="100%">
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="mb-3">
                                    <label class="form-label">Shelf No</label>
                                    <input type="text" name="shelf" class="form-control" placeholder="Shelf no ">
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <div class="mb-3">
                                    <label class="form-label">Document Type</label>
                                    <select class="js-example-basic-multiple form-select fileTypeSelect" name="doc_type[]" multiple="multiple" data-width="100%">
                                        <option value="Landowners">Landowners</option>
                                        <option value="Mutation">Mutation</option>
                                        <option value="Khatian">Khatian</option>
                                        <option value="Allotment letter">Allotment letter</option>
                                        <option value="Possession letter">Possession letter</option>
                                        <option value="Lease Deed">Lease Deed</option>
                                        <option value="Via Deed">Via Deed</option>
                                        <option value="Deed of Agreement">Deed of Agreement</option>
                                        <option value="Power of Attorney">Power of Attorney</option>
                                        <option value="Land TAX">Land Tax</option>
                                        <option value="Miscellaneous">Miscellaneous</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label" for="formFile">File upload</label>
                                    <input class="form-control" type="file" name="files[]" id="formFile" multiple>
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

        $(function() {
            var table = $('#dataTableDocuments').DataTable({
                processing: true,
                serverSide: true,
                "order": [[ 0, "DESC" ]],
                "autoWidth": false,
                columnDefs: [
                    { "width": "14%", "targets": [2, 4] }
                ],
                ajax: {
                    "url": "{{ route('user.estate.upload.index') }}",
                    "dataType": "json",
                    timeout: 500,
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
                        data: 'file_no',
                        name: 'file_no'
                    },
                    {
                        data: 'orgi_name',
                        name: 'orgi_name'
                    },
                    {
                        data: 'shelf_no',
                        name: 'shelf_no'
                    },
                    {
                        data: 'doc_type',
                        name: 'doc_type'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
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

        $('.fileTypeSelect').select2({
            dropdownParent: $('#fileUploadModal')
        });

        // Start seach Entry file number
        $('.livesearch').select2({
            dropdownParent: $('#fileUploadModal'),
            placeholder: 'Select entryfile no',
            ajax: {
                url: "{{ url('/entryfile/search') }}",
                dataType: 'json',
                delay: 500,
                processResults: function(data) {
                    return {
                        results: data,
                    };
                },
                cache: true
            }
        });
        // end seach Entry file number

    });
</script>
@endpush