<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Services\v1\UploadsServices;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Response;
use Auth;
use App\Upload;
use File;

class UploadController extends Controller
{
    protected $uploads;
    function __construct(UploadsServices $uploads)
    {
        $this->uploads = $uploads;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $uploads = Auth::user()->getUploads;
        if($uploads!=null){
            return response()->json(['uploads' => $uploads]);
        } else {
            return response()->json([],204);
        }
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
            $upload = $this->uploads->createUpload($request);
            return response()->json($upload,201);
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
        $data = $this->uploads->getUploads($params);
        return response()->json($data,200);
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
            $upload = $this->uploads->updateUpload($id,$request);
            return response()->json($upload,200);
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
        try{
            $upload = $this->uploads->deleteUpload($id);
            return response()->json('deleted',204);
        }catch(Exception $e){
            return  response()->json(['error'=>$e->getMessage()],421);
        }
    }

    
    public function uploaded_files()
    {
          
        $uploads = Auth::user()->getUploads;
        if($uploads!=null){
            return response()->json(['uploads' => $uploads2]);
        } else {
            return response()->json([],204);
        }
    }

    public function get_file($hash, $name)
    {
        $upload = Upload::where("hash", $hash)->first();
        $folder = storage_path('uploads');
        
        // Validate Upload Hash & Filename
        if(!isset($upload->id) || $upload->name != $name) {
            return response()->json([
                'status' => "failure",
                'message' => "Unauthorized Access 1"
            ]);
        }

        if($upload->public == 1) {
            $upload->public = true;
        } else {
            $upload->public = false;
        }

        // Validate if Image is Public
        if(!$upload->public && !isset(Auth::user()->id)) {
            return response()->json([
                'status' => "failure",
                'message' => "Unauthorized Access 2",
            ]);
        }

        if($upload->public || Auth::user()->id == $upload->user_id) {
            
            $path = $folder.DIRECTORY_SEPARATOR.$upload->path;

            if(!File::exists($path))
                abort(404);
    

            $file = File::get($path);
            $type = File::mimeType($path);

            $download = Input::get('download');
            if(isset($download)) {
                return response()->download($path, $upload->name);
            } else {
                $response = Response::make($file, 200);
                $response->header("Content-Type", $type);
            }
            
            return $response;
        } else {
            return response()->json([
                'status' => "failure",
                'message' => "Unauthorized Access "
            ]);
        }
    }

}
