@extends('layouts.backend')
@section('title','Map View')
@push('css')
<link rel="stylesheet" href="{{asset('backend/assets/vendors/imgeViewer2/css/leaflet.css')}}">

<style>
.map-image{
    height: 100vh;
}
.leaflet-left .leaflet-control {
    margin-left: 10px;
    margin-top: 10px;
}
</style>
@endpush

@section('content')

<div class="page-content" id="pageContent" style="margin:0px, 15px; padding:0">
    <div class="row">
        <div class="col">
        <!-- <button onclick="openFullscreen();">Fullscreen Mode</button> -->

        @if($file)
        <div class="map-image">
        <img id="mapImage" class="img-fluid" src="{{asset($file->file_path.$file->file_name)}}" alt=""/>
            <!-- <img id="mapImage" class="img-fluid" src="{{asset('backend/assets/vendors/imgeViewer2/image/southernville_2.jpg')}}" alt="Southern Ville"/> -->
        </div>
        @else
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-center p-5">
                        <h4 class="text-danger">Not Uploaded Yet</h4>
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>

@endsection

@push('js')
<script src="{{asset('backend/assets/vendors/imgeViewer2/js/leaflet.js')}}"></script>
<script src="{{asset('backend/assets/vendors/imgeViewer2/js/jquery-ui.min.js')}}"></script>
<script src="{{asset('backend/assets/vendors/imgeViewer2/lib/imgViewer2.js')}}"></script>
<script>
    (function($) {
        $(document).ready(function() {
            var $img = $("#mapImage").imgViewer2();
        });
    })(jQuery);



    var elem = document.getElementById("pageContent");
        function openFullscreen() {
        if (elem.requestFullscreen) {
            elem.requestFullscreen();
        } else if (elem.webkitRequestFullscreen) { /* Safari */
            elem.webkitRequestFullscreen();
        } else if (elem.msRequestFullscreen) { /* IE11 */
            elem.msRequestFullscreen();
        }
    }

</script>

@endpush