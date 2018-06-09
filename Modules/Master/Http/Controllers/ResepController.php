<?php

namespace Modules\Master\Http\Controllers;

use Modules\Master\Entities\Resep;
use Modules\Master\Entities\ResepDetail;
use Modules\Master\Entities\Kategori;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

use Yajra\Datatables\Datatables;

use Carbon\Carbon;

class ResepController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('permission:resep-create');
        $this->middleware('permission:resep-update');
        $this->middleware('permission:resep-delete');
        
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('master::resep.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        // return view('master::create');
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
    public function show()
    {
        // return view('master::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        // return view('master::edit');
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


    public function loadDataResep(){

        $nama_resep = \Request::input('nama_resep');
        $status = \Request::input('status');

        $GLOBALS['nomor']=\Request::input('start',1)+1;

        $dataList = Resep::where(function ($q) use ($nama_resep, $status){
                if(!empty($nama_resep)){
                    $nama_resep = strtoupper($nama_resep );
                    $q->where(DB::raw('upper(nama)'), 'LIKE', "%$nama_resep%");
                } 
                if(!empty($status) && $status!='all'){
                    $status = strtoupper($status );
                    $q->where(DB::raw('upper(aktif)'), 'LIKE', "%$status%");
                } 
            })
            ->orderby('resep.id','desc')
            ->get();

        return Datatables::of($dataList)
            ->addColumn('nomor',function($dataList){
                return $GLOBALS['nomor']++;
            })

            ->addColumn('kategori',function($dataList){
                  if(isset($dataList->kategori->nama)){
                    return $dataList->kategori->nama;
                  }else{
                    return null;
                  }
            })

            ->addColumn('status', function ($dataList) {
                $content = '';
                if($dataList->aktif == 'Y'){
                     $content .= '<span class="label label-success">Aktif</span>';
                }else{
                    $content .= '<span class="label label-warning">Closed</span>';
                }
                return $content;
            })    
          
            ->addColumn('action', function ($dataList) {
                $content = '';
                $content .= '<a href="'.url("master/resep/".$dataList->id."/detailresep").'" class="btn btn-xs btn-info" target=""><i class="glyphicon glyphicon-edit"></i> Detail</a>';
                if($dataList->aktif == 'Y'){
                    $content .= '<button id="btn_tutup" class="btn btn-xs btn-warning status-resep" status="tutup" val="'.$dataList->id.'"><i class="glyphicon glyphicon-saved"></i> Close</button>';
                    // $content .= '<a href="'.url("master/resep/tutupresep/".$dataList->id).'" class="btn btn-xs btn-warning status-resep" status="tutup" target=""><i class="glyphicon glyphicon-saved"></i> Close</a>';
                }else{
                    $content .= '<button id="btn_buka" class="btn btn-xs btn-success status-resep" status="buka" val="'.$dataList->id.'"><i class="glyphicon glyphicon-open"></i> Open</button>';
                    // $content .= '<a href="'.url("master/resep/bukaresep/".$dataList->id).'" class="btn btn-xs btn-success status-resep" status="buka" target=""><i class="glyphicon glyphicon-open"></i> Open</a>';
                }
                
               
                return $content;
            })

            ->rawColumns(['status','action'])
            ->make(true);

    }

    public function createResep(){
        $resep = new Resep;
        $kategori = Kategori::all();
        // dd('oke');
        return view('master::resep.detail-resep',compact('resep','kategori'));
    }

    public function addResep(Request $request)
    {
        $all_data = $request->all();
        // dd($all_data );

        $data_resep = array(
                                "id_kategori" => $all_data['kategori'],
                                "nama" => $all_data['nama_resep'],
                                "deskripsi" => $all_data['deskripsi'],
                                
                            );
                            
        DB::beginTransaction();
        try {
            $act=Resep::create($data_resep);
            $id_resep = $act->id;
            $this->addDetailResep($all_data,$id_resep);
        }catch (Exception $e) {
            DB::rollBack();
        }
        DB::commit();

        return redirect('/master/resep');
    }

    function addDetailResep($all_data,$id_resep)
    {
        //cek delete
        if(isset($all_data["details_deleted"]) && !empty($all_data["details_deleted"]) )  {
          $this->deleteDetailResep($all_data);
        }

        //cek edit dan kalau ada data akan di edit
        if(isset($all_data["old_id_resep_bahan_edit"]) && !empty($all_data["old_id_resep_bahan_edit"])){
            $jumlah_edit    = count($all_data["old_id_resep_bahan_edit"]);
            if($jumlah_edit > 0){
                $this->editDetailResep($all_data);
            }
        }

        //add data detail resep
        if(isset($all_data["bahan_nama"]) && !empty($all_data["bahan_nama"]) )  {
          $this->insertDetailResep($all_data,$id_resep);
        }
    }

    //Fungsi insert data ke tabel resep detail
    function insertDetailResep($all_data,$id_resep){
        // dd($all_data);
        $jumlah = count($all_data["id_bahan"]);
        for($i=0;$i<$jumlah;$i++)  {
            if($all_data["id_bahan"][$i] !== '' && !empty($all_data["id_bahan"][$i])){
                  $bahan_data = array(
                      "id_resep" => $id_resep,
                      "id_bahan" => $all_data["id_bahan"][$i],
                      "qty_bahan" => $all_data["bahan_qty"][$i],
                      "id_satuan" => $all_data["id_satuan"][$i],
                  );

                  $insertDetailResep=ResepDetail::create($bahan_data);
            }
          }
    }

    public function detailResep(Request $request, $id_resep)
    {
        $resep = Resep::find($id_resep);
        $detailResep = ResepDetail::where('id_resep',$id_resep)->get();
        $kategori= Kategori::all();

        return view('master::resep.detail-resep',compact('resep','detailResep','kategori'));
    }

    //Fungsi tambah & edit data resep detail 
    public function addEditResep(Request $request, $id_resep)
    {
        $all_data = $request->all();
        // dd( $all_data );
        $data_resep = array(
                        "id_kategori" => $all_data['kategori'],
                        "nama" => $all_data['nama_resep'],
                        "deskripsi" => $all_data['deskripsi'],
                    );

        if(!empty($all_data['id_resep']) ){
            $update_resep = Resep::findOrFail($all_data["id_resep"]);
            $update_resep->update($data_resep);
        }
        
        $this->addDetailResep($all_data,$id_resep);
        return redirect('/master/resep');
    }

    //Fungsi delete resep detail 
    public function deleteDetailResep($all_data)
    {
        // dd($all_data);
        //Hitung total data yg akan di hapus
        $jumlah = count($all_data["details_deleted"]);

        for($i=0;$i<$jumlah;$i++)  {
            //delete sesuai id
            $detailResep=ResepDetail::find($all_data["details_deleted"][$i]);
            $act=false;
            try {
                $act=$detailResep->forceDelete();
            } catch (\Exception $e) {
                $detailResep=ResepDetail::find($detailResep->id);
                $act=$detailResep->delete();
            }

        }
    }

    //Fungsi edit resep detail
    function editDetailResep($all_data){

        $jumlah = count($all_data["old_id_resep_bahan_edit"]);
        for($i=0;$i<$jumlah;$i++)  {

            if($all_data["old_id_resep_bahan_edit"][$i] !== '' && !empty($all_data["old_id_resep_bahan_edit"][$i])){
                $bahan_data = array(
                        "id_bahan" => $all_data["id_bahan_edit"][$i],
                        "qty_bahan" => $all_data["bahan_qty_edit"][$i],
                        "id_satuan" => $all_data["id_satuan_edit"][$i],
                );

                //update detil resep sesuai id nya
                $update_detailResep=ResepDetail::findOrFail($all_data["old_id_resep_bahan_edit"][$i]);
                $update_detailResep->update($bahan_data);
            }
        }
    }

    //Fungsi non aktifkan resep
    public function tutupResep($id_resep)
    {
        $resep=Resep::findOrFail($id_resep);
        if (isset($resep) && !empty($resep)){
            $resep->aktif = 'N';
            $resep->save();
        }
        return redirect('/master/resep');
    }

    //Fungsi  aktifkan resep
    public function bukaResep($id_resep)
    {
        $resep=Resep::findOrFail($id_resep);
        if (isset($resep) && !empty($resep)){
            $resep->aktif = 'Y';
            $resep->save();
        }
        return redirect('/master/resep');
    }

    //Fungsi  aktifkan resep
    public function editStatusResep(Request $request)
    {
        $message = '';
        $id_resep = \Request::input('id_resep');
        $status = \Request::input('status');

        $resep=Resep::findOrFail($id_resep);

        if (isset($resep) && !empty($resep)){
            $aktif = ($status == 'tutup')?'N':'Y';
            $resep->aktif = $aktif;
            $resep->save();
        }

        if($resep){
            $message = 'success';
        }else{
            $message = 'failed';
        }
    
        return response()->json($message);
    }



}
