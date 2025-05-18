@extends('layouts.backend')
@section('title','Dashboard')
@push('css')
    <link rel="stylesheet" href="{{asset('backend/assets/vendors/toastr.js/toastr.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css')}}">

    <style>
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

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Mouza</a></li>
                <li class="breadcrumb-item active" aria-current="page">Schedule / Create</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-12 col-md-10 col-xl-8 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">New Land Schedule Khatian Type </h6>
                        <!-- <p class="card-description">Add class <code>.table-hover</code></p> -->

                        <ul class="nav nav-pills mb-3 nav-justified bg-light" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="pills-cs-tab" data-toggle="pill" href="#pills-cs" role="tab" aria-controls="pills-cs" aria-selected="true">CS/SA</a>
                        </li>
                        <!-- <li class="nav-item" role="presentation">
                            <a class="nav-link" id="pills-sa-tab" data-toggle="pill" href="#pills-sa" role="tab" aria-controls="pills-sa" aria-selected="false">SA</a>
                        </li> -->
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
                                <!-- <div class="row">
                                    <div class="col-sm-3">
                                        <label class="control-label">Mouza</label>
                                        <select class="form-control" name="mouza" id="mouza">
                                            <option selected disabled>Select Project</option>
                                            @foreach(App\Models\Mouza::all() as $mouzas)
                                            <option value="{{$mouzas->id}}">{{$mouzas->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> -->
                                <input type="hidden" name="mouza" class="form-control" value="">
                                <div class="row cs-cont mt-3" id="csrow_1">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class="control-label">Dag No (C.S)</label>
                                            <input type="text" name="dag[]" class="form-control" placeholder="Dag No">
                                        </div>
                                    </div><!-- Col -->
                                    
                                    <!-- Col -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class="control-label">Land Size (C.S)</label>
                                            <input type="text" name="size[]" class="form-control" placeholder="Land Size">
                                        </div>
                                    </div><!-- Col -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class="control-label">Khatian (C.S)</label>
                                            <input type="text" name="khatian[]" class="form-control" placeholder="Khatian No">
                                        </div>
                                    </div>
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
                                    <div class="col-sm-2">
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
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary mr-2">Save</button>
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
<script src="{{asset('backend/assets/vendors/jquery-steps/jquery.steps.min.js')}}"></script>
<script src="{{asset('backend/assets/js/wizard.js')}}"></script>
<script src="{{asset('backend/assets/vendors/select2/select2.min.js')}}"></script>
<script src="{{asset('backend/assets/js/select2.js')}}"></script>
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
                                ' <div class="form-group">'+
                                    ' <label class="control-label">Land Size (C.S)</label>'+
                                    '<input type="text" name="size[]" class="form-control" placeholder="Land Size">'+
                                ' </div>'+
                            '</div>'+
                            ' <div class="col-sm-3">'+
                                '  <div class="form-group">'+
                                    ' <label class="control-label">Khatian (C.S)</label>'+
                                    ' <input type="text" name="khatian[]" class="form-control" placeholder="Dag No">'+
                                ' </div>'+
                            ' </div>'+
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

        var regcontent = '<div class="row cs-cont" id="sarow_1">'+
                            '<div class="col-sm-3">'+
                                '<div class="form-group" style="display: flex; flex-direction:column">'+
                                    '<label class="control-label">Dag No (C.S)</label>'+
                                    '<select class="js-example-basic-single w-100">'+
                                        '<option value="1">100</option>'+
                                    '</select>'+
                                '</div>'+
                           '</div>'+
                            '<div class="col-sm-3">'+
                                '<div class="form-group">'+
                                    '<label class="control-label">Dag No (S.A)</label>'+
                                    '<input type="text" name="dag[]" class="form-control" placeholder="Khatian No">'+
                                '</div>'+
                            '</div>'+
                            ' <div class="col-sm-2">'+
                                '  <div class="form-group">'+
                                    ' <label class="control-label">Khatian (S.A)</label>'+
                                    ' <input type="text" name="khatian[]" class="form-control" placeholder="Dag No">'+
                                ' </div>'+
                            ' </div>'+
                            ' <div class="col-sm-3">'+
                                ' <div class="form-group">'+
                                    ' <label class="control-label">Land Size (S.A)</label>'+
                                    '<input type="text" name="size[]" class="form-control" placeholder="Land Size">'+
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