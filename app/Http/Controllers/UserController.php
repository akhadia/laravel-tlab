<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\RoleUser;
use App\Permission;
use App\PermissionRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Yajra\Datatables\Datatables;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        // $this->middleware('role:admin');
        $this->middleware('permission:user-create');
        $this->middleware('permission:user-update');
        $this->middleware('permission:user-delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('User.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User;
        $role = Role::all();
        return view('User.form', compact('user', 'role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $num=0;
        $all_data = $request->all(); 
        // dd($all_data);

        $data_user = array(
                            'name'      => $all_data['name'],
                            'username'  => $all_data['username'],
                            'email'     => $all_data['email'],
                            'password'  => bcrypt($all_data['password']),
                        );
        
        //1) Create User
        $user = User::create($data_user);

        //2) Set User Role
        $role = Role::whereIn('id', $all_data['role'])->get();
        foreach ($role as $key => $value) {
            $user->attachRole($value);
            $num++;
        }

        if($num > 0){
            flash('Data user berhasil ditambahkan')->success();
        }else{
            flash('Data user gagal ditambahkan')->error();
        }

        return redirect('user');
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
        $user = User::where('id',$id)->first();
        $role_user = RoleUser::where('user_id',$id)->get();
        $role = Role::all();
        
        return view('User.form', compact('role','role_user','user'));
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
        $all_data = $request->all(); 
        
        $data_user = array(
            'name'      => $all_data['name'],
            'username'  => $all_data['username'],
            'email'     => $all_data['email'],
        );

        if(!empty($all_data['password']) || $all_data['password'] != null){
            $data_user = ['password'  => bcrypt($all_data['password'])];
        }
        

        $update_user= User::findOrFail($id);
        $act = $update_user->update($data_user);

        try {
            $role_user = RoleUser::where('user_id', $id)->get();
            foreach ($role_user as $key => $value) {
                $update_user->detachRole($value);
            }

            $role_user2 = Role::whereIn('id', $all_data['role'])->get();
            foreach ($role_user2 as $key2 => $value2) {
                $update_user->attachRole($value2);
            }
        } catch (\Exception $e) {
            //
        }

        if($act){
            flash('Data user berhasil diubah')->success();
        }else{
            flash('Data user gagal diubah')->error();
        }

        return redirect('user');
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
        $nama_user = \Request::input('nama_user');

        $GLOBALS['nomor']=\Request::input('start',1)+1;

        $dataList = User::where(function ($q) use ($nama_user){
                if(!empty($nama_user)){
                    $nama_user = strtoupper($nama_user );
                    $q->where(DB::raw('upper(name)'), 'LIKE', "%$nama_user%");
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
                $content .= '<a href="'.url("user/".$dataList->id."/edit").'" class="btn btn-xs btn-info" target=""><i class="glyphicon glyphicon-edit"></i> Edit</a>';
            
                // $content .= '<a href="'.url("role/destroy/".$dataList->id).'" class="btn btn-xs btn-danger hapus-bahan" target=""><i class="glyphicon glyphicon-trash"></i> Delete</a>';
                $content .= '<button id="btn_delete" class="btn btn-xs btn-danger hapus-role" val="'.$dataList->id.'"><i class="glyphicon glyphicon-trash"></i> Delete</button>';

               
                return $content;
            })

            ->rawColumns(['status','action'])
            ->make(true);
            
    }

    public function deleteUser(Request $request)
    {

        $id_user = \Request::input('id_user');

        $user=User::findOrFail($id_user);
        // print_r($role);
        $act=false;
        try {
            $user->roles()->sync([]); // Delete relationship data\

            $act= $user->forceDelete();
        } catch (\Exception $e) {
            $user=User::find($user->id);
            $act=$user->delete();
        }
    
        return response()->json($act);
    }
}
