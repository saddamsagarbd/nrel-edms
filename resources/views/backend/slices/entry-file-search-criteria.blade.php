
                <div class="card-body">
                    <h6 class="card-title">Search Criteria</h6>
                    <form id="searchCriteria" class="row gy-2 gx-3 align-items-center">
                        @csrf
                        <div class="col-auto">
                            <label for="autoSizingInput">From Date</label>
                            <input type="text" class="form-control" id="from_date" name="criteria[from_date]" value="">
                        </div>
                        <div class="col-auto">
                            <label for="autoSizingInput">To Date</label>
                            <input type="text" class="form-control" id="to_date" name="criteria[to_date]" value="">
                        </div>
                        <div class="col-auto">
                            <label class="w-100" for="autoSizingInputGroup">Mouza</label>
                            <select class="form-select w-100" name="criteria[mouza]" id="filter_mouza">
                                <option selected disabled value="">Select mouza</option>
                                @foreach(App\Models\Mouza::all() as $mouza)
                                    <option value="{{$mouza->id}}">{{$mouza->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-auto">
                            <label class="w-100">Khatian Type</label>
                            <select class="form-select w-100" name="criteria[khatian_type]" id="khatian_type">
                                <option selected disabled>Select Type</option>
                                @foreach(App\Models\EstateLookUp::where('data_type', 'khatian')->get() as $ktype)
                                    <option value="{{$ktype->data_keys}}">{{$ktype->data_values}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-auto">
                            <label class="w-100">Dag</label>
                            <select class="form-select w-100" name="criteria[dag_info]" id="dag_info">
                                <option selected disabled>Select Dag</option>
                            </select>
                        </div>
                        <div class="col-auto">
                            <label class="w-100">Projects *</label>
                            <select class="form-select liveSelect2 w-100" data-width="100%" name="criteria[project]" id="project">
                                <option selected disabled>Select Project</option>
                                @foreach(App\Models\EstateProject::where('parent_id', NULL)->get() as $project)
                                    @php
                                    $subparents = App\Models\EstateProject::where('parent_id', $project->id)->get()
                                    @endphp
                                    <option value="{{$project->id}}" {{count($subparents) > 0 ? 'disabled' : '' }}>{{$project->name}}</option>
                                    @foreach($subparents as $subproject)
                                    <option value="{{$subproject->id}}"> -- {{$subproject->name}}</option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-auto">
                            <label  for="autoSizingInputGroup"></label>
                            <button type="button" class="btn btn-info" id="submitSearchBtn" style="padding: 6px !important; display: block; float: left; margin-top: 20px; margin-left: 5px;"><i class="btn-icon-prepend" data-feather="search"></i>&nbsp;Search</button>
                            <button type="button" class="btn btn-warning resetBtn" id="resetCriteria" style="padding: 6px !important; float: left; margin-top: 20px; margin-left: 5px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-cw"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>&nbsp;Clear</button>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <a href="javascript:void(0)" id="exportExcel" class="btn btn-primary export-excel">
                        <img class="rounded" src="{{asset('backend/assets/images/excel.png')}}" width="16px" height="16px" style="vertical-align: text-top;" alt="">&nbsp;Export as Excel
                    </a>

                    <!-- <a href="javascript:void(0)" id="exportPdf" class="btn btn-primary export-pdf">
                        <img class="rounded" src="{{asset('backend/assets/images/pdf.png')}}" width="16px" height="16px" style="vertical-align: text-top;" alt="pdf">&nbsp;Export as PDF
                    </a> -->
                </div>