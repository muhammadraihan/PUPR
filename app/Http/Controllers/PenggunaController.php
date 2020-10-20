<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Traits\Authorizable;

use App\User;
use App\Role;
use App\Satker;
use App\Jabatan;

use Carbon\Carbon;

use Auth;
use DataTables;
use DB;
use File;
use Hash;
use Image;
use Response;
use URL;

class PenggunaController extends Controller
{

    // auth trait for access control level
    use Authorizable;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            DB::statement(DB::raw('set @rownum=0'));
            // select only ppk and kasatker
            $users = User::select([DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id','uuid','name','email','jabatan_id','satker_id','jabatan_urutan'])
            ->whereNotNull('jabatan_id')
            ->whereNotNull('satker_id');

            return DataTables::of($users)
            ->editColumn('jabatan_id',function($user){
                if (empty($user->jabatan_urutan)) {
                    return $user->jabatan->nama;
                }
                return $user->jabatan->nama." ".$user->jabatan_urutan;
            })
            ->editColumn('satker_id',function($user){
                return $user->satker->nama;
            })
            ->addColumn('wilayah',function($user){
                switch ($user->satker->wilayah) {
                    case '1':
                        return "I";
                        break;
                    case '2':
                        return "II";
                        break;
                    case '3':
                        return "III";
                        break;
                    case '4':
                        return "IV";
                        break;        
                    default:
                        return "I";
                        break;
                }
            })
            ->addColumn('action', function ($user) {
              if(auth()->user()->can('edit_pengguna','delete_pengguna')){
                return '<a class="btn btn-success btn-sm btn-icon waves-effect waves-themed" href="'.route('pengguna.edit',$user->uuid).'"><i class="fal fa-edit"></i></a>
                <a class="btn btn-danger btn-sm btn-icon waves-effect waves-themed delete-btn" data-url="'.URL::route('pengguna.destroy',$user->uuid).'" data-id="'.$user->uuid.'" data-token="'.csrf_token().'" data-toggle="modal" data-target="#modal-delete"><i class="fal fa-trash-alt"></i></a>';
              }
              else{
                return '<a href="#" class="badge badge-secondary">Not Authorize to Perform Action</a>';
              }
            })
            ->removeColumn('id')
            ->removeColumn('uuid')
            ->make();
            }
            return view('pengguna.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('name','!=','superadmin')->pluck('name','name');
        $satkers = Satker::all();
        $jabatans = Jabatan::all()->pluck('nama','id');
        return view('pengguna.create',compact('roles','satkers','jabatans'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|min:2',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required',
            'satker' => 'required',
            'jabatan' => 'required',
        ]);
        
        // get last urutan jabatan ppk
        $lastValue = DB::table('users')->select('jabatan_urutan')
                    ->where('satker_id', '=', $request->satker)
                    ->where('jabatan_id', '=', '2')
                    ->orderBy('jabatan_urutan','desc')
                    ->first();
        // retrieve password
        $password = trim($request->password);
        // Save
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($password);
        $user->jabatan_id = $request->jabatan;
        $user->satker_id = $request->satker;
        // only save urutan jabatan for PPK only
        if ($request->jabatan == "2") {
            if (empty($lastValue)) {
                $user->jabatan_urutan = $lastValue + 1;   
            }
            else{
                $user->jabatan_urutan = $lastValue->jabatan_urutan + 1;
            }
        }
        $user->save();
        // assign role to user
        if($request->get('role')) {
            $user->assignRole($request->get('role'));
        }
        toastr()->success('New Pengguna Added','Success');
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        $roles = Role::all()->pluck('name','name');
        $user = User::uuid($uuid);
        $satkers = Satker::all();
        $jabatans = Jabatan::all()->pluck('nama','id');
        // dd($user->jabatan);
        return view('pengguna.edit', compact('roles','user','jabatans','satkers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
        // Validation
        $this->validate($request,[
            'name' => 'required|min:2',
            'email' => 'required|email|unique:users,email,'.$uuid.',uuid',
            'role' => 'required',
            'satker' => 'required',
            'jabatan' => 'required',
        ]);

        // Saving data
        $user = User::uuid($uuid);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->jabatan_id = $request->jabatan;
        $user->satker_id = $request->satker;
        // Check password change
        if($request->get('password')) {
            $this->validate($request,[
            'password' => 'required|min:8'
            ]);
            // retrieve password
            $password = trim($request->password);
            $user->password = Hash::make($password);
        }
        $user->save();
        // sync role to user if any roles changed
        if($request->get('role')) {
            $user->syncRoles([$request->get('role')]);
        }

        toastr()->success('Pengguna Edited','Success');
        return redirect()->route('pengguna.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        $user = User::uuid($uuid);
        // remove assigned role
        $user->syncRoles([]);
        // delete user
        $user->delete();
  
        toastr()->success('Pengguna Deleted','Success');
        return redirect()->route('pengguna.index');
    }
}
