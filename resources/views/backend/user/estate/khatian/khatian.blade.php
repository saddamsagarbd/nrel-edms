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

    .nav-tabs-line {
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

                        <form id="addCsForm" method="POST">
                            @csrf
                            <div class="row cs-cont mt-3" id="form_field">

                            </div>

                        </form>

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
                                            <th>Dag.LAND</th>
                                            <th>Kha.LAND</th>
                                            <th>CS Dag</th>
                                            <th>SA Dag</th>
                                            <th>RS Dag</th>
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
                                    <label class="from-label">Khatian</label>
                                    <input type="text" name="khatian" id="khatianNo" class="form-control" placeholder="Khatian No">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="from-label">Dag Land Area</label>
                                    <input type="text" name="dag_land" id="dLandArea" class="form-control" placeholder="Dag Land Area">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="from-label">Khatian Land Area</label>
                                    <input type="text" name="khatian_land" id="kLandArea" class="form-control" placeholder="Khatian Land area">
                                </div>
                            </div><!-- Col -->
                            
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

            if (k_type == 'sa') {
                $('#parent_dag').html('CS DAG');
            } else if (k_type == 'rs') {
                $('#parent_dag').html('SA DAG');
            } else if (k_type == 'bs-city') {
                $('#parent_dag').html('RS DAG');
            } else {
                $('#parent_dag').html('None');
            }

            $('#khatianTypeId').val(k_type);

            $('#dataTableKhatianDag').DataTable().destroy();
            $('#type-text').html(k_type);

            loadKthatianTypeform(k_type);

            getKhatianDataByType(k_type);
        })

        // start formload
        function loadKthatianTypeform(type = '') {
            var type = type;
            $.ajax({
                type: "GET",
                url: "{{url('user/khatian-form')}}?type=" + type,
                success: function(res) {
                    if (res) {

                        $("#form_field").empty();
                        $("#form_field").html(res.form_data);

                        $('.filter_mouza, .cs_livesearch, .sa_livesearch, .rs_livesearch').select2();

                        allReleventEvent()

                    } else {
                        $("#form_field").empty();
                    }
                }
            });
        }
        loadKthatianTypeform('cs');
        // end form load

        function allReleventEvent() {

            $('#cs_livesearch').select2({
                ajax: {
                    url: "{{ url('/dag/cssarsbs-search') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term,
                            mouza_id: $('#mouza_id option:selected').val(),
                            khatian_type: 1,
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

            $('#sa_livesearch').select2({
                ajax: {
                    url: "{{ url('/dag/cssarsbs-search') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term,
                            mouza_id: $('#mouza_id option:selected').val(),
                            khatian_type: 2,
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

            $('#rs_livesearch').select2({
                ajax: {
                    url: "{{ url('/dag/cssarsbs-search') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term,
                            mouza_id: $('#mouza_id option:selected').val(),
                            khatian_type: 3,
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
            // store data

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

        }
        // end allrelevant function

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
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'mouza', name: 'mouza' },
                    { data: 'dag_no', name: 'dag_no' },
                    { data: 'khatian_no', name: 'khatian_no'},
                    { data: 'dag_land', name: 'dag_land'},
                    { data: 'khatian_land', name: 'khatian_land'},
                    { data: 'cs_dag', name: 'cs_dag' },
                    { data: 'sa_dag', name: 'sa_dag' },
                    { data: 'rs_dag', name: 'rs_dag' },
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
                $('input#khatianId').val(res.data.id);
                $('input#khatianType').val(res.data.khatian_type);
                $('input#dLandArea').val(res.data.dag_land);
                $('input#khatianNo').val(res.data.khatian_no);
                $('input#dagNo').val(res.data.dag_no);
                $('#mouzaId option[value="' + res.data.mouza_id + '"]').attr('selected', true);
                $('#csfield_box').html(res.ext_field);
                getCskhatian($('#mouzaId option:selected').val(), 1);
                getSakhatian($('#mouzaId option:selected').val(), 2);
                getRskhatian($('#mouzaId option:selected').val(), 3);

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

        function getSakhatian(mouza_id, khatian_type) {
            $('#saLiveSearch').select2({
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