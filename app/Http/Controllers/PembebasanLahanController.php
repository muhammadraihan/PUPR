<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Traits\Authorizable;

use App\PembebasanLahan;
use App\Pekerjaan;
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
            $lahan = PembebasanLahan::select([DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id','uuid','pekerjaan_id','kebutuhan','sudah_bebas','belum_bebas','dokumentasi_id','permasalahan','tindak_lanjut','created_by','edited_by'])->get();
    
            return DataTables::of($lahan)
            ->editColumn('pekerjaan_id', function($lahans){
                return $lahans->pekerjaan->title;
            })
            ->addColumn('action', function ($lahans) {
              if(auth()->user()->can('edit_lahan','delete_lahan')){
                return '
                <a class="btn btn-success btn-sm btn-icon waves-effect waves-themed" href="'.route('lahan.edit',$lahans->uuid).'"><i class="fal fa-edit"></i></a>
                <a class="btn btn-success btn-sm btn-icon waves-effect waves-themed" href="'.route('lahan.show',$lahans->uuid).'"><i class="fal fa-eye"></i></a>
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
        $pekerjaan = Pekerjaan::all();
        return view('lahan.create',compact('pekerjaan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'pekerjaan_id' => 'required',
            'kebutuhan' => 'required',
            'sudah_bebas' => 'required',
            'belum_bebas' => 'required',
            'permasalahan' => 'required',
            'tindak_lanjut' => 'required',
            'dokumentasi_id' => 'required|mimes:pdf,xlx,csv,img,png,jpg,jpeg|max:2048',
        ];

        $messages = [
            '*.required' => 'Data Harus Di isi',
            '*.mimes' => 'Type File Harus pdf',
            '*.max' => 'Size File Tidak Boleh Lebih Dari 2Mb'
        ];
        
        $this->validate($request, $rules, $messages);

        if($request->hasfile('dokumentasi_id')){
            $file = $request->file('dokumentasi_id');
            $filename = md5(uniqid(mt_rand(),true)).'.'.$file->getClientOriginalExtension();
            $path = Storage::putFileAs('public/pembebasanLahan/',$file,$filename);
        }
        
        $lahan = new PembebasanLahan();
        $lahan->pekerjaan_id = $request->pekerjaan_id;
        $lahan->kebutuhan = $request->kebutuhan;
        $lahan->sudah_bebas = $request->sudah_bebas;
        $lahan->belum_bebas = $request->belum_bebas;
        $lahan->permasalahan = $request->permasalahan;
        $lahan->tindak_lanjut = $request->tindak_lanjut;
        $lahan->dokumentasi_id = $filename;
        $lahan->created_by = Auth::user()->uuid;
        $lahan->save();

        toastr()->success('New Pembebasan Lahan Added', 'Success');
        return redirect()->route('lahan.index');
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
        $lahan = PembebasanLahan::uuid($id);
        $pekerjaan = Pekerjaan::all();
        return view('lahan.edit',compact('lahan','pekerjaan'));
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
        // dd($request->all());
        $rules = [
            'pekerjaan_id' => 'required',
            'kebutuhan' => 'required',
            'sudah_bebas' => 'required',
            'belum_bebas' => 'required',
            'permasalahan' => 'required',
            'tindak_lanjut' => 'required',
            'dokumentasi_id' => 'mimes:pdf,xlx,csv|max:2048',
        ];

        $messages = [
            '*.required' => 'Data Harus Di isi',
            '*.mimes' => 'Type File Harus pdf',
        ];

        $this->validate($request, $rules, $messages);

        if($request->hasfile('file')){
            $file = $request->file('file');
            $filename = md5(uniqid(mt_rand(),true)).'.'.$file->getClientOriginalExtension();
            $path = Storage::putFileAs('public/pembebasanLahan/',$file,$filename);
        }

        $lahan = PembebasanLahan::uuid($id);
        $lahan->pekerjaan_id = $request->pekerjaan_id;
        $lahan->kebutuhan = $request->kebutuhan;
        $lahan->sudah_bebas = $request->sudah_bebas;
        $lahan->belum_bebas = $request->belum_bebas;
        $lahan->permasalahan = $request->permasalahan;
        $lahan->tindak_lanjut = $request->tindak_lanjut;
        $lahan->dokumentasi_id = isset($filename) ? $filename : $lahan->dokumentasi_id;
        $lahan->edited_by = Auth::user()->uuid;
        $lahan->save();

        toastr()->success('Pembebasan Lahan Edited', 'Success');
        return redirect()->route('lahan.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lahan = PembebasanLahan::uuid($id);
        $lahan->delete();

        toastr()->success('Lahan Deleted','Success');
        return redirect()->route('lahan.index');
    }
}
