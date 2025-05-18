<?php

namespace App\Http\Controllers;
use App\Models\EstPlot;
use App\Models\EstPlotActivity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PHPUnit\TextUI\XmlConfiguration\Group;
use Termwind\Components\Raw;
use Yajra\DataTables\Facades\DataTables;

class EstPlotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (request()->ajax()) {

            $plots = EstPlot::all();

            return DataTables::of($plots)
                ->addIndexColumn()
                ->addColumn('s_status', function ($data) {
                    $status = json_decode($data->saleStatus->data_values);
                    return '<span class="badge" style="background-color:'.$status->color.'">'.$status->name. '</span>';
                })
                ->addColumn('created_at', function ($data) {
                    return date('d-m-Y', strtotime($data->created_at));
                })
                ->addColumn('action', function ($data) {
                    $button = '<div class="d-flex"><a href="javascript:void(0)" data-id="'.$data->id.'" class="editSaleStatus btn btn-light btn-sm btn-sm-custom">Edit</a> 
                                <a class="btn btn-light btn-sm btn-sm-custom ms-1" href="' . route('user.plot.edit', $data->id) . '" >View</a></div>';
                    return $button;
                })
                ->rawColumns(['s_status','action'])
                ->toJson();
        }

        $status = DB::table('est_plots')
            ->leftJoin('est_plot_lookups', 'est_plots.s_status', '=', 'est_plot_lookups.data_keys')
            ->select('est_plot_lookups.data_values', DB::raw('count(*) as total, est_plots.s_status'))
            ->groupBy('est_plots.s_status')
            ->groupBy('est_plot_lookups.data_values')
            ->get();
        
        return view('backend.user.plot.manage',['sstatus'=>$status]);
    }

    /**
     * Show the form for EstPloteating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function EstPloteate()
    {
        //
    }

    /**
     * Store a newly EstPloteated resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());

        $validator = Validator::make($request->all(), [
            'project'    => 'required',
            'mouza'      => 'required',
            'plot_no'    => 'required',
            'plot_size'    => 'required',
            'khatian_type'    => 'required',
            'sector'    => 'required',
            'road_no'    => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $entfile = new EstPlot();
        $entfile->plot_no       = $request->plot_no;
        $entfile->project_id    = $request->project;
        $entfile->sector_no     = $request->sector;
        $entfile->road_no       = $request->road_no;
        $entfile->plot_size     = $request->plot_size;
        $entfile->mouza_id      = $request->mouza;
        $entfile->khatian_type	= $request->khatian_type;
        $entfile->remarks	    = $request->description;
        $entfile->user_id       = Auth::user()->id;
        $entfile->save();

        return response()->json(['success' => 'Saved successfully.']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EstPlot  $estPlot
     * @return \Illuminate\Http\Response
     */
    public function show(EstPlot $estPlot)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EstPlot  $estPlot
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $plot = EstPlot::where('id', $id)->first();
        return view('backend.user.plot.edit',['plot'=>$plot]);
    }


    public function editStatus($id)
    {
        $plot = EstPlot::where('id', $id)->first();
        
        return response()->json($plot);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EstPlot  $estPlot
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EstPlot $estPlot)
    {
        //
    }

    public function updateStatus(Request $request){

        $validator = Validator::make($request->all(), [
            'status' => 'required',
            'plot_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $logdata = [
            'subject'       => 's_status',
            'activity_id'   => $request->status,
            'plot_id'       => $request->plot_id,
            'user_id'       => Auth::user()->id,
            'added_at'      => new Carbon(),
        ];

        if(EstPlotActivity::create($logdata)):
            EstPlot::where('id', $request->plot_id)
                ->update(['s_status' => $request->status]);
        endif;
    

        return response()->json(['success' => 'You have updated successfully']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EstPlot  $estPlot
     * @return \Illuminate\Http\Response
     */
    public function destroy(EstPlot $estPlot)
    {
        //
    }
}
