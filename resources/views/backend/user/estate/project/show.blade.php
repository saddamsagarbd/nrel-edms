@extends('layouts.backend')
@section('title','Project Details')
@push('css')


@endpush

@section('content')

<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Project</a></li>
            <li class="breadcrumb-item" aria-current="page">Details</li>
            <li class="breadcrumb-item active" aria-current="page">{{$project->name}}</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-8 grid-margin">
            <div class="card">
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        
                        <li class="list-group-item">
                            <div class="me-3 text-center">
                                <h5 class="card-title mt-3">Name: {{$project->name}}</h5>
                            </div>
                        </li>
                        <li class="list-group-item">Project Type:  {{$project->project_type}} </li>
                        <li class="list-group-item">Project Category : {{!empty($project->CategoryName->data_values) ? $project->CategoryName->data_values : ''}}</li>
                        <li class="list-group-item">Land Type : {{$project->land_type}}</li>
                        <li class="list-group-item">Location : {{$project->location}}</li>
                        <li class="list-group-item">Address : {{$project->address}}</li>
                        <li class="list-group-item">Division : {{$project->division->name}}</li>
                        <li class="list-group-item">District : {{$project->district->name}}</li>
                        <li class="list-group-item">Upazila  : {{$project->upazila->name}}</li>
                        <li class="list-group-item">Status : {{$project->status}}</li>
                        <li class="list-group-item">Description : {{$project->description}}</li>
                        <li class="list-group-item">User : {{$project->userName->name}}</li>
                        <li class="list-group-item">Created At : {{$project->created_at}}</li>
                        <li class="list-group-item">Last Updatet : {{$project->updated_at}}</li>
                    </ul>
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

@endpush