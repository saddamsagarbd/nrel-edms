@extends('layouts.backend')
@section('title','Dashboard')
@push('css')
    <!--  <link rel="stylesheet" href="{{asset('public/frontend/vendor/wowjs/animate.css')}}"> -->
    <link rel="stylesheet" href="{{asset('backend/assets/vendors/toastr.js/toastr.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css')}}">
    <style>
        .table th, .datepicker table th, .table td, .datepicker table td {
            white-space: normal !important;
        }
        .list-group-item {
            padding: 0.3rem 0.55rem !important;
        }
    </style>
@endpush

@section('content')

    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Projects</a></li>
                <li class="breadcrumb-item active" aria-current="page">highland</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-4 col-md-4 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Name: Navana Highland</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Vendor(s) /Transferer/ Seller / Owner: <span  class="badge badge-secondary"> </span></li>
                            <li class="list-group-item">Deed Nos : </li>
                            <li class="list-group-item">Registration Date :  </li>
                            <li class="list-group-item">Name of Vendoee  :  </li>
                            <li class="list-group-item">Name of Mouza  :  </li>
                            <li class="list-group-item">Remarks  :  </li>
                            <li class="list-group-item">Dag No : C.S-,S.A, R.S, B.S/City </li>
                            <li class="list-group-item">Dag No : C.S-,S.A, R.S, B.S/City </li>
                            <li class="list-group-item">Khatian No :  </li>
                            <li class="list-group-item">Purchased Area  :  </li>
                            <li class="list-group-item">Rate/Bigha (Tk)  :  </li>
                            <li class="list-group-item">Nature of Deed  :  </li>
                            <li class="list-group-item">Nature of land  :  </li>
                            <li class="list-group-item">Land Cost  :  </li>
                            <li class="list-group-item">Reg. Expenses  :  </li>
                            <li class="list-group-item">Total Cost  :  </li>
                        </ul>
                    </div>
                </div>
            </div>
    

            <div class="col-8 col-md-8 col-xl-8 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Documents</h6>
                        <!-- <p class="card-description">Add class <code>.table-hover</code></p> -->
                        <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Document type</th>
                                            <th>File Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>1</th>
                                            <td>Landowner</td>
                                            <td>higland-landowner.pdf</td>
                                            <td>
                                                <a href="#" class="btn btn-light btn-sm btn-sm-custom"><i data-feather="download" width="18" height="18"></i></a>
                                                <a href="#" class="btn btn-light btn-sm btn-sm-custom"><i data-feather="printer" width="18" height="18"></i></a>
                                                <a href="#" class="btn btn-light btn-sm btn-sm-custom"><i data-feather="eye" width="18" height="18"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>2</th>
                                            <td>Mutation</td>
                                            <td>higland-Mutation.pdf</td>
                                            <td>
                                                <a href="#" class="btn btn-light btn-sm btn-sm-custom"><i data-feather="download" width="18" height="18"></i></a>
                                                <a href="#" class="btn btn-light btn-sm btn-sm-custom"><i data-feather="printer" width="18" height="18"></i></a>
                                                <a href="#" class="btn btn-light btn-sm btn-sm-custom"><i data-feather="eye" width="18" height="18"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>3</th>
                                            <td>Deed</td>
                                            <td>higland-Deed.pdf</td>
                                            <td>
                                                <a href="#" class="btn btn-light btn-sm btn-sm-custom"><i data-feather="download" width="18" height="18"></i></a>
                                                <a href="#" class="btn btn-light btn-sm btn-sm-custom"><i data-feather="printer" width="18" height="18"></i></a>
                                                <a href="#" class="btn btn-light btn-sm btn-sm-custom"><i data-feather="eye" width="18" height="18"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>4</th>
                                            <td>Khatian</td>
                                            <td>higland-Khatian.pdf</td>
                                            <td>
                                                <a href="#" class="btn btn-light btn-sm btn-sm-custom"><i data-feather="download" width="18" height="18"></i></a>
                                                <a href="#" class="btn btn-light btn-sm btn-sm-custom"><i data-feather="printer" width="18" height="18"></i></a>
                                                <a href="#" class="btn btn-light btn-sm btn-sm-custom"><i data-feather="eye" width="18" height="18"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>5</th>
                                            <td>Miscellaneous</td>
                                            <td>higland-Miscellaneous.pdf</td>
                                            <td>
                                                <a href="#" class="btn btn-light btn-sm btn-sm-custom"><i data-feather="download" width="18" height="18"></i></a>
                                                <a href="#" class="btn btn-light btn-sm btn-sm-custom"><i data-feather="printer" width="18" height="18"></i></a>
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

    </div>

            
@endsection

@push('js')
<script src="{{asset('backend/assets/vendors/datatables.net/jquery.dataTables.js')}}"></script>
<script src="{{asset('backend/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js')}}"></script>
<script src="{{asset('backend/assets/js/data-table.js')}}"></script>
@endpush