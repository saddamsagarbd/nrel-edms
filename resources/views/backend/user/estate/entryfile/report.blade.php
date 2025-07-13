@extends('layouts.backend')
@section('title','Reports')
@push('css')
<link rel="stylesheet" href="{{asset('backend/assets/vendors/toastr.js/toastr.min.css')}}">
<link rel="stylesheet" href="{{asset('backend/assets/vendors/select2/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('backend/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('backend/assets/vendors/datatables.net/Buttons-2.2.3/css/buttons.bootstrap.min.css')}}">
<!-- <link rel="stylesheet" href="{{asset('backend/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css')}}"> -->

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

    .table th,
    .table td {
        padding: 0.7rem 0.5375rem !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 1.5;
    }

    .select2-container .select2-selection--single {
        height: 37px;
    }
    .dt-buttons{
        float: left !important;
        margin-right: 10px;
    }
    .dt-buttons .btn-secondary {
        border-color: #fff;
        background-color: #8395a7;
    }
    .dataTables_length{
        float: left !important;
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
                    <li class="breadcrumb-item active" aria-current="page">Entry File</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        @include('backend.slices.messages')
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                @include('backend.slices.entry-file-search-criteria')
                <div class="card-body">
                    <h6 class="card-title float-left">Entry File Report (<span class="text-danger">R.S</span>)</h6>
                    <div class="table-responsive">
                        <table id="dataTableEntryFile" class="table">
                            <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th>Deed Date</th>
                                    <th>File.No</th>
                                    <th>Prj. Name</th>
                                    <th>Deed.NO</th>
                                    <th>Mouza</th>
                                    <th>Vendor</th>
                                    <th>Vandee</th>
                                    <th>SA.kh</th>
                                    <th>RS.kh</th>
                                    <th>BS.kh</th>
                                    <th>SA.dg</th>
                                    <th>RS.dg</th>
                                    <th>BS.dg</th>
                                    <th>DAG.LAND</th>
                                    <th>PUR.LAND</th>
                                    <th>T.PUR.RS</th>
                                    <th>M.LAND</th>
                                    <th>Created.By</th>
                                    <!-- <th>Actions</th> -->
                            </thead>
                            <tbody>
                                
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
<script src="{{asset('backend/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js')}}"></script>
<script src="{{asset('backend/assets/js/data-table.js')}}"></script>
<script src="{{asset('backend/assets/vendors/toastr.js/toastr.min.js')}}"></script>

<script src="{{asset('backend/assets/vendors/select2/select2.min.js')}}"></script>
<script src="{{asset('backend/assets/js/select2.js')}}"></script>

<script src="{{asset('backend/assets/vendors/moment/moment.min.js')}}"></script>
<!-- <script src="{{asset('backend/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script> -->
<!-- <script src="{{asset('backend/assets/js/datepicker.js')}}"></script> -->
<script src="{{asset('backend/assets/js/custom.js')}}"></script>

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

        // $('.liveSelect2').select2({
        //     dropdownParent: $('#entryFileModal')
        // });

        $(document).find(".liveSelect2").select2();
        $(document).find("#filter_mouza").select2();
        $(document).find("#dag_info").select2();

        // store data function

        $(function() {
            var table = $('#dataTableEntryFile').DataTable({
                processing: true,
                serverSide: true,
                dom: 'PQBlfritp',
                "lengthMenu": [ [10, 50, 100, 500, -1], [10, 50, 100, 500, "All"] ],
                buttons: [
                    // {
                    //     extend: 'copyHtml5',
                    //     exportOptions: {
                    //         columns: [0, ':visible']
                    //     }
                    // },
                    // {
                    //     extend: 'excelHtml5',
                    //     exportOptions: {
                    //         columns: [1,2,3,4,5,6,7,8,9,10,11,12,13]
                    //     }
                    // },
                    // 'pdf',
                    // 'print'
                ],
                "order": [[ 0, "DESC" ]],
                "autoWidth": false,
                columnDefs: [
                    { "width": "8%", "targets": [2, 4, 5] },
                    {
                        "targets": 14,
                        // "render": function (data, type, full) {
                        //     return parseFloat(data).toFixed(2);
                        // }
                        "render": function (data, type, full) {
                            var num = parseFloat(data);
                            return isNaN(num) ? data : num.toFixed(2);
                        }
                    }
                ],
                
                ajax:{
                    "url": "{{ url('user/entryfile/reports') }}",
                    "dataType": "json",
                    "type": "GET",
                    // data:{"_token":" {{csrf_token()}} "}
                    data: function(d) {
                        return $.extend({}, d, {
                            criteria:{
                                from_date       : $('#from_date').val(),
                                to_date         : $('#to_date').val(),
                                mouza           : $('#filter_mouza').val(),
                                khatian_type    : $('#khatian_type').val(),
                                dag             : $('#dag_info').val(),
                                project         : $('#project').val(),
                            }
                        });
                    }
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'deed_date', name: 'deed_date'},
                    {data: 'file_no', name: 'file_no'},
                    {data: 'project', name: 'project'},
                    {data: 'deed_no', name: 'deed_no'},
                    {data: 'mouza_name', name: 'mouza_name'},
                    {data: 'landowner', name: 'landowner'}, // vendor
                    {data: 'buyer_name', name: 'buyer_name'}, // vendee
                    {data: 'sa_khatian', name: 'sa_khatian'},
                    {data: 'rs_khatian', name: 'rs_khatian'},
                    {data: 'bs_khatian', name: 'bs_khatian'},
                    {data: 'sa_dag', name: 'sa_dag'},
                    {data: 'rs_dag', name: 'rs_dag'},
                    {data: 'bs_dag', name: 'bs_dag'},
                    {data: 'dag_land', name: 'dag_land'},
                    {data: 'pur_land', name: 'pur_land'},
                    {data: 'total_pur_land', name: 'total_pur_land'},
                    {data: 'mland_size', name: 'mland_size'},
                    {data: 'username', name: 'username'},
                    // {data: 'action', name: 'action', orderable: false, searchable: false},                    
                ]
            });

            // Function to reload DataTable with new criteria
            function reloadTableWithCriteria() {
                table.ajax.reload(); // Reloads data from the server with current criteria
                $('.loader-section').remove();
            }

            // Bind the reload function to a button click
            $(document).on("click", "#submitSearchBtn", function() {
                const formFields = document.getElementById('searchCriteria').elements; // Get all form elements
                let hasData = false; // Flag to check if any field is empty

                // Loop through the form elements
                for (let i = 0; i < formFields.length; i++) {
                    const field = formFields[i];
                    
                    // Check if the field is a valid input type (exclude buttons, etc.)
                    if ((field.tagName === 'INPUT' || field.tagName === 'SELECT') && field.type !== 'submit' && field.type !== 'hidden') {

                        if (field.value.trim()) { // Check if the field has data
                            hasData = true; // Set flag to true
                        }
                    }
                }

                if(hasData){
                    $(document).find("body").append('<div class="loader-section"><div class="loader"></div></div>');
                    reloadTableWithCriteria();
                    $("#resetCriteria").show();
                }
            });

        });

        $(document).on("change", "#khatian_type, #filter_mouza", function(){

            let khatian_type = $("#khatian_type").val();
            let mouza = $("#filter_mouza").val();

            let queryParam = "";

            if(khatian_type) queryParam = "khatian_type="+khatian_type;

            if(queryParam != "") queryParam += "&"

            if(mouza) queryParam += "mouza="+mouza;

            $(document).find("body").append('<div class="loader-section"><div class="loader"></div></div>');
            
            if(queryParam != ""){
                $.ajax({
                    type:"GET",
                    url:"{{url('get-dag-info')}}?"+queryParam,
                    success:function(res){ 
                        $('.loader-section').remove();
                        if(res){
                            $("#dag_info").empty();
                            $("#dag_info").append('<option value="">Open this select menu</option>');
                            for(var i = 0; i < res.dags.length; i++){
                                $("#dag_info").append('<option value="'+res.dags[i].id+'">'+res.dags[i].dag_no+' (Khotian No: '+ res.dags[i].khatian_no +')'+'</option>');
                            }
                        }else{
                            $("#dag_info").empty();
                        }
                    }
                });
            }else{
                $("#dag_info").empty();
            }

        });

        function exportData(url, formData, ext="xlsx"){
            $.ajax({
                url:url,
                type:"POST",
                data:formData,
                processData: false,
                contentType: false,
                xhrFields: {
                    responseType: 'blob' // Ensure the response type is set to 'blob'
                },
                success: function(response){
                    $(".loader-section").remove();
                    // Create a URL for the file
                    const url = window.URL.createObjectURL(response);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'entryfile_export.'+ext; // Set the filename for the downloaded file
                    document.body.appendChild(a);
                    a.click();
                    a.remove(); // Clean up after download
                    window.URL.revokeObjectURL(url); // Revoke the URL object
                },
                error:function(err){
                    $('.loader-section').remove();
                    console.log(err);
                }
            });
        }

        var exportRoutes = {
            xlsx    : "{{ route('reports.entryfile-export-excel') }}",
            pdf     : "{{ route('reports.entryfile-export-pdf') }}",
        };

        console.log(exportRoutes);

        function handleExportClick(fileType) {
            $(document).find("body").append('<div class="loader-section"><div class="loader"></div></div>');
            const form = document.getElementById('searchCriteria');
            const formData = new FormData(form);
            const url = exportRoutes[fileType]; // Use the routes defined earlier
            
            exportData(url, formData, fileType);
        }

        $(document).on("click", "#exportExcel", function() {
            console.log("clicked");
            handleExportClick("xlsx");
        });

        $(document).on("click", "#exportCsv", function() {
            handleExportClick("csv");
        });

        $(document).on("click", "#exportPdf", function() {
            handleExportClick("pdf");
        });

        // Initialize the datepickers
        $('#from_date').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            orientation: 'bottom auto',
        }).on('changeDate', function(selected) {
            var fromDate = new Date(selected.date.valueOf());
            $('#to_date').datepicker('setStartDate', fromDate);
        });

        $('#to_date').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            orientation: 'bottom auto',
        }).on('changeDate', function(selected) {
            var toDate = new Date(selected.date.valueOf());
            $('#from_date').datepicker('setEndDate', toDate);
        });

    });
</script>
@endpush