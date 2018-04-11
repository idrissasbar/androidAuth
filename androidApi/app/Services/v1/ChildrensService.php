<?php

namespace App\Services\v1;

use App\User;
use App\Comment;
use App\Services\v1\UsersServices;
use App\Services\v1\UploadsServices;
use App\Child;
use Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Request;

class ChildrensService extends serviceBP {
    protected $supportedFields = [

    ];
    protected $clauseProprieties = [
        'id' => 'id',
        'name' => 'name',
        'birthdate' => 'birthdate',
        'user_id' => 'user_id',
    ];
    protected  $tableFields = ['name','birthdate'];
    public function getChildrens($params){
        $withKeys = [];
        if(empty($params)){
            return $this->filterChildrens(Child::all(),$withKeys);
        }
        $withKeys = $this->getWithKeys($params);
        $whereClauses = $this->getWhereClauses($params);
        $childrens = Child::with($withKeys)->where($whereClauses)->get();
        return $this->filterChildrens($childrens,$withKeys);
    }


    protected function filterChildrens($childrens,$withKeys){

            return static::staticFilterChildrens($childrens,$withKeys);
    }



    public static function staticFilterChildrens($childrens,$withKeys){
        $data = [];
        foreach ($childrens as $child){
            $entry = $child;

        
            if(in_array('getUser',$withKeys)){
                $entry['user']= UsersServices::staticFilterUsers([$child->getUser],[])[0];
            }
            
            $data[] = $entry;
        }
        return $data;
    }

    public function createChild($req){

            $child =new Child();

            $child->name = $req->input('name');
            $child->birthdate = $req->input('birthdate');
            $child->user_id = $req->input('user_id');
            $child->save();

        return $child;
    }

    public function updateChild($req,$id){
        $child = Child::find($id);
        
        foreach ($this->tableFields as $field){
            if(isset($req[$field])){
                $child->fill([$field => $req[$field]]);
            }
        }
        $child->save();
        return $child;
    }

    public function deleteChild($id){

        $child = Child::where('id', $id)->where('user_id',Auth::user()->id)->firstOrFail();

        $child->delete();
    }

}