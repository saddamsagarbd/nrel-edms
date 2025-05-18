@extends('layouts.backend')
@section('title','Agent Media')
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
                    <li class="breadcrumb-item active" aria-current="page">media</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <button type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0" data-bs-toggle="modal" data-bs-target="#agentModal">
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
                    <h6 class="card-title float-left">Media & Agent List</h6>
                    <div class="table-responsive">
                        <table id="agentDataTable" class="table">
                            <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th>name</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>NID</th>
                                    <th>Parents</th>
                                    <th>Client.Type</th>
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
    <div class="modal fade" id="agentModal" tabindex="-1" role="dialog" aria-labelledby="agentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agentModalLabel">Agent/Media/ Vendor(s) /Transferer/ landowner </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <form class="form-horizontal" id="addVendorForm">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-danger" style="display:none"></div>
                        <div class="row">

                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="from-label mb-1 pb-1">Project</label>
                                    <select data-width="100%" class="project_livesearch form-select rounded-0 mb-3 w-100" id="projectId" name="project">
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">Client Type *</label>
                                    <select class="form-select" name="client_type" id="client_type">
                                        <option value="" selected disabled>Select type</option>
                                        <option value="seller">Landowner</option>
                                        <option value="media">Agent/Media</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">Name *</label>
                                    <input type="text" name="vname" id="vname" class="form-control" placeholder="Vendors name">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">phone *</label>
                                    <input type="text" name="phone" id="phone" class="form-control" placeholder="Enter Phone">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">Address *</label>
                                    <input type="text" name="address" id="address" class="form-control" placeholder="Enter Address">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="form-label">Date of Birth</label>
                                    <div class="input-group flatpickr" id="flatpickr-date">
                                        <input type="text" name="birth_date" id="birth_date" class="form-control" placeholder="Select date" data-input>
                                        <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                    </div>
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">NID</label>
                                    <input type="text" name="nid" id="nid" class="form-control" placeholder="Enter National id">
                                </div>
                            </div><!-- Col -->

                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">Father's name</label>
                                    <input type="text" name="father_name" id="father_name" class="form-control" placeholder="Father's name">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">Mother's name</label>
                                    <input type="text" name="mother_name" id="mother_name" class="form-control" placeholder="Mother's name">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">Spouse Name</label>
                                    <input type="text" name="spouse" id="spouse" class="form-control" placeholder="Spouse name">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label" for="profile_photo">Profile Photo</label>
                                    <input class="form-control border-radius-0" name="profile_photo" type="file" id="profile_photo">
                                </div>
                            </div><!-- Col -->
                            <input type="hidden" name="agent_id" id="agentId">

                        </div><!-- Row -->

                    </div>
                    <div class="modal-footer">
                        <button type="button" id="vendorFormSubmit" class="btn btn-primary mr-2">Save</button>
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
<script src="{{asset('backend/assets/vendors/toastr.js/toastr.min.js')}}"></script>
<script src="{{asset('backend/assets/vendors/datatables.net/jquery.dataTables.js')}}"></script>
<script src="{{asset('backend/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js')}}"></script>
<script src="{{asset('backend/assets/js/data-table.js')}}"></script>
<script src="{{asset('backend/assets/vendors/flatpickr/flatpickr.min.js')}}"></script>
<script src="{{asset('backend/assets/js/flatpickr.js')}}"></script>
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

        // start data
        $(function() {
            var table = $('#agentDataTable').DataTable({
                "autoWidth": false,
                processing: true,
                serverSide: true,
                "order": [
                    [0, "DESC"]
                ],
                ajax: {
                    "url": "{{ route('user.agent.index') }}",
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
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'address',
                        name: 'address'
                    },
                    {
                        data: 'nid',
                        name: 'nid'
                    },
                    {
                        data: 'parents',
                        name: 'parents'
                    },
                    {
                        data: 'client_type',
                        name: 'client_type'
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

        // Add New Project
        $('#vendorFormSubmit').click(function(e) {
            e.preventDefault();
            var form_data = new FormData();
            form_data.append("project", $("#projectId option:selected").val());
            form_data.append("client_type", $("#client_type option:selected").val());
            form_data.append("vname", $("input#vname").val());
            form_data.append("phone", $("input#phone").val());
            form_data.append("address", $("input#address").val());
            form_data.append("birth_date", $("input#birth_date").val());
            form_data.append("nid", $("input#nid").val());
            form_data.append("father_name", $("input#father_name").val());
            form_data.append("mother_name", $("input#mother_name").val());
            form_data.append("spouse", $("input#spouse").val());
            form_data.append("agent_id", $("input#agentId").val());
            form_data.append('file', $('input[type=file]#profile_photo')[0].files[0]);
            //console.log($('#addAssetForm').serialize());
            $.ajax({
                url: "{{route('user.agent.store')}}",
                method: 'POST',
                data: form_data,
                processData: false,
                contentType: false,
                success: function(result) {
                    if (result.errors) {
                        printErrorMsg(result.errors);
                    } else {
                        printSuccessMsg(result.success);
                        $('.alert-danger').hide();
                        $('#addVendorForm').trigger("reset");
                        $("#agentDataTable").DataTable().draw();
                        $('#agentModal').modal('hide');
                    }
                }
            });
        });


        $('body').on('click', '.editAgentMedia', function() {
            var agent_id = $(this).data('id');
            $.get("{{ url('user/agent-media') }}" + '/' + agent_id + '/edit', function(data) {
                $('#addVendorForm').trigger("reset");
                $('#agentModalLabel').html("Edit Agent/Media");
                $('#vendorFormSubmit').val("update");
                $('#agentModal').modal('show');
                $('#agentId').val(data.id);
                //$('#projectId option[value="'+data.project_id+'"]' ).attr('selected', true);
                $('#vname').val(data.name);
                $('#phone').val(data.phone);
                $('#address').val(data.address);
                $('#birthDate').val(data.birth_date);
                $('#nid').val(data.nid);
                $('#fatherName').val(data.father_name);
                $('#motherName').val(data.mother_name);
                $('#spouse').val(data.spouse);
            })
        });

        $('#agentModal').on('hidden.bs.modal', function () {
            $(this).find('form#addVendorForm').trigger('reset');
        })


        $('.project_livesearch').select2({
            dropdownParent: $('#agentModal'),
            placeholder: 'Select Project',
            ajax: {
                url: "{{ url('/project/search') }}",
                data: function(params) {
                    return {
                        search: params.term,
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

         // flatpickr issue editable soln
        document.addEventListener('focusin', (e) => {
            if (e.target.closest(".flatpickr-calendar") !== null) {
                e.stopImmediatePropagation();
            }
        });
        
    });
</script>
@endpush