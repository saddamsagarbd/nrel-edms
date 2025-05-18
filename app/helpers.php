<?php

use App\Models\EstEntryFile;
use App\Models\EstEntryFileActivity;
use App\Models\EstEntryFileDag;
use App\Models\EstEntryFileMutation;
use App\Models\EstProjectUser;
use App\Models\Permission;
use App\Models\TeamUser;
use Illuminate\Support\Facades\Auth;


if(!function_exists('getReadPermission')){
    function getReadPermission($modId=null, $param=null){
        $result = Permission::where('user_id', Auth::user()->id)
                ->where('module_id', $modId)
                ->where('read', $param)
                ->first();
        if($result){
            return true;
        }else{
            return false;
        }
    }
}


if(!function_exists('getCreatePermission')){
    function getCreatePermission($modId=null, $param=null){
        $result = Permission::where('user_id', Auth::user()->id)
                ->where('module_id', $modId)
                ->where('create', $param)
                ->first();
        if($result){
            return true;
        }else{
            return false;
        }
    }
}

if(!function_exists('getUpdatePermission')){
    function getUpdatePermission($modId=null, $param=null){
        $result = Permission::where('user_id', Auth::user()->id)
                ->where('module_id', $modId)
                ->where('update', $param)
                ->first();
        if($result){
            return true;
        }else{
            return false;
        }
    }
}

if(!function_exists('getDeletePermission')){
    function getDeletePermission($modId=null, $param=null){
        $result = Permission::where('user_id', Auth::user()->id)
                ->where('module_id', $modId)
                ->where('delete', $param)
                ->first();
        if($result){
            return true;
        }else{
            return false;
        }
    }
}



if (!function_exists('isExistFileActivity')) {
    function isExistFileActivity($fileId = null, $activity = null)
    {
        $result = EstEntryFileActivity::where('entry_id', $fileId)
            ->where('activity_id', $activity)
            ->first();
        if ($result) {
            return $result->activity_id;
        } else {
            return false;
        }
    }
}


// if (!function_exists('isRegistry')) {

//     function isRegistry($fileId = null)
//     {
//         $result = EstEntryFileActivity::where('entry_id', $fileId)
//             ->where('activity_id', 2)
//             ->first();
//         if ($result) {
//             return $result->activity_id;
//         } else {
//             return false;
//         }
//     }
// }

if (!function_exists('isMutation')) {
    function isMutation($fileId = null)
    {
        $result = EstEntryFileMutation::where('entryfile_id', $fileId)->first();
        if ($result) {
            return $result->id;
        } else {
            return false;
        }
    }
}


if (!function_exists('userProjects')) {
    function userProjects($user_id = null)
    {
        $projects = EstProjectUser::where('user_id', $user_id)->get();

        $prid = [];

        if (count($projects) > 0) {
            foreach ($projects as $project) {
                $prid[] = $project->project_id;
            }
            return $prid;
        }
    }
}

if (!function_exists('teamMembers')) {

    function teamMembers()
    {
        $mems = [Auth::user()->id];

        $team_user = TeamUser::where('user_id', Auth::user()->id)->first();

        if (!empty($team_user)) {
            $team_mems = TeamUser::where('parent_id', $team_user->id)
                ->get();
            if (count($team_mems) > 0) {
                foreach ($team_mems as $mem) {
                    $mems[] = $mem->user_id;
                }
            }
        }
        return $mems;
    }
}




if (!function_exists('getApprovalPermission')) {
    function getApprovalPermission($modId = null, $param = null)
    {
        $result = Permission::where('user_id', Auth::user()->id)
            ->where('module_id', $modId)
            ->where('approval', $param)
            ->first();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}


if (!function_exists('isReviewed')) {
    function isReviewed($fileId = null, $activity = null)
    {
        $result = EstEntryFileActivity::where('entry_id', $fileId)
            ->where('activity_id', $activity)
            ->first();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('isExistDag')) {

    function isExistDag($entfile_id = null, $dag_id = null)
    {
        $result = EstEntryFileDag::where('entfile_id', $entfile_id)
            ->where('dag_id', $dag_id)
            ->first();
        if ($result) {
            return $result->dag_id;
        } else {
            return false;
        }
    }
}
