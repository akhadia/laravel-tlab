<?php

namespace Modules\API\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Master\Entities\Bahan;

class BahanController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $bahan = Bahan::all();

        return response()->json($bahan, 200);    }

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

        $id_bahan = $all_data['id_bahan'];
        $nama_bahan =  $all_data['nama_bahan'];
        $old_nama_bahan =  $all_data['old_nama_bahan'];

        if(strtoupper($nama_bahan ) != strtoupper($old_nama_bahan )){
            //cek tabel bahan
            $bahan = Bahan::where(DB::raw('upper(nama)'), 'LIKE', "%$nama_bahan%")->first();
            if($bahan){
                $id_bahan = $bahan->id;
            }else{
                //create bahan
                $data_bahan = array('nama' =>  $nama_bahan);

                $act = Bahan::create($data_bahan);
                $id_bahan = $act->id;
            }
        }

        $data_bahan = array(
                            'nama' => $all_data['nama_bahan'],
                            'id_bahan' =>  $id_bahan,
                        );

        $act=Bahan::create($data_bahan);

        return response()->json($act, 201);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($id)
    {
        $bahan = Bahan::find($id);

        return response()->json($bahan, 200);
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
     
        $id_bahan = $all_data['id_bahan'];
        $nama_bahan =  $all_data['nama_bahan'];
        $old_nama_bahan =  $all_data['old_nama_bahan'];

        if(strtoupper($nama_bahan ) != strtoupper($old_nama_bahan )){
            //cek tabel bahan
            $bahan = Bahan::where(DB::raw('upper(nama)'), 'LIKE', "%$nama_bahan%")->first();
            if($bahan){
                $id_bahan = $bahan->id;
            }else{
                //create bahan
                $data_bahan = array('nama' =>  $nama_bahan);

                $act = Bahan::create($data_bahan);
                $id_bahan = $act->id;
            }
        }

        $data_bahan = array(
                'nama' =>  $all_data['nama_bahan'],
                'id_bahan' =>  $id_bahan,
                'aktif' =>  $all_data['status'],
            );

        $update_bahan = Bahan::findOrFail($id);
        $act = $update_bahan->update($data_bahan);

        return response()->json($act, 200);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function delete(Request $request, $id)
    {
        $bahan = Bahan::findOrFail($id);

        $act=false;
        DB::beginTransaction();
        try {
            $act= $bahan->forceDelete();
        }catch (Exception $e) {
            DB::rollBack();
        }
        DB::commit();

        return response()->json($act, 204);
    }
}
