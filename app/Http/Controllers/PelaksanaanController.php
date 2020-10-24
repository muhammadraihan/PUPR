<?php

namespace App\Http\Controllers;

use App\Pelaksanaan;
use App\Pekerjaan;

use Illuminate\Http\Request;

use App\Traits\Authorizable;

use Carbon\Carbon;

use Auth;
use DataTables;
use DB;
use File;
use Hash;
use Image;
use Response;
use URL;

class PelaksanaanController extends Controller
{
    // authorizable
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
            $pelaksanaans = Pelaksanaan::select([DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id','uuid','pekerjaan_id','nomor_pelaksanaan','tanggal_pelaksanaan','rencana_fisik','realisasi_fisik','deviasi_fisik','rencana_keuangan','realisasi_keuangan','deviasi_keuangan','permasalahan','tindakan']);
            return DataTables::of($pelaksanaans)
            ->editColumn('paket', function($pelaksanaan){
                return $pelaksanaan->pekerjaan->title;
            })
            ->addColumn('action', function ($pelaksanaan) {
                if(auth()->user()->can('edit_pelaksanaan','delete_pelaksanaan')){
                  return '
                  <a class="btn btn-dark btn-sm btn-icon waves-effect waves-themed" href="'.route('pelaksanaan.dokumentasi',$pelaksanaan->uuid).'"><i class="fal fa-camera-retro" data-toggle="tooltip" data-placement="top"
                  title="Upload Dokumentasi"></i></a>
                  <a class="btn btn-success btn-sm btn-icon waves-effect waves-themed" href="'.route('pelaksanaan.edit',$pelaksanaan->uuid).'"><i class="fal fa-edit"></i></a>
                  <a class="btn btn-danger btn-sm btn-icon waves-effect waves-themed delete-btn" data-url="'.URL::route('pelaksanaan.destroy',$pelaksanaan->uuid).'" data-id="'.$pelaksanaan->uuid.'" data-token="'.csrf_token().'" data-toggle="modal" data-target="#modal-delete"><i class="fal fa-trash-alt"></i></a>
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
        return view('pelaksanaan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pekerjaans = Pekerjaan::all()->pluck('title','id');
        return view('pelaksanaan.create',compact('pekerjaans'));
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
            'rencana_fisik' => 'required|numeric|between:0,100',
            'realisasi_fisik' => 'required|numeric|between:0,100',
            'deviasi_fisik' => 'required|numeric|between:0,100',
            'rencana_keuangan' => 'required|numeric|between:0,100',
            'realisasi_keuangan' => 'required|numeric|between:0,100',
            'deviasi_keuangan' => 'required|numeric|between:0,100',
        ];
        $messages = [
            '*.required' => 'Tidak boleh kosong',
            '*.numeric' => 'Isisan harus angka',
            '*.between' => 'Isian tidak boleh lebih dari 100%',
        ];
        $this->validate($request, $rules, $messages);

        $pelaksanaan = new Pelaksanaan;
        $pelaksanaan->pekerjaan_id = $request->pekerjaan;
        $pelaksanaan->nomor_pelaksanaan = $request->urutan;
        $pelaksanaan->tanggal_pelaksanaan = $request->tanggal;
        $pelaksanaan->rencana_fisik = $request->rencana_fisik;
        $pelaksanaan->realisasi_fisik = $request->realisasi_fisik;
        $pelaksanaan->deviasi_fisik = $request->deviasi_fisik;
        $pelaksanaan->rencana_keuangan = $request->rencana_keuangan;
        $pelaksanaan->realisasi_keuangan = $request->realisasi_keuangan;
        $pelaksanaan->deviasi_keuangan = $request->deviasi_keuangan;
        $pelaksanaan->permasalahan = $request->permasalahan;
        $pelaksanaan->tindakan = $request->tindakan;
        $pelaksanaan->created_by = Auth::user()->uuid;
        $pelaksanaan->save();

        toastr()->success('Pelaksanaan Added','Success');
        return redirect()->route('pelaksanaan.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pelaksanaan  $Pelaksanaan
     * @return \Illuminate\Http\Response
     */
    public function show(Pelaksanaan $Pelaksanaan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pelaksanaan  $Pelaksanaan
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        $pekerjaans = Pekerjaan::all()->pluck('title','id');
        $pelaksanaan = Pelaksanaan::uuid($uuid);
        // dd($pelaksanaan->pekerjaan->title);
        return view('pelaksanaan.edit',compact('pelaksanaan','pekerjaans'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pelaksanaan  $Pelaksanaan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
         //validation
         $rules = [
            'pekerjaan' => 'required',
            'urutan' => 'required|numeric',
            'tanggal' => 'required',
            'rencana_fisik' => 'required|numeric|between:0,100',
            'realisasi_fisik' => 'required|numeric|between:0,100',
            'deviasi_fisik' => 'required|numeric|between:0,100',
            'rencana_keuangan' => 'required|numeric|between:0,100',
            'realisasi_keuangan' => 'required|numeric|between:0,100',
            'deviasi_keuangan' => 'required|numeric|between:0,100',
        ];
        $messages = [
            '*.required' => 'Tidak boleh kosong',
            '*.numeric' => 'Isisan harus angka',
            '*.between' => 'Isian tidak boleh lebih dari 100%',
        ];
        $this->validate($request, $rules, $messages);

        $pelaksanaan = Pelaksanaan::uuid($uuid);
        $pelaksanaan->pekerjaan_id = $request->pekerjaan;
        $pelaksanaan->nomor_pelaksanaan = $request->urutan;
        $pelaksanaan->tanggal_pelaksanaan = $request->tanggal;
        $pelaksanaan->rencana_fisik = $request->rencana_fisik;
        $pelaksanaan->realisasi_fisik = $request->realisasi_fisik;
        $pelaksanaan->deviasi_fisik = $request->deviasi_fisik;
        $pelaksanaan->rencana_keuangan = $request->rencana_keuangan;
        $pelaksanaan->realisasi_keuangan = $request->realisasi_keuangan;
        $pelaksanaan->deviasi_keuangan = $request->deviasi_keuangan;
        $pelaksanaan->permasalahan = $request->permasalahan;
        $pelaksanaan->tindakan = $request->tindakan;
        $pelaksanaan->edited_by = Auth::user()->uuid;
        $pelaksanaan->save();

        toastr()->success('Pelaksanaan Edited','Success');
        return redirect()->route('pelaksanaan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pelaksanaan  $Pelaksanaan
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        $pelaksanaan = Pelaksanaan::uuid($uuid);
        $pelaksanaan->delete();

        toastr()->success('Pelaksanaan Delete','Success');
        return redirect()->route('pelaksanaan.index');
    }

    /**
     * Show form for upload dokumentasi fisik
     *
     * @param uuid $uuid
     * @return void
     */
    public function getUpload($uuid)
    {
        $pelaksanaan = Pelaksanaan::uuid($uuid);
        return view('pelaksanaan.upload',compact('pelaksanaan'));
    }

    public function uploadImages()
    {
        # code...
    }
}
