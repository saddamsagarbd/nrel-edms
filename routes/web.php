<?php

use App\Http\Controllers\Admin\EstateEntryFileController as AdminEstateEntryFileController;
use App\Http\Controllers\Admin\EstateProjectController as AdminEstateProjectController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CrmLeadController;
use App\Http\Controllers\EstateEntryFileController;
use App\Http\Controllers\EstateProjectController;
use App\Http\Controllers\EstPlotController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\EstateFileController;
use App\Http\Controllers\EstateKhatianController;
use App\Http\Controllers\ReportManageController;
use App\Http\Controllers\User\EstateMouzaController;
use App\Http\Controllers\User\EstateVendorController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/get-district', [App\Http\Controllers\DistrictController::class, 'getDistrictByDivision']);
Route::get('/get-upazila', [App\Http\Controllers\UpazilaController::class, 'getUpazilaByDistrict']);
Route::get('/get-union', [App\Http\Controllers\UnionController::class, 'getUnionByUpazila']);
Route::get('/get-dag-info', [App\Http\Controllers\FileController::class, 'getDagInfoByKhatianAndMouza']);

Route::name('map.')->group(function () {

    Route::get('/map', [App\Http\Controllers\EstGraphViewController::class, 'index'])->name('index');
    Route::post('/map-view', [App\Http\Controllers\EstGraphViewController::class, 'store'])->name('store');
    Route::get('/map-view/{slug}', [App\Http\Controllers\EstGraphViewController::class, 'show'])->name('show');
    
});

Auth::routes();

Route::get('/entryfile/search', [EstateEntryFileController::class, 'findEntryFile'])->middleware('auth');

Route::get('/dag/search', [EstateKhatianController::class, 'dagSearchByMouza'])->middleware('auth');
Route::get('/dag/cssarsbs-search', [EstateKhatianController::class, 'csSaRsBsDagByMouza'])->middleware('auth');

Route::get('/dag/search/land-size', [EstateKhatianController::class, 'landSizeByDag'])->middleware('auth');

Route::get('/lanowner/search', [EstateVendorController::class, 'landownerSerch'])->middleware('auth');
Route::get('/agent/search', [EstateVendorController::class, 'agentSerch'])->middleware('auth');
Route::get('/project/search', [EstateProjectController::class, 'searchProject'])->middleware('auth');

Route::group(['as' => 'entryfile.', 'prefix' => 'entryfile','middleware'=>['auth']], function () {

    Route::get('/dag/search', [EstateEntryFileController::class, 'dagSearchByEntryFile']);

});
/*------------------------------------------
All Normal Users Routes List
--------------------------------------------*/

