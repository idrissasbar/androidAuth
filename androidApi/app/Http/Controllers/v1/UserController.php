<?php

namespace App\Http\Controllers\v1;

use App\User;
use App\Http\Controllers\Controller;
use App\Services\v1\UsersServices;
use App\Track;
use Auth;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use DB;

class UserController extends Controller
{
    protected $users;

    function __construct(UsersServices $service)
    {
        $this->users = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
         $params = request()->input();
        $data = $this->users->getUsers($params);
        return response()->json($data,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        try{
            $user = $this->users->createUser($request);
            return response()->json($user,201);
        }catch(Exception $e){
            return  response()->json(['error'=>$e->getMessage()],421);
        }
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
        $params = request()->input();
        $params['id'] = $id;
        $data = $this->users->getUsers($params);
        if($data!= null)
            return response()->json($data[0],200);
        else return response()->json("",200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
        try{
            $user = $this->users->updateUser($id,$request);
            return response()->json($user,200);
        }catch(Exception $e){
            return  response()->json(['error'=>$e->getMessage()],421);
        }
    }

    public function updateProfile(Request $request)
    {
        //
        try{
            $user = UsersServices::staticFilterUsers([$this->users->updateUser(Auth::user()->id,$request)],[]);
            if($user!=null)
                return response()->json($user[0],200);
            else
                return response()->json($user,421);

        }catch(Exception $e){
            return  response()->json(['error'=>$e->getMessage()],421);
        }
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
       
    $id=Auth::user()->id;   
        
    try{
            $this->users->deleteUser($id);
            return response()->json('deleted',204);
        }catch(Exception $e){
            return  response()->json(['error'=>$e->getMessage()],421);
        }
    }

    public function getAuthUser()
    {  

        $params = request()->input();
        $params['id'] = Auth::user()->id;
        $data = $this->users->getUsers($params);
        if($data!= null)
            return response()->json($data[0],200);
        else return response()->json("",200);
        
    }

}
