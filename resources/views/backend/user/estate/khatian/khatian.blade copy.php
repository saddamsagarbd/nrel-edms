@extends('layouts.backend')
@section('title','Dashboard')
@push('css')
<link rel="stylesheet" href="{{asset('backend/assets/vendors/toastr.js/toastr.min.css')}}">
<link rel="stylesheet" href="{{asset('backend/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css')}}">

<link rel="stylesheet" href="{{asset('backend/assets/vendors/select2/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('backend/assets/vendors/jquery-tags-input/jquery.tagsinput.min.css')}}">

<link rel="stylesheet" href="{{asset('backend/assets/vendors/jquery-steps/jquery.steps.css')}}">

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

    .stripe>tbody>tr:nth-of-type(odd) {
        --bs-table-accent-bg: none !important;
    }

    body.modal-open {
        overflow: auto;
    }

    .select2-container--default .select2-selection--single {
        height: 33px;
    }
    .nav-tabs-line{
        text-transform: uppercase !important;
    }
</style>
@endpush

@section('content')

<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Mouza</a></li>
            <li class="breadcrumb-item" aria-current="page">khatian</li>
            <li class="breadcrumb-item active" aria-current="page">manage</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-12 col-md-12 col-xl-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Khatian Type </h6>
                    <ul class="nav nav-tabs nav-tabs-line" id="lineTab" role="tablist">
                        @foreach(App\Models\EstateLookUp::where('data_type', 'khatian')->orderBy('id','ASC')->get() as $khatian)
                        <li class="nav-item">
                            <a class="nav-link {{!empty($khatian->data_values) && $khatian->data_values == $ktypes ? 'active' :''}}" id="{{$khatian->data_values}}-line-tab" data-bs-toggle="tab" href="#{{$khatian->data_values}}" role="tab" aria-controls="{{$khatian->data_values}}" data-url="{{$khatian->data_values}}" aria-selected="true">{{$khatian->data_values}}</a>
                        </li>
                        @endforeach
                    </ul>
                    
                    <input type="hidden" name="khatianType" id="khatianTypeId" class="form-control">

                    <div class="tab-content ml-3" id="lineTabContent">

                        <div class="tab-pane fade show active" id="cs" role="tabpanel" aria-labelledby="cs-line-tab">
                            <form id="addCsForm" method="POST">
                                @csrf
                                <div class="cs-info">
                                    <input type="hidden" name="khatian_type" class="form-control" value="1">
                                    <div class="row cs-cont mt-3">
                                        <div class="col-sm-2">
                                            <label class="from-label">Mouza</label>
                                            <select class="form-select mb-3 mouza_id" name="mouza" id="mouza">
                                                <option selected disabled>Select Mouza</option>
                                                @foreach(App\Models\Mouza::all() as $mouzas)
                                                <option value="{{$mouzas->id}}">{{$mouzas->name}} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="mb-3">
                                                <label class="from-label">Dag No (C.S)</label>
                                                <input type="text" name="dag" class="form-control" placeholder="Dag No">
                                            </div>
                                        </div><!-- Col -->
                                        <div class="col-sm-2">
                                            <div class="mb-3">
                                                <label class="from-label">Khatian (C.S)</label>
                                                <input type="text" name="khatian" class="form-control" placeholder="Khatian No">
                                            </div>
                                        </div>
                                        <!-- Col -->
                                        <div class="col-sm-2">
                                            <div class="mb-3">
                                                <label class="from-label">Land Size (C.S)</label>
                                                <input type="text" name="land_size" class="form-control" placeholder="Land Size">
                                            </div>
                                        </div><!-- Col -->
                                        <div class="col-sm-2 mt-3 pt-1">
                                            <button type="button" id="csFormSubmit" class="btn btn-primary mr-2">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="sa" role="tabpanel" aria-labelledby="sa-line-tab">
                            <form id="addSaForm" method="POST">
                                @csrf
                                <div class="sa-info">
                                    <input type="hidden" name="khatian_type" class="form-control" value="2">
                                    <div class="row mt-3">
                                        @include('backend.user.estate.slices.field-sa')
                                        <div class="col-sm-2">
                                            <div class="mb-3">
                                                <label class="from-label">Dag No (S.A)</label>
                                                <input type="text" name="dag" class="form-control" placeholder="Dag No">
                                            </div>
                                        </div><!-- Col -->
                                        <div class="col-sm-2">
                                            <div class="mb-3">
                                                <label class="from-label">Khatian (S.A)</label>
                                                <input type="text" name="khatian" class="form-control" placeholder="Khatian No">
                                            </div>
                                        </div>
                                        <!-- Col -->
                                        <div class="col-sm-2">
                                            <div class="mb-3">
                                                <label class="from-label">Land Size (S.A)</label>
                                                <input type="text" name="land_size" class="form-control" placeholder="Land Size">
                                            </div>
                                        </div><!-- Col -->
                                        
                                        <div class="col-sm-2 mt-3 pt-1">
                                            <button type="button" id="saFormSubmit" class="btn btn-primary mr-2">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="rs" role="tabpanel" aria-labelledby="rs-line-tab">
                            <form id="addRsForm" method="POST">
                                @csrf
                                <div class="rs-info">
                                    <input type="hidden" name="khatian_type" class="form-control" value="3">
                                    <div class="row cs-cont mt-3">
                                        @include('backend.user.estate.slices.field-rs')
                                        <div class="col-sm-2">
                                            <div class="mb-3">
                                                <label class="from-label">Dag No (R.S)</label>
                                                <input type="text" name="dag" class="form-control" placeholder="Dag No">
                                            </div>
                                        </div><!-- Col -->

                                        <div class="col-sm-1">
                                            <div class="mb-3">
                                                <label class="from-label">Khatian(R.S)</label>
                                                <input type="text" name="khatian" class="form-control" placeholder="Khatian No">
                                            </div>
                                        </div>
 
                                        <!-- Col -->
                                        <div class="col-sm-2">
                                            <div class="mb-3">
                                                <label class="from-label">Land Size (R.S)</label>
                                                <input type="text" name="land_size" class="form-control" placeholder="Land Size">
                                            </div>
                                        </div><!-- Col -->
                                        
                                        <div class="col-sm-1 mt-3 pt-1">
                                            <button type="button" id="rsFormSubmit" class="btn btn-primary mr-2">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="bs-city" role="tabpanel" aria-labelledby="bs-city-line-tab">
                            <form id="addBsForm" method="POST">
                                @csrf
                                <div class="cs-info">
                                    <input type="hidden" name="khatian_type" class="form-control" value="4">
                                    <div class="row cs-cont mt-3">
                                        @include('backend.user.estate.slices.field-bs')
                                        <div class="col-sm-2">
                                            <div class="mb-3">
                                                <label class="from-label">Dag No (B.S)</label>
                                                <input type="text" name="dag" class="form-control" placeholder="Dag No">
                                            </div>
                                        </div><!-- Col -->
                                        <div class="col-sm-2">
                                            <div class="mb-3">
                                                <label class="from-label">Khatian</label>
                                                <input type="text" name="khatian" class="form-control" placeholder="Khatian No">
                                            </div>
                                        </div>
                                        <!-- Col -->
                                        <div class="col-sm-2">
                                            <div class="mb-3">
                                                <label class="from-label">Size (B.S)</label>
                                                <input type="text" name="land_size" class="form-control" placeholder="Land Size">
                                            </div>
                                        </div><!-- Col -->
                                       
                                        <div class="col-sm-1 mt-3 pt-1">
                                            <button type="button" id="bsFormSubmit" class="btn btn-primary mr-2">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>

                    <div class="card mt-3">
                        <div class="card-body">
                            <h6 class="card-title float-left"><span id="type-text">CS</span> Khatian Information</h6>
                            <div class="table-responsive">
                                <table id="dataTableKhatianDag" class="table stripe">
                                    <thead>
                                        <tr>
                                            <th>#ID</th>
                                            <th>Mouza</th>
                                            <th>Dag No</th>
                                            <th>Khatina No</th>
                                            <th>Land Size</th>
                                            <th id="parent_dag">Dag</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="khatian_rowid">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <div class="modal fade" id="khatianModal" tabindex="-1" role="dialog" aria-labelledby="khatianModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="khatianModalLabel">Edit Dag</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>

                <form class="form-horizontal" id="updateKhatianForm" method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="alert alert-danger" style="display:none"></div>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="from-label">Mouza</label>
                                    <select class="form-select mb-3" name="mouza" id="mouzaId" disabled>
                                        <option selected disabled>Select Mouza</option>
                                        @foreach(App\Models\Mouza::all() as $mouzas)
                                        <option value="{{$mouzas->id}}">{{$mouzas->name}} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="hidden" name="khatian_id" id="khatianId">
                            </div><!-- Col -->
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="from-label">Dag No</label>
                                    <input type="text" name="dag" id="dagNo" class="form-control" placeholder="Dag No">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="from-label">Land Size</label>
                                    <input type="text" name="land_size" id="landSize" class="form-control" placeholder="Land Size">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="from-label">Khatian</label>
                                    <input type="text" name="khatian" id="khatianNo" class="form-control" placeholder="Khatian No">
                                </div>
                            </div>
                        </div><!-- Row -->
                        <div class="row mb-3" id="csfield_box">
                        </div>
                        <input type="hidden" name="khatian_type" id="khatianType">
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="updateKhatianBtn" class="btn btn-primary mr-2">Save</button>
                    </div>
                </form>

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

