<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function getDistrictByDivision(Request $request)
    {
        $districts = DB::table('districts')->where('division_id', $request->division_id)->pluck('name', 'id', 'bg_name');

        return response()->json(['districts'=>$districts]);
    }

    public function store(Request $request)
    {
        //
    }



}
