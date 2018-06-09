<?php

namespace Modules\Master\Http\Controllers;

use Modules\Master\Entities\Satuan;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

use Yajra\Datatables\Datatables;

class SatuanController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('permission:satuan-create');
        $this->middleware('permission:satuan-update');
        $this->middleware('permission:satuan-delete');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('master::satuan.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $satuan = new Satuan;
        return view('master::satuan.form', compact('satuan'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $all_data = $request->all(); 

        // $validatedData = $request->validate([
        //     'name' => 'required|unique:posts|max:255',
        // ]);
    

        $data_satuan = array('nama' => $all_data['nama_satuan']);

        $act=Satuan::create($data_satuan);

        if($act){
            flash('Data satuan berhasil ditambahkan')->success();
        }else{
            flash('Data satuan gagal ditambahkan')->error();
        }
    
        return redirect('/master/satuan');
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
        $satuan = Satuan::where('id',$id)->first();
        return view('master::satuan.form', compact('satuan'));
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

        if($act){
            flash('Data satuan berhasil diubah')->success();
        }else{
            flash('Data satuan gagal diubah')->error();
        }

        return redirect('/master/satuan');
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }

    public function delete($id){
        $satuan = Satuan::findOrFail($id);
        // $satuan->aktif = 'N';
        // $act = $satuan->save();

        $act=false;
        DB::beginTransaction();
        try {
            $act= $satuan->forceDelete();
        }catch (Exception $e) {
            DB::rollBack();
        }
        DB::commit();

        if($act){
            flash('Data satuan berhasil dihapus')->success();
        }else{
            flash('Data satuan gagal dihapus')->error();
        }

        return redirect('/master/satuan');
    }

    public function loadDataSatuan(){
        $nama_satuan = \Request::input('nama_satuan');
        $status = \Request::input('status');

        $GLOBALS['nomor']=\Request::input('start',1)+1;

        $dataList = Satuan::where(function ($q) use ($nama_satuan, $status){
                if(!empty($nama_satuan)){
                    $nama_satuan = strtoupper($nama_satuan );
                    $q->where(DB::raw('upper(nama)'), 'LIKE', "%$nama_satuan%");
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

                $content .= '<a href="'.url("master/satuan/".$dataList->id."/edit").'" class="btn btn-xs btn-info" target=""><i class="glyphicon glyphicon-edit"></i> Edit</a>';
            
                $content .= '<a href="'.url("master/satuan/delete/".$dataList->id).'" class="btn btn-xs btn-danger hapus-satuan" target=""><i class="glyphicon glyphicon-trash"></i> Delete</a>';
                
                return $content;
            })

            ->rawColumns(['status','action'])
            ->make(true);
            
    }

    public function popupSatuan(){
    // print_r('oke');die;
      return view('master::satuan.popup-satuan');
    //   return $this->view("popup-satuan");
    }

    public function loadDataPopupSatuan(){
        $nama_satuan = \Request::input('nama_satuan');

        $GLOBALS['nomor']=\Request::input('start',1)+1;

        $dataList = Satuan::where(function ($q) use ($nama_satuan){
                if(!empty($nama_satuan)){
                    $nama_satuan = strtoupper($nama_satuan );
                    $q->where(DB::raw('upper(nama)'), 'LIKE', "%$nama_satuan%");
                }
            })
            ->where('aktif','Y')
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
                $content = '<a href="#" class="btn btn-xs btn-primary select-satuan-from-popup" data-id="'.$dataList->id.'"><i class="glyphicon glyphicon-ok"></i> Add</a>';

                return $content;
            })

            ->rawColumns(['status','action'])
            ->make(true);
            
    }

    function getSatuan(Request $request, $id){
        $satuan=Satuan::where('id',$id)->first();
        return response()->json($satuan);
    }
 
}
