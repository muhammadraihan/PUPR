<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\Authorizable;

use App\DataKontrak;
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

class KontrakController extends Controller
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
            $contract = DataKontrak::select([DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id','uuid','pekerjaan_id','pagu','nilai_kontrak','panjang_jalan','panjang_jembatan','tahun_anggaran','tanggal_kontrak_awal','tanggal_adendum_kontrak','tanggal_adendum_akhir','tanggal_pho','tanggal_fho','data_teknis','created_by','edited_by']);
    
            return DataTables::of($contract)
            ->editColumn('pekerjaan_id', function($contract){
                return $contract->pekerjaan->title;
            })
            ->addColumn('action', function ($contracts) {
              if(auth()->user()->can('edit_kontrak','delete_kontrak')){
                return '<a class="btn btn-success btn-sm btn-icon waves-effect waves-themed" href="'.route('kontrak.edit',$contracts->uuid).'"><i class="fal fa-edit"></i></a>
                <a class="btn btn-danger btn-sm btn-icon waves-effect waves-themed delete-btn" data-url="'.URL::route('kontrak.destroy',$contracts->uuid).'" data-id="'.$contracts->uuid.'" data-token="'.csrf_token().'" data-toggle="modal" data-target="#modal-delete"><i class="fal fa-trash-alt"></i></a>';
              }
              else{
                return '<a href="#" class="badge badge-secondary">Not Authorize to Perform Action</a>';
              }
            })
            ->removeColumn('id')
            ->removeColumn('uuid')
            ->make();
        }
            return view('kontrak.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pekerjaan = Pekerjaan::all();
        return view('kontrak.create',compact('pekerjaan'));
    }

    public function getForm(Request $request)
    {
        $pekerjaan = Pekerjaan::uuid($request['param']);
        return view('kontrak.formComponent',compact('pekerjaan'));
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
        $rules = [
            'pekerjaan_id' => 'required',
            'pagu' => 'required',
            'nilai_kontrak' => 'required',
            // 'panjang_jalan' => 'required',
            // 'panjang_jembatan' => 'required',
            'tahun_anggaran' => 'required',
            'tanggal_kontrak_awal' => 'required',
            'tanggal_adendum_kontrak' => 'required',
            'tanggal_adendum_akhir' => 'required',
            'tanggal_pho' => 'required',
            'tanggal_fho' => 'required',
            'data_teknis' => 'required',
          ];

        $messages = [
            '*.required' => 'Data Tidak boleh kosong',
        ];

        $this->validate($request, $rules, $messages);
          
          // Save
          $kontrak = new DataKontrak();
          $kontrak->pekerjaan_id = $request->pekerjaan_id;
          $kontrak->pagu = $request->pagu;
          $kontrak->nilai_kontrak = $request->nilai_kontrak;
          $kontrak->panjang_jalan = $request->panjang_jalan;
          $kontrak->panjang_jembatan = $request->panjang_jembatan;
          $kontrak->tahun_anggaran = $request->tahun_anggaran;
          $kontrak->tanggal_kontrak_awal = Carbon::parse($request->tanggal_kontrak_awal)->format('Y-m-d');
          $kontrak->tanggal_adendum_kontrak = Carbon::parse($request->tanggal_adendum_kontrak)->format('Y-m-d');
          $kontrak->tanggal_adendum_akhir = Carbon::parse($request->tanggal_adendum_akhir)->format('Y-m-d');
          $kontrak->tanggal_pho = Carbon::parse($request->tanggal_pho)->format('Y-m-d');
          $kontrak->tanggal_fho = Carbon::parse($request->tanggal_fho)->format('Y-m-d');
          $kontrak->data_teknis = $request->data_teknis;
          $kontrak->created_by = Auth::user()->uuid;
          $kontrak->save();
    
          toastr()->success('New Kontrak Added','Success');
          return redirect()->route('kontrak.index');
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
        $kontrak = DataKontrak::uuid($id);
        return view('kontrak.edit',compact('kontrak'));
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
        $rules = [
            'pekerjaan_id' => 'required',
            'pagu' => 'required',
            'nilai_kontrak' => 'required',
            // 'panjang_jalan' => 'required',
            // 'panjang_jembatan' => 'required',
            'tahun_anggaran' => 'required',
            'tanggal_kontrak_awal' => 'required',
            'tanggal_adendum_kontrak' => 'required',
            'tanggal_adendum_akhir' => 'required',
            'tanggal_pho' => 'required',
            'tanggal_fho' => 'required',
            'data_teknis' => 'required',
          ];
        $messages = [
            '*.required' => 'Data Tidak Boleh Kosong',
        ];

        $this->validate($request, $rules, $messages);
          
          // Save
          $kontrak = DataKontrak::uuid($id);
          $kontrak->pekerjaan_id = $request->pekerjaan_id;
          $kontrak->pagu = $request->pagu;
          $kontrak->nilai_kontrak = $request->nilai_kontrak;
          $kontrak->panjang_jalan = $request->panjang_jalan;
          $kontrak->panjang_jembatan = $request->panjang_jembatan;
          $kontrak->tahun_anggaran = $request->tahun_anggaran;
          $kontrak->tanggal_kontrak_awal = Carbon::parse($request->tanggal_kontrak_awal)->format('Y-m-d');
          $kontrak->tanggal_adendum_kontrak = Carbon::parse($request->tanggal_adendum_kontrak)->format('Y-m-d');
          $kontrak->tanggal_adendum_akhir = Carbon::parse($request->tanggal_adendum_akhir)->format('Y-m-d');
          $kontrak->tanggal_pho = Carbon::parse($request->tanggal_pho)->format('Y-m-d');
          $kontrak->tanggal_fho = Carbon::parse($request->tanggal_fho)->format('Y-m-d');
          $kontrak->data_teknis = $request->data_teknis;
          $kontrak->edited_by = Auth::user()->uuid;
          $kontrak->save();
    
          toastr()->success('Kontrak Edited','Success');
          return redirect()->route('kontrak.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kontrak = DataKontrak::uuid($id);
        $kontrak->delete();

        toastr()->success('Kontrak Deleted','Success');
        return redirect()->route('kontrak.index');
    }
}
