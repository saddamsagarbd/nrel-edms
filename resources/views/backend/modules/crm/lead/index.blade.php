@extends('layouts.backend')
@section('title','Projects')
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
        padding: 0.3rem .5rem;
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

<div class="page-content">

    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0"></h4>
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Leads</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <button type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0" data-bs-toggle="modal" data-bs-target="#leadModal">
              <i class="btn-icon-prepend" data-feather="plus-circle"></i>
              New Lead
            </button>
        </div>
    </div>

    <div class="row">
        @include('backend.slices.messages')
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title float-left">Clients</h6>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Location</th>
                                <th>Tags</th>
                                <th>Stage</th>
                                <th>Lead Source</th>
                                <th>Sales Person</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($leads as $lead)
                            <tr>
                                <td>{{$lead->id}}</td>
                                <td>{{$lead->name}}</td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td>
                                <td>{{$lead->location}}</td>
                                <td><span>{{$lead->status}}</span></td>
                                <td>
                                    <a href="{{route('user.lead.edit',$lead->id)}}" class="btn btn-light btn-sm btn-sm-custom"><i data-feather="edit-2" width="18" height="18"></i></a>
                                    <a href="{{route('user.lead.show',$lead->id)}}" class="btn btn-light btn-sm btn-sm-custom"><i data-feather="eye" width="18" height="18"></i></a>
                                </td>
                            </tr>
                            @endforeach

                            <tr>
                                <td>1</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
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
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    All Leads By Status
                </div>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Qualifications
                        <span class="badge bg-primary rounded-pill">14</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Need analysis
                        <span class="badge bg-primary rounded-pill">2</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Proposal/Price Quote
                        <span class="badge bg-primary rounded-pill">1</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Negotiation
                        <span class="badge bg-primary rounded-pill">1</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Closed Won
                        <span class="badge bg-primary rounded-pill">1</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Closed Lost
                        <span class="badge bg-primary rounded-pill">1</span>
                    </li>
                </ul>

            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="leadModal" tabindex="-1" role="dialog" aria-labelledby="leadModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="leadModalLabel">Add Client</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>

                <form class="form-horizontal">
                    <div class="modal-body">  
                        <div class="alert alert-danger" style="display:none"></div>                           
                        <div class="mb-3 row">
                            <label for="name" class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="name" autocomplete="off" placeholder="name">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="phone" class="col-sm-3 col-form-label">Telephone</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="phone" autocomplete="off" placeholder="Mobile number">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="email" class="col-sm-3 col-form-label">Email Address</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="email" autocomplete="off" placeholder="Email">
                            </div>
                        </div>
                        
                        <div class="mb-3 row">
                            <label for="lead_source" class="col-sm-3 col-form-label">Lead Source</label>
                            <div class="col-sm-9">
                                <select id="lead_source" class="form-control">
                                    <option value="" selected disabled>Open this select menu</option>
                                    <option value="1">Facebook</option>
                                    <option value="2">Linkedin</option>
                                    <option value="3">Others</option>
                                </select>
                            </div>
                        </div>
                        @php 
                            $lead_status = array('New', 'Converted','Qualified','Proposal Sent','Contacted','Disqualified');
                        @endphp
                        <div class="mb-3 row">
                            <label for="lead_status" class="col-sm-3 col-form-label">Lead Status</label>
                            <div class="col-sm-9">
                                <select id="lead_status" class="form-control">
                                    <option value="" selected disabled>Select Status</option>
                                    @foreach($lead_status as $lead)
                                    <option value="{{$lead}}">{{$lead}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="project" class="col-sm-3 col-form-label">Project</label>
                            <div class="col-sm-9">
                                <select id="project" class="form-control mb-3">
                                    <option value="" selected disabled>Select project</option>
                                    <option value="1">Belgravia</option>
                                    <option value="2">Prstine Pavilion</option>
                                    <option value="3">Cheze de Sofia</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="description" class="col-sm-3 col-form-label">Details</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="description" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="row mt-1 mb-3">
                            <h6>Address & Organisation Details</h6>
                        </div>
                        <div class="mb-3 row">
                            
                            <label for="address" class="col-sm-3 col-form-label">Present Address</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="address" autocomplete="off" placeholder="address">
                            </div>
                        </div>                
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="formSubmit" class="btn btn-primary mr-2">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="projectTimelineModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Work Timeline</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="forms-sample" action="">
                    <div class="modal-body">                             
                        <ul class="timeline">
                            <li class="event" data-date="12:30 - 1:00pm">
                                <h3>Registration</h3>
                                <p>Get here on time, it's first come first serve. Be late, get turned away.</p>
                            </li>
                            <li class="event" data-date="2:30 - 4:00pm">
                                <h3>Opening Ceremony</h3>
                                <p>Get ready for an exciting event, this will kick off in amazing fashion with MOP & Busta Rhymes as an opening show.</p>    
                            </li>
                            <li class="event" data-date="5:00 - 8:00pm">
                                <h3>Main Event</h3>
                                <p>This is where it all goes down. You will compete head to head with your friends and rivals. Get ready!</p>    
                            </li>
                            <li class="event" data-date="8:30 - 9:30pm">
                                <h3>Closing Ceremony</h3>
                                <p>See how is the victor and who are the losers. The big stage is where the winners bask in their own glory.</p>    
                            </li>
                        </ul>               
                    </div>
                    <div class="modal-footer">
                        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                        <!-- <button type="submit" class="btn btn-primary mr-2">Save</button> -->
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

            $('#formSubmit').click(function(e){
                e.preventDefault();
                $.ajax({
                    url: "{{ route('user.lead.store') }}",
                    method: 'post',
                    data: {
                        name: $('input#name').val(),
                        phone: $('input#phone').val(),
                        email: $('input#email').val(),
                        lead_source: $('select#lead_source option:selected').val(),
                        lead_status: $('select#lead_status option:selected').val(),
                        project: $('select#project option:selected').val(),
                        description: $('input#description').val(),
                        address: $('input#address').val(),
                    },
                    success: function(result){
                        if(result.errors)
                        {
                            //printErrorMsg(result.errors);
                            $('.alert-danger').html('');
                            $.each(result.errors, function(key, value){
                                $('.alert-danger').show();
                                $('.alert-danger').append('<li>'+value+'</li>');
                            });
                        }
                        else
                        {   
                            printSuccessMsg(result.success);
                            $('.alert-danger').hide();
                            $('#leadModal').modal('hide');
                        }
                    }
                });
            });
        });
</script>
@endpush