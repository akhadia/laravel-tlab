<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Permission;
use App\PermissionRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


use Yajra\Datatables\Datatables;

class RoleController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        // $this->middleware('role:admin');
        $this->middleware('permission:role-create');
        $this->middleware('permission:role-update');
        $this->middleware('permission:role-delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $user = auth()->user()->can('role-create');
        // $user  = auth()->user()->hasRole('staff'); 
        // dd($user);

        // if($user->can('resep-create')){
        //     dd('success'.);
        // }else{
        //      dd('fail');
        // }
        return view('Role.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role = new Role;
        $permission = Permission::all();
        return view('Role.form', compact('role','permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $all_data = $request->all(); 

        $data_role = array(
                        'name'          =>   $all_data['nama_role'],
                        'display_name'  =>   $all_data['display_name'],
                        'description'   =>   $all_data['description'],
                    );
        
        //1) Create Admin Role
        $role = Role::create($data_role);

        //2) Set Role Permissions
        if(isset($all_data['permission'])){
            $permission = Permission::whereIn('id', $all_data['permission'])->get();
            foreach ($permission as $key => $value) {
                $role->attachPermission($value);
            }
        }
       

        return redirect('role');
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
        $role = Role::where('id',$id)->first();
        $permission_role = PermissionRole::where('role_id',$id)->get();
        $permission = Permission::all();
        
        return view('Role.form', compact('role','permission','permission_role'));
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
        $n=0;
        $all_data = $request->all(); 

        $data_role = array(
                        'name'          =>   $all_data['nama_role'],
                        'display_name'  =>   $all_data['display_name'],
                        'description'   =>   $all_data['description'],
                    );
        

        $update_role = Role::findOrFail($id);
        $act = $update_role->update($data_role);

        try {
            $permission = PermissionRole::where('role_id', $id)->get();
            foreach ($permission as $key => $value) {
                $update_role->detachPermission($value);
            }

            $permission2 = Permission::whereIn('id', $all_data['permission'])->get();
            foreach ($permission2 as $key2 => $value2) {
                $update_role->attachPermission($value2);
            }
        } catch (\Exception $e) {
            //
        }

        if($act){
            flash('Data role berhasil diubah')->success();
        }else{
            flash('Data role gagal diubah')->error();
        }

        return redirect('role');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function loadData(){
        // print_r('oke');die;
        $nama_role = \Request::input('nama_role');

        $GLOBALS['nomor']=\Request::input('start',1)+1;

        $dataList = Role::where(function ($q) use ($nama_role){
                if(!empty($nama_role)){
                    $nama_role = strtoupper($nama_role );
                    $q->where(DB::raw('upper(name)'), 'LIKE', "%$nama_role%");
                } 
            })
            ->orderby('id','desc')
            ->get();

        return Datatables::of($dataList)
            ->addColumn('nomor',function($dataList){
                return $GLOBALS['nomor']++;
            })  
          
            ->addColumn('action', function ($dataList) {
                $content = '';
                $content .= '<a href="'.url("role/".$dataList->id."/edit").'" class="btn btn-xs btn-info" target=""><i class="glyphicon glyphicon-edit"></i> Edit</a>';
            
                // $content .= '<a href="'.url("role/destroy/".$dataList->id).'" class="btn btn-xs btn-danger hapus-bahan" target=""><i class="glyphicon glyphicon-trash"></i> Delete</a>';
                $content .= '<button id="btn_delete" class="btn btn-xs btn-danger hapus-role" val="'.$dataList->id.'"><i class="glyphicon glyphicon-trash"></i> Delete</button>';

               
                return $content;
            })

            ->rawColumns(['status','action'])
            ->make(true);
            
    }

    public function deleteRole(Request $request)
    {

        $id_role = \Request::input('id_role');

        $role=Role::findOrFail($id_role);
        // print_r($role);
        $act=false;
        try {
            $role->users()->sync([]); // Delete relationship data
            $role->perms()->sync([]); // Delete relationship data

            $act= $role->forceDelete();
        } catch (\Exception $e) {
            $role=Role::find($role->id);
            $act=$role->delete();
        }
    
        return response()->json($act);
    }
}
