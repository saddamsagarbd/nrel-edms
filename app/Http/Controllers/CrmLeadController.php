<?php

namespace App\Http\Controllers;

use App\Models\CrmLead;
use Illuminate\Http\Request;

class CrmLeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $leads = CrmLead::orderBy('id', 'DESC')->get();
        return view('backend.modules.crm.lead.index', ['leads' => $leads]);
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
            'name' => 'required',
            'phone' => 'required|max:50|unique:crm_leads',
            'email' => 'required|max:50|unique:crm_leads',
            'lead_source' => 'required',
            'lead_status' => 'required',
            'project' => 'required',
            'address' => 'required|max:1000',
        ]);

        if ($validator->fails()){
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $crmLead  = new CrmLead();
        $crmLead->name          = $request->name;
        $crmLead->phone         = $request->phone;
        $crmLead->email         = $request->email;
        $crmLead->lead_source   = $request->lead_source;
        $crmLead->lead_status   = $request->lead_status;
        $crmLead->project_id    = $request->project;
        $crmLead->user_id       = Auth::id();
        $crmLead->company_id    = Auth::user()->company_id;
        $crmLead->address       = $request->address;
        $crmLead->description   = $request->description;
        $crmLead->save();

        return response()->json(['success'=>'Your ticket has been submitted successfully']);
        
    }

    public function convertLead(Request $request){

        if($request->lead_id):
            $validator = Validator::make($request->all(), [
                'deal_name' => 'required',
                'closing_date' => 'required',
                'stage' => 'required',
            ]);

            if ($validator->fails()){
                return response()->json(['errors'=>$validator->errors()->all()]);
            }

            $lead = CrmLead::find($request->lead_id);

            // create account
            $account                = new CrmAccount;
            $account->account_name  = $lead->name;
            $account->phone         = $lead->phone;
            $account->save();

            // create contact
            $contact                = new CrmContact;
            $contact->contact_name  = $lead->name;
            $contact->account_id    = $account->id;
            $contact->email         = $lead->email;
            $contact->phone         = $lead->phone;
            $contact->save();

            // deal create
            $deal = new CrmDeal;
            $deal->amount       = $request->amount;
            $deal->deal_name    = $request->deal_name;
            $deal->closing_date = $request->closing_date;
            $deal->deal_stage   = $request->stage;
            $deal->account_id   = $account->id;
            $deal->contact_id   = $contact->id;
            $deal->save();

            //delete old lead
            //$lead->delete();

            return response()->json(['success'=>'Your ticket has been submitted successfully']);

        endif;

        return response()->json(['errors'=>'Somthing error please try again']);
        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lead = CrmLead::where('id', $id)->first();
        return view('backend.user.crm.lead.show', ['lead' => $lead]);
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
