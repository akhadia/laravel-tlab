<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Master\Entities\Satuan;

class SatuanController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $satuan = Satuan::all();

        return $satuan ;

    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('api::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $all_data = $request->all(); 

        $data_satuan = array('nama' => $all_data['nama_satuan']);

        $act = Satuan::create($data_satuan); 

        return response()->json($act, 201);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($id)
    {
        $satuan = Satuan::find($id);

        return $satuan ;
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('api::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $all_data = $request->all(); 

        $data_satuan = array(
                'nama' =>  $all_data['nama_satuan'],
                'aktif' =>  $all_data['status'],
            );

        $update_satuan = Satuan::findOrFail($id);
        $act = $update_satuan->update($data_satuan);

        return response()->json($act, 200);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function delete(Request $request, $id)
    {
        $satuan = Satuan::findOrFail($id);

        $act=false;
        DB::beginTransaction();
        try {
            $act= $satuan->forceDelete();
        }catch (Exception $e) {
            DB::rollBack();
        }
        DB::commit();

        return response()->json($act, 204);
    }
}
