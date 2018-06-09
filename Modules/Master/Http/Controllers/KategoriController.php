<?php

namespace Modules\Master\Http\Controllers;

use Modules\Master\Entities\Kategori;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

use Yajra\Datatables\Datatables;

class KategoriController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('permission:kategori-create');
        $this->middleware('permission:kategori-update');
        $this->middleware('permission:kategori-delete');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('master::kategori.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $kategori = new Kategori;
        return view('master::kategori.form', compact('kategori'));
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

        $act=Kategori::create($data_kategori);

        if($act){
            flash('Data kategori berhasil ditambahkan')->success();
        }else{
            flash('Data kategori gagal ditambahkan')->error();
        }
    
        return redirect('/master/kategori');
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
        $kategori = Kategori::where('id',$id)->first();
        return view('master::kategori.form', compact('kategori'));
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

        if($act){
            flash('Data kategori berhasil diubah')->success();
        }else{
            flash('Data kategori gagal diubah')->error();
        }

        return redirect('/master/kategori');
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }

    public function delete($id){
        $kategori = Kategori::findOrFail($id);
        // $kategori->aktif = 'N';
        // $act = $kategori->save();

        $act=false;
        DB::beginTransaction();
        try {
            $act= $kategori->forceDelete();
        }catch (Exception $e) {
            DB::rollBack();
        }
        DB::commit();

        if($act){
            flash('Data kategori berhasil dihapus')->success();
        }else{
            flash('Data kategori gagal dihapus')->error();
        }

        return redirect('/master/kategori');
    }

    public function loadDataKategori(){
        // print_r('oke');die;
        $nama_kategori = \Request::input('nama_kategori');
        $status = \Request::input('status');

        $GLOBALS['nomor']=\Request::input('start',1)+1;

        $dataList = Kategori::where(function ($q) use ($nama_kategori, $status){
                if(!empty($nama_kategori)){
                    $nama_kategori = strtoupper($nama_kategori );
                    $q->where(DB::raw('upper(nama)'), 'LIKE', "%$nama_kategori%");
                } 
                if(!empty($status) && $status!='all'){
                    $status = strtoupper($status );
                    $q->where(DB::raw('upper(aktif)'), 'LIKE', "%$status%");
                } 
            })
            ->get();

        return Datatables::of($dataList)
            ->addColumn('nomor',function($dataList){
                return $GLOBALS['nomor']++;
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
                $content .= '<a href="'.url("master/kategori/".$dataList->id."/edit").'" class="btn btn-xs btn-info" target=""><i class="glyphicon glyphicon-edit"></i> Edit</a>';
            
                $content .= '<a href="'.url("master/kategori/delete/".$dataList->id).'" class="btn btn-xs btn-danger hapus-kategori" target=""><i class="glyphicon glyphicon-trash"></i> Delete</a>';
                
               
                return $content;
            })

            ->rawColumns(['status','action'])
            ->make(true);
            
    }
}
