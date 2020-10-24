<?php

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
    // check if user is auth then redirect to dashboard page
    if(Auth::check()) {
        return redirect()->route('backoffice.dashboard');
    }
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'backoffice', 'middleware' => ['auth']], function() {
    // backoffice route
    Route::get('/', 'DashboardController@index');
    Route::get('dashboard',['as' => 'backoffice.dashboard','uses' => 'DashboardController@dashboard']);
    Route::get('logs',['as' => 'logs','uses' => 'ActivityController@index']);
    Route::resource('users','UserController');
    Route::resource('permissions', 'PermissionController');
    Route::resource('roles', 'RoleController');
    Route::resource('kontrak', 'KontrakController');
    Route::resource('lahan', 'PembebasanLahanController');
    Route::resource('satker', 'SatkerController');
    Route::resource('jabatan', 'JabatanController');
    Route::resource('pekerjaan', 'PekerjaanController');
    Route::resource('jenker', 'JenisPekerjaanController');
    Route::resource('pengguna', 'PenggunaController');
    Route::resource('pelaksanaan', 'PelaksanaanController');

    // user Profile
    Route::get('profile', ['as'=>'profile','uses'=>'UserController@profile']);
    Route::patch('profile/{user}/update',['as' => 'profile.update', 'uses' => 'UserController@ProfileUpdate']);
    Route::patch('profile/{user}/password',['as' => 'profile.password','uses' => 'UserController@ChangePassword']);

    // upload dokumentasi pelaksanaan
    Route::get('pelaksanaan/{uuid}/dokumentasi',['as' => 'pelaksanaan.dokumentasi','uses'=> 'PelaksanaanController@getUpload']);
    Route::post('pelaksanaan/dokumentasi/upload',['as' => 'pelaksanaan.upload','uses'=> 'PelaksanaanController@uploadImages']);
});