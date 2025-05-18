@extends('layouts.backend')
@section('title','Agent Media Details')
@push('css')
<style>
    .list-group-item {
        padding: 0.3rem 0.55rem !important;
    }
</style>
@endpush

@section('content')

@php

@endphp

<div class="page-content">

    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Agent</a></li>
                    <li class="breadcrumb-item">Details</li>
                    <li class="breadcrumb-item active" aria-current="page">{{$client->name}}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-6 col-md-6 col-xl-6 grid-margin">
            <div class="card">
                <div class="card-body">
                    
                    <ul class="list-group list-group-flush">
                        
                        <li class="list-group-item">
                            <div class="me-3 text-center">
                                <img src="{{asset('uploads/agentclient')}}/{{ !empty($client->image) ? $client->image :'default.jpg' }}" class="rounded-circle wd-80" alt="user">
                                <h5 class="card-title mt-3">Name: {{$client->name}}</h5>
                            </div>
                        </li>
                        <li class="list-group-item">Phone: <span class="badge badge-secondary"> {{$client->phone}}</span></li>
                        <li class="list-group-item">Father Name : {{$client->father_name}}</li>
                        <li class="list-group-item">Mother Name : {{$client->mother_name}}</li>
                        <li class="list-group-item">Spouse Name : {{$client->spouse}}</li>
                        <li class="list-group-item">Birth Date : {{$client->birth_date}}</li>
                        <li class="list-group-item">NID : {{$client->nid}}</li>
                        <li class="list-group-item">Project Name: {{$client->project->name}}</li>
                        <li class="list-group-item">Address : {{$client->address}}</li>
                        <li class="list-group-item">Client Type : {{$client->client_type}}</li>
                        <!-- <li class="list-group-item">User: {{$client->user_id}}</li> -->
                        <li class="list-group-item">Created At : {{$client->created_at}}</li>
                        <li class="list-group-item">Last Updatet : {{$client->updated_at}}</li>
                        <!-- <li class="list-group-item"> Id No : <strong>{{$client->id}}</strong></li> -->
                    </ul>
                </div>
            </div>
        </div>

    </div>


</div>


@endsection

@push('js')


@endpush