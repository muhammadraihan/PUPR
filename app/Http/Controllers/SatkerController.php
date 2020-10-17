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
    public function index(Request $request)
    {
        $satker = Satker::all();
        if ($request->ajax()) {
            $data = Satker::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    // ->addColumn('action', function ($data) {
                    //       return '<a class="btn btn-success btn-sm btn-icon waves-effect waves-themed" href="'.route('ajaxproducts.edit',$data->id).'"><i class="fal fa-edit"></i></a>
                    //       <a class="btn btn-danger btn-sm btn-icon waves-effect waves-themed" data-url="'.URL::route('ajaxproducts.destroy',$data->id).'" data-id="'.$data->id.'"  data-toggle="modal" data-target="#modal-delete"><i class="fal fa-trash-alt"></i></a>';
                    //   })
                    ->addColumn('action', function($row){

                        return '<a class="btn btn-success btn-sm btn-icon waves-effect waves-themed" href="'.route('satker.edit',$row->id).'" data-id="'.$row->id.'"><i class="fal fa-edit"></i></a>
                        
                        <a class="btn btn-danger btn-sm btn-icon waves-effect waves-themed delete-btn" data-url="'.URL::route('satker.destroy',$row->id).'" data-id="'.$row->id.'" data-token="'.csrf_token().'" data-toggle="modal" data-target="#modal-delete"><i class="fal fa-trash-alt"></i></a>';
                        
                 })
                 ->rawColumns(['action'])
                 ->make(true);
     }
   
     return view('satker.index',compact('satker'));
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
        Satker::updateOrCreate(['id' => $request->id],
        ['nama' => $request->nama, 'wilayah' => $request->wilayah, 'created_by' => Auth::user()->uuid]);        

        
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
      // dd($user->roles[0]['name']);
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
        'nama' => 'required|min:3',
        'wilayah' => 'required|min:10',
        'edited by' => 'required|min:3',
      ]);
      // Saving data
      $satker = Satker::find($id);
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
        $satker = Satker::find($id)->delete();
     
        // return response()->json(['success'=>'Product deleted successfully.']);
        // return view('productAjax');
         return redirect()->route('satker.index');
    }
}
