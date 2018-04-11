<?php

namespace App\Http\Controllers\v1\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Client;
use App\Services\v1\UsersServices;
use App\User;
use App\User;
use DB;
class RegiterController extends Controller
{
	
	private $client;

	public function __construct(){
		$this->client = Client::find(1);
	}

   public function register(Request $request){

 
   	  $validator=Validator::make($request->all(),[
   		'email'=>'required|email|unique:users',
   		'password'=> 'required|min:6',
   		
   		]);
   		if ($validator->fails()) {
				 return response()->json([
				 		'status' => 'failed',
						'error'=>$validator->errors(),
					],422);
			}
	
		$user=User::create([
			'name'=>$request->username,
			'email'=>$request->email,
			'password'=>bcrypt($request->password),
			'type' => $request->type,
		]);

    		$params = [
            'grant_type' => 'password',
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,           
            'username'=>$request->email,
            'password'=>$request->password,
            'scope'=>'*',
        	];

        $request->request->add($params);

    		$passport_token = Request::create('oauth/token', 'POST');

    		return Route::dispatch($passport_token);
    	
		
    	}
  

}
