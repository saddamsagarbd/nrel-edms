<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EstateProject;
use App\Models\EstProjectUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class EstateProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   

        $getuserProjects = userProjects(Auth::user()->id);

        if($getuserProjects):

            $projects = EstateProject::whereIn('estate_projects.id', $getuserProjects)
                        ->get();
        endif;

        if (request()->ajax()) {

            $getuserProjects = userProjects(Auth::user()->id);

            $projects = EstateProject::whereIn('estate_projects.id', $getuserProjects)
                        ->get();

            return DataTables::of($projects)
                ->addIndexColumn()
                ->addColumn('division', function ($data) {
                    return $data->division->name;
                })
                ->addColumn('district', function ($data) {
                    return $data->district->name;
                })
                ->addColumn('upazila', function ($data) {
                    return !empty($data->upazila->name) ?  $data->upazila->name:'';
                })
                ->addColumn('user_name', function ($data) {
                    return $data->userName->name;
                })
                ->addColumn('action', function ($data) {
                    $button = '<div class="d-flex"><a href="'.route('user.project.edit', $data->id).'" class="btn btn-light btn-sm btn-sm-custom">Edit</a> 
                                <a class="btn btn-light btn-sm btn-sm-custom ms-1" href="'.route('user.project.show', $data->id).'" >View</a></div>';
                    return $button;
                })
                ->rawColumns(['created_at','action'])
                ->toJson();
        }


        return view('backend.user.estate.project.index');
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

 
        if (getCreatePermission(15, 1) == false) {
            return response()->json(['errors' => [0 => 'You have not permission for creating vehicle']]);
        }
        
        $validator = Validator::make($request->all(), [
            'name'           => 'required|max:150|unique:estate_projects',
            'project_type'   => 'max:200',
            'location'       => 'required',
            'address'        => 'required',
            'division'       => 'required',
            'district'       => 'required',
            'land_type'      => 'required',
            'status'         => 'required',
            
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $project = new EstateProject;
        $project->name              = $request->name;
        $project->parent_id         = $request->parent_id;
        $project->slug              = Str::slug($request->name);
        $project->project_type      = $request->project_type;
        $project->pr_category       = $request->project_category;
        $project->land_type         = $request->land_type;
        $project->location          = $request->location;
        $project->address          = $request->address;
        $project->division_id       = $request->division;
        $project->district_id       = $request->district;
        $project->upazila_id        = $request->upazila;
        $project->status            = $request->status;
        $project->user_id           =  Auth::id();
        $project->save();

        if($project->id):

            $project_data = EstProjectUser::where('project_id', $project->id)
                            ->where('user_id', Auth::id())
                            ->first();

            if(empty($project_data->project_id)):
                $projectuser                = new EstProjectUser();
                $projectuser->user_id       = Auth::id();
                $projectuser->inserted_uid  = Auth::id();
                $projectuser->project_id    = $project->id;
                $projectuser->save();
            endif;

        endif;

        return response()->json(['success'=>'Data is successfully added']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = EstateProject::find($id);
        return view('backend.user.estate.project.show', ['project' =>$project]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $updatePermission = getUpdatePermission(15, 1);
        
        if($updatePermission == false):
            return back()->with('error', 'Access denied');
        endif;

        $project = EstateProject::where('id', $id)
                            ->first();

        return view('backend.user.estate.project.edit', ['data'=>$project]);
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
            'name'           => 'required|max:150',
            'project_type'   => 'required',
            'project_category'   => 'required',
            'land_type'      => 'required',
            'location'       => 'required',
            'project_id'       => 'required',
            'status'         => 'required',
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        
        $project = EstateProject::find($request->project_id);

        $project->name              = $request->name;
        //$project->parent_id         = $request->parent_id;
        $project->slug              = Str::slug($request->name);
        $project->project_type      = $request->project_type;
        $project->pr_category       = $request->project_category;
        $project->land_type         = $request->land_type;
        $project->location          = $request->location;
        $project->division_id       = $request->division;
        $project->status            = $request->status;
        $project->description       = $request->description;
        $project->save();

        return response()->json(['success'=>'Data is successfully added']);


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

    public function searchProject(Request $request)
    {
        //$users = [];

        if ($request->has('search')) {

            $search = $request->search;

            if ($search == '') :
                $projects = EstateProject::select("id", "name")
                    ->orderBy('name', 'DESC')
                    ->get();
            else :
                $projects = $projects = EstateProject::select("id", "name")
                    ->where('name', 'LIKE', "%$search%")
                    ->orderBy('name', 'DESC')
                    ->get();
            endif;

            $response = array();
            foreach ($projects as $single) {
                $response[] = array(
                    'id' => $single->id,
                    'text' => $single->name,
                );
            }
            return response()->json($response);
        }
    }


}
