<?php 
namespace App\Services\v1;

use App\Upload;
use Auth;
use Illuminate\Support\Facades\Input;
use Storage;
/**
* 
*/
class UploadsServices extends serviceBP {	

	protected $supportedFields = [
        'getOwner' => 'owner',
    ];
    protected $clauseProprieties = [
        'id' => 'id',
        'name' => 'name',
        'path' => 'path',
        'extension' => 'extension',
        'caption' => 'caption',
        'user_id' => 'user_id',
        'public' => 'public',
        'hash' => 'hash',
    ];

    protected  $tableFields = ['id','name' ,'path' ,'extension','caption' ,'user_id','public','hash' ];

	public function createUpload($request,$name)
    {
        $id=static::staticCreateUpload($request,$name);
        if($id>0){
                response()->json(['id'=>$id], 200);
        }else{
                response()->json('error: upload file not found.', 400);
        }
    }

    public static function staticCreateUpload($request,$name)
    {
            $input = Input::all();
            
            if(Input::hasFile($name)) {
                /*
                $rules = array(
                    'file' => 'mimes:jpg,jpeg,bmp,png,pdf|max:3000',
                );
                $validation = Validator::make($input, $rules);
                if ($validation->fails()) {
                    return response()->json($validation->errors()->first(), 400);
                }
                */
                $file = Input::file($name);
                
                $folder = storage_path('uploads');
                $filename = $file->getClientOriginalName();
    
                $date_append = round(microtime(true) * 1000);
                $upload_success = Input::file($name)->move($folder, $date_append.$filename);
                
                if( $upload_success ) {
    
                    $public = Input::get('public');
                    if(isset($public)) {
                        $public = true;
                    } else {
                        $public = false;
                    }
    
                    $upload = Upload::create([
                        "name" => $filename,
                        "path" => $date_append.$filename,
                        "extension" => pathinfo($filename, PATHINFO_EXTENSION),
                        "caption" => "",
                        "hash" => "",
                        "public" => true,
                        "user_id" => Auth::user()->id
                    ]);
                    while(true) {
                        $hash = strtolower(str_random(20));
                        if(!Upload::where("hash", $hash)->count()) {
                            $upload->hash = $hash;
                            break;
                        }
                    }
                    $upload->save();
    
                    return $upload->id;// response()->json(['id'=>$upload->id], 200);
                } else {
                    return 0;// response()->json(["status" => "error" ], 400);
                }
            } else {
                return 0;//response()->json('error: upload file not found.', 400);
            }
    }


     public static function staticCreateUploadFromUrl($url,$id)
    {
            
                
                $folder = storage_path('uploads');
                $filename = "avatar";
    
                $date_append = round(microtime(true) * 1000);
                $upload_success=Storage::disk('uploads')->put($date_append.$filename, fopen($url, 'r'));
                
                if( $upload_success ) {
    
    
                    $upload = Upload::create([
                        "name" => $filename,
                        "path" => $date_append.$filename,
                        "extension" => "jpeg",
                        "caption" => "",
                        "hash" => "",
                        "public" => true,
                        "user_id" => $id
                    ]);
                    while(true) {
                        $hash = strtolower(str_random(20));
                        if(!Upload::where("hash", $hash)->count()) {
                            $upload->hash = $hash;
                            break;
                        }
                    }
                    $upload->save();
    
                    return $upload->id;// response()->json(['id'=>$upload->id], 200);
                } else {
                    return 0;// response()->json(["status" => "error" ], 400);
                }
            
    }


	public function updateUpload($id,$request){
		$upload=Upload::find($id);
		$upload->update($request->input());
		$upload->save();
	}

	public function deleteUpload($id){
		$upload=Upload::findOrFail($id);
		$upload->delete();
	}

	protected function filterUploads($uploads,$withKeys){
        $data = array();
        foreach ($uploads as $upload){
            $entry = $upload;

            
            if(in_array('getOwner',$withKeys)){
                $entry['owner'] = $upload->getOwner ;
            }
            
            $data[] = $entry;
        }
        return $data;
    }
	
    public function getUploads($params)
	{	
		$withKeys = [];
        if(empty($params)){
            return $this->filterUploads(Upload::all(),$withKeys);
        }
        $withKeys = $this->getWithKeys($params);
        $whereClauses = $this->getWhereClauses($params);
        $uploads = Upload::with($withKeys)->where($whereClauses)->get();
        return $this->filterUploads($uploads,$withKeys);
	}
	
}