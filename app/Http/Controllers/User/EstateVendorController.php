<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\EstateVendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class EstateVendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $getuserProjects = userProjects(Auth::user()->id);
        
        if (request()->ajax()) {

            $vendors = EstateVendor::whereIn('project_id', $getuserProjects)->get();
            //$vendors = EstateVendor::all();

            return DataTables::of($vendors)
                ->addIndexColumn()
                ->addColumn('parents', function ($data) {
                    return '<p>Father :' . $data->father_name . '<br>Mother :' . $data->mother_name . '</p>';
                })
                ->addColumn('action', function ($data) {
                    $button = '<div class="d-flex"><a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->id . '" data-original-title="Edit" class="btn btn-light btn-sm btn-sm-custom editAgentMedia">Edit</a> 
                                <a class="btn btn-light btn-sm btn-sm-custom ms-1" href="'.route('user.agent.show', $data->id).'" >View</a></div>';
                    return $button;
                })
                ->rawColumns(['created_at', 'parents', 'action',])
                ->toJson();
        }
        return view('backend.user.estate.agent.index');
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

        if($request->project != 'undefined'):

            $validator = Validator::make($request->all(), [
                'vname'        => 'required|max:150',
                'father_name'  => 'max:200',
                'phone'        => 'required',
                'client_type'  => 'required',
                'address'      => 'required',
                'address'      => 'required',
                'project'      => 'required',
                // 'file'         => 'mimes:png,jpg,jpeg|max:1024'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            }
            
            if ($request->agent_id) :
                
                $vendor = EstateVendor::find($request->agent_id);
                $vendor->name             = $request->vname;
                $vendor->client_type      = $request->client_type;
                $vendor->address          = $request->address;
                $vendor->phone            = $request->phone;
                $vendor->slug             = Str::slug($request->vname);
                $vendor->father_name      = $request->father_name;
                $vendor->mother_name      = $request->mother_name;
                $vendor->spouse           = $request->spouse;
                $vendor->birth_date       = $request->birth_date;
                $vendor->project_id       = $request->project;
                $vendor->nid              = $request->nid;
                $vendor->user_id          =  Auth::id();
                $vendor->save();

                return response()->json(['success' => 'Updated successfully.']);

            else :
                
                //dd($request->all());
                if ($request->file != 'undefined') {
                    $file = $request->file('file');
                    $slug = Str::slug($request->vname);
                    $currentDate = Carbon::now()->toDateString();
                    $new_name = $slug . '-' . $currentDate . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/agentclient'), $new_name);
                }

                $vendor                   = new EstateVendor();
                $vendor->name             = $request->vname;
                $vendor->client_type      = $request->client_type;
                $vendor->address          = $request->address;
                $vendor->phone            = $request->phone;
                $vendor->slug             = Str::slug($request->vname);
                $vendor->father_name      = $request->father_name;
                $vendor->mother_name      = $request->mother_name;
                $vendor->spouse           = $request->spouse;
                $vendor->birth_date       = $request->birth_date;
                $vendor->nid              = $request->nid;
                $vendor->image            = !empty($new_name) ? $new_name :'default.jpg';
                //$vendor->project_id       = json_encode($request->project_id);
                $vendor->project_id       = $request->project;
                $vendor->user_id          =  Auth::id();
                $vendor->save();

                return response()->json(['success' => 'Saved successfully.']);

            endif;
        else:
        return response()->json(['errors' => ['0'=>'Please select project.']]);
        endif;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = EstateVendor::find($id);
        return view('backend.user.estate.agent.show', ['client' =>$client]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $agent = EstateVendor::find($id);
        return response()->json($agent);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }


    public function landownerSerch(Request $request)
    {

        if ($request->has('q')) {

            $getuserProjects = userProjects(Auth::user()->id);

            $search = $request->q;

            $response = array();

            if ($search == '') :
                $landowners = EstateVendor::where('client_type','seller')
                            ->whereIn('project_id', $getuserProjects)
                            ->get();
            else :
                $landowners = EstateVendor::where('client_type','seller')
                    ->where('name', 'LIKE', "%$search%")
                    ->whereIn('project_id', $getuserProjects)
                    ->get();
            endif;
            
            foreach ($landowners as $client) {
                $response[] = array(
                    'id' => $client->id,
                    'text' => $client->name . ' (' . $client->phone .') ',
                );
            }
            return response()->json($response);
        }
    }


    public function agentSerch(Request $request)
    {

        if ($request->has('q')) {

            $getuserProjects = userProjects(Auth::user()->id);

            $search = $request->q;

            $response = array();

            if ($search == '') :
                $landowners = EstateVendor::where('client_type','media')
                            ->whereIn('project_id', $getuserProjects)
                            ->get();
            else :
                $landowners = EstateVendor::where('client_type','media')
                    ->where('name', 'LIKE', "%$search%")
                    ->whereIn('project_id', $getuserProjects)
                    ->get();
            endif;
            
            foreach ($landowners as $client) {
                $response[] = array(
                    'id' => $client->id,
                    'text' => $client->name . ' (' . $client->phone .') ',
                );
            }
            return response()->json($response);
        }
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
