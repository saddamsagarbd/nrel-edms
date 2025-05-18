@extends('layouts.backend')
@section('title','Mouza')
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
        padding: 0.25rem 0.85rem !important;
    }
    table.dataTable.stripe tr.odd {
        background-color: #f9f9f9 !important;
    }
    .stripe > tbody > tr:nth-of-type(odd) {
        --bs-table-accent-bg: none !important;
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
                    <li class="breadcrumb-item active" aria-current="page">Mouza</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <button type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0" data-bs-toggle="modal" data-bs-target="#mouzaModal">
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
                        <table id="mouzaDataTable" class="table stripe">
                            <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th>Mouza Name</th>
                                    <th>Division</th>
                                    <th>District</th>
                                    <th>Upazilla</th>
                                    <th>Union</th>
                                    <th>Create.At</th>
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
    <div class="modal fade" id="mouzaModal" tabindex="-1" role="dialog" aria-labelledby="mouzaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mouzaModalLabel">Add New Mouza</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>

                <form class="form-horizontal" id="addMouzaForm" method="post">
                    @csrf
                    <div class="modal-body">  
                        <div class="alert alert-danger" style="display:none"></div> 
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name" id="mName" class="form-control" placeholder="Mouza name">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">G.L no</label>
                                    <input type="text" name="gl_no" id="glNo" class="form-control" placeholder="G.L no">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">Divisions</label>
                                    <select class="form-select" name="division" id="division">
                                        <option selected disabled>Select District</option>
                                        @foreach(App\Models\Division::all() as $division)
                                            <option value="{{$division->id}}">{{$division->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">District</label>
                                    <select class="form-select liveSelect2" data-width="100%" name="district" id="districtId">
                                        <option selected disabled>Select District</option>
                                        @foreach(App\Models\District::all() as $district)
                                            <option value="{{$district->id}}">{{$district->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">Police Station / Upazilla</label>
                                    <select class="form-select" name="upazila" id="upazilaId">
                                        <option selected disabled>Select Upazila</option>
                                    </select>
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">Union</label>
                                    <select class="form-select" name="union" id="unionId">
                                        <option selected disabled>Select Union</option>
                                    </select>
                                </div>
                            </div><!-- Col -->
                            <input type="hidden" name="mouza_id" id="mouzaId">
                        </div><!-- Row -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="mouzaFormSubmit" class="btn btn-primary mr-2">Save</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</div>

@endsection

@push('js')
<script src="{{asset('backend/assets/vendors/toastr.js/toastr.min.js')}}"></script>
<script src="{{asset('backend/assets/vendors/select2/select2.min.js')}}"></script>
<script src="{{asset('backend/assets/js/select2.js')}}"></script>
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

        
        $('.liveSelect2').select2({
            dropdownParent: $('#mouzaModal')
        });

        
        $(function() {
            var table = $('#mouzaDataTable').DataTable({
                "autoWidth": false,
                processing: true,
                serverSide: true,
                "order": [
                    [0, "DESC"]
                ],
                ajax: {
                    "url": "{{ route('user.mouza.index') }}",
                    "dataType": "json",
                    "type": "GET",
                    data: {
                        "_token": " {{csrf_token()}} "
                    }
                },
                columns: [
                    { data: 'id',  name: 'id' },
                    { data: 'name',  name: 'name' },
                    { data: 'division_name',  name: 'division_name' },
                    { data: 'district_name',  name: 'district_name' },
                    { data: 'upazila_name',  name: 'upazila_name' },
                    { data: 'union_name',  name: 'union_name' },
                    { data: 'created_at',  name: 'created_at' },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

        });


        // Add New Mouza
        $('#mouzaFormSubmit').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{route('user.mouza.store')}}",
                method: 'POST',
                data: $('#addMouzaForm').serialize(),
                success: function(result) {
                    if (result.errors) {
                        printErrorMsg(result.errors);
                    } else {
                        printSuccessMsg(result.success);
                        $('.alert-danger').hide();
                        $('#addMouzaForm').trigger("reset");
                        $("#mouzaDataTable").DataTable().draw();
                        $('#mouzaModal').modal('hide');
                        //table.draw();
                    }
                }
            });
        });

        $('body').on('click', '.editMouza', function() {
            var mouza_id = $(this).data('id');
            $.get("{{ url('user/mouza') }}" + '/' + mouza_id + '/edit', function(data) {
                console.log(data.district_id);
                $('#mouzaModalLabel').html("Edit Mouza");
                $('#mouzaFormSubmit').val("update");
                $('#mouzaModal').modal('show');
                $('#mouzaId').val(data.id);
                $('#mName').val(data.name);
                $('#glNo').val(data.gl_no);
                $('#division option[value="'+data.division_id+'"]' ).attr('selected', true);
                $('#districtId option[value="'+data.district_id+'"]' ).attr('selected', true);
                
            })
        });


        $('#districtId').change(function(){
            var district_id = $(this).val();
            if(district_id){
                $.ajax({
                    type:"GET",
                    url:"{{url('get-upazila')}}?district_id="+district_id,
                    success:function(res){  
                        if(res){
                            $("#upazilaId").empty();
                            $("#upazilaId").append('<option>Open this select menu</option>');
                            $.each(res.upazilas,function(key,value){
                                $("#upazilaId").append('<option value="'+key+'">'+value+'</option>');
                            });
                        }else{
                            $("#upazilaId").empty();
                        }
                    }
                });
            }else{
                $("#upazilaId").empty();
            }      
        });

        $('#upazilaId').change(function(){
            var upazila_id = $(this).val();
            if(upazila_id){
                $.ajax({
                    type:"GET",
                    url:"{{url('get-union')}}?upazila_id="+upazila_id,
                    success:function(res){  
                        if(res){
                            $("#unionId").empty();
                            $("#unionId").append('<option disabled>Open this select menu</option>');
                            $.each(res.unions,function(key,value){
                                $("#unionId").append('<option value="'+key+'">'+value+'</option>');
                            });
                        }else{
                            $("#unionId").empty();
                        }
                    }
                });
            }else{
                $("#unionId").empty();
            }      
        });


    });
</script>
@endpush