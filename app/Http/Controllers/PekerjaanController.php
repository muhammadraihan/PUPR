<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\Authorizable;

use App\Pekerjaan;
use App\JenisPekerjaan;
use App\Satker;
use Carbon\Carbon;

use Auth;
use DataTables;
use DB;
use File;
use Hash;
use Image;
use Response;
use URL;

class PekerjaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // use Authorizable;

    public function index()
    {
        if (request()->ajax()) {
            DB::statement(DB::raw('set @rownum=0'));
            $data = Pekerjaan::select([DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id','uuid','title','jenis_pekerjaan','satker_id','tahun_mulai','tahun_selesai','created_by','edited_by']);

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('jenis_pekerjaan',function($row){
                        return $row->jenker->nama;
                    })
                    ->editColumn('satker_id',function($row){
                        return $row->satker->wilayah;
                    })
                    ->editColumn('created_by',function($row){
                        return $row->userCreate->name;
                    })
                    ->editColumn('edited_by',function($row){
                        if($row->edited_by != null){
                        return $row->userEdit->name;
                        }else{
                            return null;
                        }
                    })
                    ->addColumn('action', function($row){
                        // if(auth()->user()->can('edit','delete')){
                            return '<a class="btn btn-success btn-sm btn-icon waves-effect waves-themed" href="'.route('pekerjaan.edit',$row->uuid).'"><i class="fal fa-edit"></i></a>
                                    <a class="btn btn-danger btn-sm btn-icon waves-effect waves-themed delete-btn" data-url="'.URL::route('pekerjaan.destroy',$row->uuid).'" data-id="'.$row->uuid.'" data-token="'.csrf_token().'" data-toggle="modal" data-target="#modal-delete"><i class="fal fa-trash-alt"></i></a>';
                        // }
                        // else{
                        //     return '<a href="#" class="badge badge-secondary">Not Authorize to Perform Action</a>';
                        // }   
                 })
                 ->removeColumn('id')
                 ->removeColumn('uuid')
                 ->rawColumns(['action'])
                 ->make(true);
     }
   
     return view('pekerjaan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jenkers = JenisPekerjaan::all()->pluck('nama','uuid');
        $satkers = Satker::all()->pluck('wilayah','uuid');
        return view('pekerjaan.create',compact('jenkers','satkers'));
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
            'title' => 'required',
            'jenis_pekerjaan' => 'required',
            'satker_id' => 'required',
            'tahun_mulai' => 'required',
            'tahun_selesai' => 'required',
        ];

        $messages = [
            '*.required' => 'Field tidak boleh kosong !',
        ];

        $this->validate($request, $rules, $messages);

        $pekerjaan = new Pekerjaan();
        $pekerjaan->title = $request->title;
        $pekerjaan->jenis_pekerjaan = $request->jenis_pekerjaan;
        $pekerjaan->satker_id = $request->satker_id;
        $pekerjaan->tahun_mulai = $request->tahun_mulai;
        $pekerjaan->tahun_selesai = $request->tahun_selesai;
        $pekerjaan->created_by = Auth::user()->uuid;

        $pekerjaan->save();        

        
        toastr()->success('New pekerjaan Added','Success');
        return redirect()->route('pekerjaan.index');
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
        $jenkers = JenisPekerjaan::all()->pluck('nama','uuid');
        $satkers = Satker::all()->pluck('wilayah','uuid');
        $pekerjaan = Pekerjaan::uuid($id);
      
        return view('pekerjaan.edit', compact('pekerjaan','jenkers','satkers'));
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
            'title' => 'required',
            'jenis_pekerjaan' => 'required',
            'satker_id' => 'required',
            'tahun_mulai' => 'required',
            'tahun_selesai' => 'required',
        ];

        $messages = [
            '*.required' => 'Field tidak boleh kosong !',
        ];

        $this->validate($request, $rules, $messages);

          // Saving data
          $pekerjaan = Pekerjaan::uuid($id);
          $pekerjaan->title = $request->title;
          $pekerjaan->jenis_pekerjaan = $request->jenis_pekerjaan;
          $pekerjaan->satker_id = $request->satker_id;
          $pekerjaan->tahun_mulai = $request->tahun_mulai;
          $pekerjaan->tahun_selesai = $request->tahun_selesai;
          $pekerjaan->edited_by = Auth::user()->uuid;
    
          $pekerjaan->save();
    
          toastr()->success('Pekerjaan Edited','Success');
          return redirect()->route('pekerjaan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pekerjaan = Pekerjaan::uuid($id);
        $pekerjaan->delete();
        toastr()->success('Pekerjaan Deleted','Success');
        return redirect()->route('pekerjaan.index');
    }
}
