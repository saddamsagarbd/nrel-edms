<div class="col-sm-2">
    <label class="control-label">Mouza</label>
    <select class="form-select mb-3 filter_mouza" name="mouza" id="filter_mouza_bs">
        <option selected disabled>Select Mouza</option>
        @foreach(App\Models\Mouza::all() as $mouzas)
        <option value="{{$mouzas->id}}"> {{$mouzas->name}} </option>
        @endforeach
    </select>
</div>
<div class="col-sm-2">
    <div class="form-group">
        <label class="control-label">Dag No (C.S)</label>
        <select class="cs_livesearch w-100 form-select mb-3 parent_cs" name="parent_cs" data-width="100%">
        </select>
    </div>
</div><!-- Col -->
<div class="col-sm-2">
    <div class="form-group">
        <label class="control-label">Dag No (S.A)</label>
        <select class="sa_livesearch w-100 form-select mb-3 parent_sa" name="parent_dag_sa" data-width="100%">
        </select>
    </div>
</div><!-- Col -->
<div class="col-sm-2">
    <div class="mb-3">
        <label class="from-label">Dag No (R.S)</label>
        <select class="rs_livesearch w-100 form-select mb-3" id="parent_rs" name="parent_dag" data-width="100%">
        </select>
    </div>
</div><!-- Col -->