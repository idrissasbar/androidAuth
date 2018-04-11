<?php 
namespace App\Services\v1;

use App\User;
use App\Services\v1\ChildrensService;
use DB;
/**
* 
*/
class UsersServices extends serviceBP {   

    protected $supportedFields = [
        'getChildrens' => 'childrens',
    ];
    protected $clauseProprieties = [
        'id' => 'id',
        'name' => 'name',
        'email' => 'email',
        'type' => 'type',
        'context_id' => 'context_id',
      
    ];

    
    protected  $tableFields = ['name', 'email','type'];

    static public function create($request){
        $user=new User();
        $user->name=$request->input('name');
        $user->email=$request->input('email');
        $user->type=$request->input('type');
        $user->save();
        return $user;
    }

    public function createUser($request)
    {
        static::create($request);
    }


    public function updateUser($id,$request){
        $user=User::find($id);
        
        DB::transaction(function () use ($request,&$user) {       
            try {
                    foreach ($this->tableFields as $field){
                            if(isset($request[$field])){
                                 $user->fill([$field => $request->input($field)]);
                        }
                    }
                    $user->save();

                } catch (\Exception $e) {
                    DB::rollback();
                    $user=null;
                }
                    
            });
        return $user;
    }

    public function deleteUser($id){
        $user=User::findOrFail($id);
        $user->delete();
    }

    protected function filterUsers($users,$withKeys){
    
        return static::staticFilterUsers($users,$withKeys);
    }
    public static function staticFilterUsers($users,$withKeys){
        $data = array();
        foreach ($users as $user){
            $entry = $user;
           
            
            if(in_array('getChildrens',$withKeys)){
                $entry['childrens']= ChildrensService::staticFilterChildrens($user->getChildrens,[]);
            }

            $data[] = $entry;
        }
        return $data;
    }
    
    public function getUsers($params)
    {   
        $withKeys = [];
        if(empty($params)){
            return $this->filterUsers(User::all(),$withKeys);
        }
        $withKeys = $this->getWithKeys($params);
        $whereClauses = $this->getWhereClauses($params);
        $users = User::with($withKeys)->where($whereClauses)->get();
        return $this->filterUsers($users,$withKeys);

        /*$users=User::all($columns)->each(function ($item, $key) {
            $item->url=route('users.show', [$item->id]);
        });
        return $users;*/
    }
    


    public function getChildrens($user_id,$child_columns=['*'])
    {
        $childrens=User::find($user_id)->getChildrens()->get($child_columns);

        return $childrens;
    }


}
