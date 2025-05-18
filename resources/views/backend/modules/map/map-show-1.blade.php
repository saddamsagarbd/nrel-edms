@extends('layouts.backend')
@section('title','Map View')
@push('css')
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="{{asset('backend/assets/vendors/any-zoom-out/css/normalize.css?v=1.0')}}">
<link rel="stylesheet" href="{{asset('backend/assets/vendors/any-zoom-out/css/jquery.zoom.css?v=1.0')}} ">
<link rel="stylesheet" href="{{asset('backend/assets/vendors/any-zoom-out/css/styles.css?v=1.0')}}">
<style>

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
                    <li class="breadcrumb-item"><a href="#">Plot</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Map</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="map">
                <div class="maps-container unselectable" style="overflow: auto;">

                    <div class="map-control map-control-zoomin"></div>
                    <div class="map-control map-control-zoomout"></div>

                    <!-- maps-container-inner -->
                    <div class="maps-container-inner zoomedElement zoomedElement414" style="transform: scale(4.54782); left: -379.615px; top: 334.1px;">
                        <!-- maps-zoomed-container -->
                        <div class="maps-zoomed-container">

                            <div class="map-image" id="map-all" style="display:block;">
                                <img src="{{asset('backend/assets/vendors/any-zoom-out/images/southernville_1.jpg')}}" alt="World map" />
                            </div>

                            <div class="marker-all marker-group" id="group-marker-northamerica" style="display: block; transform: scale(0.219886);">
                                <a href="#"></a>
                                <span>North America</span>
                            </div>
                            <div class="marker-all marker-group" id="group-marker-southamerica" style="display: block; transform: scale(0.219886);">
                                <a href="#"></a>
                                <span>South America</span>
                            </div>
                            <div class="marker-all marker-group" id="group-marker-europe" style="display: block; transform: scale(0.219886);">
                                <a href="#"></a>
                                <span>Europe</span>
                            </div>
                            <div class="marker-all marker-group" id="group-marker-africa" style="display: block; transform: scale(0.219886);">
                                <a href="#"></a>
                                <span>Africa</span>
                            </div>
                            <div class="marker-all marker-group" id="group-marker-middleeast" style="display: block; transform: scale(0.219886);">
                                <a href="#"></a>
                                <span>Middle East</span>
                            </div>
                            <div class="marker-all marker-group" id="group-marker-india" style="display: block; transform: scale(0.219886);">
                                <a href="#"></a>
                                <span>India</span>
                            </div>
                            <div class="marker-all marker-group" id="group-marker-asia" style="display: block; transform: scale(0.219886);">
                                <a href="#"></a>
                                <span>Asia</span>
                            </div>
                            <div class="marker-all marker-group" id="group-marker-oceania" style="display: block; transform: scale(0.219886);">
                                <a href="#"></a>
                                <span>Oceania</span>
                            </div>
                            <div class="testpoint"></div>
                        </div>
                        <!-- //maps-zoomed-container -->
                    </div>
                    <!-- //maps-container-inner -->
                </div>
            </div>
        </div>
    </div>



</div>

@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"></script>
<script src="{{asset('backend/assets/vendors/any-zoom-out/js/zoom.jquery.js')}}"></script>
<script src="{{asset('backend/assets/vendors/any-zoom-out/js/main.js')}}"></script>
<script>

</script>

@endpush