<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\EstateFile;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class EstateFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (request()->ajax()) {

            $estFiles = DB::table('estate_files')
                ->leftJoin('est_entry_files', 'est_entry_files.id', '=', 'estate_files.entryfile_id')
                ->leftJoin('users', 'users.id', '=', 'estate_files.user_id')
                ->select('estate_files.*', 'est_entry_files.file_no', 'users.name as username')
                ->where('estate_files.user_id', Auth::user()->id)
                ->latest()
                ->get();
                
            return DataTables::of($estFiles)
                ->addIndexColumn()
                ->addColumn('doc_type', function ($data) {
                    return json_decode($data->doc_type);
                })
                ->addColumn('action', function ($data) {
                    $button = '<div class="d-flex"><a class="btn btn-light btn-sm btn-sm-custom" href="' . asset($data->file_path) . '/' . $data->file_name . '" download>Download</a> 
                                <a class="btn btn-light btn-sm btn-sm-custom ms-1" target="_blank" href="' . asset($data->file_path) . '/' . $data->file_name . '">View</a></div>';
                    return $button;
                })
                ->rawColumns(['doc_type','action'])
                ->toJson();
        }

        return view('backend.user.estate.upload');
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
        //dd(json_encode($request->doc_type));

        $getperm = Permission::where('user_id', Auth::user()->id)->where('module_id', 11)->first();

        if (!empty($getperm->create) && $getperm->create === 1) :

            $request->validate([
                'shelf'         => 'required',
                'entryFileNo'   => 'required',
                'files.*'       => 'required|mimes:pdf|max:15024'
            ]);

            $files = $request->file('files');
            
            //$purpose_name = ProjectPurpose::where('id', $request->order_type)->pluck('slug')->first();
            $shelf = $request->shelf;
            $entryFile_no = $request->entryFileNo;

            if (count((array)$files) > 0) {
                $i = 0;
                foreach ($files as $file) {
                    $currentDate = Carbon::now()->toDateString();
                    $new_name =  Str::slug($file->getClientOriginalName()) . '-' . uniqid() . '-' . $currentDate . '.' . $file->getClientOriginalExtension();
                    $upload_path = 'upload/' . $shelf . '/' . $entryFile_no . '/';

                    $file->move(public_path($upload_path), $new_name);

                    $efile = new EstateFile;
                    $efile->entryfile_id    = $entryFile_no;
                    $efile->file_name       = $new_name;
                    $efile->orgi_name       = $file->getClientOriginalName();
                    $efile->file_path       = $upload_path;
                    $efile->file_type       = '';
                    $efile->file_size       = '';
                    $efile->shelf_no        = $request->shelf;
                    $efile->doc_type        = json_encode($request->doc_type);
                    $efile->user_id         = Auth::user()->id;
                    $efile->save();

                    $i++;
                }

                return back()
                    ->with('success', 'You have successfully uploaded file.');
            }
            return back()
                ->with('error', 'You have not uploaded any files.');
        endif;

        return back()
            ->with('error', 'You have not permission for uploading files.');
    }

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
        //
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
