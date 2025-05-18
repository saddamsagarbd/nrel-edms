<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EstateLookUp;
use App\Models\KhatianDagInfo;
use App\Models\Mouza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;


class EstateKhatianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('backend.user.estate.khatian.khatian');
    }

    public function khatianByType(Request $request)
    {

        if ($request->ajax()) {

            $ktypes = $request->type;

            if ($ktypes) :
                $k_id = $this->getKhatianTypeId($ktypes);
                $query = KhatianDagInfo::where('khatian_type', $k_id)->get();
            else :
                $query = KhatianDagInfo::where('khatian_type', 1)->get();
            endif;

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('mouza', function ($data) {
                    return '<p>' . $data->mouza->name . '</p>';
                })
                ->addColumn('cs_dag', function ($data) {
                        return !empty($data->csDag->dag_no) ? $data->csDag->dag_no : '';
                })
                ->addColumn('sa_dag', function ($data) {
                    return !empty($data->saDag->dag_no) ? $data->saDag->dag_no : '';
                })
                ->addColumn('rs_dag', function ($data) {
                    return !empty($data->rsDag->dag_no) ? $data->rsDag->dag_no : '';
                })
                ->addColumn('action', function ($data) {
                    $button = '<a href="javascript:void(0)" data-id="' . $data->id . '" class="btn btn-light btn-sm btn-sm-custom editKhatian">Edit</a>';
                    return $button;
                })
                ->rawColumns(['mouza', 'parent_dag', 'action'])
                ->toJson();
        }

        return view('backend.user.estate.khatian.khatian', ['ktypes' => 'cs']);
    }

    public function getKhatianTypeId($slug)
    {

        $k_type = EstateLookUp::where('data_values', $slug)->first();

        return $k_type->data_keys;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $mouza_id = $request->mouza;
        $khatian_type = $request->khatian_type;
        $dag = $request->dag;
        $khatian = $request->khatian;

        $isExistDag = KhatianDagInfo::where('mouza_id', $mouza_id)
                    ->where('khatian_type', $khatian_type)
                    ->where('dag_no', $dag)
                    ->where('khatian_no', $khatian)
                    ->first();

        if(empty($isExistDag)):

            $validator = Validator::make($request->all(), [
                'mouza'         => 'required',
                'dag'           => 'required|max:150',
                'dag_land'      => 'required',
                'khatian_land'  => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            // if ($request->parent_dag) :
            //     $parent_dag = $request->parent_dag;
            // else :
            //     $parent_dag = $request->parent_dag_sa;
            // endif;

            $khatian = new KhatianDagInfo;
            $khatian->mouza_id      = $mouza_id;
            $khatian->khatian_type  = $khatian_type;
            $khatian->dag_no        = $dag;
            $khatian->dag_land      = $request->dag_land;
            $khatian->khatian_land  = $request->khatian_land;
            $khatian->khatian_no    = $request->khatian;
            $khatian->csdag_id      = $request->cs_dag;
            $khatian->sadag_id      = $request->sa_dag;
            $khatian->rsdag_id      = $request->rs_dag;
            $khatian->user_id       =  Auth::user()->id;
            $khatian->save();

            return response()->json(['success' => 'Saved successfully.']);

        else:
            
            return response()->json(['errors' => ['0' => 'Already you have added']]);

        endif;


    }

    // public function isExistDag($mouza, $dag_no)
    // {
    //     $checkDag  = MouzaCs::where('mouza_id', $mouza)->where('cs_dag', $dag_no)->first();
    //     if ($checkDag) {
    //         return true;
    //     }
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $khatian = KhatianDagInfo::find($id);

        $ext_field = '';

        if ($khatian->khatian_type == 2) :

            $ext_field = '<div class="col-sm-3">
                            <label class="from-label">CS Dag</label>
                            <select class="w-100 form-select mb-3 " id="csLiveSearch" name="cs_dag" data-width="100%">
                            </select>
                         </div>';

        elseif ($khatian->khatian_type == 3) :

            $ext_field = '<div class="col-sm-3">
                            <label class="from-label">CS Dag</label>
                            <select class="w-100 form-select mb-3 " id="csLiveSearch" name="cs_dag" data-width="100%">
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label class="from-label">SA Dag</label>
                            <select class="w-100 form-select mb-3 " id="saLiveSearch" name="sa_dag" data-width="100%">
                            </select>
                        </div>';

        elseif ($khatian->khatian_type == 4 || $khatian->khatian_type == 5) :
            $ext_field = '<div class="col-sm-3">
                            <label class="from-label">CS Dag</label>
                            <select class="w-100 form-select mb-3 " id="csLiveSearch" name="cs_dag" data-width="100%">
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label class="from-label">SA Dag</label>
                            <select class="w-100 form-select mb-3 " id="saLiveSearch" name="sa_dag" data-width="100%">
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label class="from-label">RS Dag</label>
                            <select class=w-100 form-select mb-3 " id="rsLiveSearch" name="rs_dag" data-width="100%">
                            </select>
                        </div>';

        else :
            $ext_field = '';
        endif;

        return response()->json(['data' => $khatian, 'ext_field' => $ext_field]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $khatian_dag_id = $request->khatian_id;

        $isAuthorised = KhatianDagInfo::where('id', $khatian_dag_id)->where('user_id', Auth::user()->id)->first();

        if(is_null($isAuthorised)):
            return response()->json(['errors' => ['0' => 'You are not authorised to edit on this info']]);
        endif;
        
        $validator = Validator::make($request->all(), [
            'dag'           => 'required|max:150',
            'dag_land'      => 'required',
            'khatian_id'    => 'required',
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $khatian_dag = KhatianDagInfo::find($khatian_dag_id);
   
        $khatian_dag->khatian_type  = $request->khatian_type;
        $khatian_dag->dag_no        = $request->dag;
        $khatian_dag->dag_land      = $request->dag_land;
        $khatian_dag->khatian_land  = $request->khatian_land;
        $khatian_dag->khatian_no    = $request->khatian;
        $khatian_dag->csdag_id      = !empty($request->cs_dag) ? $request->cs_dag: $khatian_dag->csdag_id;
        $khatian_dag->sadag_id      = !empty($request->sa_dag) ? $request->sa_dag: $khatian_dag->sadag_id;
        $khatian_dag->rsdag_id      = !empty($request->rs_dag) ? $request->rs_dag: $khatian_dag->rsdag_id;
        $khatian_dag->user_id       =  Auth::user()->id;
        $khatian_dag->save();

        return response()->json(['success'=>'Data is successfully added']);

    }

    public function csSaRsBsDagByMouza(Request $request){

        if ($request->has('search')) {

            $search = $request->search;
            $mouza_id = $request->mouza_id;
            $khatian_type = $request->khatian_type;

            $datas = KhatianDagInfo::select('id', 'dag_no', 'khatian_no')
                ->where('dag_no', 'LIKE', "%$search%")
                ->where('khatian_type', '=', $khatian_type)
                ->where('mouza_id', '=', $mouza_id)
                ->get();

            $response = array();
            foreach ($datas as $data) {
                $response[] = array(
                    'id' => $data->id,
                    'text' => $data->dag_no.'(kh-'.$data->khatian_no.')',
                );
            }
            return response()->json($response);
        }

    }


    public function dagSearchByMouza(Request $request)
    {

        if ($request->has('search')) {

            $search = $request->search;
            $mouza_id = $request->mouza_id;
            $khatian_type = $request->khatian_type;

            $datas = KhatianDagInfo::select('id', 'dag_no', 'khatian_no')
                ->where('dag_no', 'LIKE', "%$search%")
                ->where('khatian_type', '=', $khatian_type)
                ->where('mouza_id', '=', $mouza_id)
                ->get();

            $response = array();
            foreach ($datas as $data) {
                $response[] = array(
                    'id' => $data->id,
                    'text' => $data->dag_no.'(kh-'.$data->khatian_no.')',
                );
            }
            return response()->json($response);
        }
    }


    public function landSizeByDag(Request $request){

        $data = KhatianDagInfo::select("khatian_dag_infos.*", DB::raw("(SELECT SUM(est_entry_file_dags.purchase_land) FROM est_entry_file_dags  WHERE est_entry_file_dags.dag_id = khatian_dag_infos.id) as purchase_land"))
                ->where('id', $request->dag_id)
                ->first();
                                
        return response()->json(['data' => $data]);
    }


    public function khatianFrom(Request $request){

        $k_type = $request->type;

        $mouzas = Mouza::all();

        $data_mouza = '';
        foreach($mouzas as $mouza){
            $data_mouza.='<option value="'.$mouza->id.'">'.$mouza->name.'</option>';
        }
        
        $khatian_type = EstateLookUp::where('data_values', $k_type)->where('data_type', 'khatian')
                          ->first();

        $form_data = '<input type="hidden" name="khatian_type" class="form-control" id="khatianType" value="'.$khatian_type->data_keys.'">
                    <div class="col-sm-2">
                        <label class="control-label">Mouza</label>
                        <select class="form-select mb-3 filter_mouza" name="mouza" id="mouza_id">
                            <option selected disabled>Select Mouza</option>
                            '.$data_mouza.'
                        </select>
                    </div>';

        if($k_type =='sa'):
             $form_data.= '<div class="col-sm-2">
                    <div class="form-group">
                        <label class="control-label">Dag No (C.S)</label>
                        <select class="cs_livesearch form-select mb-3 parent_cs" id="cs_livesearch" name="cs_dag">
                        </select>
                    </div>
                </div>';

        elseif($k_type =='rs'):
            $form_data.= '<div class="col-sm-2">
                            <div class="form-group">
                                <label class="control-label">Dag No (C.S)</label>
                                <select class="cs_livesearch form-select mb-3 parent_cs" id="cs_livesearch" name="cs_dag">
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="control-label">Dag No (S.A)</label>
                                <select class="sa_livesearch form-select mb-3 parent_sa" id="sa_livesearch" name="sa_dag">
                                </select>
                            </div>
                        </div>';

        elseif($k_type =='bs' || $k_type =='city'):
            $form_data.= '<div class="col-sm-2">
                            <div class="form-group">
                                <label class="control-label">Dag No (C.S)</label>
                                <select class="cs_livesearch form-select mb-3" id="cs_livesearch" name="cs_dag">
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="control-label">Dag No (S.A)</label>
                                <select class="sa_livesearch form-select mb-3 parent_sa" id="sa_livesearch" name="sa_dag">
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                        <div class="mb-3">
                            <label class="from-label">Dag No (R.S)</label>
                            <select class="rs_livesearch form-select mb-3" id="rs_livesearch" name="rs_dag">
                            </select>
                        </div>
                        </div>';

        else:
            $form_data.= '';
        endif;

        $form_data.='<div class="col-sm-2">
                        <div class="mb-3">
                            <label class="from-label">Dag No</label>
                            <input type="text" name="dag" class="form-control" placeholder="Dag No">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="mb-3">
                            <label class="from-label">Khatian</label>
                            <input type="text" name="khatian" class="form-control" placeholder="Khatian No">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="mb-3">
                            <label class="from-label">Dag Land Area</label>
                            <input type="text" name="dag_land" class="form-control" placeholder="Dag Land">
                        </div>
                    </div>
                    <div class="col-sm-2">
                    <div class="mb-3">
                        <label class="from-label">Khatian Land Area</label>
                        <input type="text" name="khatian_land" class="form-control" placeholder="Khatian Land">
                    </div>
                </div>
                    <div class="col-sm-2 mt-3 pt-1">
                        <button type="button" id="csFormSubmit" class="btn btn-primary mr-2">Save</button>
                    </div>';

        return response()->json(['form_data' => $form_data]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
