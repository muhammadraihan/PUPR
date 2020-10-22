<?php

namespace App\Http\Controllers;

use App\ProgresFisik;
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

use Illuminate\Http\Request;

class ProgresFisikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            DB::statement(DB::raw('set @rownum=0'));
            $fisiks = ProgresFisik::select([DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id','uuid','pekerjaan_id','nomor_pelaksanaan','tanggal_pelaksanaan','rencana','realisasi','deviasi','permasalahan','tindakan']);
            return DataTables::of($fisiks)
            ->editColumn('paket', function($fisik){
                return $fisik->pekerjaan->title;
            })
            ->addColumn('action', function ($fisik) {
                if(auth()->user()->can('edit_fisik','delete_fisik')){
                  return '
                  <a class="btn btn-dark btn-sm btn-icon waves-effect waves-themed" href="'.route('upload.form',$fisik->uuid).'"><i class="fal fa-camera-retro" data-toggle="tooltip" data-placement="top"
                  title="Upload Dokumentasi"></i></a>
                  <a class="btn btn-success btn-sm btn-icon waves-effect waves-themed" href="'.route('fisik.edit',$fisik->uuid).'"><i class="fal fa-edit"></i></a>
                  <a class="btn btn-danger btn-sm btn-icon waves-effect waves-themed delete-btn" data-url="'.URL::route('fisik.destroy',$fisik->uuid).'" data-id="'.$fisik->uuid.'" data-token="'.csrf_token().'" data-toggle="modal" data-target="#modal-delete"><i class="fal fa-trash-alt"></i></a>
                  ';
                }
                else{
                  return '<a href="#" class="badge badge-secondary">Not Authorize to Perform Action</a>';
                }
              })
              ->removeColumn('id')
              ->removeColumn('uuid')
              ->make();
        }
        return view('fisiks.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pekerjaans = Pekerjaan::all()->pluck('title','id');
        return view('fisiks.create',compact('pekerjaans'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        //validation
        $rules = [
            'pekerjaan' => 'required',
            'urutan' => 'required|numeric',
            'tanggal' => 'required',
            'rencana' => 'required|numeric|between:0,100',
            'realisasi' => 'required|numeric|between:0,100',
            'deviasi' => 'required|numeric|between:0,100',
        ];
        $messages = [
            '*.required' => 'Tidak boleh kosong',
            '*.numeric' => 'Isisan harus angka',
            '*.between' => 'Isian tidak boleh lebih dari 100%',
        ];
        $this->validate($request, $rules, $messages);

        $fisik = new ProgresFisik;
        $fisik->pekerjaan_id = $request->pekerjaan;
        $fisik->nomor_pelaksanaan = $request->urutan;
        $fisik->tanggal_pelaksanaan = $request->tanggal;
        $fisik->rencana = $request->rencana;
        $fisik->realisasi = $request->realisasi;
        $fisik->deviasi = $request->deviasi;
        $fisik->permasalahan = $request->permasalahan;
        $fisik->tindakan = $request->tindakan;
        $fisik->created_by = Auth::user()->uuid;
        $fisik->save();

        toastr()->success('Pelaksanaan Fisik Added','Success');
        return redirect()->route('fisik.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProgresFisik  $progresFisik
     * @return \Illuminate\Http\Response
     */
    public function show(ProgresFisik $progresFisik)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProgresFisik  $progresFisik
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        $pekerjaans = Pekerjaan::all()->pluck('title','id');
        $fisik = ProgresFisik::uuid($uuid);
        // dd($fisik->pekerjaan->title);
        return view('fisiks.edit',compact('fisik','pekerjaans'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProgresFisik  $progresFisik
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
         //validation
         $rules = [
            'pekerjaan' => 'required',
            'urutan' => 'required|numeric',
            'tanggal' => 'required',
            'rencana' => 'required|numeric|between:0,100',
            'realisasi' => 'required|numeric|between:0,100',
            'deviasi' => 'required|numeric|between:0,100',
        ];
        $messages = [
            '*.required' => 'Tidak boleh kosong',
            '*.numeric' => 'Isisan harus angka',
            '*.between' => 'Isian tidak boleh lebih dari 100%',
        ];
        $this->validate($request, $rules, $messages);

        $fisik = ProgresFisik::uuid($uuid);
        $fisik->pekerjaan_id = $request->pekerjaan;
        $fisik->nomor_pelaksanaan = $request->urutan;
        $fisik->tanggal_pelaksanaan = $request->tanggal;
        $fisik->rencana = $request->rencana;
        $fisik->realisasi = $request->realisasi;
        $fisik->deviasi = $request->deviasi;
        $fisik->permasalahan = $request->permasalahan;
        $fisik->tindakan = $request->tindakan;
        $fisik->edited_by = Auth::user()->uuid;
        $fisik->save();

        toastr()->success('Pelaksanaan Fisik Edited','Success');
        return redirect()->route('fisiks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProgresFisik  $progresFisik
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        $fisik = ProgresFisik::uuid($uuid);
        $fisik->delete();

        toastr()->success('Pelaksanaan Fisik Delete','Success');
        return redirect()->route('fisiks.index');
    }

    /**
     * Show form for upload dokumentasi fisik
     *
     * @param uuid $uuid
     * @return void
     */
    public function getUpload($uuid)
    {
        $fisik = ProgresFisik::uuid($uuid);
        return view('fisiks.upload',compact('fisik'));
    }

    public function uploadImages()
    {
        # code...
    }
}
