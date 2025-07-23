<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EstateVendor;
use Illuminate\Http\Request;
use App\Models\EstEntryFile;
use App\Models\EstEntryFileActivity;
use App\Models\EstEntryFileDag;
use App\Models\EstEntryFileDeed;
use App\Models\EstEntryFileMutation;
use App\Models\KhatianDagInfo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class EstateEntryFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (request()->ajax()) {

            $entryFiles = EstEntryFile::with(['entryDagData'])
                ->leftJoin('users', 'users.id', '=', 'est_entry_files.user_id')
                ->select('est_entry_files.*', 'users.name as username')
                ->latest()
                ->get();

            return DataTables::of($entryFiles)
                ->addIndexColumn()
                ->addColumn('media_name', function ($data) {
                    if (!empty($data->agent->name)) {
                        $agent = $data->agent->name;
                    } else {
                        $agent = '';
                    }
                    return $agent;
                })
                ->addColumn('project_name', function ($data) {
                    return $data->project->name;
                })
                ->addColumn('mouza_name', function ($data) {
                    return $data->mouza->name;
                })
                ->addColumn('landowner', function ($data) {
                    $owner = '';
                    if ($data->landowners) :
                        foreach (EstateVendor::whereIn('id', $data->landowners)->get() as $lw) :
                            $owner .= '<p>' . $lw->name . '.</p>';
                        endforeach;
                        return $owner;
                    else :
                        return $owner;
                    endif;
                })
                ->addColumn('dags', function ($data) {
                    return $data->entryDagData->map(function ($dag) {
                        return $dag->dag_no;
                    })->implode(', ');
                })
                ->addColumn('khatian_type', function ($data) {
                    return !empty($data->khatianType->data_values) ? $data->khatianType->data_values : 'Others';
                })
                ->addColumn('status', function ($data) {
                    $status = json_decode($data->entFileStatus->data_values);
                    return '<span class="badge" style="background-color:' . $status->color . '">' . $status->name . '</span>';
                })
                ->addColumn('action', function ($data) {
                    $button = '<div class="d-flex"><a class="btn btn-light btn-sm btn-sm-custom" href="' . route('admin.entryFile.edit', $data->id) . '">Edit</a> 
                                <a class="btn btn-light btn-sm btn-sm-custom ms-1" href="' . route('admin.entryFile.show', $data->id) . '" >View</a></div>';
                    return $button;
                })
                ->rawColumns(['dags', 'media_name', 'mouza_name', 'landowner', 'status', 'action'])
                ->toJson();
        }

        return view('backend.admin.estate.entryfile.index');
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

        $validator = Validator::make($request->all(), [
            'landowner'     => 'required',
            'file_no'       => 'required|unique:est_entry_files',
            'project'       => 'required',
            'mouza'         => 'required',
            'khatian_type'  => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        //$ldata['landwoners'] = implode(",", $request->landowner);
        //$ldata['landwoners'] = json_encode($request->landowner);

        $entfile = new EstEntryFile();
        $entfile->file_no       = $request->file_no;
        $entfile->project_id    = $request->project;
        $entfile->agent_id      = $request->agent;
        $entfile->mouza_id      = $request->mouza;
        $entfile->khatype_id    = $request->khatian_type;
        $entfile->landowners    = json_encode($request->landowner);
        $entfile->remarks       = $request->remarks;
        $entfile->user_id       = Auth::user()->id;
        $entfile->save();

        // $entry_id =   $entfile->id;

        // foreach ($request->name as $key => $value) {
        //     $data = [
        //         'p_name' => $request->name[$key],
        //         'p_phone' => $request->phone[$key],
        //         'p_address' => $request->address[$key],
        //         'entfile_id' => $entry_id,
        //     ];
        //     EstEntryFileParty::create($data);
        // }

        return response()->json(['success' => 'Saved successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $entryFile = EstEntryFile::where('id', $id)->first();

        $dags = EstEntryFileDag::where('entfile_id', $id)
            ->leftJoin('khatian_dag_infos', 'est_entry_file_dags.dag_id', 'khatian_dag_infos.id')
            ->select('est_entry_file_dags.*', 'khatian_dag_infos.khatian_land', 'khatian_dag_infos.dag_no')
            ->get();
        //dd(json_decode($entryFile->landowners));
        //$lands =  EstateVendor::whereIn('id', json_decode($entryFile->landowners))->get();

        return view('backend.admin.estate.entryfile.show-more', ['entryFile' => $entryFile, 'dags' => $dags]);
    }

    public function isExistBsKhatian($fileid, $type)
    {
        $khatian_type = EstEntryFileDag::where('entfile_id', $fileid)->where('khatian_type', $type)->first();
        if ($khatian_type) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $entryFile = EstEntryFile::where('id', $id)->first();

        return view('backend.admin.estate.entryfile.edit', ['entryFile' => $entryFile]);
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
        $validator = Validator::make($request->all(), [
            'mouza'         => 'required',
            'khatian_type'  => 'required',
            'entryFile_id'  => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $entry_id = $request->entryFile_id;

        $entfile  = EstEntryFile::find($entry_id);
        $entfile->agent_id      = $request->agent;
        $entfile->khatype_id    = $request->khatian_type;
        $entfile->remarks       = $request->remarks;
        $entfile->user_id       = Auth::user()->id;
        $entfile->save();


        // foreach ($request->name as $key => $value) {

        //     $party_id = $request->party_id[$key];

        //     if ($party_id) :
        //         $data = [
        //             'p_name' => $request->name[$key],
        //             'p_phone' => $request->phone[$key],
        //             'p_address' => $request->address[$key],
        //             'entfile_id' => $entry_id,
        //         ];

        //         EstEntryFileParty::where('id', $party_id)->update($data);

        //     else :


        //         $data = [
        //             'p_name' => $request->name[$key],
        //             'p_phone' => $request->phone[$key],
        //             'p_address' => $request->address[$key],
        //             'entfile_id' => $entry_id,
        //         ];
        //         EstEntryFileParty::create($data);
        //     endif;
        // }

        return response()->json(['success' => 'Saved successfully.']);
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

    /**
     * Search the RS Khatian with CS/SA Dag
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    // public function rsKhatianSearchByCsSa(Request $request)
    // {

    //     $dags = KhatianDagInfo::where('mouza_id', $request->mouza_id)
    //         ->where('parent_id', $request->dag_id)
    //         ->where('khatian_type', '=', 2)
    //         ->get();

    //     $output = '';
    //     $output .=  '<option disabled selected></option>';
    //     foreach ($dags  as $dag) :
    //         $output .= '<option value="' . $dag->id . '">' . $dag->dag_no . '</option>';
    //     endforeach;

    //     return response()->json(['data' => $output]);
    // }



    // public function rsBsKhatianSearchByCsSa(Request $request)
    // {

    //     $rsdags = KhatianDagInfo::where('mouza_id', $request->mouza_id)
    //         ->where('parent_id', $request->dag_id)
    //         ->where('khatian_type', '=', 2)
    //         ->get();

    //     $rsoutput = '';
    //     $rsoutput .=  '<option disabled selected></option>';
    //     foreach ($rsdags  as $dag) :
    //         $rsoutput .= '<option value="' . $dag->id . '">' . $dag->dag_no . '</option>';
    //     endforeach;

    //     $bsdags = KhatianDagInfo::where('mouza_id', $request->mouza_id)
    //         ->where('parent_id', $request->dag_id)
    //         ->where('khatian_type', '=', 3)
    //         ->get();

    //     $bsoutput = '';
    //     $bsoutput .=  '<option disabled selected></option>';
    //     foreach ($bsdags  as $dag) :
    //         $bsoutput .= '<option value="' . $dag->id . '">' . $dag->dag_no . '</option>';
    //     endforeach;

    //     return response()->json(['rsdata' => $rsoutput, 'bsdata' => $bsoutput]);
    // }


    /**
     * Search the Bs Khatian with Rs Dag
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function bsKhatianSearchByRs(Request $request)
    // {

    //     $data = KhatianDagInfo::where('mouza_id', $request->mouza_id)
    //         ->where('id', $request->dag_id)
    //         ->first();

    //     $dags = KhatianDagInfo::where('mouza_id', $request->mouza_id)
    //         ->where('parent_id', $request->dag_id)
    //         ->where('khatian_type', '=', 3)
    //         ->get();

    //     $pr_dags = '';

    //     if (count($dags) > 0) :
    //         foreach ($dags  as $dag) :
    //             $pr_dags .=  '<option disabled selected></option>';
    //             $pr_dags .= '<option value="' . $dag->id . '">' . $dag->dag_no . '</option>';
    //         endforeach;
    //     else :
    //         $pr_dags = 0;
    //     endif;

    //     return response()->json(['pr_dags' => $pr_dags, 'data' => $data]);
    // }


    // public function getDagInfo(Request $request)
    // {
    //     $data = KhatianDagInfo::where('mouza_id', $request->mouza_id)
    //         ->where('id', $request->dag_id)
    //         ->first();
    //     return response()->json(['data' => $data]);
    // }


    /**
     * Store a newly Dag created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function dagStore(Request $request)
    {

        $entfile_id = $request->entryFile_id;
        $dag_id = $request->dag_id;

        $isExistDag = isExistDag($entfile_id, $dag_id);

        if ($isExistDag == false) :
            $validator = Validator::make($request->all(), [
                'khatianType'       => 'required',
                'dag_id'            => 'required',
                'propose_land'      => 'required',
                'entryFile_id'      => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            $dag                    = new EstEntryFileDag();
            $dag->dag_id            = $dag_id;
            $dag->entfile_id        = $entfile_id;
            $dag->propose_land      = $request->propose_land;
            $dag->purchase_land     = $request->purchase_land;
            $dag->khatian_type      = $request->khatianType;
            $dag->save();

            if ($dag->id) {
                $data = EstEntryFileDag::where('est_entry_file_dags.id', $dag->id)
                    ->leftJoin('khatian_dag_infos', 'est_entry_file_dags.dag_id', 'khatian_dag_infos.id')
                    ->select('est_entry_file_dags.*', 'khatian_dag_infos.land_size', 'khatian_dag_infos.dag_no')
                    ->first();
            }

            return response()->json(['success' => 'Saved successfully.', 'data' => $data]);

        else :

            return response()->json(['errors' => ['0' => 'Already you have added']]);

        endif;
    }


    /**
     * Edit entry file dag with land size modal open
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function dagEdit($id)
    {
        $dagInfo = EstEntryFileDag::select("est_entry_file_dags.*", 'khatian_dag_infos.dag_no')
            ->leftJoin('khatian_dag_infos', 'khatian_dag_infos.id', '=', 'est_entry_file_dags.dag_id')
            ->where('est_entry_file_dags.id', $id)
            ->first();

        // $dagInfo = EstEntryFileDag::select(
        //     "est_entry_file_dags.*",
        //     DB::raw("(SELECT khatian_dag_infos.dag_no FROM khatian_dag_infos
        //             WHERE khatian_dag_infos.id = est_entry_file_dags.dag_id) as cs_dag"),
        //     DB::raw("(SELECT khatian_dag_infos.dag_no FROM khatian_dag_infos
        //             WHERE khatian_dag_infos.id = est_entry_file_dags.rs_dag) as rs_dag"),
        //     DB::raw("(SELECT khatian_dag_infos.dag_no FROM khatian_dag_infos
        //             WHERE khatian_dag_infos.id = est_entry_file_dags.bscity_dag) as bs_dag"),
        // )
        //     ->where('est_entry_file_dags.id', $id)
        //     ->first();

        return response()->json($dagInfo);
    }


    /**
     * Update entry file dag with land size modal
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function dagUpdate(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'proposedLand'     => 'required',
            'purchasedLand'    => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $id = $request->dag_id;
        $data = [
            'propose_land' => $request->proposedLand,
            'purchase_land' => $request->purchasedLand,
            'mutation_land' => $request->mutationLand ? $request->mutationLand : '',
        ];

        $entryDag = EstEntryFileDag::where('id', $id)->update($data);

        return response()->json(['success' => 'Saved successfully', 'data' => $entryDag]);
    }
    /**
     * Registry entry file
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function entryfileRegistry(Request $request)
    {

        $entryId = $request->entryFileId;
        $deed_type = $request->deed_type;

        $isExistDeed = EstEntryFileDeed::where('entfile_id', $entryId)->where('deed_type', $deed_type)->first();

        if (empty($isExistDeed)) :

            $totalLand = $this->getPurchaseLand($entryId);

            if ($totalLand > 0 && floatval($request->deed_land_size) == $totalLand) {

                $validator = Validator::make($request->all(), [
                    'deed_type'         => 'required',
                    'deed_no'           => 'required',
                    'registry_date'     => 'required',
                    'deed_land_size'    => 'required',
                    'deed_cost'         => 'required',
                    'buyer'             => 'required',
                    'registry_office'   => 'required',
                    'isReview'          => 'required',
                    'land_value'        => 'required',
                    'entryFileId'       => 'required',
                ]);

                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()->all()]);
                }

                $entryDeed = new EstEntryFileDeed();
                $entryDeed->entfile_id      = $entryId;
                $entryDeed->deed_no         = $request->deed_no;
                $entryDeed->deed_type       = $deed_type;
                $entryDeed->dland_size      = $request->deed_land_size;
                $entryDeed->deed_date       = $request->registry_date;
                $entryDeed->expenses        = $request->deed_cost;
                $entryDeed->buyer           = $request->buyer;
                $entryDeed->land_value      = $request->land_value;
                $entryDeed->user_id         = Auth::user()->id;
                $entryDeed->save();

                if ($entryDeed) :
                    $data = [
                        'deed_type'     => $request->deed_type,
                        'status'        => 3,
                    ];
                    $registryFile = EstEntryFile::where('id', $entryId)->update($data);
                    // if($registryFile):
                    //     EstEntryFileDag::where('entfile_id', $entryId)->update(['purchase_land' => $request->deed_land_size]);
                    // endif;
                    $entryActivity = new EstEntryFileActivity();
                    $entryActivity->activity_id     = $deed_type;
                    $entryActivity->entry_id        = $entryId;
                    $entryActivity->user_id         = Auth::user()->id;
                    $entryActivity->data            = 'looks.registry';
                    $entryActivity->added_at        = Carbon::now();
                    $entryActivity->save();

                    return response()->json(['success' => 'Registered successfully', 'data' => $registryFile]);

                endif;
            } else {
                return response()->json(['errors' => ['0' => 'Please check your land size. or entry land size against dag']]);
            }

        else :
            return response()->json(['errors' => ['0' => 'Already Submitted']]);
        endif;
    }


    public function getPurchaseLand($entFIleId)
    {
        $pLandSize = EstEntryFileDag::where('entfile_id', $entFIleId)->sum('purchase_land');
        return $pLandSize;
    }
    /**
     * Mutation entry file
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function mutationEntryfile(Request $request)
    {

        $entryId = $request->entryFileId;

        $isExistMutation = EstEntryFileMutation::where('entryfile_id', $entryId)->first();

        if (empty($isExistMutation)) :

            $getMutationLand = $this->getMutationLandSize($entryId);

            if ($getMutationLand > 0 && floatval($request->mutation_land) == $getMutationLand) {

                $validator = Validator::make($request->all(), [
                    'zoth_no'       => 'required',
                    'mkhatian_no'   => 'required',
                    'mutation_date' => 'required',
                    'mutation_land' => 'required',
                    'isReview'      => 'required',
                    'entryFileId'   => 'required'
                ]);

                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()->all()]);
                }

                $mutation = new EstEntryFileMutation();
                $mutation->entryfile_id     = $entryId;
                $mutation->zoth_no          = $request->zoth_no;
                $mutation->mland_size       = $request->mutation_land;
                $mutation->mkhatian_no      = $request->mkhatian_no;
                $mutation->m_date           = $request->mutation_date;
                $mutation->mcase_date       = $request->case_date;
                $mutation->user_id          = Auth::user()->id;
                $mutation->save();

                return response()->json(['success' => 'Mutation Successfull', 'data' => $mutation]);
            } else {
                return response()->json(['errors' => ['0' => 'Please check your Mutation land size against dag']]);
            }

        else :
            return response()->json(['errors' => ['0' => 'Already you have Mutioned the file']]);
        endif;
    }

    public function getMutationLandSize($entFIleId)
    {
        $mLandSize = EstEntryFileDag::where('entfile_id', $entFIleId)->sum('mutation_land');
        return $mLandSize;
    }


    public function findEntryFile(Request $request)
    {

        if ($request->has('q')) {
            $search = $request->q;
            $files = EstEntryFile::select('id', 'file_no')
                ->where('file_no', 'LIKE', "%$search%")
                ->get();

            $response = array();
            foreach ($files as $file) {
                $response[] = array(
                    'id' => $file->id,
                    'text' => $file->file_no,
                );
            }
            return response()->json($response);
        }
    }


    public function statusEntryfile(Request $request)
    {
        $approval = getApprovalPermission(6, 1);

        if ($approval == TRUE) :
            $validator = Validator::make($request->all(), [
                'checked_file'      => 'required',
                'entryFileId'       => 'required',
                'status'       => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            $entryFileId = $request->entryFileId;


            $isExistStatus = EstEntryFileActivity::where('entry_id', $entryFileId)
                ->where('activity_id', $request->status)
                ->first();

            if (empty($isExistStatus)) :

                $status = $request->status + 1;
                $entryActivity = new EstEntryFileActivity();
                $entryActivity->activity_id     = $status;
                $entryActivity->entry_id        = $entryFileId;
                $entryActivity->user_id         = Auth::user()->id;
                $entryActivity->data            = 'Approved';
                $entryActivity->added_at        = Carbon::now();
                $entryActivity->save();

                if ($entryActivity) :
                    EstEntryFile::where('id', $entryFileId)->update(['status' => $status]);
                endif;

                return response()->json(['success' => 'Reviewed submitted successfully']);

            else :
                return response()->json(['errors' => ['0' => 'Already you have checked']]);
            endif;

        else :
            return response()->json(['errors' => ['0' => 'You have not permission']]);
        endif;
    }

    protected function applyCriteria($criteria, $query)
    {
        if (isset($criteria['from_date'], $criteria['to_date'])) {
            $fromDate = $criteria['from_date'] . ' 00:00:00';
            $toDate = $criteria['to_date'] . ' 23:59:59';
            $query->whereBetween('est_entry_file_deeds.deed_date', [$fromDate, $toDate]);
        }
        
        if (!empty($criteria['project']) && $criteria['project'] !== 'all') {
            $query->where('est_entry_files.project_id', $criteria['project']);
        }

        if (!empty($criteria['mouza']) && $criteria['mouza'] !== 'all') {
            $query->where('est_entry_files.mouza_id', $criteria['mouza']);
        }
        
        if (!empty($criteria['khatian_type']) && $criteria['khatian_type'] !== 'all') {
            $query->where('est_entry_files.khatype_id', $criteria['khatian_type']);
        }
        
        if (!empty($criteria['dag']) && $criteria['dag'] !== 'all') {
            $query->whereHas('entryDagData', function($q) use ($criteria) {
                $q->where('est_entry_file_dags.dag_id', $criteria['dag']);
            });
        }
    }

    /**
     * Display the report.
     *
     * @param  int  $
     * @return \Illuminate\Http\Response
     */

    public function report(Request $request)
    {

        // if (request()->ajax()) {

        //     $query = EstEntryFile::with(['entryDagData', 'user', 'mouza'])
        //         // ->leftJoin('users', 'users.id', '=', 'est_entry_files.user_id')
        //         // ->leftJoin('khatian_dag_infos', 'est_entry_files.mouza_id', '=', 'khatian_dag_infos.mouza_id')
        //         ->select('est_entry_files.*', 'users.name as username');

        //     // Get pagination parameters
        //     $perPage    = request()->input('length', 10);
        //     $start      = request()->input('start', 0);
        //     $draw       = request()->input('draw');

        //     $this->applyCriteria($request->criteria, $query);

        //     $total = $query->count();

        //     $entryFiles = $query->skip($start)->take($perPage)->latest()->get();

        //     return DataTables::of($entryFiles)
        //         ->addIndexColumn()
        //         ->addColumn('media_name', function ($data) {
        //             if (!empty($data->agent->name)) {
        //                 $agent = $data->agent->name;
        //             } else {
        //                 $agent = '';
        //             }
        //             return $agent;
        //         })
        //         ->addColumn('mouza_name', function ($data) {
        //             return $data->mouza->name;
        //         })
        //         ->addColumn('buyer_name', function ($data) {
        //             return !empty($data->buyerName->data_values)? $data->buyerName->data_values : '';
        //         })
        //         ->addColumn('landowner', function ($data) {
        //             $owner='';
        //             if($data->landowners):
        //                 foreach(EstateVendor::whereIn('id', $data->landowners)->get() as $lw):
        //                     $owner .= '<p>'.$lw->name.'.</p>';
        //                 endforeach;
        //                 return $owner;
        //             else:
        //                 return $owner;
        //             endif;

        //         })
        //         ->addColumn('sa_khatian', function ($data) {
        //             return $data->entryDagData->map(function ($dag) {
        //                 $sa_dag = $this->getDagData($dag->sadag_id);
        //                 return !empty($sa_dag->khatian_no)? $sa_dag->khatian_no : '';
        //             })->implode(',<br>');
        //         })
        //         ->addColumn('sa_dag', function ($data) {
        //             return $data->entryDagData->map(function ($dag) {
        //                 $sa_dag = $this->getDagData($dag->sadag_id);
        //                 return !empty($sa_dag->dag_no) ? $sa_dag->dag_no: '';
        //             })->implode(', <br>');
        //         })
        //         ->addColumn('rs_khatian', function ($data) {
        //             if($data->khatype_id==3)
        //                 return $data->entryDagData->map(function ($dag) {
        //                     $rs_dag = $this->getDagData($dag->dag_id);
        //                     return !empty($rs_dag->khatian_no)? $rs_dag->khatian_no : '';
        //                 })->implode(',<br>');
        //             else{
        //                 return $data->entryDagData->map(function ($dag) {
        //                     $rs_dag = $this->getDagData($dag->rsdag_id);
        //                     return !empty($rs_dag->khatian_no)? $rs_dag->khatian_no : '';
        //                 })->implode(',<br>');
        //             }
        //         })
        //         ->addColumn('rs_dag', function ($data) {
        //             if($data->khatype_id==3)
        //                 return $data->entryDagData->map(function ($dag) {
        //                     $rs_dag = $this->getDagData($dag->dag_id);
        //                     return !empty($rs_dag->dag_no) ? $rs_dag->dag_no: '';
        //                 })->implode(', <br>');
        //             else{
        //                 return $data->entryDagData->map(function ($dag) {
        //                     $rs_dag = $this->getDagData($dag->rsdag_id);
        //                     return !empty($rs_dag->dag_no) ? $rs_dag->dag_no: '';
        //                 })->implode(', <br>');
        //             }
        //         })
        //         ->addColumn('bs_khatian', function ($data) {
        //             if($data->khatype_id==4)
        //             return $data->entryDagData->map(function ($dag) {
        //                 $bs_dag = $this->getDagData($dag->dag_id);
        //                 return !empty($bs_dag->khatian_no)? $bs_dag->khatian_no : '';
        //             })->implode(',<br>');
        //             else{
        //                 return '...';
        //             }
        //         })
        //         ->addColumn('bs_dag', function ($data) {
        //             if($data->khatype_id==4)
        //                 return $data->entryDagData->map(function ($dag) {
        //                     return $dag->dag_no;
        //                 })->implode(', <br>');
        //             else{
        //                 return '...';
        //             }
        //         })
        //         ->addColumn('dag_land', function ($data) {
        //             return $data->entryDagData->map(function ($dag) {
        //                 $dag_data = $this->getDagData($dag->dag_id);
        //                 return !empty($dag_data->dag_land)? $dag_data->dag_land : '';
        //             })->implode(',<br>');
        //         })
        //         ->addColumn('pur_land', function ($data) {
        //             return $data->entryDagData->map(function ($dag) {
        //                 return $dag->purchase_land;
        //             })->implode(', <br>');
        //         })
        //         ->addColumn('total_pur_land', function ($data) {
        //             return $data->entryDagData->map(function ($dag) {
        //                 return $dag->purchase_land;
        //             })->sum();
        //         })
        //         ->addColumn('deed_no', function ($data) {
        //             return $data->entryDeed->map(function ($dag) {
        //                 return $dag->deed_no;
        //             })->implode(', ');
        //         })
        //         ->addColumn('mzoth_no', function ($data) {
        //             return $data->entryMutation->map(function ($dag) {
        //                 return $dag->zoth_no;
        //             })->implode(', ');
        //         })
        //         ->addColumn('action', function ($data) {
        //             $button = '<a class="btn btn-light btn-sm btn-sm-custom ms-1" href="' . route('admin.entryFile.show', $data->id) . '" >View</a></div>';
        //             return $button;
        //         })
        //         ->rawColumns(['sa_khatian','rs_khatian','sa_dag','rs_dag', 'bs_khatian', 'bs_dag', 'dag_land','pur_land','buyer_name', 'mouza_name','landowner','action'])
        //         ->toJson();
        // }

        if ($request->ajax()) {
            // DB::enableQueryLog();
            $query = EstEntryFile::with(['entryDagData'])
                ->leftJoin('users', 'users.id', '=', 'est_entry_files.user_id')
                ->leftJoin('estate_projects', 'estate_projects.id', '=', 'est_entry_files.project_id')
                ->leftJoin('est_entry_file_deeds', 'est_entry_file_deeds.entfile_id', '=', 'est_entry_files.id')
                ->select(
                    'est_entry_files.*', 
                    'est_entry_file_deeds.deed_date', 
                    'estate_projects.name as project_name', 
                    'estate_projects.project_type as project_type', 
                    'estate_projects.land_type as land_type', 
                    'estate_projects.address as project_address', 
                    'users.name as username'
                )
                ->distinct();

            $this->applyCriteria($request->criteria, $query);

            // $query->get();

            // dd(DB::getQueryLog());
            $entryFiles = $query->latest();

            // return DataTables::of($entryFiles)
            //     ->addIndexColumn()
            //     ->addColumn('project', fn ($data) => $data->project_name ?? '')
            //     ->addColumn('media_name', fn ($data) => $data->agent->name ?? '')
            //     ->addColumn('mouza_name', fn ($data) => $data->mouza->name ?? '')
            //     ->addColumn('buyer_name', fn ($data) => $data->buyerName->data_values ?? '')
            //     ->addColumn('landowner', function ($data) {
            //         if (!$data->landowners) return '';
            //         return EstateVendor::whereIn('id', $data->landowners)
            //             ->get()
            //             ->map(fn($lw) => "<p>{$lw->name}.</p>")
            //             ->implode('');
            //     })
            //     ->addColumn('sa_khatian', function ($data) {
            //         return $data->entryDagData->map(fn ($dag) =>
            //             optional($this->getDagData($dag->sadag_id))->khatian_no
            //         )->implode(',<br>');
            //     })
            //     ->addColumn('sa_dag', function ($data) {
            //         return $data->entryDagData->map(fn ($dag) =>
            //             optional($this->getDagData($dag->sadag_id))->dag_no
            //         )->implode(', <br>');
            //     })
            //     ->addColumn('rs_khatian', function ($data) {
            //         return $data->entryDagData->map(function ($dag) use ($data) {
            //             $rs_dag = $data->khatype_id == 3
            //                 ? $this->getDagData($dag->dag_no)
            //                 : $this->getDagData($dag->rsdag_id);
            //             return optional($rs_dag)->khatian_no;
            //         })->implode(',<br>');
            //     })
            //     ->addColumn('rs_dag', function ($data) use ($request) {

            //         return $data->entryDagData->map(function ($dag) use ($data) {
            //             $rs_dag = $data->khatype_id == 3
            //                 ? $this->getDagData($dag->dag_id)
            //                 : $this->getDagData($dag->rsdag_id);
            //             return optional($rs_dag)->dag_no;
            //         })->implode(', <br>');
            //     })
            //     ->addColumn('bs_khatian', function ($data) {
            //         if ($data->khatype_id != 4) return '...';
            //         return $data->entryDagData->map(fn ($dag) =>
            //             optional($this->getDagData($dag->dag_no))->khatian_no
            //         )->implode(',<br>');
            //     })
            //     ->addColumn('bs_dag', function ($data) {
            //         if ($data->khatype_id != 4) return '...';
            //         return $data->entryDagData->map(function ($dag) {
            //             return isset($dag->dag_no) && $dag->dag_no !== null && $dag->dag_no != ""
            //                     ? (string) $dag->dag_no
            //                     : '...';
            //         })->implode(', <br>');
            //     })

            //     ->addColumn('dag_land', function ($data) {
            //         return $data->entryDagData->map(fn ($dag) =>
            //             optional($this->getDagData($dag->dag_no))->dag_land
            //         )->implode(',<br>');
            //     })
            //     ->addColumn('pur_land', fn ($data) => $data->entryDagData->pluck('purchase_land')->implode(', <br>'))
            //     ->addColumn('total_pur_land', fn ($data) => $data->entryDagData->sum('purchase_land'))
            //     ->addColumn('deed_no', fn ($data) => $data->entryDeed->pluck('deed_no')->implode(', '))
            //     ->addColumn('mland_size', fn ($data) => $data->entryMutation->pluck('mland_size')->implode(', '))
            //     // ->addColumn('action', function ($data) {
            //     //     return '<a class="btn btn-light btn-sm btn-sm-custom ms-1" href="' . route('admin.entryFile.show', $data->id) . '">View</a>';
            //     // })
            //     ->rawColumns(['sa_khatian','rs_khatian','sa_dag','rs_dag', 'bs_khatian', 'bs_dag', 'dag_land','pur_land','buyer_name', 'mouza_name','landowner'])
            //     ->make(true);

            return DataTables::of($entryFiles)
                    ->addIndexColumn()
                    ->addColumn('deed_date', fn ($data) => $data->deed_date ?? '')
                    ->addColumn('media_name', fn ($data) => $data->agent->name ?? '')
                    ->addColumn('mouza_name', fn ($data) => $data->mouza->name ?? '')
                    ->addColumn('buyer_name', fn ($data) => $data->buyerName->data_values ?? '')
                    ->addColumn('landowner', function ($data) {
                        if (!$data->landowners) return '';
                        return EstateVendor::whereIn('id', $data->landowners)
                            ->get()
                            ->map(fn($lw) => "<p>{$lw->name}.</p>")
                            ->implode('');
                    })
                    ->addColumn('project', fn ($data) => $data->project_name ?? '')
                    ->addColumn('deed_no', fn ($data) => $data->entryDeed->pluck('deed_no')->implode(', '))

                    // Filtered by dag criteria if present
                    ->addColumn('sa_khatian', function ($data) use ($request) {
                        $filterDagId = $request->criteria['dag'] ?? null;

                        return $data->entryDagData
                            ->filter(fn($dag) => !$filterDagId || $dag->dag_id == $filterDagId)
                            ->map(fn($dag) => optional($this->getDagData($dag->sadag_id))->khatian_no)
                            ->implode(',<br>');
                    })

                    ->addColumn('sa_dag', function ($data) use ($request) {
                        $filterDagId = $request->criteria['dag'] ?? null;

                        return $data->entryDagData
                            ->filter(fn($dag) => !$filterDagId || $dag->dag_id == $filterDagId)
                            ->map(fn($dag) => optional($this->getDagData($dag->sadag_id))->dag_no)
                            ->implode(', <br>');
                    })

                    ->addColumn('rs_khatian', function ($data) use ($request) {
                        $filterDagId = $request->criteria['dag'] ?? null;

                        return $data->entryDagData
                            ->filter(function ($dag) use ($data, $filterDagId) {
                                return !$filterDagId || (
                                    $data->khatype_id == 3
                                        ? $dag->dag_id == $filterDagId
                                        : $dag->rsdag_id == $filterDagId
                                );
                            })
                            ->map(function ($dag) use ($data) {
                                $rs_dag = $data->khatype_id == 3
                                    ? $this->getDagData($dag->dag_id)
                                    : $this->getDagData($dag->rsdag_id);
                                return optional($rs_dag)->khatian_no;
                            })
                            ->implode(',<br>');
                    })

                    ->addColumn('rs_dag', function ($data) use ($request) {
                        $filterDagId = $request->criteria['dag'] ?? null;

                        return $data->entryDagData
                            ->filter(function ($dag) use ($data, $filterDagId) {
                                return !$filterDagId || (
                                    $data->khatype_id == 3
                                        ? $dag->dag_id == $filterDagId
                                        : $dag->rsdag_id == $filterDagId
                                );
                            })
                            ->map(function ($dag) use ($data) {
                                $rs_dag = $data->khatype_id == 3
                                    ? $this->getDagData($dag->dag_id)
                                    : $this->getDagData($dag->rsdag_id);
                                return optional($rs_dag)->dag_no;
                            })
                            ->implode(', <br>');
                    })

                    ->addColumn('bs_khatian', function ($data) use ($request) {
                        if ($data->khatype_id != 4) return '...';
                        $filterDagId = $request->criteria['dag'] ?? null;

                        return $data->entryDagData
                            ->filter(fn($dag) => !$filterDagId || $dag->dag_id == $filterDagId)
                            ->map(fn($dag) => optional($this->getDagData($dag->dag_id))->khatian_no)
                            ->implode(',<br>');
                    })

                    ->addColumn('bs_dag', function ($data) use ($request) {
                        if ($data->khatype_id != 4) return '...';
                        $filterDagId = $request->criteria['dag'] ?? null;

                        return $data->entryDagData
                            ->filter(fn($dag) => !$filterDagId || $dag->dag_id == $filterDagId)
                            ->map(fn($dag) => optional($this->getDagData($dag->dag_id))->dag_no)
                            ->implode(', <br>');
                    })

                    ->addColumn('dag_land', function ($data) use ($request) {
                        $filterDagId = $request->criteria['dag'] ?? null;

                        return $data->entryDagData
                            ->filter(fn($dag) => !$filterDagId || $dag->dag_id == $filterDagId)
                            ->map(fn($dag) => optional($this->getDagData($dag->dag_id))->dag_land)
                            ->implode(', <br>');
                    })

                    // ->addColumn('pur_land', fn ($data) => $data->entryDagData->pluck('purchase_land')->implode(', <br>'))
                    ->addColumn('pur_land', function ($data) use ($request) {
                        $filterDagId = $request->criteria['dag'] ?? null;

                        return $data->entryDagData
                            ->filter(function ($dag) use ($data, $filterDagId) {
                                if (!$filterDagId) return true;
                                return $data->khatype_id == 3
                                    ? $dag->dag_id == $filterDagId
                                    : $dag->rsdag_id == $filterDagId;
                            })
                            ->map(fn($dag) => $dag->purchase_land)
                            ->implode(', <br>');
                    })
                    ->addColumn('total_pur_land', function ($data) use ($request){
                        $filterDagId = $request->criteria['dag'] ?? null;
                        return $data->entryDagData
                            ->filter(function ($dag) use ($data, $filterDagId) {
                                if (!$filterDagId) return true;
                                return $data->khatype_id == 3
                                    ? $dag->dag_id == $filterDagId
                                    : $dag->rsdag_id == $filterDagId;
                            })->sum('purchase_land');
                    })
                    ->addColumn('mland_size', fn ($data) => $data->entryMutation->pluck('mland_size')->implode(', '))
                    ->rawColumns([
                        'sa_khatian', 'rs_khatian', 'sa_dag', 'rs_dag',
                        'bs_khatian', 'bs_dag', 'dag_land', 'pur_land',
                        'buyer_name', 'mouza_name', 'landowner'
                    ])
                    ->make(true);
        }

        return view('backend.admin.estate.entryfile.report');
    }

    public function getDagData($id){
        $dag_data = KhatianDagInfo::where('id', $id)->first();
        if($dag_data){
            return $dag_data;
        } 
    }

    // public function getParentDagInfo($id)
    // {
    //     $dag_data = KhatianDagInfo::where('id', $id)->first();
    //     if ($dag_data) {
    //         return $dag_data;
    //     }
    // }

    // public function getLandowners($id){
    //     $landowners = EstateVendor::whereIn('id', $id)->get();
    // }



}