Route::group(['as' => 'user.', 'prefix' => 'user', 'namespace' => 'User', 'middleware' => ['auth', 'user-access:user']], function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    // Route::get('projects',[ProjectController::class, 'index'])->name('project.index');
    // Route::get('projects/details/{id}',[ProjectController::class, 'show'])->name('project.show');
    Route::name('project.')->group(function () {
        Route::get('project', [EstateProjectController::class, 'index'])->name('index');
        Route::post('project', [EstateProjectController::class, 'store'])->name('store');
        Route::get('project/{id}', [EstateProjectController::class, 'show'])->name('show');
        Route::get('project/{id}/edit', [EstateProjectController::class, 'edit'])->name('edit');
        Route::post('project/update', [EstateProjectController::class, 'update'])->name('update');
    });

    Route::name('agent.')->group(function () {
        Route::get('/agent-media', [EstateVendorController::class, 'index'])->name('index');
        Route::post('/agent-media', [EstateVendorController::class, 'store'])->name('store');
        Route::get('/agent-media/{id}', [EstateVendorController::class, 'show'])->name('show');
        Route::get('/agent-media/{id}/edit', [EstateVendorController::class, 'edit'])->name('edit');
    });

    Route::name('mouza.')->group(function () {
        Route::get('/mouza', [EstateMouzaController::class, 'index'])->name('index');
        Route::post('/mouza', [EstateMouzaController::class, 'store'])->name('store');
        Route::get('/mouza/{id}', [EstateMouzaController::class, 'show'])->name('show');
        Route::get('/mouza/{id}/edit', [EstateMouzaController::class, 'edit'])->name('edit');
    });

    Route::name('khatian.')->group(function () {
        Route::get('/khatian', [EstateKhatianController::class, 'index'])->name('index');
        Route::get('/khatian/type', [EstateKhatianController::class, 'khatianByType'])->name('type');
        Route::post('/khatian', [EstateKhatianController::class, 'store'])->name('store');

        Route::get('/khatian/{id}/edit', [EstateKhatianController::class, 'edit'])->name('edit');
        Route::put('/khatian/update', [EstateKhatianController::class, 'update'])->name('update');

        // Route::get('/mouza-cs/search', [EstateKhatianController::class, 'csKhatianSearch']);
        // Route::get('/mouza-sa/search', [EstateKhatianController::class, 'saKhatianSearch']);
        // Route::get('/mouza-rs/search', [EstateKhatianController::class, 'rsKhatianSearch']);
        //Route::get('/khatian/cssa/search', [EstateKhatianController::class, 'csSaKhatianSearch']);
        Route::get('/khatian-form', [EstateKhatianController::class, 'khatianFrom']);
    });

    Route::name('entryFile.')->group(function () {
        Route::get('/entryfile', [EstateEntryFileController::class, 'index'])->name('index');
        Route::post('/entryfile', [EstateEntryFileController::class, 'store'])->name('store');

        Route::get('/entryfile/{id}/details', [EstateEntryFileController::class, 'show'])->name('show');

        Route::get('/entryfile/{id}/edit', [EstateEntryFileController::class, 'edit'])->name('edit');
        Route::put('/entryfile/update', [EstateEntryFileController::class, 'update'])->name('update');

        Route::post('/entryfile/dag', [EstateEntryFileController::class, 'dagStore'])->name('dag.store');
        Route::get('entryfile/dag/{id}/edit', [EstateEntryFileController::class, 'dagEdit']);
        Route::post('entryfile/dag/update', [EstateEntryFileController::class, 'dagUpdate'])->name('dag.update');

        Route::post('/entryfile/deed', [EstateEntryFileController::class, 'entryfileRegistry'])->name('deed.store');
        Route::get('/entryfile/deed/{id}/edit', [EstateEntryFileController::class, 'editDeed'])->name('deed.edit');

        Route::post('entryfile/mutation', [EstateEntryFileController::class, 'mutationEntryfile'])->name('mutation');

        Route::post('entryfile/status', [EstateEntryFileController::class, 'statusEntryfile'])->name('status');

        Route::get('entryfile/reports', [EstateEntryFileController::class, 'report'])->name('report');

        Route::put('/mouza/more', [EstateEntryFileController::class, 'addMoreMouza'])->name('extmouza.store');

    });

    Route::get('/upload/file', [EstateFileController::class, 'index'])->name('estate.upload.index');
    Route::post('/upload/file', [EstateFileController::class, 'store'])->name('estate.upload.store');

    Route::name('plot.')->group(function () {
        Route::get('/estate/plot', [EstPlotController::class, 'index'])->name('index');
        Route::get('/estate/plot/{id}/edit', [EstPlotController::class, 'edit'])->name('edit');
        Route::post('/estate/plot', [EstPlotController::class, 'store'])->name('store');
        Route::get('plot/status/{id}/edit', [EstPlotController::class, 'editStatus']);
        Route::post('/estate/plot/status', [EstPlotController::class, 'updateStatus'])->name('status.update');
    });

    // crm start
    Route::name('lead.')->group(function () {
        Route::get('/lead', [CrmLeadController::class, 'index'])->name('index');
        Route::post('/lead', [CrmLeadController::class, 'store'])->name('store');
        Route::get('/lead/{id}', [CrmLeadController::class, 'show'])->name('show');
        Route::get('/lead/{id}/edit', [CrmLeadController::class, 'edit'])->name('edit');
        Route::post('/lead/covert', [CrmLeadController::class, 'convertLead'])->name('convert');
    });


});

/*------------------------------------------
All Admin Routes List
--------------------------------------------*/
Route::middleware(['auth', 'user-access:manager'])->group(function () {
    Route::get('/manager/dashboard', [HomeController::class, 'managerHome'])->name('manager.dashboard');
});

/*------------------------------------------
All Report Routes List
--------------------------------------------*/
Route::group(['as' => 'reports.', 'prefix' => 'reports', 'middleware' => ['auth']], function () {
    Route::post('/entryfile-export-excel', [ReportManageController::class, 'entryFileExcel'])->name('entryfile-export-excel');
    Route::post('/entryfile-export-pdf', [ReportManageController::class, 'entryFilePdf'])->name('entryfile-export-pdf');
});

