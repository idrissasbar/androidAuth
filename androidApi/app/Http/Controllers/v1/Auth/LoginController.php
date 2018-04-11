<?php

namespace App\Http\Controllers\v1\Auth;

use App\Http\Controllers\Controller;
use App\Services\v1\VolunteersServices;
use App\Services\v1\UploadsServices;
use App\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Client;
use Socialite;
use Validator;
class LoginController extends Controller
{
    //
    private $client;

    public function __construct(){
        $this->client = Client::find(1);
    }

    public function login(Request $request)
    {
        $validator=Validator::make($request->all(),[
        'username'=>'required',
        'password'=> 'required',
        ]);
        if ($validator->fails()) {
                 return response()->json([
                        'status' => 'failed',
                        'error'=>$validator->errors(),
                    ]);
            }

        $params = [
            'grant_type' => 'password',
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,           
            'username'=>$request->username,
            'password'=>$request->password,
            'scope'=>'*',
            ];

        $request->request->add($params);

        $passport_token = Request::create('oauth/token', 'POST');

        return Route::dispatch($passport_token);
    }

    public function refresh(Request $request)
    {
        $validator=Validator::make($request->all(),[
        'refresh_token'=>'required',
        ]);
        if ($validator->fails()) {
                 return response()->json([
                        'status' => 'failed',
                        'error'=>$validator->errors(),
                    ]);
            }

        $params = [
            'grant_type' => 'refresh_token',
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,           
            'username'=>$request->username,
            'password'=>$request->password,
            'scope'=>'*',
            ];

        $request->request->add($params);

        $passport_token = Request::create('oauth/token', 'POST');

        return Route::dispatch($passport_token);
    }

    public function logout(Request $request)
    {
        $accessToken = Auth::user()->token();

        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update(['revoked' => true]);

        $accessToken->revoke();

        return response()->json([], 204);
    }

   


}