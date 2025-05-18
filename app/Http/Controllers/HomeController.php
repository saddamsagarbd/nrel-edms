<?php

namespace App\Http\Controllers;

use App\Models\EstEntryFile;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $t_entryfile = EstEntryFile::count();

        $users_entry_data = EstEntryFile::join('users', 'users.id', '=', 'est_entry_files.user_id')
            ->select('users.name as user_name', DB::raw('count(est_entry_files.id) as total'))
            //->whereBetween('tickets.created_at',[$dateS,$dateE])
            //->whereDate('est_entry_files.created_at', '>=', $date)
            ->groupBy('est_entry_files.user_id')
            ->groupBy('user_name')
            ->orderBy('total', 'DESC')
            ->get();

        $dailyEntry = EstEntryFile::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        $daylabels = [];
        $daydata = [];
        foreach ($dailyEntry as $day_data) {
            $daylabels[] = $day_data->date;
            $daydata[] = $day_data->total;
        }
        
        
        return view('backend.user.dashboard', ['t_entry' => $t_entryfile, 'users_entry_data' => $users_entry_data, 'daylabels'=>$daylabels, 'daydata'=>$daydata]);

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminHome()
    {

        $t_entryfile = EstEntryFile::count();

        $users_entry_data = EstEntryFile::join('users', 'users.id', '=', 'est_entry_files.user_id')
            ->select('users.name as user_name', DB::raw('count(est_entry_files.id) as total'))
            //->whereBetween('tickets.created_at',[$dateS,$dateE])
            //->whereDate('est_entry_files.created_at', '>=', $date)
            ->groupBy('est_entry_files.user_id')
            ->groupBy('user_name')
            ->orderBy('total', 'DESC')
            ->get();

        $dailyEntry = EstEntryFile::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        $daylabels = [];
        $daydata = [];
        foreach ($dailyEntry as $day_data) {
            $daylabels[] = $day_data->date;
            $daydata[] = $day_data->total;
        }
    
        return view('backend.admin.dashboard', ['t_entry' => $t_entryfile, 'users_entry_data' => $users_entry_data, 'daylabels'=>$daylabels, 'daydata'=>$daydata]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function managerHome()
    {
        return view('backend.manager.dashboard');
    }
}