/*------------------------------------------
All Admin Routes List
--------------------------------------------*/
Route::group(['as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'user-access:admin']], function () {
    Route::get('/dashboard', [HomeController::class, 'adminHome'])->name('dashboard');

    Route::group(['as' => 'user.', 'prefix' => 'employee'], function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/show/{id}', [UserController::class, 'show'])->name('show');
        Route::post('/permission', [UserController::class, 'permissionUpdate'])->name('permission');
    });

    Route::name('project.')->group(function () {
        Route::get('project', [AdminEstateProjectController::class, 'index'])->name('index');
        Route::post('project', [AdminEstateProjectController::class, 'store'])->name('store');
        Route::get('project/{id}', [AdminEstateProjectController::class, 'show'])->name('show');
        Route::get('project/{id}/edit', [AdminEstateProjectController::class, 'edit'])->name('edit');
        Route::post('project/update', [AdminEstateProjectController::class, 'update'])->name('update');
    });
    
    Route::name('agent.')->group(function () {
        Route::get('/agent-media', [EstateVendorController::class, 'index'])->name('index');
        Route::post('/agent-media', [EstateVendorController::class, 'store'])->name('store');
        Route::get('/agent-media/{id}', [EstateVendorController::class, 'show'])->name('show');
        Route::get('/agent-media/{id}/edit', [EstateVendorController::class, 'edit'])->name('edit');
    });


    Route::name('mouza.')->group(function () {
        Route::get('/mouza', [EstateMouzaController::class, 'index'])->name('index');
        Route::post('/mouza', [EstateMouzaController::class, 'store'])->name('store');
        Route::get('/mouza/{id}', [EstateMouzaController::class, 'show'])->name('show');
    });

    Route::name('khatian.')->group(function () {
        Route::get('/khatian', [EstateKhatianController::class, 'index'])->name('index');
        Route::get('/khatian/type', [EstateKhatianController::class, 'khatianByType'])->name('type');
        Route::post('/khatian', [EstateKhatianController::class, 'store'])->name('store');

        Route::get('/mouza-cs/search', [EstateKhatianController::class, 'csSaSearchByMouza']);
        Route::get('/mouza-rs/search', [EstateKhatianController::class, 'rsKhatianSearch']);
        Route::get('/khatian/cssa/search', [EstateKhatianController::class, 'csSaKhatianSearch']);
    });

    Route::name('entryFile.')->group(function () {
        Route::get('/entryfile', [AdminEstateEntryFileController::class, 'index'])->name('index');
        Route::post('/entryfile', [AdminEstateEntryFileController::class, 'store'])->name('store');

        Route::get('/entryfile/{id}/details', [AdminEstateEntryFileController::class, 'show'])->name('show');

        Route::get('/entryfile/{id}/edit', [AdminEstateEntryFileController::class, 'edit'])->name('edit');
        Route::put('/entryfile/update', [AdminEstateEntryFileController::class, 'update'])->name('update');

        Route::post('/entryfile/dag', [AdminEstateEntryFileController::class, 'dagStore'])->name('dag.store');
        Route::get('entryfile/dag/{id}/edit', [AdminEstateEntryFileController::class, 'dagEdit']);
        Route::post('entryfile/dag/update', [AdminEstateEntryFileController::class, 'dagUpdate'])->name('dag.update');
        Route::post('entryfile/dag/registry', [AdminEstateEntryFileController::class, 'entryfileRegistry'])->name('dag.registry');
        Route::post('entryfile/mutation', [AdminEstateEntryFileController::class, 'mutationEntryfile'])->name('mutation');

        Route::post('entryfile/status', [AdminEstateEntryFileController::class, 'statusEntryfile'])->name('status');

        Route::get('entryfile/reports', [AdminEstateEntryFileController::class, 'report'])->name('report');

    });

    Route::get('/upload/file', [EstateFileController::class, 'index'])->name('estate.upload.index');
    Route::post('/upload/file', [EstateFileController::class, 'store'])->name('estate.upload.store');

    Route::name('plot.')->group(function () {
        Route::get('/estate/plot', [EstPlotController::class, 'index'])->name('index');
        Route::get('/estate/plot/{id}/edit', [EstPlotController::class, 'edit'])->name('edit');
        Route::post('/estate/plot', [EstPlotController::class, 'store'])->name('store');
        Route::get('plot/status/{id}/edit', [EstPlotController::class, 'editStatus']);
        Route::post('/estate/plot/status', [EstPlotController::class, 'updateStatus'])->name('status.update');
    });

    Route::name('lead.')->group(function () {
        Route::get('/lead', [CrmLeadController::class, 'index'])->name('index');
        Route::post('/lead', [CrmLeadController::class, 'store'])->name('store');
        Route::get('/lead/{id}', [CrmLeadController::class, 'show'])->name('show');
        Route::get('/lead/{id}/edit', [CrmLeadController::class, 'edit'])->name('edit');
        Route::post('/lead/covert', [CrmLeadController::class, 'convertLead'])->name('convert');
    });


});
