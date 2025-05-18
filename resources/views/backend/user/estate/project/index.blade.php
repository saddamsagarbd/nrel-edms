@extends('layouts.backend')
@section('title','Projects')
@push('css')
<link rel="stylesheet" href="{{asset('backend/assets/vendors/toastr.js/toastr.min.css')}}">
<link rel="stylesheet" href="{{asset('backend/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css')}}">
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
                    <li class="breadcrumb-item active" aria-current="page">Projects</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <button type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0" data-bs-toggle="modal" data-bs-target="#addNewModal">
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
                    <h6 class="card-title float-left">Estate Projects</h6>

                    <div class="table-responsive">
                        <table id="projectDataTable" class="table">
                            <thead>
                                <tr>
                                    <th>#File No</th>
                                    <th>NAME</th>
                                    <th>Address</th>
                                    <th>Division</th>
                                    <th>District</th>
                                    <th>Zone Name</th>
                                    <th>Land Type</th>
                                    <th>Created.BY</th>
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
    <div class="modal fade" id="addNewModal" tabindex="-1" role="dialog" aria-labelledby="addNewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewModalLabel">Add Projects</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <form class="form-horizontal" id="addProjectForm" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-danger" style="display:none"></div>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="form-label">Project Name *</label>
                                    <input type="text" name="name" class="form-control" placeholder="Enter Project name">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="form-label">Parent Project</label>
                                    <select class="form-select" name="parent_id" id="parent_id">
                                        <option selected disabled>Select Project</option>
                                        @foreach(App\Models\EstateProject::where('parent_id', NULL)->get() as $project)
                                        <option value="{{$project->id}}">{{$project->name}}</option>
                                        @foreach(App\Models\EstateProject::where('parent_id', $project->id)->get() as $subproject)
                                        <option value="" disabled> -- {{$subproject->name}}</option>
                                        @endforeach
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="form-label">Land Type *</label>
                                    <select class="form-select" name="land_type" id="land_type">
                                        <option selected disabled>Select your type</option>
                                        <option>Freehold</option>
                                        <option>Leasehold</option>
                                        <option>Others</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="form-label">Project Category *</label>
                                    <select class="form-select" name="project_category" id="project_category">
                                        <option selected disabled>Select your Category</option>
                                        @foreach(App\Models\EstateLookUp::where('data_type', 'project.category')->get() as $pr_cat)
                                        <option value="{{$pr_cat->data_keys}}">{{$pr_cat->data_values}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="form-label">Project Type *</label>
                                    <select class="form-select" name="project_type" id="project_type">
                                        <option selected disabled>Select your type</option>
                                        <option value="land">Land</option>
                                        <option value="apartment">Apartment</option>
                                        <option value="others">Others</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="form-label">Location *</label>
                                    <select class="form-select" name="location" id="location">
                                        <option value="" selected disabled>Select project location</option>
                                        <option value="uttara">Uttara</option>
                                        <option value="bashundhara">Bashundhara</option>
                                        <option value="dhanmondi">Dhanmondi</option>
                                        <option value="banani">Banani</option>
                                        <option value="gulshan">Gulshan</option>
                                        <option value="baridhara">Baridhara</option>
                                        <option value="mirpur">Mirpur</option>
                                        <option value="mohammadpur">Mohammadpur</option>
                                        <option value="midtown">Midtown</option>
                                        <option value="chittagong">Chittagong</option>
                                        <option value="outside">Outside of Dhaka</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="form-label">Map Location *</label>
                                    <input type="text" name="address" class="form-control" placeholder="Project Address">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="form-label">Select Status *</label>
                                    <select class="form-select" name="status" id="statusId">
                                        <option selected disabled>Select status</option>
                                        <option value="upcoming">Upcoming</option>
                                        <option value="ongoing">Ongoing</option>
                                        <option value="completed">Completed</option>
                                    </select>
                                </div>
                            </div>
                        </div><!-- Row -->

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">Division </label>
                                    <select class="form-select" name="division" id="divisionId">
                                        <option selected disabled>Select Project</option>
                                        @foreach(App\Models\Division::all() as $division)
                                        <option value="{{$division->id}}">{{$division->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">District </label>
                                    <select class="form-select" name="district" id="districtId">
                                        <option selected disabled>Select District</option>
                                    </select>
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">Thana/Upazila </label>
                                    <select class="form-select" name="upazila" id="upazilaId">
                                        <option selected disabled>Select Project</option>
                                    </select>
                                </div>
                            </div><!-- Col -->

                        </div><!-- Row -->

                    </div>
                    <div class="modal-footer">
                        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                        <button type="button" id="projectFormSubmit" class="btn btn-primary mr-2">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@endsection

@push('js')
<script src="{{asset('backend/assets/vendors/toastr.js/toastr.min.js')}}"></script>

<script src="{{asset('backend/assets/vendors/datatables.net/jquery.dataTables.js')}}"></script>
<script src="{{asset('backend/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js')}}"></script>
<script src="{{asset('backend/assets/js/data-table.js')}}"></script>

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

        //function for get project data
        $(function() {
            var table = $('#projectDataTable').DataTable({
                "autoWidth": false,
                processing: true,
                serverSide: true,
                "order": [
                    [0, "DESC"]
                ],
                ajax: {
                    "url": "{{ route('user.project.index') }}",
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
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'address',
                        name: 'address'
                    },
                    {
                        data: 'division',
                        name: 'division'
                    },
                    {
                        data: 'district',
                        name: 'district'
                    },
                    {
                        data: 'upazila',
                        name: 'upazila'
                    },
                    {
                        data: 'land_type',
                        name: 'land_type'
                    },
                    {
                        data: 'user_name',
                        name: 'user_name'
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
        // end project data

        // Add New Project
        $('#projectFormSubmit').click(function(e) {
            e.preventDefault();
            //console.log($('#addAssetForm').serialize());
            $.ajax({
                url: "{{route('user.project.store')}}",
                method: 'POST',
                data: $('#addProjectForm').serialize(),
                success: function(result) {
                    if (result.errors) {
                        printErrorMsg(result.errors);
                    } else {
                        printSuccessMsg(result.success);
                        $('.alert-danger').hide();
                        $('#addProjectForm').trigger("reset");
                        $("#projectDataTable").DataTable().draw();
                        $('#addNewModal').modal('hide');
                    }
                }
            });
        });

        // start country
        $('#divisionId').change(function() {
            var division_id = $(this).val();
            if (division_id) {
                $.ajax({
                    type: "GET",
                    url: "{{url('get-district')}}?division_id=" + division_id,
                    success: function(res) {
                        console.log(res);
                        if (res) {
                            $("#districtId").empty();
                            $("#districtId").append('<option>Open this select menu</option>');
                            $.each(res.districts, function(key, value) {
                                $("#districtId").append('<option value="' + key + '">' + value + '</option>');
                            });
                        } else {
                            $("#districtId").empty();
                        }
                    }
                });
            } else {
                $("#districtId").empty();
            }
        });

        $('#districtId').change(function() {
            var district_id = $(this).val();
            if (district_id) {
                $.ajax({
                    type: "GET",
                    url: "{{url('get-upazila')}}?district_id=" + district_id,
                    success: function(res) {
                        if (res) {
                            $("#upazilaId").empty();
                            $("#upazilaId").append('<option selected disabled>Open this select menu</option>');
                            $.each(res.upazilas, function(key, value) {
                                $("#upazilaId").append('<option value="' + key + '">' + value + '</option>');
                            });
                        } else {
                            $("#upazilaId").empty();
                        }
                    }
                });
            } else {
                $("#upazilaId").empty();
            }
        });

    });
</script>
@endpush