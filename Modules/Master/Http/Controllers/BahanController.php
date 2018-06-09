<?php

namespace Modules\Master\Http\Controllers;

use Modules\Master\Entities\Bahan;
use Modules\Master\Entities\Satuan;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

use Yajra\Datatables\Datatables;

class BahanController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        // $this->middleware('role:admin');
        $this->middleware('permission:bahan-create');
        $this->middleware('permission:bahan-update');
        $this->middleware('permission:bahan-delete');
    }
    
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('master::bahan.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $bahan = new Bahan;
        return view('master::bahan.form', compact('bahan'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $all_data = $request->all(); 

        $id_satuan = $all_data['id_satuan'];
        $nama_satuan =  $all_data['nama_satuan'];
        $old_nama_satuan =  $all_data['old_nama_satuan'];

        if(strtoupper($nama_satuan ) != strtoupper($old_nama_satuan )){
            //cek tabel satuan
            $satuan = Satuan::where(DB::raw('upper(nama)'), 'LIKE', "%$nama_satuan%")->first();
            if($satuan){
                $id_satuan = $satuan->id;
            }else{
                //create satuan
                $data_satuan = array('nama' =>  $nama_satuan);

                $act = Satuan::create($data_satuan);
                $id_satuan = $act->id;
            }
        }

        $data_bahan = array(
                            'nama' => $all_data['nama_bahan'],
                            'id_satuan' =>  $id_satuan,
                        );

        $act=Bahan::create($data_bahan);

        if($act){
            flash('Data bahan berhasil ditambahkan')->success();
        }else{
            flash('Data bahan gagal ditambahkan')->error();
        }
    
        return redirect('/master/bahan');
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
    public function edit($id)
    {
        $bahan = Bahan::where('id',$id)->first();
        return view('master::bahan.form', compact('bahan'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $all_data = $request->all(); 
     
        $id_satuan = $all_data['id_satuan'];
        $nama_satuan =  $all_data['nama_satuan'];
        $old_nama_satuan =  $all_data['old_nama_satuan'];

        if(strtoupper($nama_satuan ) != strtoupper($old_nama_satuan )){
            //cek tabel satuan
            $satuan = Satuan::where(DB::raw('upper(nama)'), 'LIKE', "%$nama_satuan%")->first();
            if($satuan){
                $id_satuan = $satuan->id;
            }else{
                //create satuan
                $data_satuan = array('nama' =>  $nama_satuan);

                $act = Satuan::create($data_satuan);
                $id_satuan = $act->id;
            }
        }

        $data_bahan = array(
                'nama' =>  $all_data['nama_bahan'],
                'id_satuan' =>  $id_satuan,
                'aktif' =>  $all_data['status'],
            );

        $update_bahan = Bahan::findOrFail($id);
        $act = $update_bahan->update($data_bahan);

        if($act){
            flash('Data bahan berhasil diubah')->success();
        }else{
            flash('Data bahan gagal diubah')->error();
        }

        return redirect('/master/bahan');
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
    }

    public function delete($id){
        $bahan = Bahan::findOrFail($id);
        // $bahan->aktif = 'N';
        // $act = $bahan->save();

        $act=false;
        DB::beginTransaction();
        try {
            $act= $bahan->forceDelete();
        }catch (Exception $e) {
            DB::rollBack();
        }
        DB::commit();

        if($act){
            flash('Data bahan berhasil dihapus')->success();
        }else{
            flash('Data bahan gagal dihapus')->error();
        }

        return redirect('/master/bahan');
    }

    public function loadDataBahan(){
        // print_r('oke');die;
        $nama_bahan = \Request::input('nama_bahan');
        $status = \Request::input('status');

        $GLOBALS['nomor']=\Request::input('start',1)+1;

        $dataList = Bahan::where(function ($q) use ($nama_bahan, $status){
                if(!empty($nama_bahan)){
                    $nama_bahan = strtoupper($nama_bahan );
                    $q->where(DB::raw('upper(nama)'), 'LIKE', "%$nama_bahan%");
                } 
                if(!empty($status) && $status!='all'){
                    $status = strtoupper($status );
                    $q->where(DB::raw('upper(aktif)'), 'LIKE', "%$status%");
                } 
            })
            ->orderby('id','desc')
            ->get();

        return Datatables::of($dataList)
            ->addColumn('nomor',function($dataList){
                return $GLOBALS['nomor']++;
            })

            ->addColumn('satuan', function ($dataList) {
                if(isset($dataList->satuan->nama)){
                    return $dataList->satuan->nama;
                    // return null;
                }else{
                    return null;
                }
                
            })  

            ->addColumn('status', function ($dataList) {
                $content = '';
                if($dataList->aktif == 'Y'){
                     $content .= '<span class="label label-success">Aktif</span>';
                }else{
                    $content .= '<span class="label label-danger">Non Aktif</span>';
                }
                return $content;
            })    
          
            ->addColumn('action', function ($dataList) {
                $content = '';
                $content .= '<a href="'.url("master/bahan/".$dataList->id."/edit").'" class="btn btn-xs btn-info" target=""><i class="glyphicon glyphicon-edit"></i> Edit</a>';
            
                $content .= '<a href="'.url("master/bahan/delete/".$dataList->id).'" class="btn btn-xs btn-danger hapus-bahan" target=""><i class="glyphicon glyphicon-trash"></i> Delete</a>';
                
               
                return $content;
            })

            ->rawColumns(['status','action'])
            ->make(true);
            
    }
}
