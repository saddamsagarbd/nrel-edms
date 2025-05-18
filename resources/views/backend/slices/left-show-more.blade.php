<div class="card">
    <div class="card-body">
        <h5 class="card-title">Project Name: {{$entryFile->project->name}}</h5>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">Entry File No : <strong>{{$entryFile->file_no}}</strong></li>
            <li class="list-group-item">Name of Mouza : {{$entryFile->mouza->name}}</li>
            <li class="list-group-item">Khatian Type : <span style="text-transform: uppercase; font-weight:bold">{{ !empty($entryFile->khatianType->data_values) ? $entryFile->khatianType->data_values : ''}}</span></li>
            <li class="list-group-item">Remarks : {{$entryFile->remarks}}</li>
            <li class="list-group-item">Agent/Media:
                <div class="w-100">
                    <div class="d-flex justify-content-between">
                        <h6 class="text-body mb-1">Name: {{ !empty($entryFile->agent->name) ? $entryFile->agent->name :''}}</h6>
                    </div>
                    <p class="text-muted tx-13">Phone: {{!empty($entryFile->agent->phone) ? $entryFile->agent->phone:''}}</p>
                </div>
            </li>
            <li class="list-group-item">Buyer Name : {{! empty($entryFile->buyerName->data_values) ? $entryFile->buyerName->data_values :''}}</li>
            <li class="list-group-item">Created By : {{$entryFile->userInfo->name}}</li>
            <li class="list-group-item">Created Date : {{$entryFile->created_at}}</li>
        </ul>
    </div>
</div>

<div class="card mt-2">
    <div class="card-body">
        <h6 class="card-title mb-3">Transferer/Landowner</h6>
        <div class="d-flex flex-column">
            @foreach($entryFile->entLandowners as $landowner)
            <a href="javascript:;" class="d-flex align-items-center border-bottom pb-3">
                <div class="me-3">
                    <img src="{{asset('uploads/agentclient')}}/{{$landowner->image}}" class="rounded-circle wd-35" alt="user">
                </div>
                <div class="w-100">
                    <div class="d-flex justify-content-between">
                        <h6 class="text-body mb-1">{{$landowner->name}}</h6>
                    </div>
                    <p class="text-muted tx-13">{{$landowner->address}}</p>
                    <p class="text-muted tx-13">{{$landowner->phone}}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>
<div class="card mt-2">
    <div class="card-body">
        <div class="d-grid">
            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#reviewModal">Review</button>
        </div>
    </div>
</div>