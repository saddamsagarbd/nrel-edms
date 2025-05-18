@extends('layouts.backend')
@section('title','Dashboard')
@push('css')
<link rel="stylesheet" href="{{asset('backend/assets/vendors/toastr.js/toastr.min.css')}}">

@endpush

@section('content')

<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Project</a></li>
            <li class="breadcrumb-item" aria-current="page">edit</li>
            <li class="breadcrumb-item active" aria-current="page">{{$data->name}}</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-9 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">{{$data->name}} </h6>
                    <form class="form-horizontal" id="updateProjectForm" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="alert alert-danger" style="display:none"></div>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="form-label">Project Name *</label>
                                    <input type="text" name="name" class="form-control" value="{{$data->name}}" placeholder="Enter Project name">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="form-label">Parent Project</label>
                                    <select class="form-select" name="parent_id" id="parent_id">
                                        <option selected disabled>Select Project</option>
                                        @foreach(App\Models\EstateProject::where('parent_id', NULL)->get() as $sproject)
                                        <option value="{{$sproject->id}}" {{$data->id == $sproject->id ? 'selected' : ''}}>{{$sproject->name}}</option>
                                        @foreach(App\Models\EstateProject::where('parent_id', $sproject->id)->get() as $subproject)
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
                                        <option selected disabled>Select Land type</option>
                                        <option {{$data->land_type == 'Freehold' ? 'selected' : ''}}>Freehold</option>
                                        <option {{$data->land_type == 'Leasehold' ? 'selected': ''}}>Leasehold</option>
                                        <option {{$data->land_type == 'Others' ? 'selected' : ''}}>Others</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="form-label">Project Category *</label>
                                    <select class="form-select" name="project_category" id="project_category">
                                        <option selected disabled>Select your Category</option>
                                        @foreach(App\Models\EstateLookUp::where('data_type', 'project.category')->get() as $pr_cat)
                                        <option value="{{$pr_cat->data_keys}}" {{$pr_cat->data_keys == $data->pr_category ? 'selected' : ''}} >{{$pr_cat->data_values}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">Project Type *</label>
                                    <select class="form-select" name="project_type" id="project_type">
                                        <option selected disabled>Select project type</option>
                                        <option value="land" {{$data->project_type == 'land' ? 'selected' : ''}}> Land</option>
                                        <option value="apartment" {{$data->project_type == 'apartment' ? 'selected' : ''}}>Apartment</option>
                                        <option value="others" {{$data->project_type == 'others' ? 'selected' : ''}}> Others</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="form-label">Location *</label>
                                    <select class="form-select" name="location" id="location">
                                        <option selected disabled>Select project location</option>
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
                                        <option value="mawa">Mawa</option>
                                    </select>
                                </div>
                            </div>
            
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">Select Status *</label>
                                    <select class="form-select" name="status" id="statusId">
                                        <option selected disabled>Select status</option>
                                        <option value="upcoming" {{$data->status == 'upcoming' ? 'selected' : ''}}>Upcoming</option>
                                        <option value="ongoing" {{$data->status == 'ongoing' ? 'selected' : ''}}>Ongoing</option>
                                        <option value="completed" {{$data->status == 'completed' ? 'selected' : ''}}>Completed</option>
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
                                        <option value="{{$division->id}}" {{$division->id == $data->division_id ? 'selected' : ''}}>{{$division->name}}</option>
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
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Address *</label>
                                    <input type="text" name="address" value="{{$data->address}}" class="form-control" placeholder="Project address">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Description *</label>
                                    <input type="text" name="description" value="{{$data->description}}" class="form-control" placeholder="Project Description">
                                </div>
                            </div>
                            <input type="hidden" name="project_id" value="{{$data->id}}">

                        </div><!-- Row -->
                        <button type="button" id="projectFormSubmit" class="btn btn-primary mr-2">Save</button>
                    </form>

                </div>
            </div>
        </div>
        <div class="col-md-3 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Users List</h6>
                </div>
            </div>
        </div>
    </div>

</div>


@endsection

@push('js')

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


        $('#projectFormSubmit').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{route('admin.project.update')}}",
                method: 'POST',
                data: $('#updateProjectForm').serialize(),
                success: function(result) {
                    if (result.errors) {
                        printErrorMsg(result.errors);
                    } else {
                        printSuccessMsg(result.success);
                        $('.alert-danger').hide();
                        $('#updateProjectForm').trigger("reset");
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
                            $("#upazilaId").append('<option>Open this select menu</option>');
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