<?php
/**
 * Created by PhpStorm.
 * User: reda-benchraa
 * Date: 10/04/17
 * Time: 19:01
 */

namespace App\Services\v1;


class serviceBP
{
    protected $supportedFields = [
    ];
    protected $clauseProprieties = [
    ];
    protected function getWhereClauses($params){
        $clause = array();
        foreach ($this->clauseProprieties as $keys =>$propriety){
            if(in_array($propriety,array_keys($params))){
                $clause[$keys] = $params[$propriety];
            }
        }
        return  $clause;
    }
    protected function getWithKeys($params){
        $withKeys = array();
        if(isset($params['include'])){
            $includes = array();
            $includeParams = explode(',',$params['include']);
            $includes = array_intersect($this->supportedFields,$includeParams);
            $withKeys = array_keys($includes);
        }
        return  $withKeys;
    }
}