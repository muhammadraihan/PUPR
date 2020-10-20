<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\Authorizable;

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

class JabatanController extends Controller
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
            $data = Jabatan::select([DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id','uuid','nama','created_by','edited_by'])->get();

            return Datatables::of($data)
                    ->addIndexColumn()
                    // ->addColumn('action', function ($data) {
                    //       return '<a class="btn btn-success btn-sm btn-icon waves-effect waves-themed" href="'.route('ajaxproducts.edit',$data->id).'"><i class="fal fa-edit"></i></a>
                    //       <a class="btn btn-danger btn-sm btn-icon waves-effect waves-themed" data-url="'.URL::route('ajaxproducts.destroy',$data->id).'" data-id="'.$data->id.'"  data-toggle="modal" data-target="#modal-delete"><i class="fal fa-trash-alt"></i></a>';
                    //   })
                    ->addColumn('action', function($row){
                        // if(auth()->user()->can('edit','delete')){
                            return '<a class="btn btn-success btn-sm btn-icon waves-effect waves-themed" href="'.route('jabatan.edit',$row->uuid).'"><i class="fal fa-edit"></i></a>
                                    <a class="btn btn-danger btn-sm btn-icon waves-effect waves-themed delete-btn" data-url="'.URL::route('jabatan.destroy',$row->uuid).'" data-id="'.$row->uuid.'" data-token="'.csrf_token().'" data-toggle="modal" data-target="#modal-delete"><i class="fal fa-trash-alt"></i></a>';
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

        return view('jabatan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('jabatan.create');
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
        ]);

        $jabatan = new Jabatan();
        $jabatan->nama = $request->nama;
        $jabatan->created_by = Auth::user()->uuid;

        $jabatan->save();        

        
        toastr()->success('New Jabatan Added','Success');
        return redirect()->route('jabatan.index');
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
        $jabatan = Jabatan::uuid($id);
      // dd($user->roles[0]['name']);
      return view('jabatan.edit', compact('jabatan'));
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
        $this->validate($request,[
            'nama' => 'required|min:3',
          ]);
          // Saving data
          $jabatan = Jabatan::uuid($id);
          $jabatan->nama = $request->nama;
          $jabatan->edited_by = Auth::user()->uuid;
    
          $jabatan->save();
    
          toastr()->success('jabatan Edited','Success');
          return redirect()->route('jabatan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jabatan = Jabatan::uuid($id)->delete();
         return redirect()->route('jabatan.index');
    }
}
