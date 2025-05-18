<div class="col-sm-2">
    <label class="control-label">Mouza</label>
    <select class="form-select mb-3 filter_mouza" name="mouza" id="filter_mouza_sa">
        <option selected disabled>Select Mouza</option>
        @foreach(App\Models\Mouza::all() as $mouzas)
        <option value="{{$mouzas->id}}"> {{$mouzas->name}} </option>
        @endforeach
    </select>
</div>
<div class="col-sm-2">
    <div class="form-group">
        <label class="control-label">Dag No (C.S)</label>
        <select class="cs_livesearch w-100 form-select mb-3 parent_cs" name="parent_dag" data-width="100%">
        </select>
    </div>
</div><!-- Col -->