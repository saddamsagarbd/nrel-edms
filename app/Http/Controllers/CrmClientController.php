<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CrmClientController extends Controller
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

    public function getClientJsonData(Request $request)
    {
        if ($request->ajax()) {

            $mem = [Auth::user()->id];

            $team_user = CrmTeam::where('user_id', Auth::user()->id)->first();

            if ($team_user->parent_id == NULL) {
                $sub_teams = CrmTeam::where('parent_id', $team_user->id)
                    ->get();
                if (count($sub_teams) > 0) {
                    foreach ($sub_teams as $subteam) {
                        $mem[] = $subteam->user_id;
                    }
                }
            } elseif ($team_user->sub_parent_id == NULL) {
                $sub_teams = CrmTeam::where('sub_parent_id', $team_user->id)->get();
                if (count($sub_teams) > 0) {
                    foreach ($sub_teams as $subteam) {
                        $mem[] = $subteam->user_id;
                    }
                }
            } else {
                $mem[] = $team_user->user_id;
            }

            $query = CrmClient::with('crmPrjoectsByClient')->whereIn('crd_user_id', $mem)->orderBy('id', 'DESC')->get();

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('project_name', function (CrmClient $crmClient) {
                    return $crmClient->crmPrjoectsByClient->map(function ($single) {
                        return '<p>' . $single->project_name . '</p>';
                    })->implode('');
                })
                ->addColumn('action', function ($data) {
                    $role =  Auth::user()->role->slug . '.clients.show';
                    $button = '<a href="' . route($role, $data->id) . '" class="btn btn-light btn-sm btn-sm-custom">View</a>';
                    return $button;
                })
                ->rawColumns(['project_name', 'action'])
                ->toJson();
        }
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
            'name'          => 'required|max:150',
            'email'         => 'required|email|string|unique:crm_clients',
            'phone'         => 'required|digits:11|unique:crm_clients',
            'user_id'       => 'required',
            'client_type'   => 'required',
            'booking_date'  => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $client = new CrmClient;
        $client->client_type    = $request->client_type;
        $client->name           = $request->name;
        $client->email          = $request->email;
        $client->phone          = $request->phone;
        $client->booking_date   = $request->booking_date;
        $client->prsnt_address  = $request->prsnt_address;
        $client->prmnt_address  = $request->prmnt_address;
        $client->ofc_address    = $request->ofc_address;
        $client->cperson_name   = $request->cperson_name;
        $client->cperson_mobile = $request->cperson_mobile;
        $client->apartment_no = $request->apartment_no;
        $client->company_id     = 100;
        $client->crd_user_id    = $request->user_id;
        $client->user_id        = Auth::id();
        $client->save();

        if ($client->id && count((array)$request->project) > 0) :

            foreach ($request->project as $single) {
                $pr_client = new CrmClientProject;
                $pr_client->client_id   = $client->id;
                $pr_client->project_id  = (int)$single;
                $pr_client->user_id     = Auth::id();
                $pr_client->save();
            }

        endif;

        return response()->json(['success' => 'Data is successfully added']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = CrmClient::with('crmPrjoectsByClient')->where('id', $id)
            ->orderBy('id', 'DESC')
            ->first();

        $services = CrmClientService::with('crmServicesTypes')
            ->where('client_id', $id)
            ->orderBy('id', 'DESC')
            ->get();
        return view('backend.user.crm.single-clients', ['services' => $services, 'client' => $client]);
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