<script src="{{asset('backend/assets/vendors/select2/select2.min.js')}}"></script>
<script src="{{asset('backend/assets/js/select2.js')}}"></script>

<script src="{{asset('backend/assets/vendors/jquery-steps/jquery.steps.min.js')}}"></script>
<script src="{{asset('backend/assets/js/wizard.js')}}"></script>

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

        // Start Department Wise New Ticket
        $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
            e.target // newly activated tab
            e.relatedTarget // previous active tab

            let k_type = $(this).attr("data-url");

            if(k_type=='sa'){
                $('#parent_dag').html('CS DAG');
            }else if(k_type=='rs'){
                $('#parent_dag').html('SA DAG');
            }else if(k_type=='bs-city'){
                $('#parent_dag').html('RS DAG');
            }else{
                $('#parent_dag').html('None');
            }

            $('#khatianTypeId').val(k_type);

            $('#dataTableKhatianDag').DataTable().destroy();

            $('#type-text').html(k_type);

            getKhatianDataByType(k_type);

            loadKthatianTypeform(k_type);


        })

        function getKhatianDataByType(type = '') {

            $('#dataTableKhatianDag').DataTable({
                "autoWidth": false,
                "lengthMenu": [
                    [10, 20, 50, 100, -1],
                    [10, 20, 50, 100, "All"]
                ],
                processing: true,
                serverSide: true,
                "order": [
                    [0, "desc"]
                ],
                ajax: {
                    url: "{{route('user.khatian.type')}}",
                    "dataType": "json",
                    data: {
                        type: type
                    },
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'mouza',
                        name: 'mouza'
                    },
                    {
                        data: 'dag_no',
                        name: 'dag_no'
                    },
                    {
                        data: 'khatian_no',
                        name: 'khatian_no'
                    },
                    {
                        data: 'land_size',
                        name: 'land_size'
                    },
                    {
                        data: 'parent_dag',
                        name: 'parent_dag'
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
        }

        getKhatianDataByType();
        // end display deprtment wise datatable

        // start formload
        function loadKthatianTypeform(type=''){
            var type = type;
            $.ajax({
                type: "GET",
                url: "{{url('user/khatian-form')}}?type=" + type,
                success: function(res) {
                    if (res) {
                        $("#form_field").empty();
                        $("#form_field").html(res.form_data);
                    } else {
                        $("#form_field").empty();
                    }
                }
            });
        }
        // end form load


        $('#csFormSubmit').click(function(e) {
            e.preventDefault();
            //console.log($('#addAssetForm').serialize());
            $.ajax({
                url: "{{route('user.khatian.store')}}",
                method: 'POST',
                data: $('#addCsForm').serialize(),
                success: function(result) {
                    if (result.errors) {
                        printErrorMsg(result.errors);
                    } else {
                        printSuccessMsg(result.success);
                        $('.alert-danger').hide();
                        $('#addCsForm').trigger("reset");
                        $("#dataTableKhatianDag").DataTable().draw();
                    }
                }
            });
        });


        $('#saFormSubmit').click(function(e) {
            $.ajax({
                url: "{{route('user.khatian.store')}}",
                method: 'POST',
                data: $('#addSaForm').serialize(),
                success: function(result) {
                    if (result.errors) {
                        printErrorMsg(result.errors);
                    } else {
                        printSuccessMsg(result.success);
                        $('.alert-danger').hide();
                        $('#addSaForm').trigger("reset");
                        $("#dataTableKhatianDag").DataTable().draw();
                    }
                }
            });
            e.preventDefault();

        });

        $('#rsFormSubmit').click(function(e) {

            //console.log($('#addAssetForm').serialize());
            $.ajax({
                url: "{{route('user.khatian.store')}}",
                method: 'POST',
                data: $('#addRsForm').serialize(),
                success: function(result) {
                    if (result.errors) {
                        printErrorMsg(result.errors);
                    } else {
                        printSuccessMsg(result.success);
                        $('.alert-danger').hide();
                        $('#addRsForm').trigger("reset");
                        $("#dataTableKhatianDag").DataTable().draw();
                    }
                }
            });
            e.preventDefault();

        });

        $('#bsFormSubmit').click(function(e) {
            //console.log($('#addAssetForm').serialize());
            $.ajax({
                url: "{{route('user.khatian.store')}}",
                method: 'POST',
                data: $('#addBsForm').serialize(),
                success: function(result) {
                    if (result.errors) {
                        printErrorMsg(result.errors);
                    } else {
                        printSuccessMsg(result.success);
                        $('.alert-danger').hide();
                        $('#addBsForm').trigger("reset");
                        $("#dataTableKhatianDag").DataTable().draw();
                    }
                }
            });
            e.preventDefault();

        });

        // filter dag information by Mouza 

        // $('.cs_livesearch').select2({
        //     placeholder: 'Select CS/SA',
        //     ajax: {
        //         url: "{{ url('/khatian/cssa/search') }}",
        //         dataType: 'json',
        //         delay: 250,
        //         processResults: function(data) {
        //             return {
        //                 results: data,
        //             };
        //         },
        //         cache: true
        //     }
        // });
        // $('#refresh').click(function() {
        //     $('#filter_company').val('');
        //     $('#departmentId').val('');
        //     $('#dataTableUsers').DataTable().destroy();
        //     getKhatianDataByType();
        // })

        $('.cs_livesearch').select2();
        $('.sa_livesearch').select2();
        $('.rs_livesearch').select2();
    
        $('.filter_mouza').change(function(e) {
            e.preventDefault();
            var mouza_id = $(this).val();
            if (mouza_id) {
                $.ajax({
                    type: "GET",
                    url: "{{url('user/mouza-cs/search')}}?mouza_id=" + mouza_id,
                    success: function(res) {
                        if (res) {
                            $(".parent_cs").empty();
                            $(".parent_cs").html(res.data);
                        } else {
                            $(".parent_cs").empty();
                        }
                    }
                });
            } else {
                $(".parent_cs").empty();
            }
        });

        $('.cs_livesearch').change(function(e) {
            e.preventDefault();
            var mouza_id = $('#filter_mouza_sa option:selected').val();
            var csdag_id = $(this).val();
            if (csdag_id) {
                $.ajax({
                    type: "GET",
                    url: "{{url('user/mouza-sa/search')}}?mouza_id=" + mouza_id + '&csdag_id=' + csdag_id,
                    success: function(res) {
                        if (res) {
                            $(".parent_sa").empty();
                            $(".parent_sa").html(res.data);
                        } else {
                            $(".parent_sa").empty();
                        }
                    }
                });
            } else {
                $(".parent_sa").empty();
            }
        });

        $('.sa_livesearch').change(function(e) {
            e.preventDefault();
            var mouza_id = $('#filter_mouza_rs option:selected').val();
            var sadag_id = $(this).val();
            if (sadag_id) {
                $.ajax({
                    type: "GET",
                    url: "{{url('user/mouza-rs/search')}}?mouza_id=" + mouza_id + '&sadag_id=' + sadag_id,
                    success: function(res) {
                        if (res) {
                            $("#parent_rs").empty();
                            $("#parent_rs").html(res.data);
                        } else {
                            $("#parent_rs").empty();
                        }
                    }
                });
            } else {
                $("#parent_rs").empty();
            }
        });

        // $('.rsLivesearch').change(function(e) {
        //     e.preventDefault();
        //     var mouza_id = $('#filter_mouza_bs option:selected').val();
        //     var csdag_id = $(this).val();
        //     if (csdag_id) {
        //         $.ajax({
        //             type: "GET",
        //             url: "{{url('user/mouza-rs/search')}}?mouza_id=" + mouza_id + '&csdag_id=' + csdag_id,
        //             success: function(res) {
        //                 if (res) {
        //                     $("#parent_rs").empty();
        //                     $("#parent_rs").html(res.data);
        //                 } else {
        //                     $("#parent_rs").empty();
        //                 }
        //             }
        //         });
        //     } else {
        //         $("#parent_rs").empty();
        //     }
        // });

        // function for edit dag information

        $('.dag_livesearch').select2({
            dropdownParent: $('#khatianModal'),
        });

        $('body').on('click', '.editKhatian', function(e) {

            e.preventDefault();

            var khatian_id = $(this).data('id');

            $.get("{{ url('user/khatian') }}" + '/' + khatian_id + '/edit', function(res) {

                $('#khatianModalLabel').html("Edit Khatian");
                $('#mouzaFormSubmit').val("update");
                $('#khatianModal').modal('show');
                $('#khatianId').val(res.data.id);
                $('#landSize').val(res.data.land_size);
                $('#khatianNo').val(res.data.khatian_no);
                $('#dagNo').val(res.data.dag_no);
                $('#mouzaId option[value="' + res.data.mouza_id + '"]').attr('selected', true);
                $('#khatianType').val(res.data.khatian_type);
                $('#csfield_box').html(res.ext_field);
                getCskhatian($('#mouzaId option:selected').val(), 1);
                getRskhatian($('#mouzaId option:selected').val(), 2);
                // if(res.data.khatian_type == 3){
                //     $('#rsLiveSearch option[value="' + res.data.parent_dag + '"]').attr('selected', true);
                // }else{
                //     $('#csLiveSearch option[value="' + res.data.parent_dag + '"]').attr('selected', true);
                // }

            })
        });

        function getCskhatian(mouza_id, khatian_type) {
            $('#csLiveSearch').select2({
                dropdownParent: $('#khatianModal'),
                ajax: {
                    url: "{{ url('/dag/search') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term,
                            mouza_id: mouza_id,
                            khatian_type: khatian_type
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data,
                        };
                    },
                    cache: true
                }

            });
        }

        function getRskhatian(mouza_id, khatian_type) {
            $('#rsLiveSearch').select2({
                dropdownParent: $('#khatianModal'),
                ajax: {
                    url: "{{ url('/dag/search') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term,
                            mouza_id: mouza_id,
                            khatian_type: khatian_type
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data,
                        };
                    },
                    cache: true
                }

            });
        }

        // $('#khatianModal').on('hidden.bs.modal', function(e) {
        //     location.reload();
        // })

        $('#updateKhatianBtn').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{route('user.khatian.update')}}",
                method: 'POST',
                data: $('#updateKhatianForm').serialize(),
                success: function(result) {
                    if (result.errors) {
                        printErrorMsg(result.errors);
                    } else {
                        printSuccessMsg(result.success);
                        $('.alert-danger').hide();
                        $('#updateKhatianForm').trigger("reset");
                        $("#dataTableKhatianDag").DataTable().draw();
                        $('#khatianModal').modal('hide');
                    }
                }
            });
            e.preventDefault();

        });



    });
</script>
@endpush