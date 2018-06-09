<?php

namespace Modules\Master\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

use Modules\Master\Entities\Bahan;
use Modules\Master\Entities\Satuan;

class AutocompleteController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     * @return Response
     */

    public function search($method,Request $request)
    {
        return $this->$method($request);
    }
     
    public function bahan($r)
    {
        $cari = strtoupper($r->get('q'));
        $query = Bahan::select('bahan.id as id_bahan','bahan.nama as nama_bahan', 'satuan.id as id_satuan', 'satuan.nama as nama_satuan')
                ->leftjoin('satuan','satuan.id','=','bahan.id_satuan')
                ->where(DB::raw('upper(bahan.nama)'), 'LIKE', "%$cari%")
                ->limit(20);

        $results=$query->get();

        return response()->json($results->toArray());
    }

}
