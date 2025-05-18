<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use function PHPUnit\Framework\isNull;

class EstGraphViewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files = File::all();
        return view('backend.modules.map.map-upload',['files'=>$files]);
    }

    // public function mapView($slug=null){
    //     dd($slug);
    //     $file = File::where('project_id', $slug)->first();
    //     return view('backend.modules.map.map-show');
    // }

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
        $getperm = getCreatePermission(16,1);

        if (!empty($getperm)) :

            $request->validate([
                'project'  => 'required',
                'image'     => 'required|mimes:jpg,jpeg,png|max:15024'
            ]);

            $pr_id = $request->project;

            $existFile = File::where('project_id', $pr_id)->first();

            $file = $request->file('image');

            if(empty($existFile->id)):

                $currentDate = Carbon::now()->toDateString();
                $new_name =  Str::slug($file->getClientOriginalName()) . '-' . uniqid() . '-' . $currentDate . '.' . $file->getClientOriginalExtension();
                $upload_path = 'uploads/plot-map/';

                $file->move(public_path($upload_path), $new_name);

                $efile = new File();
                $efile->file_name       = $new_name;
                $efile->orgi_name       = $file->getClientOriginalName();
                $efile->file_path       = $upload_path;
                $efile->file_type       = '';
                $efile->file_size       = '';
                $efile->project_id      = $request->project;
                $efile->purpose         = 'map';
                $efile->user_id         = Auth::user()->id;
                $efile->save();

            else:

                $currentDate = Carbon::now()->toDateString();
                $new_name =  Str::slug($file->getClientOriginalName()) . '-' . uniqid() . '-' . $currentDate . '.' . $file->getClientOriginalExtension();
                $upload_path = 'uploads/plot-map/';

                $file->move(public_path($upload_path), $new_name);

                $efile = File::find($existFile->id);

                if(!is_null(($efile))){
                    unlink($efile->file_path.$efile->file_name);
                }

                $efile->file_name       = $new_name;
                $efile->orgi_name       = $file->getClientOriginalName();
                $efile->file_path       = $upload_path;
                $efile->file_type       = '';
                $efile->file_size       = '';
                $efile->project_id      = $request->project;
                $efile->purpose         = 'map';
                $efile->user_id         = Auth::user()->id;
                $efile->save();


            endif;

            return back()
                    ->with('success', 'You have successfully uploaded file.');
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
        $file = File::where('project_id', $id)->first();
        return view('backend.modules.map.map-show', ['file'=>$file]);
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
