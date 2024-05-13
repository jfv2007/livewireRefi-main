<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Livewire\Admin\HistorialFalla\HfallaController;
use App\Http\Livewire\Admin\Categorias\ListCategorias as CategoriasListCategorias;
use App\Http\Livewire\Admin\Categoriass\ListCategorias;
use App\Http\Livewire\Admin\Falla\ListConsultaFallas;
use App\Http\Livewire\Admin\Falla\ListConsultas;
use App\Http\Livewire\Admin\Falla\ListFallas;
use App\Http\Livewire\Admin\Plantas\ListPlantas;
use App\Http\Livewire\Admin\Profile\UpdateProfile;
use App\Http\Livewire\Admin\Seccions\ListSeccions;
use App\Http\Livewire\Admin\Tag18\CreateTag18Form;
use App\Http\Livewire\Admin\Tag18\ListFallas as Tag18ListFallas;
use App\Http\Livewire\Admin\Tag18\ListFallasTags18;
use App\Http\Livewire\Admin\Tag18\ListTag18s;
use App\Http\Livewire\Admin\Tag18\ListTagsFallas;
use App\Http\Livewire\Admin\Tag18\ListTrabajos as Tag18ListTrabajos;
use App\Http\Livewire\Admin\Tag18\ListTrabajosTags18;
use App\Http\Livewire\Admin\Tag18\UpdateTag18Form;
use App\Http\Livewire\Admin\Trabajo\ListConsultas as TrabajoListConsultas;
use App\Http\Livewire\Admin\Trabajo\ListConsultaTrabajos;
use App\Http\Livewire\Admin\Trabajo\ListTrabajos;  /* no tocar */
use App\Http\Livewire\Admin\Users\ListUsers;
use App\Mail\ContactanosMailable;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
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

Route::get('/', function () {
    return view('welcome');
});


 Route::group(['middleware' =>'auth','verified'], function(){

    Route::get('admin/dashboard', DashboardController::class)->name('admin.dashboard');
     Route::get('admin/users', ListUsers::class)->name('admin.users');

    Route::get('admin/tag18s',ListTag18s::class)->name('admin.tag18s');

    Route::get('admin/tag18s/{tag18}/listfallas', ListFallasTags18 ::class)->name('admin.tag18s.list-fallas');
    Route::get('admin/tag18s/{tag18}/listtrabajos', ListTrabajosTags18 ::class)->name('admin.tag18s.list-trabajos');
    Route::get('admin/tag18s/create', CreateTag18Form::class)->name('admin.tag18s.create');
    Route::get('admin/tag18s/{tag18}/edit', UpdateTag18Form::class)->name('admin.tag18s.edit');

    Route::get('admin/fallas', ListFallas::class)->name('admin.fallas');
    Route::get('admin/fallas/{falla}/listconsultas',ListConsultas ::class)->name('admin.falla.list-consultas');
    Route::get('admin/fallas/{trabajo}/listconsultafallas',ListConsultaFallas ::class)->name('admin.falla.list-consulta-fallas');

    Route::get('admin/trabajos', ListTrabajos::class)->name('admin.trabajos');
    Route::get('admin/trabajos/{trabajo}/listconsultas',TrabajoListConsultas ::class)->name('admin.trabajo.list-consultas');
     Route::get('admin/trabajos/{falla}/listconsultatrabajo',ListConsultaTrabajos ::class)->name('admin.trabajo.list-consulta-trabajos');

    Route::get('admin/plantas', ListPlantas::class)->name('admin.plantas');
    Route::get('admin/categorias', CategoriasListCategorias::class)->name('admin.categorias');
    Route::get('admin/seccions', ListSeccions::class)->name('admin.seccions');

    /* Route::get('admin/hfalla',[HfallaController::class,'index'])->name('admin.hfalla'); */
    Route::resource('permissions', App\Http\Controllers\PermissionController::class);
    Route::resource('roles', App\Http\Controllers\RoleController::class);
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::resource('plantas', App\Http\Controllers\PlantaController::class);

    Route::get('admin/profile', UpdateProfile::class)->name('profile.edit');

    Route::get('contactanos', function(){

        $correo = new ContactanosMailable;
        Mail::to('jfv6@hotmail.com')->send($correo);
        return "Mensaje enviado";
    });

    Route::get('/linkstorage', function () {
        Artisan::call('storage:link');
    });


 });

 Route::get('/home', function (){
    return view ('home');
})->middleware(['auth', 'verified'])->name('home');

/* require __DIR__ .'/auth.php'; */

/* Route::get('/email/verify', function(){
    return view('auth.verify-email.');
})->middleware(['auth'])->name('verification.notice'); */

/* Auth::routes(''); */

/* Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home'); */

/* Route::view('/home','home')->middleware('auth', 'verified'); */
