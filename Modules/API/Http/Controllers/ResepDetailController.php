<?php

namespace Modules\API\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Master\Entities\Resep;
use Modules\Master\Entities\ResepDetail;
use Modules\Master\Entities\Kategori;
use Modules\Master\Entities\Satuan;
use Modules\Master\Entities\Bahan;

class ResepDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        // $selected_field = 'resep_detail.id, resep_detail.id_resep, resep_detail.qty_bahan,
        //             b.id as id_bahan, b.nama as nama_bahan,
        //             s.id as id_satuan, s.nama as nama_satuan';

        // $resep = ResepDetail::select(\DB::raw($selected_field))
        //         ->leftjoin('bahan as b','b.id','=','resep_detail.id_bahan')
        //         ->leftjoin('satuan as s','s.id','=','resep_detail.id_satuan')
        //         ->get();

        // return response()->json($resep, 200);
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
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($id)
    {
        $selected_field =   'resep_detail.id, resep_detail.id_resep, resep_detail.qty_bahan,
                            b.id as id_bahan, b.nama as nama_bahan,
                            s.id as id_satuan, s.nama as nama_satuan';

        $resep_detail = ResepDetail::select(\DB::raw($selected_field))
                    ->leftjoin('bahan as b','b.id','=','resep_detail.id_bahan')
                    ->leftjoin('satuan as s','s.id','=','resep_detail.id_satuan')
                    ->where('resep_detail.id_resep', $id)
                    ->get();

        return response()->json($resep_detail, 200);
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
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
