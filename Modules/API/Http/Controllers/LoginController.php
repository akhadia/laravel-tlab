<?php

namespace Modules\API\Http\Controllers;

use Auth;
use Hash;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('api::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('api::create');
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
        return view('api::show');
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

    /*
    * This function authenticates the user by email and password,
    * creates a new api_token for validated user, saves it
    * in the database and returns back the user
    */
    public function login(Request $request)
    {
        $data = $request->all(); 
        $user = User::where('username',$data['username'])->first();
       
        // if($user != null && Hash::check($data['password'], $user->getAuthPassword())) {
        //     $user->generateToken();

        //     return response()->json([
        //         'data' => $user->toArray()
        //     ], 200);
        // };

        if($user == null) {
            return $this->outputJSON(null,"Incorrect Username Address",404);
        } elseif (Hash::check($data['password'], $user->getAuthPassword())) {
            $user->generateToken();

            return $this->outputJSON($user,"Logged In Successfully",200);
        } else {
            return $this->outputJSON(null,"Incorrect Password",404);         
        }   
    }

    /*
    * This function will get the authenticated user
    * unset and save the api token
    */
    public function logout()
    {
        $user = Auth::user();
        $user->api_token = null;
        $user->save();
        return $this->outputJSON(null,"Successfully Logged Out"); 
    }

    protected function outputJSON($result = null, $message = '', $responseCode = 200) {

        if ($message != '') $response["message"] = $message;
        if ($result != null) $response["result"] = $result;

        return response()->json($response, $responseCode);
    }
}
