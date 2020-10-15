<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\Authorizable;

use App\pembebasanLahan;
use Carbon\Carbon;

use Auth;
use DataTables;
use DB;
use File;
use Hash;
use Image;
use Response;
use URL;

class PembebasanLahanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use Authorizable;
    
    public function index()
    {
        if (request()->ajax()) {
            DB::statement(DB::raw('set @rownum=0'));
            $lahan = pembebasanLahan::select([DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'pekerjaan_id','kebutuhan','sudah_bebas','belum_bebas','dokumentasi_id','permasalahan','tindak_lanjut','created_by','edited_by'])->get();
    
            return DataTables::of($lahan)
            ->addColumn('action', function ($lahans) {
              if(auth()->user()->can('edit_kontrak','delete_kontrak')){
                return '<a class="btn btn-success btn-sm btn-icon waves-effect waves-themed" href="'.route('lahan.edit',$lahans->uuid).'"><i class="fal fa-edit"></i></a>
                <a class="btn btn-danger btn-sm btn-icon waves-effect waves-themed delete-btn" data-url="'.URL::route('lahan.destroy',$lahans->uuid).'" data-id="'.$lahans->uuid.'" data-token="'.csrf_token().'" data-toggle="modal" data-target="#modal-delete"><i class="fal fa-trash-alt"></i></a>';
              }
              else{
                return '<a href="#" class="badge badge-secondary">Not Authorize to Perform Action</a>';
              }
            })
            ->removeColumn('id')
            ->removeColumn('uuid')
            ->make();
        }
            return view('lahan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('lahan.create');
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
        //
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
