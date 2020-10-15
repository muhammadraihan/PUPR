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
        $this->validate($request, [
            'pekerjaan_id' => 'required',
            'kebutuhan' => 'required',
            'sudah_bebas' => 'required',
            'belum_bebas' => 'required',
            'permasalahan' => 'required',
            'tindak_lanjut' => 'required',
            'dokumentasi_id' => 'required|mimes:pdf,xlx,csv|max:2048',
        ]);

        $messages = [
            '*.required' => 'Data Harus Di isi',
            '*.mimes' => 'Type File Harus pdf',
            '*.max' => 'Size File Tidak Boleh Lebih Dari 2Mb'
        ];
        
            if($request->hasfile('dokumentasi_id')){
                $file = $request->file('dokumentasi_id');
                $filename = md5(uniqid(mt_rand(),true)).'.'.$file->getClientOriginalExtension();
                $path = Storage::putFileAs('public/pembebasanLahan/',$file,$filename);
            }
            $document = new pembebasanLahan();
            $document->nama = $request->nama;
            $document->no_document = $request->no_document;
            $document->jenis_dokumen_id = $request->jenis_dokumen_id;
            $document->edisi = $request->edisi;
            $document->revisi = $request->revisi;
            $document->efektif = Carbon::parse($request->efektif)->format('Y-m-d');
            $document->jumlah_halaman = $request->jumlah_halaman;
            $document->dokument = $filename;
            $document->siklus_id = $siklus->uuid;
            $document->gjm_id = $request->unit;
            $document->gkm_id = null;
            $document->role_id = $role->id;
            $document->created_by = Auth::user()->uuid;
            $document->save();

            // $gugus = new GugusTugas();
            // $gugus->user_id = Auth::user()->id;
            // $gugus->siklus_id = $siklus->id;
            // $gugus->gjm_id = isset(Auth::user()->gkm_id[0]) ? Auth::user()->gkm_id[0] : '0';
            // $gugus->gkm_id = isset(Auth::user()->gkm_id[0]) ? Auth::user()->gkm_id[0] : '0';
            // $gugus->is_upload = 1;
            // $gugus->is_skoring = 0;
            // $gugus->save();

            toastr()->success('New Document Added', 'Success');
            return redirect()->route('documents.index');
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
