<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\Authorizable;

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

class SatkerController extends Controller
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
            $data = Satker::select([DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id','uuid','nama','wilayah','created_by','edited_by'])->get();

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                    if(auth()->user()->can('edit','delete')){
                        return '
                        <a class="btn btn-success btn-sm btn-icon waves-effect waves-themed" href="'.route('satker.edit',$row->uuid).'"><i class="fal fa-edit"></i></a>
                        <a class="btn btn-danger btn-sm btn-icon waves-effect waves-themed delete-btn" data-url="'.URL::route('satker.destroy',$row->uuid).'" data-id="'.$row->uuid.'" data-token="'.csrf_token().'" data-toggle="modal" data-target="#modal-delete"><i class="fal fa-trash-alt"></i></a>';
                    }else{
                        return '<a href="#" class="badge badge-secondary">Not Authorize to Perform Action</a>';
                    }
                 })
            ->removeColumn('id')
            ->removeColumn('uuid')
            ->rawColumns(['action'])
            ->make(true);
     }
   
     return view('satker.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('satker.create');
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
            'nama' => 'required',
            'wilayah' => 'required',
        ]);

        $satker = new Satker();
        $satker->nama = $request->nama;
        $satker->wilayah = $request->wilayah;
        $satker->created_by = Auth::user()->uuid;

        $satker->save();        

        
        toastr()->success('New Satker Added','Success');
        return redirect()->route('satker.index');
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
      $satker = Satker::find($id);
      return view('satker.edit', compact('satker'));
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
        // dd(request()->all());
        // Validation
      $this->validate($request,[
        'nama' => 'required',
        'wilayah' => 'required',
      ]);
      // Saving data
      $satker = Satker::uuid($id);
      $satker->nama = $request->nama;
      $satker->wilayah = $request->wilayah;
      $satker->edited_by = Auth::user()->uuid;

      $satker->save();

      toastr()->success('Satker Edited','Success');
      return redirect()->route('satker.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // dd('sdadas');
        $satker = Satker::uuid($id);
        $satker->delete();
     
        toastr()->success('Satker Deleted','Success');
        return redirect()->route('satker.index');
    }
}
