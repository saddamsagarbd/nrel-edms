@extends('layouts.backend')
@section('title','Projects')
@push('css')
    <link rel="stylesheet" href="{{asset('backend/assets/vendors/toastr.js/toastr.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css')}}">
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
                    <li class="breadcrumb-item active" aria-current="page">document</li>
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
                    <h6 class="card-title float-left">Land Documents Information</h6>
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
                    <h5 class="modal-title" id="exampleModalLabel">Add Land Document Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <form class="form-horizontal" action="#" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">  
                        <div class="alert alert-danger" style="display:none"></div> 
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="control-label">Estate Projects </label>
                                    <select class="form-control" name="status" id="exampleFormControlSelect1">
                                        <option selected disabled>Select Project</option>
                                        <option>Navana Bhuiyan City	 </option>
                                        <option>Highland</option>
                                        <option> -- Highland 1</option>
                                        <option> -- Highland 2</option>
                                        <option> -- Highland 3</option>
                                        <option> -- Highland 4</option>
                                        <option> -- Highland 5</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">Vendor(s) /Transferer/ Seller / Owner </label>
                                    <select class="form-control" name="status" id="exampleFormControlSelect1">
                                        <option selected disabled>Select Project</option>
                                        <option>Ali Amjad Khan</option>
                                        <option>Haji Jalal Uddin</option>
                                        <option>Aziz Sheikh & Edris Miah</option>
                                        <option>NAVANA Plantatiopn Ltd.</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label class="control-label">Deed Nos</label>
                                    <input type="text" name="area_land" class="form-control" placeholder="Deed Nos">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="control-label">Date of Registration</label>
                                    <input type="text" name="area_land" class="form-control" placeholder="dd/mm/yy">
                                </div>
                            </div>
                        </div> <!-- Row -->
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="control-label">Name of Buyer</label>
                                    <input type="text" name="location" class="form-control" placeholder="Site Code/ Received Date">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="control-label">Name of Mouza</label>
                                    <input type="text" name="location" class="form-control" placeholder="Name of mouza">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="control-label">Purchased Area</label>
                                    <input type="text" name="zone" class="form-control" placeholder="Purchased area">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="control-label">Rate/Bigha (Tk)</label>
                                    <input type="text" name="zone" class="form-control" placeholder="Rate/Bigha (Tk)">
                                </div>
                            </div><!-- Col -->
                            
                        </div><!-- Row -->                        
                         <div class="row">
                            
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="control-label">Nature of Deed</label>
                                    <input type="text" name="zone" class="form-control" placeholder="Nature of deed">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label class="control-label">Nature of land</label>
                                    <input type="text" name="zone" class="form-control" placeholder="Land nature">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label class="control-label">Land Cost</label>
                                    <input type="text" name="zone" class="form-control" placeholder="Land cost">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label class="control-label">Reg. Expenses</label>
                                    <input type="text" name="zone" class="form-control" placeholder="Reg. Expenses">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="control-label">Remarks</label>
                                    <textarea name="zone" class="form-control" placeholder="Remarks" rows='2'></textarea>
                                </div>
                            </div><!-- Col -->
                            
                        </div>
                        
                        <!-- CS khatian -->
                        <hr>
                        <div class="cs-info">
                            <h6 class="card-title">C.S</h6>
                            <div class="row cs-cont" id="csrow_1">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">Dag No (C.S)</label>
                                        <input type="text" name="zone" class="form-control" placeholder="Dag No">
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">Khatian No (C.S)</label>
                                        <input type="text" name="zone" class="form-control" placeholder="Khatian No">
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">Purchase Land Size (C.S)</label>
                                        <input type="text" name="zone" class="form-control" placeholder="Land Size">
                                    </div>
                                </div><!-- Col -->
                                <!-- <div class="col-sm-1">
                                    <label class="d-md-block d-sm-none d-none">&nbsp;</label>
                                    <a href="#" class="btn btn-danger btn-sm btn-sm-custom trash"><i data-feather="trash-2" width="18" height="18"></i></a>
                                </div> -->
                            </div>
                        </div> 
                        <div class="add-more">
                            <a href="javascript:void(0);" class="add-cs_khatian"><i class="fa fa-plus-circle"></i> Add More</a>
                        </div>

                       <!-- S.A khatian -->
                       <hr>
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
                                        <label class="control-label">Khatian No (S.A)</label>
                                        <input type="text" name="zone" class="form-control" placeholder="Khatian No">
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">Purchase Land Size (S.A)</label>
                                        <input type="text" name="zone" class="form-control" placeholder="Land Size">
                                    </div>
                                </div><!-- Col -->
                            </div>
                        </div> 
                        <div class="add-more">
                            <a href="javascript:void(0);" class="add-sa_khatian"><i class="fa fa-plus-circle"></i> Add More</a>
                        </div>

                        <!-- R.S khatian -->
                        <hr>
                        <h6 class="card-title">R.S</h6>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="control-label">Dag No (R.S)</label>
                                    <input type="text" name="zone" class="form-control" placeholder="Dag no">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="control-label">Khatian No (R.S)</label>
                                    <input type="text" name="zone" class="form-control" placeholder="khatian no">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="control-label">Purchase Land Size (R.S)</label>
                                    <input type="text" name="zone" class="form-control" placeholder="land size">
                                </div>
                            </div><!-- Col -->
                        </div> 

                        <!-- B.S khatian -->
                        <hr>
                        <h6 class="card-title">B.S</h6>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="control-label">Dag No (B.S)</label>
                                    <input type="text" name="zone" class="form-control" placeholder="Dag no">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="control-label">Khatian No (B.S)</label>
                                    <input type="text" name="zone" class="form-control" placeholder="Khatian no">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="control-label"> Purchase land Size(B.S) </label>
                                    <input type="text" name="zone" class="form-control" placeholder="land size">
                                </div>
                            </div><!-- Col -->
                        </div> 

                        <hr>
                        <h6 class="card-title">CITY</h6>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="control-label">Dag No (CITY)</label>
                                    <input type="text" name="zone" class="form-control" placeholder="Dag no (city)">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="control-label">Khatian No (CITY)</label>
                                    <input type="text" name="zone" class="form-control" placeholder="khatian no (city)">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="control-label">Purchase Land Size (CITY) </label>
                                    <input type="text" name="zone" class="form-control" placeholder="land size (city)">
                                </div>
                            </div><!-- Col -->
                        </div> 

                    </div>
                    <div class="modal-footer">
                        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button> -->
                        <button type="submit" id="formSubmit" class="btn btn-primary mr-2">Save</button>
                    </div>
                </form>
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

        var regcontent = '<div class="row cs-cont" id="csrow_1">'+
                                '<div class="col-sm-3">'+
                                    '<div class="form-group">'+
                                        '<label class="control-label">Dag No (C.S)</label>'+
                                        '<input type="text" name="zone" class="form-control" placeholder="Dag No">'+
                                    '</div>'+
                                '</div>'+
                               ' <div class="col-sm-3">'+
                                  '  <div class="form-group">'+
                                       ' <label class="control-label">Khatian No (C.S)</label>'+
                                       ' <input type="text" name="zone" class="form-control" placeholder="Khatian No">'+
                                   ' </div>'+
                               ' </div>'+
                               ' <div class="col-sm-3">'+
                                   ' <div class="form-group">'+
                                       ' <label class="control-label">Purchase Land Size (C.S)</label>'+
                                        '<input type="text" name="zone" class="form-control" placeholder="Land Size">'+
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
                                        '<label class="control-label">Dag No (S.A)</label>'+
                                        '<input type="text" name="zone" class="form-control" placeholder="Dag No">'+
                                    '</div>'+
                                '</div>'+
                               ' <div class="col-sm-3">'+
                                  '  <div class="form-group">'+
                                       ' <label class="control-label">Khatian No (S.A)</label>'+
                                       ' <input type="text" name="zone" class="form-control" placeholder="Khatian No">'+
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