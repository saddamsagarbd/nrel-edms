@extends('layouts.backend')
@section('title','Dashboard')
@push('css')
<link rel="stylesheet" href="{{asset('backend/assets/vendors/toastr.js/toastr.min.css')}}">

@endpush

@section('content')

<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Project</a></li>
            <li class="breadcrumb-item" aria-current="page">edit</li>
            <li class="breadcrumb-item active" aria-current="page">{{$project->name}}</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-8 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">{{$project->name}} </h6>
                </div>
            </div>
        </div>
        <div class="col-md-4 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Users List</h6>
                </div>
            </div>
        </div>
    </div>

</div>


@endsection

@push('js')

<script src="{{asset('backend/assets/vendors/toastr.js/toastr.min.js')}}"></script>

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

    });


</script>
@endpush