@extends('layouts.backend')
@section('title','Projects')
@push('css')
    <link rel="stylesheet" href="{{asset('backend/assets/vendors/toastr.js/toastr.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('backend/assets/vendors/jquery-steps/jquery.steps.css')}}">
    <style>
        .table th, .datepicker table th, .table td, .datepicker table td {
            white-space: normal !important;
        }
        body.modal-open {
            overflow: auto;
        }
        .table th, .table td {
            padding: 0.7rem 0.5375rem !important;
        }
        .nav-pills .nav-link.active, .nav-pills .show > .nav-link {
            background-color: #4e4e4e;
        }
        .nav-link {
            padding: 0.4rem 1rem;
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
                    <li class="breadcrumb-item active" aria-current="page">Schedule</li>
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
                    <h6 class="card-title float-left">Land Schedule Information</h6>
                    <div class="table-responsive">
                        <table id="dataTableProjects" class="table">
                        <thead>
                            
                            <tr>
                                <th>#ID</th>
                                <th>Vendor(s)</th>
                                <th>Deed No.</th>
                                <th>Reg.Date</th>
                                <th>Mouza</th>
                                <th style="background-color: #f7f7f7;">C.S/S.A</th>
                                <th style="background-color: #f7f7f7;">R.S</th>
                                <th style="background-color: #e7e9ff;">Kha. (C.S/S.A) </th>
                                <th style="background-color: #e7e9ff;">Kha. (R.S)</th>
                                <th>Area</th>
                                <th>Rate/B</th>
                                <th>Land Cost</th>
                                <th>Reg. Expen</th>
                                <th>Total Cost</th>
                                <th>Remarks</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>NAVANA Plantatiopn Ltd.</td>
                                <td> 870</td>
                                <td> 08/03/2006</td>
                                <td> Ketun </td>
                                <td> 198 </td>
                                <td> 515</td>
                                <td> - </td>
                                <td> -</td>
                                <td>128</td>
                                <td>17.00</td>
                                <td>6,600,000.00</td>
                                <td>200,000.00</td>
                                <td>6,800,000.00</td>
                                <td> SK</td>
                                <td> 
                                    <a href="#" class="btn btn-light btn-sm btn-sm-custom"><i data-feather="edit-2" width="18" height="18"></i></a>
                                    <a href="{{route('user.deed.show',1)}}" class="btn btn-light btn-sm btn-sm-custom"><i data-feather="eye" width="18" height="18"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Aziz Sheikh & Edris Miah</td>
                                <td>5644</td>
                                <td>28/12/2006</td>
                                <td> Ketun </td>
                                <td> 141 </td>
                                <td> 249</td>
                                <td> - </td>
                                <td> - </td>
                                <td>49</td>
                                <td>30</td>
                                <td>4,454,500.00</td>
                                <td>63,800.00</td>
                                <td>4,518,300.00</td>
                                <td> SK</td>
                                <td> 
                                    <a href="#" class="btn btn-light btn-sm btn-sm-custom"><i data-feather="edit-2" width="18" height="18"></i></a>
                                    <a href="{{route('user.deed.show',1)}}" class="btn btn-light btn-sm btn-sm-custom"><i data-feather="eye" width="18" height="18"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Ali Amjad Khan</td>
                                <td>4280</td>
                                <td>26.09.2007</td>
                                <td> Ketun </td>
                                <td> 141 </td>
                                <td> 249</td>
                                <td> - </td>
                                <td> - </td>
                                <td>35</td>
                                <td>17</td>
                                <td>1,803,030.00</td>
                                <td>17,000.00</td>
                                <td>1,820,030.00</td>
                                <td> Power</td>
                                <td> 
                                    <a href="#" class="btn btn-light btn-sm btn-sm-custom"><i data-feather="edit-2" width="18" height="18"></i></a>
                                    <a href="{{route('user.deed.show',1)}}" class="btn btn-light btn-sm btn-sm-custom"><i data-feather="eye" width="18" height="18"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Ali Amjad Khan</td>
                                <td>5715</td>
                                <td>19.12.2007</td>
                                <td> Ketun </td>
                                <td> 142 </td>
                                <td> 244</td>
                                <td> - </td>
                                <td> - </td>
                                <td>8.5</td>
                                <td>15</td>
                                <td>386,300.00</td>
                                <td>14,000.00</td>
                                <td>400,300.00</td>
                                <td> SK</td>
                                <td> 
                                    <a href="#" class="btn btn-light btn-sm btn-sm-custom"><i data-feather="edit-2" width="18" height="18"></i></a>
                                    <a href="{{route('user.deed.show',1)}}" class="btn btn-light btn-sm btn-sm-custom"><i data-feather="eye" width="18" height="18"></i></a>
                                </td>
                            </tr>

                            <tr>
                                <td>5</td>
                                <td>Ali Amjad Khan</td>
                                <td>2624</td>
                                <td>02. 07.2007</td>
                                <td> Ketun </td>
                                <td> 142 </td>
                                <td> 244</td>
                                <td> - </td>
                                <td> - </td>
                                <td>8.5</td>
                                <td>15</td>
                                <td>386,300.00</td>
                                <td>12,000.00</td>
                                <td>398,300.00</td>
                                <td> SK</td>
                                <td> 
                                    <a href="#" class="btn btn-light btn-sm btn-sm-custom"><i data-feather="edit-2" width="18" height="18"></i></a>
                                    <a href="{{route('user.deed.show',1)}}" class="btn btn-light btn-sm btn-sm-custom"><i data-feather="eye" width="18" height="18"></i></a>
                                </td>
                            </tr>

                            <tr>
                                <td>6</td>
                                <td>Haji Jalal Uddin</td>
                                <td>1444</td>
                                <td>22.04.2007</td>
                                <td> Ketun </td>
                                <td> 70 </td>
                                <td> 221</td>
                                <td> - </td>
                                <td> - </td>
                                <td>10.5</td>
                                <td>10</td>
                                <td>318,000.00</td>
                                <td>10,000.00</td>
                                <td>328,000.00</td>
                                <td>Power</td>
                                <td> 
                                    <a href="#" class="btn btn-light btn-sm btn-sm-custom"><i data-feather="edit-2" width="18" height="18"></i></a>
                                    <a href="{{route('user.deed.show',1)}}" class="btn btn-light btn-sm btn-sm-custom"><i data-feather="eye" width="18" height="18"></i></a>
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
                    <h5 class="modal-title" id="exampleModalLabel">Add Land Schedule Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>

                <div class="modal-body"> 

                    <ul class="nav nav-pills mb-3 nav-justified bg-light" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="pills-cs-tab" data-toggle="pill" href="#pills-cs" role="tab" aria-controls="pills-cs" aria-selected="true">CS</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="pills-sa-tab" data-toggle="pill" href="#pills-sa" role="tab" aria-controls="pills-sa" aria-selected="false">SA</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="pills-rs-tab" data-toggle="pill" href="#pills-rs" role="tab" aria-controls="pills-rs" aria-selected="false">RS</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="pills-bs-tab" data-toggle="pill" href="#pills-bs" role="tab" aria-controls="pills-bs" aria-selected="false">BS</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="pills-city-tab" data-toggle="pill" href="#pills-city" role="tab" aria-controls="pills-city" aria-selected="false">CITY</a>
                        </li>
                    </ul>
                    <div class="tab-content ml-3" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-cs" role="tabpanel" aria-labelledby="pills-cs-tab">
                            <form action="{{route('user.land.schedule.cs.store')}}" method="POST">
                            @csrf
                            <div class="cs-info">
                                <h6 class="card-title">C.S</h6>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label class="control-label">Mouza</label>
                                        <select class="form-control" name="mouza" id="mouza">
                                            <option selected disabled>Select Project</option>
                                            @foreach(App\Models\Mouza::all() as $mouzas)
                                            <option value="{{$mouzas->id}}">{{$mouzas->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row cs-cont mt-3" id="csrow_1">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class="control-label">Dag No (C.S)</label>
                                            <input type="text" name="dag[]" class="form-control" placeholder="Dag No">
                                        </div>
                                    </div><!-- Col -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class="control-label">Khatian (C.S)</label>
                                            <input type="text" name="khatian[]" class="form-control" placeholder="Khatian No">
                                        </div>
                                    </div><!-- Col -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class="control-label">Land Size (C.S)</label>
                                            <input type="text" name="size[]" class="form-control" placeholder="Land Size">
                                        </div>
                                    </div><!-- Col -->
                                </div>
                            </div> 
                            <div class="add-more">
                                <a href="javascript:void(0);" class="add-cs_khatian"><i class="fa fa-plus-circle"></i> Add More</a>
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary mr-2">Save</button>
                            </div>

                            </form>
                        </div>
                        <div class="tab-pane fade" id="pills-sa" role="tabpanel" aria-labelledby="pills-sa-tab">
                            <div class="sa-info">
                                <h6 class="card-title">S.A</h6>
                                <div class="row cs-cont" id="sarow_1">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class="control-label">Dag No (S.A)</label>
                                            <input type="text" name="zone" class="form-control" placeholder="Dag No">
                                        </div>
                                    </div><!-- Col -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class="control-label">Khatian (S.A)</label>
                                            <input type="text" name="zone" class="form-control" placeholder="Khatian No">
                                        </div>
                                    </div><!-- Col -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class="control-label">Land Size (S.A)</label>
                                            <input type="text" name="zone" class="form-control" placeholder="Land Size">
                                        </div>
                                    </div><!-- Col -->
                                </div>
                            </div> 
                            <div class="add-more">
                                <a href="javascript:void(0);" class="add-sa_khatian"><i class="fa fa-plus-circle"></i> Add More</a>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="pills-rs" role="tabpanel" aria-labelledby="pills-rs-tab">
                            <h6 class="card-title">R.S</h6>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">Dag No (R.S)</label>
                                        <input type="text" name="zone" class="form-control" placeholder="Dag No">
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">Khatian (R.S)</label>
                                        <input type="text" name="zone" class="form-control" placeholder="Khatian no">
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">Land Size(R.S)</label>
                                        <input type="text" name="zone" class="form-control" placeholder="Land Size">
                                    </div>
                                </div><!-- Col -->
                            </div> 
                        </div>

                        <div class="tab-pane fade" id="pills-bs" role="tabpanel" aria-labelledby="pills-bs-tab">
                            <h6 class="card-title">B.S</h6>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">Dag No (B.S)</label>
                                        <input type="text" name="zone" class="form-control" placeholder="Dag No">
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">Khatian No (B.S)</label>
                                        <input type="text" name="zone" class="form-control" placeholder="Khatian No">
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">Land Size (B.S)</label>
                                        <input type="text" name="zone" class="form-control" placeholder="Land Size">
                                    </div>
                                </div><!-- Col -->
                            </div> 
                        </div> <!-- END -->
                        <div class="tab-pane fade" id="pills-city" role="tabpanel" aria-labelledby="pills-city-tab">

                            <h6 class="card-title">City</h6>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">Dag No (City)</label>
                                        <input type="text" name="zone" class="form-control" placeholder="Dag No">
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">Khatian No (City)</label>
                                        <input type="text" name="zone" class="form-control" placeholder="Khatian No">
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">Land Size (City)</label>
                                        <input type="text" name="zone" class="form-control" placeholder="Land Size">
                                    </div>
                                </div><!-- Col -->
                            </div> 

                        </div> <!-- END -->

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" id="formSubmit" class="btn btn-primary mr-2">Save</button>
                </div>
   
            </div>
        </div>
    </div>
    <!-- Modal -->

</div>
            
@endsection

@push('js')
<script src="{{asset('backend/assets/vendors/datatables.net/jquery.dataTables.js')}}"></script>
<script src="{{asset('backend/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js')}}"></script>
<script src="{{asset('backend/assets/js/data-table.js')}}"></script>
<script src="{{asset('backend/assets/vendors/toastr.js/toastr.min.js')}}"></script>
<script src="{{asset('backend/assets/vendors/jquery-steps/jquery.steps.min.js')}}"></script>
<script src="{{asset('backend/assets/js/wizard.js')}}"></script>
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



    // C.S Add More
	
    $(".cs-info").on('click','.trash', function () {
		$(this).closest('.cs-cont').remove();
		return false;
    });

    $(".add-cs_khatian").on('click', function () {
        console.log('hello');

        var regcontent = '<div class="row cs-cont" id="csrow_1">'+
                                '<div class="col-sm-3">'+
                                    '<div class="form-group">'+
                                        '<label class="control-label">Dag No (C.S)</label>'+
                                        '<input type="text" name="dag[]" class="form-control" placeholder="Khatian No">'+
                                    '</div>'+
                                '</div>'+
                               ' <div class="col-sm-3">'+
                                  '  <div class="form-group">'+
                                       ' <label class="control-label">Khatian (C.S)</label>'+
                                       ' <input type="text" name="khatian[]" class="form-control" placeholder="Dag No">'+
                                   ' </div>'+
                               ' </div>'+
                               ' <div class="col-sm-3">'+
                                   ' <div class="form-group">'+
                                       ' <label class="control-label">Land Size (C.S)</label>'+
                                        '<input type="text" name="size[]" class="form-control" placeholder="Land Size">'+
                                  ' </div>'+
                                '</div>'+
                               ' <div class="col-sm-1">'+
                                    '<label class="d-md-block d-sm-none d-none">&nbsp;</label>'+
                                    '<a href="#" class="btn btn-danger btn-sm btn-sm-custom trash" style="padding:11px !important">X</a>'+
                               ' </div>'+
                           ' </div>';
		
		$(".cs-info").append(regcontent);
        return false;
    });
    // end CS

    // C.S Add More
	
    $(".sa-info").on('click','.trash', function () {
		$(this).closest('.cs-cont').remove();
		return false;
    });

    $(".add-sa_khatian").on('click', function () {

        var regcontent = '<div class="row cs-cont" id="csrow_1">'+
                                '<div class="col-sm-3">'+
                                    '<div class="form-group">'+
                                        '<label class="control-label">Khatian No (S.A)</label>'+
                                        '<input type="text" name="zone" class="form-control" placeholder="Khatian No">'+
                                    '</div>'+
                                '</div>'+
                               ' <div class="col-sm-3">'+
                                  '  <div class="form-group">'+
                                       ' <label class="control-label">Dag No (S.A)</label>'+
                                       ' <input type="text" name="zone" class="form-control" placeholder="Dag No">'+
                                   ' </div>'+
                               ' </div>'+
                               ' <div class="col-sm-3">'+
                                   ' <div class="form-group">'+
                                       ' <label class="control-label">Purchase Land Size (S.A)</label>'+
                                        '<input type="text" name="zone" class="form-control" placeholder="Land Size">'+
                                  ' </div>'+
                                '</div>'+
                               ' <div class="col-sm-1">'+
                                    '<label class="d-md-block d-sm-none d-none">&nbsp;</label>'+
                                    '<a href="#" class="btn btn-danger btn-sm btn-sm-custom trash" style="padding:11px !important">X</a>'+
                               ' </div>'+
                           ' </div>';
		
		$(".sa-info").append(regcontent);
        return false;
    });


</script>
@endpush