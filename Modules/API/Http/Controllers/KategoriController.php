<?php

namespace Modules\API\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Master\Entities\Kategori;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $kategori = Kategori::all();

        return response()->json($kategori, 200);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        // return view('api::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $all_data = $request->all(); 

        $data_kategori = array('nama' => $all_data['nama_kategori']);

        $act = Kategori::create($data_kategori); 

        return response()->json($act, 201);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($id)
    {
        $kategori = Kategori::find($id);

        return response()->json($kategori, 200);
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        // return view('api::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $all_data = $request->all(); 

        $data_kategori = array(
                'nama' =>  $all_data['nama_kategori'],
                'aktif' =>  $all_data['status'],
            );

        $update_kategori = Kategori::findOrFail($id);
        $act = $update_kategori->update($data_kategori);

        return response()->json($act, 200);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function delete(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $act=false;
        DB::beginTransaction();
        try {
            $act= $kategori->forceDelete();
        }catch (Exception $e) {
            DB::rollBack();
        }
        DB::commit();

        return response()->json($act, 204);
    }
}
