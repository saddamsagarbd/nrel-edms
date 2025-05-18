<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $users = User::all();
        return view('backend.admin.users.index', ['users' => $users]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = User::where('id', $id)->first();

        $modules = Module::where('parent_id', 0)->get();

        return view('backend.admin.users.show', compact('employee', 'modules'));
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

    public function permissionUpdate(Request $request)
    {

        // dd($request->all());

        if ($request->user_id) {
            $validator = Validator::make($request->all(), [
                'module_id'     => 'required',
                'user_id'        => 'required',
            ]);

            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator);
            }
            $data = [
                'user_id' => $request->user_id,
                'module_id' => $request->module_id,
                'create' => !empty($request->create) ? 1 : 0,
                'read' => !empty($request->read) ? 1 : 0,
                'update' => !empty($request->update) ? 1 : 0,
                'delete' => !empty($request->mdelete) ? 1 : 0,
                'cancel' => !empty($request->cancel) ? 1 : 0,
                'approval' => !empty($request->approval) ? 1 : 0,
            ];

            //dd($data);
            Permission::updateOrInsert(
                ['user_id' =>  $request->user_id, 'module_id' => $request->module_id],
                $data
            );
            return redirect()->back()->with('success', 'Data is successfully added');
        } else {
            return redirect()->back()->with('success', 'Please add user at first');
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
