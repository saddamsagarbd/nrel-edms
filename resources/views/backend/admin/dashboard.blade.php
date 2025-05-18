@extends('layouts.backend')
@section('title','Dashboard')
@push('css')

@endpush


@section('content')

<div class="page-content">

    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Welcome to Dashboard</h4>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <div class="input-group flatpickr wd-200 me-2 mb-2 mb-md-0" id="dashboardDate">
                <span class="input-group-text input-group-addon bg-transparent border-primary" data-toggle><i data-feather="calendar" class="text-primary"></i></span>
                <input type="text" class="form-control bg-transparent border-primary" placeholder="Select date" data-input>
            </div>
            <button type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
                <i class="btn-icon-prepend" data-feather="download-cloud"></i>
                Download Report
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-xl-12 stretch-card">
            <div class="row flex-grow-1">
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-1">Total Entry</h6>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2">{{$t_entry}}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-1">Total Baina</h6>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2">00</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-1">Total Purchase</h6>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2">00</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-1">Total Mutation</h6>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2">00</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-1">Total Sales Mutation</h6>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2">00</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-1">Total Mouzas</h6>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2">00</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-1">Total Agents</h6>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2">00</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-1">Total Customers</h6>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2">00</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div> <!-- row -->


    <div class="row">
        <div class="col-lg-9 col-xl-9 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline mb-2">
                        <h6 class="card-title mb-0">Daily Entry</h6>
                        <div class="dropdown mb-2">
                            <a type="button" id="dropdownMenuButton4" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="edit-2" class="icon-sm me-2"></i> <span class="">Edit</span></a>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="trash" class="icon-sm me-2"></i> <span class="">Delete</span></a>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="printer" class="icon-sm me-2"></i> <span class="">Print</span></a>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="download" class="icon-sm me-2"></i> <span class="">Download</span></a>
                            </div>
                        </div>
                    </div>
                    <p class="text-muted">We will able to get data from here daily</p>
                    <div id="monthlyEntryChart"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-xl-3 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                        <h6 class="card-title mb-3">Last Entry File Data By Users </h6>
                    </div>
                    @php $i=1; $total= 0; @endphp
                    @foreach($users_entry_data as $data)
                    <div class="d-flex bd-highlight shadow-sm mb-1 rounded">
                        <div class="p-2 w-100 bd-highlight">{{$i.'. '.$data->user_name}}</div>
                        <div class="p-2 flex-shrink-1"><span class="badge bg-primary rounded-pill">{{$data->total}}</span></div>
                    </div>
                    @php
                    $i++;
                    $total = $total + $data->total ;
                    @endphp
                    @endforeach

                    <div class="d-flex bg-light shadow-sm mb-1 rounded">
                        <div class="p-2 w-100 bd-highlight">Total</div>
                        <div class="p-2 flex-shrink-1"><span class="badge bg-primary rounded-pill">{{$total}}</span></div>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- row -->


</div>


@endsection
@push('js')
<script>
    var _daylabels = {!! json_encode($daylabels) !!};
    var _daydata = {!! json_encode($daydata) !!};
</script>
@endpush