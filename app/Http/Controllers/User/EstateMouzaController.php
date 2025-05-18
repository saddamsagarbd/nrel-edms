<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Mouza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class EstateMouzaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (request()->ajax()) {

            $mouzas = Mouza::select('mouzas.*','upazilas.name as upazila_name','unions.name as union_name', 'districts.name as district_name','divisions.name as division_name')
                    ->leftJoin('upazilas', 'upazilas.id', 'mouzas.upazilla_id')
                    ->leftJoin('unions', 'unions.id', 'mouzas.union_id')
                    ->leftJoin('districts', 'districts.id', 'mouzas.district_id')
                    ->leftJoin('divisions', 'divisions.id', 'mouzas.division_id')
                    ->get();
            
            return DataTables::of($mouzas)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $button = '<div class="d-flex">
                                <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data->id.'" data-original-title="Edit" class="btn btn-light btn-sm btn-sm-custom editMouza">Edit</a> 
                                <a class="btn btn-light btn-sm btn-sm-custom ms-1" href="' . route('user.mouza.show', $data->id) . '" >View</a></div>';
                    return $button;
                })
                ->rawColumns(['created_at','action'])
                ->toJson();
        }


        return view('backend.user.estate.mouza.index');

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
        
        if(!empty($request->mouza_id)):

            $mouza_id = $request->mouza_id;

            $isAuthorised = Mouza::where('id', $mouza_id)->where('user_id', Auth::user()->id)->first();

            dd(Auth::user()->id);
            
            if(is_null($isAuthorised)):
                return response()->json(['errors' => ['0' => 'You are not authorised to edit on this info']]);
            endif;


            $validator = Validator::make($request->all(), [
                'name'        => 'required|max:150',
                'district'     => 'required',
                'upazila'      => 'required',
            ]);       
    
            if ($validator->fails())
            {
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            $mouza = Mouza::find($mouza_id);
            
            $mouza->name             = $request->name;
            $mouza->gl_no            = $request->gl_no;
            $mouza->division_id      = $request->division;
            $mouza->district_id      = $request->district;
            $mouza->upazilla_id      = $request->upazila;
            $mouza->union_id         = $request->union;
            $mouza->save();

            return response()->json(['success' => 'Update successfully.']);

        else:

            $validator = Validator::make($request->all(), [
                'name'        => 'required|max:150|unique:mouzas',
                'district'     => 'required',
                'upazila'      => 'required',
            ]);       
    
            if ($validator->fails())
            {
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            $mouza                  = new Mouza();
            $mouza->name            = $request->name;
            $mouza->gl_no           = $request->gl_no;
            $mouza->division_id     = $request->division;
            $mouza->district_id     = $request->district;
            $mouza->upazilla_id     = $request->upazila;
            $mouza->union_id        = $request->union;
            $mouza->user_id         = Auth::user()->id;
            $mouza->save();

            return response()->json(['success' => 'Saved successfully.']);

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
        return view('backend.user.estate.mouza.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mouzas = Mouza::find($id);
        return response()->json($mouzas);
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
